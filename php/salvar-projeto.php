<?php
// Função simples para limpar texto
function limpar($texto) {
    return trim(htmlspecialchars($texto));
}

// Coleta os campos de texto
$titulo = limpar($_POST['titulo'] ?? '');
$conteudo = limpar($_POST['conteudo'] ?? '');
$foto_capa_acervo = limpar($_POST ['foto_capa_acervo'] ?? '');
$diretorio = 'uploads/';
$habilidades = limpar($_POST['habilidades'] ?? '');
$feedback = limpar($_POST['feedback'] ?? '');
$edicao = limpar($_POST['edicao'] ?? '');
$musicas = json_encode([
    $_POST['musica1'] ?? '',
    $_POST['musica2'] ?? '',
    $_POST['musica3'] ?? ''
]);
?>

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


// Função para salvar 1 arquivo binário
function salvarArquivoBinario($campo) {
    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == 0) {
        return file_get_contents($_FILES[$campo]['tmp_name']); // binário puro
    }
    return null;
}

$foto_capa_acervo = salvarImagemCapa('foto_capa_acervo', 'foto_capa_acervo_');

function salvarImagemCapa($campo, $prefixo = '') {
    global $diretorio;
    $caminho = '';
    
    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] === 0) {
        // Verifica se o tipo MIME é de imagem
        $tipo = mime_content_type($_FILES[$campo]['tmp_name']);
        if (strpos($tipo, 'image/') === 0) {
            $ext = pathinfo($_FILES[$campo]['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid($prefixo, true) . '.' . $ext;
            $caminhoCompleto = $diretorio . $novoNome;
            if (move_uploaded_file($_FILES[$campo]['tmp_name'], $caminhoCompleto)) {
                $caminho = $caminhoCompleto;
            }
        }
    }
    
    return $caminho;
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
$videos = salvarMultiplosArquivosBinarios('videos');
$curta = salvarMultiplosArquivosBinarios('curta');
$fotos = salvarMultiplosArquivosBinarios('fotos');

// 1. Inserção na tabela acervos
$sql = "INSERT INTO acervos (titulo, descricao, foto_capa_acervo, musicas, habilidades, feedback, edicao) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssssssi", $titulo, $conteudo, $foto_capa_acervo, $musicas, $habilidades, $feedback, $edicao);

if ($stmt->execute()) {
    $acervo_id = $stmt->insert_id; // ID do acervo recém-criado
    echo "Acervo salvo com sucesso!<br>";
    
function inserirArquivo($conexao, $tabela, $acervo_id, $arquivos) {
    $sql = "INSERT INTO $tabela (acervo_id, nome_arquivo, tipo_arquivo, dados) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar SQL para $tabela: " . $conexao->error);
    }

    foreach ($arquivos as $arquivo) {
        $nome = $arquivo['nome'];
        $tipo = $arquivo['tipo'];
        $dados = $arquivo['dados'];

        $null = NULL;
        $stmt->bind_param("sssb", $acervo_id, $nome, $tipo, $null);
        $stmt->send_long_data(3, $dados);
        $stmt->execute();
    }

    $stmt->close();
}
    // Inserir arquivos nas tabelas específicas
    inserirArquivo($conexao, "videos_acervo", $acervo_id, $videos);
    inserirArquivo($conexao, "curtas_acervo", $acervo_id, $curta);
    inserirArquivo($conexao, "fotos_acervo", $acervo_id, $fotos);
    
    header("Location: criar-projeto-adm.php?sucesso=1");
    exit;
} else {
    echo "Erro ao salvar projeto: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Preencha todos os campos necessários</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
    </style>
</head>
<body>
    <?php
    if (
    !$titulo || 
    !$conteudo || 
    !$edicao || 
    !isset($_FILES['foto_capa_acervo']) || 
    $_FILES['foto_capa_acervo']['error'] !== 0
) {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "warning",
            title: "Campos obrigatórios",
            text: "Preencha todos os campos obrigatórios e envie a foto de capa!",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = "criar-projeto-adm.php";
        });
    </script>';
    exit;
}
    ?>
</body>
</html>