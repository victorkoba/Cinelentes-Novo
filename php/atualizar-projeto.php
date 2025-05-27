<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die('Acesso inválido.');
}

function saveUploadFile($inputName, $destFolder, $multiple = true) {
  if (!isset($_FILES[$inputName])) return [];

  $files = $_FILES[$inputName];
  $savedPaths = [];

  if (!is_dir($destFolder)) {
    mkdir($destFolder, 0775, true);
  }

  if ($multiple && is_array($files['tmp_name'])) {
    foreach ($files['tmp_name'] as $index => $tmpName) {
      if ($files['error'][$index] === UPLOAD_ERR_OK) {
        $originalName = basename($files['name'][$index]);
        $safeName = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
        $targetPath = "$destFolder/$safeName";
        if (move_uploaded_file($tmpName, $targetPath)) {
          $savedPaths[] = $targetPath;
        }
      }
    }
  } else {
    if ($files['error'] === UPLOAD_ERR_OK) {
      $originalName = basename($files['name']);
      $safeName = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
      $targetPath = "$destFolder/$safeName";
      if (move_uploaded_file($files['tmp_name'], $targetPath)) {
        $savedPaths[] = $targetPath;
      }
    }
  }

  return $savedPaths;
}

// Dados do formulário
$id = intval($_POST['id']);
$titulo = $_POST['titulo'] ?? '';
$descricao = $_POST['conteudo'] ?? '';
$habilidades = $_POST['habilidades'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$edicao = isset($_POST['edicao']) ? (int)$_POST['edicao'] : 2023;

// Busca dados antigos
$stmt = $conexao->prepare("SELECT * FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die('Projeto não encontrado.');
}

$projeto = $result->fetch_assoc();

$excluirFotos = $_POST['excluir_fotos'] ?? [];
$excluirVideos = $_POST['excluir_videos'] ?? [];
$excluirCurta = isset($_POST['excluir_curta']);

$fotosAtuais = json_decode($projeto['fotos'], true) ?: [];
$videosAtuais = json_decode($projeto['videos'], true) ?: [];
$curtaAtual = $projeto['curtas'] ?? null;

$fotosFiltradas = array_filter($fotosAtuais, fn($f) => !in_array($f, $excluirFotos));
$videosFiltradas = array_filter($videosAtuais, fn($v) => !in_array($v, $excluirVideos));
$curtaFinal = $excluirCurta ? null : $curtaAtual;

foreach ($excluirFotos as $f) {
  if (file_exists($f)) unlink($f);
}
foreach ($excluirVideos as $v) {
  if (file_exists($v)) unlink($v);
}
if ($excluirCurta && file_exists($curtaAtual)) {
  unlink($curtaAtual);
}

$fotosNovas = saveUploadFile('fotos', '../uploads/fotos');
$videosNovas = saveUploadFile('videos', '../uploads/videos');
$curtaNova = saveUploadFile('curta', '../uploads/curtas', false);

$fotosFinais = array_merge($fotosFiltradas, $fotosNovas);
$videosFinais = array_merge($videosFiltradas, $videosNovas);
if (!empty($curtaNova)) $curtaFinal = $curtaNova[0];

$fotosJson = json_encode($fotosFinais);
$videosJson = json_encode($videosFinais);

$stmt = $conexao->prepare("
  UPDATE acervos 
  SET titulo=?, descricao=?, fotos=?, videos=?, curtas=?, habilidades=?, feedback=?, edicao=?
  WHERE id_acervo=?
");

$stmt->bind_param(
  'sssssssii',
  $titulo,
  $descricao,
  $fotosJson,
  $videosJson,
  $curtaFinal,
  $habilidades,
  $feedback,
  $edicao,
  $id
);

if ($stmt->execute()) {
  echo "<script>
    alert('Projeto atualizado com sucesso!');
    window.location.href = 'ver-projeto.php?id=$id';
  </script>";
} else {
  echo "Erro ao atualizar: " . $stmt->error;
}
?>
