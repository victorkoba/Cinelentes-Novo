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

// Função para salvar 1 arquivo binário
function salvarArquivoBinario($campo) {
    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == 0) {
        return file_get_contents($_FILES[$campo]['tmp_name']); // binário puro
    }
    return null;
}

// Função para salvar múltiplos arquivos binários
function salvarMultiplosArquivosBinarios($campo) {
    $arquivos = [];

    if (isset($_FILES[$campo]) && is_array($_FILES[$campo]['name'])) {
        for ($i = 0; $i < count($_FILES[$campo]['name']); $i++) {
            if ($_FILES[$campo]['error'][$i] === 0) {
                $conteudo = file_get_contents($_FILES[$campo]['tmp_name'][$i]);
                $tipo = mime_content_type($_FILES[$campo]['tmp_name'][$i]);
                $nomeOriginal = $_FILES[$campo]['name'][$i];

                $arquivos[] = [
                    'nome' => $nomeOriginal,
                    'tipo' => $tipo,
                    'dados' => $conteudo // binário puro
                ];
            }
        }
    }

    return $arquivos;
}

// Uploads
$imagem_capa = salvarArquivoBinario('foto_capa');
$fotos = salvarMultiplosArquivosBinarios('fotos');
$videos = salvarMultiplosArquivosBinarios('videos');
$curta = salvarMultiplosArquivosBinarios('curta');

// 1. Inserção na tabela acervos
$sql = "INSERT INTO acervos (titulo, descricao, foto_capa, musicas, habilidades, feedback, edicao) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssssssi", $titulo, $conteudo, $imagem_capa, $musicas, $habilidades, $feedback, $edicao);

if ($stmt->execute()) {
    $acervo_id = $stmt->insert_id; // ID do acervo recém-criado
    echo "Acervo salvo com sucesso!<br>";

    // Função para inserir um arquivo em uma tabela (fotos, vídeos ou curtas)
    function inserirArquivo($conexao, $tabela, $acervo_id, $arquivos) {
        $sql = "INSERT INTO $tabela (acervo_id, nome_arquivo, tipo_arquivo, dados) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        foreach ($arquivos as $arquivo) {
            $nome = $arquivo['nome'];
            $tipo = $arquivo['tipo'];
            $dados = $arquivo['dados']; // já está em binário
            $stmt->bind_param("issb", $acervo_id, $nome, $tipo, $null); // 'b' para blob
            $stmt->send_long_data(3, $dados); // índice 3 é o quarto parâmetro (dados)
            $stmt->execute();
        }
        $stmt->close();
    }

    // Inserir arquivos nas tabelas específicas
    inserirArquivo($conexao, "fotos_acervo", $acervo_id, $fotos);
    inserirArquivo($conexao, "videos_acervo", $acervo_id, $videos);
    inserirArquivo($conexao, "curtas_acervo", $acervo_id, $curta);

    echo "<br><a href='pagina-inicial-adm.php'>Voltar</a>";
} else {
    echo "Erro ao salvar projeto: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>