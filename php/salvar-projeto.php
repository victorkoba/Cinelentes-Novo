<?php
include 'conexao.php';
session_start();

// Validação básica
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die("Acesso inválido.");
}

// Função utilitária para salvar arquivos
function saveUploadFile($inputName, $destFolder, $multiple = true) {
  if (!isset($_FILES[$inputName])) return [];

  $files = $_FILES[$inputName];
  $savedPaths = [];

  // Garante que a pasta exista
  if (!is_dir($destFolder)) {
    mkdir($destFolder, 0775, true);
  }

  // Se múltiplos arquivos
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
    // Arquivo único
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

// Sanitização dos dados do formulário
$titulo = $_POST['titulo'] ?? '';
$descricao = $_POST['conteudo'] ?? '';
$habilidades = $_POST['habilidades'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$edicao = isset($_POST['edicao']) ? (int)$_POST['edicao'] : 2023;

$musicas = json_encode([
  $_POST['musica1'] ?? '',
  $_POST['musica2'] ?? '',
  $_POST['musica3'] ?? ''
]);

// Processamento dos uploads
$fotos = saveUploadFile('fotos', '../uploads/fotos'); // múltiplos
$videos = saveUploadFile('videos', '../uploads/videos'); // múltiplos
$curta = saveUploadFile('curta', '../uploads/curtas', false); // único
$video_final = saveUploadFile('final_video', '../uploads/curtas', false); // único

// Codificação para salvar no banco
$fotosJson = json_encode($fotos);
$videosJson = json_encode($videos);
$curtaPath = $curta[0] ?? null;
$videoFinalPath = $video_final[0] ?? null;

try {
  $stmt = $conexao->prepare("INSERT INTO acervos 
    (titulo, descricao, video_final, fotos, videos, curtas, musicas, habilidades, feedback, edicao)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param(
    'sssssssssi',
    $titulo,
    $descricao,
    $videoFinalPath,
    $fotosJson,
    $videosJson,
    $curtaPath,
    $musicas,
    $habilidades,
    $feedback,
    $edicao
  );

  $stmt->execute();

  echo "<script>
    alert('Projeto salvo com sucesso!');
    window.location.href = 'pagina-inicial-adm.php';
  </script>";

} catch (Exception $e) {
  echo "Erro ao salvar: " . $e->getMessage();
}
?>
