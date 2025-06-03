<?php
include 'verificar-login.php';
include 'conexao.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Validar ID
$id = intval($_POST['id'] ?? 0);
if (!$id) die('ID inválido');

// Função para limpar entradas
function limpar($texto) {
  return trim(htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8'));
}

// Coleta e limpeza dos campos de texto
$titulo = limpar($_POST['titulo'] ?? '');
$conteudo = limpar($_POST['conteudo'] ?? '');
$habilidades = limpar($_POST['habilidades'] ?? '');
$feedback = limpar($_POST['feedback'] ?? '');
$edicao = intval($_POST['edicao'] ?? 0);

$musicasArray = [];
if (!empty($projeto['musicas'])) {
  $decoded = json_decode($projeto['musicas'], true);
  if (is_array($decoded)) {
    $musicasArray = $decoded;
  } else {
    $musicasArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $projeto['musicas'])));
  }
}

// Upload de nova capa (opcional)
$foto_capa_acervo = $_POST['foto_capa_atual'] ?? '';
if (!empty($_FILES['foto_capa']['name']) && $_FILES['foto_capa']['error'] === 0) {
  $novoNome = uniqid('capa_') . '_' . basename($_FILES['foto_capa']['name']);
  move_uploaded_file($_FILES['foto_capa']['tmp_name'], "uploads/$novoNome");
  $foto_capa_acervo = $novoNome;
}

// Atualizar a tabela acervos
$stmt = $conexao->prepare("UPDATE acervos SET titulo=?, descricao=?, foto_capa_acervo=?, habilidades=?, feedback=?, edicao=? WHERE id_acervo=?");
$stmt->bind_param("sssssii", $titulo, $conteudo, $foto_capa_acervo, $habilidades, $feedback, $edicao, $id);
$stmt->execute();
$stmt->close();


function excluirFotosPorIndice($conexao, $acervo_id, $indices) {
  // Buscar todas as fotos associadas a esse acervo
  $sql = "SELECT id_fotos AS id FROM fotos_acervo WHERE acervo_id = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("i", $acervo_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $fotos = $result->fetch_all(MYSQLI_ASSOC);
  $stmt->close();

  // Excluir as fotos nos índices especificados
  foreach ($indices as $i) {
    if (isset($fotos[$i])) {
      $idFoto = $fotos[$i]['id'];
      $del = $conexao->prepare("DELETE FROM fotos_acervo WHERE id_fotos = ?");
      $del->bind_param("i", $idFoto);
      $del->execute();
      $del->close();
    }
  }
}

// Função para excluir por índice
function excluirPorIndice($conexao, $tabela, $acervo_id, $indices) {
  $id_coluna = ($tabela === 'videos_acervo') ? 'id_videos' : 'id_curtas';
  $sql = "SELECT $id_coluna AS id FROM $tabela WHERE acervo_id = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("i", $acervo_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $todos = $result->fetch_all(MYSQLI_ASSOC);
  $stmt->close();

  foreach ($indices as $i) {
    if (isset($todos[$i])) {
      $idArquivo = $todos[$i]['id'];
      $del = $conexao->prepare("DELETE FROM $tabela WHERE $id_coluna = ?");
      $del->bind_param("i", $idArquivo);
      $del->execute();
      $del->close();
    }
  }
}

// Excluir vídeos
if (!empty($_POST['excluir_videos'])) {
  excluirPorIndice($conexao, 'videos_acervo', $id, $_POST['excluir_videos']);
}

// Excluir curta
if (!empty($_POST['excluir_curta'])) {
  excluirPorIndice($conexao, 'curtas_acervo', $id, $_POST['excluir_curtas']);
}

// Excluir fotos
if (!empty($_POST['excluir_fotos'])) {
  $conexao->query("DELETE FROM fotos_acervo WHERE acervo_id = $id");
}

// Upload múltiplo para tabela de vídeos
function salvarMultiplosArquivos($conexao, $tabela, $acervo_id, $campo) {
  if (!isset($_FILES[$campo])) return;

  foreach ($_FILES[$campo]['tmp_name'] as $i => $tmp) {
    if ($_FILES[$campo]['error'][$i] === 0) {
      $nome = $_FILES[$campo]['name'][$i];
      $tipo = mime_content_type($tmp);

      $stmt = $conexao->prepare("INSERT INTO $tabela (acervo_id, nome_arquivo, tipo_arquivo, dados) VALUES (?, ?, ?, ?)");
      $null = NULL;
      $stmt->bind_param("issb", $acervo_id, $nome, $tipo, $null);

      $fp = fopen($tmp, 'rb');
      while (!feof($fp)) {
        $stmt->send_long_data(3, fread($fp, 8192));
      }
      fclose($fp);

      $stmt->execute();
      $stmt->close();
    }
  }
}

salvarMultiplosArquivos($conexao, 'videos_acervo', $id, 'videos');
salvarMultiplosArquivos($conexao, 'fotos_acervo', $id, 'fotos');
salvarMultiplosArquivos($conexao, 'curtas_acervo', $id, 'curtas');

// Redireciona ou exibe mensagem
header("Location: ver-projeto.php?id=$id");
exit;
?>