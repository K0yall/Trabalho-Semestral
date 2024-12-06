<?php
$host = 'localhost'; // Host do banco de dados
$db = 'semestral'; // Nome do banco de dados
$user = 'adm'; // Usuário do banco
$pass = 'adm123'; // Senha do banco

try {
    // Configuração da conexão com o banco de dados PostgreSQL
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
