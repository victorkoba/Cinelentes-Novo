<?php
session_start(); // Inicia a sessão, caso ainda não esteja iniciada

// Remove todas as variáveis de sessão
$_SESSION = array();

// Se for necessário, destrói o cookie de sessão (opcional, mas recomendado)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Encerra a sessão
session_destroy();

// Redireciona para a tela de login ou página inicial
header("Location: login.php");
exit;
?>
