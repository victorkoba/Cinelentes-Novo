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

// 1. Buscar músicas existentes do banco
$sqlMusicas = $conexao->prepare("SELECT musicas FROM acervos WHERE id_acervo = ?");
$sqlMusicas->bind_param("i", $id);
$sqlMusicas->execute();
$resultMusicas = $sqlMusicas->get_result();
$musicasArray = [];

if ($row = $resultMusicas->fetch_assoc()) {
    $musicasRaw = $row['musicas'];
    if (!empty($musicasRaw)) {
        $decoded = json_decode($musicasRaw, true);
        if (is_array($decoded)) {
            $musicasArray = $decoded;
        } else {
            $musicasArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $musicasRaw)));
        }
    }
}
$sqlMusicas->close();

// 2. Remover músicas marcadas
if (!empty($_POST['excluir_musicas']) && is_array($_POST['excluir_musicas'])) {
    foreach ($_POST['excluir_musicas'] as $indice) {
        unset($musicasArray[$indice]);
    }
    $musicasArray = array_values($musicasArray); // reindexar
}

// 3. Adicionar novas músicas
if (!empty($_POST['novas_musicas']) && is_array($_POST['novas_musicas'])) {
    foreach ($_POST['novas_musicas'] as $nova) {
        $nova = trim($nova);
        if (!empty($nova)) {
            $musicasArray[] = $nova;
        }
    }
}

// 4. Atualizar o campo 'musicas' no banco
$musicasJson = json_encode($musicasArray);
$updateMusicas = $conexao->prepare("UPDATE acervos SET musicas = ? WHERE id_acervo = ?");
$updateMusicas->bind_param("si", $musicasJson, $id);
$updateMusicas->execute();
$updateMusicas->close();

// Upload de nova capa (opcional)
// $foto_capa_acervo = $_POST['foto_capa_atual'] ?? '';
// if (!empty($_FILES['foto_capa_acervo']['name']) && $_FILES['foto_capa_acervo']['error'] === 0) {
//   // Apagar a foto antiga do servidor (se existir)
//   $caminho_antigo = "uploads/" . $foto_capa_acervo;
//   if (file_exists($caminho_antigo)) {
//     unlink($caminho_antigo);
//   }

//   // Fazer upload da nova
//   $novoNome = uniqid('capa_') . '_' . basename($_FILES['foto_capa_acervo']['name']);
//   if (move_uploaded_file($_FILES['foto_capa']['tmp_name'], "uploads/$novoNome")) {
//     $foto_capa_acervo = $novoNome;
//   } else {
//       die('Falha ao mover a nova imagem de capa.');
//   }
// }

// Atualizar a tabela acervos
$stmt = $conexao->prepare("UPDATE acervos SET titulo=?, descricao=?, habilidades=?, feedback=?, edicao=? WHERE id_acervo=?");
$stmt->bind_param("ssssii", $titulo, $conteudo, $habilidades, $feedback, $edicao, $id);
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

// Excluir somente os videos selecionados
if (!empty($_POST['excluir_videos']) && is_array($_POST['excluir_videos'])) {
  foreach ($_POST['excluir_videos'] as $fotoId) {
    // Opcional: Buscar nome do arquivo da foto para excluir do servidor, se armazenado
    $stmt = $conexao->prepare("DELETE FROM videos_acervo WHERE id_videos = ?");
    $stmt->bind_param("i", $fotoId);
    $stmt->execute();
    $stmt->close();
  }
}

// Excluir somente os curtas selecionados
if (!empty($_POST['excluir_curtas']) && is_array($_POST['excluir_curtas'])) {
  foreach ($_POST['excluir_curtas'] as $fotoId) {
    // Opcional: Buscar nome do arquivo da foto para excluir do servidor, se armazenado
    $stmt = $conexao->prepare("DELETE FROM curtas_acervo WHERE id_curtas = ?");
    $stmt->bind_param("i", $fotoId);
    $stmt->execute();
    $stmt->close();
  }
}

// Excluir somente as fotos selecionadas
if (!empty($_POST['excluir_fotos']) && is_array($_POST['excluir_fotos'])) {
  foreach ($_POST['excluir_fotos'] as $fotoId) {
    // Opcional: Buscar nome do arquivo da foto para excluir do servidor, se armazenado
    $stmt = $conexao->prepare("DELETE FROM fotos_acervo WHERE id_fotos = ?");
    $stmt->bind_param("i", $fotoId);
    $stmt->execute();
    $stmt->close();
  }
}

// Upload múltiplo para tabela de vídeos
function salvarMultiplosArquivos($conexao, $tabela, $acervo_id, $campo) {
  if (!isset($_FILES[$campo]) || !is_array($_FILES[$campo]['tmp_name'])) return;

  foreach ($_FILES[$campo]['tmp_name'] as $i => $tmp) {
    if (!is_uploaded_file($tmp)) continue;
    if ($_FILES[$campo]['error'][$i] !== 0) continue;

    $nome = basename($_FILES[$campo]['name'][$i]);
    $tipo = mime_content_type($tmp);

    $stmt = $conexao->prepare("INSERT INTO $tabela (acervo_id, nome_arquivo, tipo_arquivo, dados) VALUES (?, ?, ?, ?)");

    $null = null;
    $stmt->bind_param("issb", $acervo_id, $nome, $tipo, $null); // BLOB é nulo inicialmente

    // Agora envia os dados binários
    $fp = fopen($tmp, 'rb');
    while (!feof($fp)) {
      $stmt->send_long_data(3, fread($fp, 8192));
    }
    fclose($fp);

    $stmt->execute();
    $stmt->close();
  }
}

salvarMultiplosArquivos($conexao, 'videos_acervo', $id, 'videos');
salvarMultiplosArquivos($conexao, 'fotos_acervo', $id, 'fotos');
salvarMultiplosArquivos($conexao, 'curtas_acervo', $id, 'curtas');

// Redireciona ou exibe mensagem
header("Location: pagina-inicial-adm.php");
exit;
?>