<?php
include 'conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit('ID do vídeo não informado ou inválido.');
}

$id = intval($_GET['id']);

// Buscar pelo id_videos, que é a chave primária
$sql = "SELECT nome_arquivo, tipo_arquivo, dados FROM curtas_acervo WHERE id_curtas = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($nome, $tipo, $dados);
$stmt->fetch();
$stmt->close();

if (!$dados) {
    http_response_code(404);
    exit('Vídeo não encontrado.');
}

header('Content-Type: ' . $tipo);
header('Content-Disposition: inline; filename="' . $nome . '"');
header('Content-Length: ' . strlen($dados));

echo $dados;
exit;
?>
