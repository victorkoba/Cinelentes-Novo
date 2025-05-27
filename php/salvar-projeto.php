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
$fotos_acervo = limpar($_POST['fotos_acervo'] ?? '');
$diretorio = 'uploads/'; // caminho da pasta onde os arquivos serão salvos
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

$fotos = salvarMultiplosArquivos('fotos', 'foto_');
$fotos_acervo = json_encode($fotos); // caminhos para os arquivos na pasta 'uploads/'

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
$foto_capa = salvarArquivoBinario('foto_capa');
$videos = salvarMultiplosArquivosBinarios('videos');
$curta = salvarMultiplosArquivosBinarios('curta');

// 1. Inserção na tabela acervos
$sql = "INSERT INTO acervos (titulo, descricao, fotos_acervo, musicas, habilidades, feedback, edicao) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssssssi", $titulo, $conteudo, $fotos_acervo, $musicas, $habilidades, $feedback, $edicao);

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

    $foto_capa_arquivo = [];

        if ($foto_capa !== null) {
            $foto_capa_arquivo[] = [
                'nome' => $_FILES['foto_capa']['name'] ?? 'capa_sem_nome',
                'tipo' => mime_content_type($_FILES['foto_capa']['tmp_name'] ?? ''),
                'dados' => $foto_capa
            ];
        }

    // Inserir arquivos nas tabelas específicas
    inserirArquivo($conexao, "videos_acervo", $acervo_id, $videos);
    inserirArquivo($conexao, "curtas_acervo", $acervo_id, $curta);
    inserirArquivo($conexao, "foto_capa_acervo", $acervo_id, $foto_capa_arquivo);

    echo "<br><a href='pagina-inicial-adm.php'>Voltar</a>";
} else {
    echo "Erro ao salvar projeto: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>