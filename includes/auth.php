<?php
// 🔐 Segurança de sessão - deve vir antes do session_start
session_start();

🚨 Proteção contra Session Hijacking
if (isset($_SESSION['user_id'])) {
    // Verifica IP e navegador
    $ip_check = $_SESSION['ip_address'] ?? '';
    $agent_check = $_SESSION['user_agent'] ?? '';

    if ($ip_check !== $_SERVER['REMOTE_ADDR'] || $agent_check !== $_SERVER['HTTP_USER_AGENT']) {
        // Destrói sessão e força novo login
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit();
    }
}

// 🔐 Função para verificar login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// 🔐 Redireciona se não estiver logado
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}
?>