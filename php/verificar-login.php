<?php
session_start();

// Impede o navegador de usar cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verifica se o administrador está logado
if (!isset($_SESSION['administrador']) || !isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
?>