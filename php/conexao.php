<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cinelentes";

// Criação da conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Verifica se há erro na conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
?>