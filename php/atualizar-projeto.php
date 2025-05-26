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

$fotosNovas = saveUploadFile('fotos', '../uploads/fotos');
$videosNovos = saveUploadFile('videos', '../uploads/videos');
$curtaNovo = saveUploadFile('curta', '../uploads/curtas', false);

// Concatena mídias antigas com novas
$fotosFinais = array_merge(json_decode($projeto['fotos'], true) ?: [], $fotosNovas);
$videosFinais = array_merge(json_decode($projeto['videos'], true) ?: [], $videosNovos);
$curtaFinal = !empty($curtaNovo) ? $curtaNovo[0] : $projeto['curtas'];

// Atualiza no banco
try {
  $stmt = $conexao->prepare("UPDATE acervos SET titulo=?, descricao=?, video_final=?, fotos=?, videos=?, curtas=?, habilidades=?, feedback=?, edicao=? WHERE id_acervo=?");

  $fotosJson = json_encode($fotosFinais);
  $videosJson = json_encode($videosFinais);

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

} catch (Exception $e) {
  echo "Erro ao atualizar: " . $e->getMessage();
}
?>
