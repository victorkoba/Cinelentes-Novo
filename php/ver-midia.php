<?php
include 'conexao.php';

$tabela = $_GET['tabela'] ?? '';
$id = intval($_GET['id'] ?? 0);
$midiaIndex = intval($_GET['midia'] ?? 0);

// Tabelas permitidas
$tabelasPermitidas = [
  'videos_acervo',
  'curtas_acervo'
];

if (!in_array($tabela, $tabelasPermitidas)) {
  http_response_code(400);
  exit('Tabela inválida.');
}

// Consulta segura
$stmt = $conexao->prepare("SELECT tipo_arquivo, dados FROM $tabela WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$midias = [];
while ($row = $result->fetch_assoc()) {
  $midias[] = $row;
}

// Verifica índice válido
if (!isset($midias[$midiaIndex])) {
  http_response_code(404);
  exit('Mídia não encontrada.');
}

$midia = $midias[$midiaIndex];
$tipo = $midia['tipo_arquivo'] ?? 'application/octet-stream';
$dados = $midia['dados'];

header("Content-Type: $tipo");
header("Content-Length: " . strlen($dados));
echo $dados;
exit;
