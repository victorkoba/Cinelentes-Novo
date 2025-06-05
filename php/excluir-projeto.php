<?php
include 'conexao.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID inválido.');
}

$id = intval($_GET['id']);

// Deletar fotos associadas
$stmt = $conexao->prepare("DELETE FROM fotos_acervo WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Deletar vídeos associados
$stmt = $conexao->prepare("DELETE FROM videos_acervo WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Deletar curtas associados
$stmt = $conexao->prepare("DELETE FROM curtas_acervo WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Deletar o projeto
$stmt = $conexao->prepare("DELETE FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Projeto Excluído</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
    </style>
</head>
<body>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Projeto excluído com sucesso!',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'pagina-inicial-adm.php';
        });
    </script>
</body>
</html>
