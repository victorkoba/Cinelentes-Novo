<?php
include('verificar-login.php');
include('conexao.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Validar ID
$id = intval($_POST['id'] ?? 0);
if (!$id) die('ID inválido');

// Limpeza de dados
function limpar($texto) {
  return trim(htmlspecialchars($texto));
}

// Campos de texto
$titulo = limpar($_POST['titulo']);
$conteudo = limpar($_POST['conteudo']);
$habilidades = limpar($_POST['habilidades']);
$feedback = limpar($_POST['feedback']);
$edicao = intval($_POST['edicao']);

// Atualizar tabela acervos
$stmt = $conexao->prepare("UPDATE acervos SET titulo=?, descricao=?, habilidades=?, feedback=?, edicao=? WHERE id_acervo=?");
$stmt->bind_param("ssssii", $titulo, $conteudo, $habilidades, $feedback, $edicao, $id);
$stmt->execute();
$stmt->close();

function excluirPorIndice($conexao, $tabela, $acervo_id, $indices) {
  // Mapear chave primária por tabela
  $coluna_id = [
    'fotos_acervo' => 'id_fotos',
    'videos_acervo' => 'id_videos',
    'curtas_acervo' => 'id_curtas',
    'foto_capa_acervo' => 'id' // caso necessário
  ][$tabela] ?? 'id'; // fallback

  $sql = "SELECT $coluna_id AS id FROM $tabela WHERE acervo_id = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("i", $acervo_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $todos = $result->fetch_all(MYSQLI_ASSOC);
  $stmt->close();

  foreach ($indices as $index) {
    if (isset($todos[$index])) {
      $idArquivo = $todos[$index]['id'];
      $stmt = $conexao->prepare("DELETE FROM $tabela WHERE $coluna_id = ?");
      $stmt->bind_param("i", $idArquivo);
      $stmt->execute();
      $stmt->close();
    }
  }
}


// Excluir arquivos marcados
if (!empty($_POST['excluir_fotos'])) excluirPorIndice($conexao, 'fotos_acervo', $id, $_POST['excluir_fotos']);
if (!empty($_POST['excluir_videos'])) excluirPorIndice($conexao, 'videos_acervo', $id, $_POST['excluir_videos']);
if (!empty($_POST['excluir_curta'])) $conexao->query("DELETE FROM curtas_acervo WHERE acervo_id = $id");

// Função de upload múltiplo
function salvarMultiplosArquivos($conexao, $tabela, $acervo_id, $campo) {
  if (!isset($_FILES[$campo])) return;

  for ($i = 0; $i < count($_FILES[$campo]['name']); $i++) {
    if ($_FILES[$campo]['error'][$i] === 0) {
      $nome = $_FILES[$campo]['name'][$i];
      $tipo = mime_content_type($_FILES[$campo]['tmp_name'][$i]);
      $dados = file_get_contents($_FILES[$campo]['tmp_name'][$i]);

      $stmt = $conexao->prepare("INSERT INTO $tabela (acervo_id, nome_arquivo, tipo_arquivo, dados) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("issb", $acervo_id, $nome, $tipo, $null);
      $stmt->send_long_data(3, $dados);
      $stmt->execute();
      $stmt->close();
    }
  }
}

// Upload de curta (único)
if (isset($_FILES['curta']) && $_FILES['curta']['error'] === 0) {
  $nome = $_FILES['curta']['name'];
  $tipo = mime_content_type($_FILES['curta']['tmp_name']);
  $dados = file_get_contents($_FILES['curta']['tmp_name']);

  $stmt = $conexao->prepare("INSERT INTO curtas_acervo (acervo_id, nome_arquivo, tipo_arquivo, dados) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("issb", $id, $nome, $tipo, $null);
  $stmt->send_long_data(3, $dados);
  $stmt->execute();
  $stmt->close();
}

// Salvar novos arquivos
salvarMultiplosArquivos($conexao, 'fotos_acervo', $id, 'fotos');
salvarMultiplosArquivos($conexao, 'videos_acervo', $id, 'videos');

// Redirecionar
header("Location: pagina-inicial-adm.php");
exit;
?>
