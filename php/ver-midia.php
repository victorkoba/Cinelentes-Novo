<?php
include 'conexao.php';

$tabela = $_GET['tabela'] ?? '';
$id = intval($_GET['id'] ?? 0);
$midiaIndex = intval($_GET['midia'] ?? 0);

// Verifica a tabela permitida
$tabelasPermitidas = [
  'videos_acervo',
  'curtas_acervo',
  'fotos_acervo',
  'foto_capa_acervo'
];
if (!in_array($tabela, $tabelasPermitidas)) {
  http_response_code(400);
  exit('Tabela inválida.');
}

// Busca a mídia
$stmt = $conexao->prepare("SELECT * FROM $tabela WHERE acervo_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$midias = [];
while ($row = $result->fetch_assoc()) {
  $midias[] = $row;
}

if (!isset($midias[$midiaIndex])) {
  http_response_code(404);
  exit('Mídia não encontrada.');
}

$midia = $midias[$midiaIndex];

// Campo da mídia: pode ser 'arquivo', 'foto', ou 'video' dependendo da tabela
$campo = 'arquivo';
if ($tabela === 'fotos_acervo' || $tabela === 'foto_capa_acervo') {
  $campo = 'foto';
} elseif ($tabela === 'curtas_acervo') {
  $campo = 'video';
}

// Tipo MIME correto
$tipo = $midia['tipo_arquivo'] ?? 'application/octet-stream';
$dados = $midia[$campo];

header("Content-Type: $tipo");
header("Content-Length: " . strlen($dados));
echo $dados;
exit;
