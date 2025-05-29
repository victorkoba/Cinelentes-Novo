<?php
include 'conexao.php';

$tabela = $_GET['tabela'] ?? '';
$id = intval($_GET['id'] ?? 0);

$coluna_id = [
  'videos_acervo' => 'id_videos',
  'curtas_acervo' => 'id_curtas',
][$tabela] ?? null;

if (!$tabela || !$coluna_id || !$id) {
  http_response_code(400);
  exit('Parâmetros inválidos');
}

$sql = "SELECT tipo_arquivo, dados FROM $tabela WHERE $coluna_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  $stmt->bind_result($tipo, $dados);
  $stmt->fetch();
  header("Content-Type: $tipo");
  echo $dados;
} else {
  http_response_code(404);
  echo "Arquivo não encontrado.";
}

$stmt->close();