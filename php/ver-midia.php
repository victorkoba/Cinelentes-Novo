<?php
include 'conexao.php';

$tabela = $_GET['tabela'] ?? '';
$acervo_id = intval($_GET['id']);
$index = intval($_GET['midia'] ?? 0);

$tabelasPermitidas = [
  'fotos_acervo',
  'videos_acervo',
  'curtas_acervo',
  'foto_capa_acervo'
];

if (!in_array($tabela, $tabelasPermitidas)) {
  http_response_code(403);
  exit('Acesso negado.');
}

$sql = "SELECT tipo_arquivo, dados FROM $tabela WHERE acervo_id = ? LIMIT 1 OFFSET ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $acervo_id, $index);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
  http_response_code(404);
  exit('Arquivo não encontrado.');
}

$stmt->bind_result($tipo, $dados);
$stmt->fetch();

header("Content-Type: $tipo");
echo $dados;
exit;
?>
