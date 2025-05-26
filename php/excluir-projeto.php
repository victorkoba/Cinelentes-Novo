<?php
include 'conexao.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID inválido.');
}

$id = intval($_GET['id']);

$stmt = $conexao->prepare("SELECT fotos, videos, curtas FROM acervos WHERE id_acervo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Projeto não encontrado.');
}

$projeto = $result->fetch_assoc();

$fotos = json_decode($projeto['fotos'], true) ?: [];
$videos = json_decode($projeto['videos'], true) ?: [];
$curta = $projeto['curtas'];

foreach ($fotos as $f) {
    if (file_exists($f)) unlink($f);
}

foreach ($videos as $v) {
    if (file_exists($v)) unlink($v);
}

if (!empty($curta) && file_exists($curta)) {
    unlink($curta);
}
$deleteStmt = $conexao->prepare("DELETE FROM acervos WHERE id_acervo = ?");
$deleteStmt->bind_param("i", $id);
$deleteStmt->execute();

echo "<script>
  alert('Projeto excluído com sucesso.');
  window.location.href = 'pagina-inicial-adm.php';
</script>";
?>
