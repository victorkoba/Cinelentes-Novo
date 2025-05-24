<?php
include 'conexao.php';
include 'verificar-login.php';

$titulo = $_POST['titulo'];
$descricao = $_POST['conteudo'];

// PROCESSAR FOTOS (upload múltiplo)
$fotosArray = [];
if (isset($_FILES['fotos'])) {
    foreach ($_FILES['fotos']['tmp_name'] as $i => $tmp) {
        if ($_FILES['fotos']['error'][$i] === 0) {
            $pasta = 'uploads/fotos/';
            if (!is_dir($pasta)) mkdir($pasta, 0777, true);
            $nomeFoto = basename($_FILES['fotos']['name'][$i]);
            $destino = $pasta . $nomeFoto;
            if (move_uploaded_file($tmp, $destino)) {
                $fotosArray[] = $destino;
            }
        }
    }
}
$fotos = json_encode($fotosArray);

// PROCESSAR VÍDEOS (upload múltiplo)
$videosArray = [];
if (isset($_FILES['videos'])) {
    foreach ($_FILES['videos']['tmp_name'] as $i => $tmp) {
        if ($_FILES['videos']['error'][$i] === 0) {
            $pasta = 'uploads/videos/';
            if (!is_dir($pasta)) mkdir($pasta, 0777, true);
            $nomeVideo = basename($_FILES['videos']['name'][$i]);
            $destino = $pasta . $nomeVideo;
            if (move_uploaded_file($tmp, $destino)) {
                $videosArray[] = $destino;
            }
        }
    }
}
$videos = json_encode($videosArray);

// PROCESSAR CURTA (upload)
$curtas = '';
if (isset($_FILES['curta']) && $_FILES['curta']['error'] === 0) {
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

// PROCESSAR VÍDEO FINAL
$video_final = '';
if (isset($_FILES['final_video']) && $_FILES['final_video']['error'] === 0) {
    $pasta = 'uploads/final/';
    if (!is_dir($pasta)) mkdir($pasta, 0777, true);
    $nomeVideoFinal = basename($_FILES['final_video']['name']);
    $destino = $pasta . $nomeVideoFinal;
    if (move_uploaded_file($_FILES['final_video']['tmp_name'], $destino)) {
        $video_final = $destino;
    }
}

// MÚSICAS (json com 3 campos)
$musicas = json_encode([
    $_POST['musica1'] ?? '',
    $_POST['musica2'] ?? '',
    $_POST['musica3'] ?? ''
]);

$habilidades = $_POST['habilidades'] ?? '';
$feedback = $_POST['feedback'] ?? '';
$agenda = $_POST['agenda'] ?? '';

// INSERIR NO BANCO
$sql = "INSERT INTO acervos (titulo, descricao, video_final, fotos, videos, curtas, musicas, habilidades, feedback)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("sssssssss", $titulo, $descricao, $video_final, $fotos, $videos, $curtas, $musicas, $habilidades, $feedback, $agenda);

if ($stmt->execute()) {
    echo "<script>
        alert('Projeto salvo com sucesso!');
        window.location.href = 'pagina-inicial-adm.php';
    </script>";
} else {
    echo "Erro ao salvar: " . $stmt->error;
}
?>
