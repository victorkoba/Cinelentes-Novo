<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acervo_id = filter_input(INPUT_POST, 'acervo_id', FILTER_VALIDATE_INT);
    $link_musica = filter_input(INPUT_POST, 'link_musica', FILTER_SANITIZE_URL);

    if (!$acervo_id || !$link_musica) {
        die("Dados inválidos.");
    }

    // Você pode adicionar validação extra para o link ser do YouTube
    if (!preg_match('/^(https?\:\/\/)?(www\.youtube\.com|youtu\.be)\/.+$/', $link_musica)) {
        die("Link de música inválido. Use um link do YouTube.");
    }

    // Buscar o array atual de músicas para este acervo no banco
    $sqlGet = "SELECT musicas FROM acervos WHERE id_acervo = ?";
    $stmtGet = $conexao->prepare($sqlGet);
    $stmtGet->bind_param("i", $acervo_id);
    $stmtGet->execute();
    $result = $stmtGet->get_result();
    if ($result->num_rows === 0) {
        die("Projeto não encontrado.");
    }
    $row = $result->fetch_assoc();

    // Assume que 'musicas' é armazenado como JSON no banco (array de links)
    $musicasArray = json_decode($row['musicas'], true);
    if (!is_array($musicasArray)) {
        $musicasArray = [];
    }

    // Adicionar novo link
    $musicasArray[] = $link_musica;

    // Atualizar no banco
    $musicasJson = json_encode($musicasArray);

    $sqlUpdate = "UPDATE acervos SET musicas = ? WHERE id_acervo = ?";
    $stmtUpdate = $conexao->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $musicasJson, $acervo_id);
    if ($stmtUpdate->execute()) {
        // Redirecionar de volta para página de edição
        header("Location: editar-projeto.php?id=" . $acervo_id);
        exit;
    } else {
        echo "Erro ao salvar música.";
    }
} else {
    echo "Método inválido.";
}
?>