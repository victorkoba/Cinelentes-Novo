<?php
include 'conexao.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID inválido.');
}

$id = intval($_GET['id']);

// Deletar da foto_capa_acervo
$stmt = $conexao->prepare("DELETE FROM foto_capa_acervo WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Deletar de fotos_acervo
$stmt = $conexao->prepare("DELETE FROM fotos_acervo WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Deletar de videos_acervo
$stmt = $conexao->prepare("DELETE FROM videos_acervo WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Deletar de curtas_acervo
$stmt = $conexao->prepare("DELETE FROM curtas_acervo WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Deletar do acervos (último para manter integridade referencial)
$stmt = $conexao->prepare("DELETE FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

echo "<script>
    alert('Projeto excluído com sucesso!');
    window.location.href = 'pagina-inicial-adm.php';
</script>";
?>
