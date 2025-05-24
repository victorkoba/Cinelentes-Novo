<?php
include 'conexao.php';
session_start();

// Validação básica
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die("Acesso inválido.");
}

// Sanitize
$titulo = $_POST['titulo'] ?? '';
$descricao = $_POST['conteudo'] ?? '';
$habilidades = $_POST['habilidades'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$edicao = 2023; // default

// Captura links de músicas
$musicas = json_encode([
  $_POST['musica1'] ?? '',
  $_POST['musica2'] ?? '',
  $_POST['musica3'] ?? ''
]);

// Helper: retorna conteúdo de arquivo ou null
function getFileData($inputName) {
  if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) return null;
  return file_get_contents($_FILES[$inputName]['tmp_name']);
}

// Fotos (múltiplas) - apenas primeira junta
$fotos = '';
if (!empty($_FILES['fotos']['tmp_name'][0])) {
  $fotos = file_get_contents($_FILES['fotos']['tmp_name'][0]); // Apenas 1 por agora
}

// Vídeos (múltiplos)
$videos = '';
if (!empty($_FILES['videos']['tmp_name'][0])) {
  $videos = file_get_contents($_FILES['videos']['tmp_name'][0]);
}

$video_final = getFileData('final_video');
$curta = getFileData('curta');

try {
  $stmt = $conn->prepare("INSERT INTO acervos 
    (titulo, descricao, video_final, fotos, videos, curtas, musicas, habilidades, feedback, edicao)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param(
    'sssssssssi',
    $titulo,
    $descricao,
    $video_final,
    $fotos,
    $videos,
    $curta,
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
