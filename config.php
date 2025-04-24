<?php
$host = "localhost"; // ou 127.0.0.1
$usuario = "root"; // usuário do MySQL
$senha = ""; // senha do MySQL
$banco = "odonto-gpt"; // nome do banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    // Definindo o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
