<?php
// Ativa mensagens de erro para debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conecta com o banco
include('conexao.php');

// Verifica se veio via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Acesso inválido.');
}

// Função simples para limpar texto
function limpar($texto) {
    return trim(htmlspecialchars($texto));
}

// Coleta os campos de texto
$titulo = limpar($_POST['titulo'] ?? '');
$conteudo = limpar($_POST['conteudo'] ?? '');
$habilidades = limpar($_POST['habilidades'] ?? '');
$feedback = limpar($_POST['feedback'] ?? '');
$edicao = limpar($_POST['edicao'] ?? '');
$musicas = json_encode([
  $_POST['musica1'] ?? '',
  $_POST['musica2'] ?? '',
  $_POST['musica3'] ?? ''
]);

// Verifica campos obrigatórios
if (!$titulo || !$conteudo || !$edicao) {
    die('Preencha todos os campos obrigatórios.');
}

// Pasta onde os arquivos serão salvos
$diretorio = 'uploads/';
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true);
}

// Função para salvar 1 arquivo
function salvarArquivo($campo, $novoNomePrefixo = '') {
    global $diretorio;
    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == 0) {
        $ext = pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION);
        $novoNome = uniqid($novoNomePrefixo, true) . '.' . $ext;
        $caminhoCompleto = $diretorio . $novoNome;
        if (move_uploaded_file($_FILES[$campo]['tmp_name'], $caminhoCompleto)) {
            return $caminhoCompleto;
        }
    }
    return null;
}

// Função para salvar múltiplos arquivos (array)
function salvarMultiplosArquivos($campo, $prefixo = '') {
    global $diretorio;
    $caminhos = [];
    if (isset($_FILES[$campo]) && is_array($_FILES[$campo]['name'])) {
        for ($i = 0; $i < count($_FILES[$campo]['name']); $i++) {
            if ($_FILES[$campo]['error'][$i] === 0) {
                $ext = pathinfo($_FILES[$campo]['name'][$i], PATHINFO_EXTENSION);
                $novoNome = uniqid($prefixo, true) . '.' . $ext;
                $caminhoCompleto = $diretorio . $novoNome;
                if (move_uploaded_file($_FILES[$campo]['tmp_name'][$i], $caminhoCompleto)) {
                    $caminhos[] = $caminhoCompleto;
                }
            }
        }
    }
    return $caminhos;
}

// Uploads
$imagem_capa = salvarArquivo('foto_capa', 'capa_');
$fotos = salvarMultiplosArquivos('fotos', 'foto_');
$videos = salvarMultiplosArquivos('videos', 'video_');
$curta = salvarMultiplosArquivos('curta', 'curta_');

// Converte arrays em JSON para salvar no banco
$fotos_json = json_encode($fotos);
$videos_json = json_encode($videos);
$curta_json = json_encode($curta);

// Prepara SQL
$sql = "INSERT INTO acervos (titulo, descricao, foto_capa, fotos, videos, curtas, musicas, habilidades, feedback, edicao) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepara statement
$stmt = $conexao->prepare($sql);
if (!$stmt) {
    die("Erro ao preparar statement: " . $conexao->error);
}

// Faz o bind dos valores
$stmt->bind_param("sssssssssi", 
    $titulo, 
    $conteudo, 
    $imagem_capa,
    $fotos_json, 
    $videos_json, 
    $curta_json, 
    $musicas,
    $habilidades, 
    $feedback, 
    $edicao
);

if ($stmt->execute()) {
    echo "Projeto salvo com sucesso!";
    echo "<br><a href='pagina-inicial-adm.php'>Voltar</a>";
} else {
    echo "Erro ao salvar projeto: " . $stmt->error;
}

// Fecha
$stmt->close();
$conexao->close();
?>