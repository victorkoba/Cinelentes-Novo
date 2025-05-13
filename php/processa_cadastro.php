<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Criptografar a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verificar se o e-mail já existe
    $sql_verifica = "SELECT id_adm FROM administradores WHERE email_adm = ?";
    $stmt_verifica = $conexao->prepare($sql_verifica);
    $stmt_verifica->bind_param("s", $email);
    $stmt_verifica->execute();
    $stmt_verifica->store_result();

    if ($stmt_verifica->num_rows > 0) {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'E-mail já cadastrado!'
                }).then(() => window.location.href = 'cadastro.php');
            </script>
        </body>
        </html>";
        exit;
    }

    // Inserir novo administrador
    $sql = "INSERT INTO administradores (email_adm, senha_adm) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $email, $senha_hash);
        if ($stmt->execute()) {
            echo "<!DOCTYPE html>
            <html lang='pt-br'>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Administrador cadastrado com sucesso!'
                    }).then(() => window.location.href = 'login.php'); // redireciona para login
                </script>
            </body>
            </html>";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta.";
    }

    $stmt_verifica->close();
    $conexao->close();
}
?>
