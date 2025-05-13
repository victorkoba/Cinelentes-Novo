<?php
$servername = "localhost";  // Ou o endereço do seu servidor de banco de dados
$username = "root";         // Seu usuário de banco de dados
$password = "";             // Sua senha de banco de dados
$dbname = "cinelentes";  // Nome do seu banco de dados

// Criação da conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Verifica se há erro na conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
?>
