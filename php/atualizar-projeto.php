<?php
include 'conexao.php';
session_start();

// Verifica se foi postado
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

// Após recuperar os dados antigos do projeto:
$excluirFotos = $_POST['excluir_fotos'] ?? [];
$excluirVideos = $_POST['excluir_videos'] ?? [];
$excluirCurta = isset($_POST['excluir_curta']);

$fotosAtuais = json_decode($projeto['fotos'], true) ?: [];
$videosAtuais = json_decode($projeto['videos'], true) ?: [];
$curtaAtual = $projeto['curtas'] ?? null;

// Remove as fotos marcadas
$fotosFiltradas = array_filter($fotosAtuais, function($f) use ($excluirFotos) {
  return !in_array($f, $excluirFotos);
});

// Remove os vídeos marcados
$videosFiltradas = array_filter($videosAtuais, function($v) use ($excluirVideos) {
  return !in_array($v, $excluirVideos);
});

// Remove o curta, se solicitado
$curtaFinal = $excluirCurta ? null : $curtaAtual;

// ⚠️ (opcional) Deleta os arquivos físicos
foreach ($excluirFotos as $f) {
  if (file_exists($f)) unlink($f);
}
foreach ($excluirVideos as $v) {
  if (file_exists($v)) unlink($v);
}
if ($excluirCurta && file_exists($curtaAtual)) {
  unlink($curtaAtual);
}

// Uploads novos
$fotosNovas = saveUploadFile('fotos', '../uploads/fotos');
$videosNovas = saveUploadFile('videos', '../uploads/videos');
$curtaNova = saveUploadFile('curta', '../uploads/curtas', false);

$fotosFinais = array_merge($fotosFiltradas, $fotosNovas);
$videosFinais = array_merge($videosFiltradas, $videosNovas);
if (!empty($curtaNova)) $curtaFinal = $curtaNova[0];

$fotosJson = json_encode($fotosFinais);
$videosJson = json_encode($videosFinais);

// Atualização final
$stmt = $conexao->prepare("UPDATE acervos SET titulo=?, descricao=?, video_final=?, fotos=?, videos=?, curtas=?, habilidades=?, feedback=?, edicao=? WHERE id_acervo=?");
$stmt->bind_param(
  'ssssssssii',
  $titulo,
  $descricao,
  $curtaFinal,
  $fotosJson,
  $videosJson,
  $curtaFinal,
  $habilidades,
  $feedback,
  $edicao,
  $id
);

$stmt->execute();

echo "<script>
  alert('Projeto atualizado com sucesso!');
  window.location.href = 'ver-projeto.php?id=$id';
</script>";
