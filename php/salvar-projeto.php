<?php
include 'conexao.php'
include 'verificar-login.php';

$titulo = $_POST['titulo'];
$descricao = $_POST['conteudo'];

// PROCESSAR FOTO (upload)
$fotos = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $pasta = 'uploads/fotos/';
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);
    $nomeFoto = basename($_FILES['foto']['name']);
    $destino = $pasta . $nomeFoto;
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
        $fotos = $destino;
    }
} else {
    $fotos = 'Sem foto';
}

// PROCESSAR VÍDEO (link)
$videos = isset($_POST['video_link']) ? $_POST['video_link'] : 'Sem vídeo';

// PROCESSAR CURTA (upload)
$curtas = '';
if (isset($_FILES['curta']) && $_FILES['curta']['error'] == 0) {
    $pasta = 'uploads/curtas/';
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);
    $nomeCurta = basename($_FILES['curta']['name']);
    $destino = $pasta . $nomeCurta;
    if (move_uploaded_file($_FILES['curta']['tmp_name'], $destino)) {
        $curtas = $destino;
    }
} else {
    $curtas = 'Sem curta';
}

// Música (continua o seu json)
$musicas = json_encode([
    $_POST['musica1'] ?? '',
    $_POST['musica2'] ?? '',
    $_POST['musica3'] ?? ''
]);

$habilidades = $_POST['habilidades'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$agenda = $_POST['agenda'] ?? '';

$sql = "INSERT INTO acervos (titulo, descricao, video_final, fotos, videos, curtas, musicas, habilidades, feedback, agenda)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$video_final = ''; // você pode tratar depois, por enquanto vazio

$stmt->bind_param("ssssssssss", $titulo, $descricao, $video_final, $fotos, $videos, $curtas, $musicas, $habilidades, $feedback, $agenda);

if ($stmt->execute()) {
    echo "<script>
        alert('Projeto salvo com sucesso!');
        window.location.href = 'pagina-inicial-adm.php';
    </script>";
} else {
    echo "Erro: " . $stmt->error;
}
?>