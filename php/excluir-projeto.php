<?php
include 'conexao.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID inválido.');
}

$id = intval($_GET['id']);

// Se tiver uma tabela que armazena a foto de capa no servidor, delete o arquivo antes (opcional)

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

// Agora sim, deletar o projeto (acervo)
$stmt = $conexao->prepare("DELETE FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

echo "<script>
    alert('Projeto excluído com sucesso!');
    window.location.href = 'pagina-inicial-adm.php';
</script>";
?>