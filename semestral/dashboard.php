<?php
// Dashboard simples em PHP
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Título maior e mais destacado -->
        <div class="header">
            <h1>Bem-vindo ao Dashboard</h1>
        </div>
        
        <div class="cards-container">
            <!-- Card 1: Perguntas (clicável) -->
            <a href="perguntas.php" class="card">
                <h2>Perguntas</h2>
                <p>Alterar e Adicionar perguntas</p>
            </a>
            
            <!-- Card 2: Sair (clicável) -->
            <a href="sair.php" class="card">
                <h2>Sair</h2>
                <p>Faça logout da plataforma</p>
            </a>
            
            <!-- Card 3: Respostas (clicável) -->
            <a href="respostas.php" class="card">
                <h2>Respostas</h2>
                <p>Alterar ou Remover respostas</p>
            </a>
        </div>
    </div>
</body>
</html>
