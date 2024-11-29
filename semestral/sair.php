<?php
// sair.php
session_start();
// Simulando o processo de logout, removendo as variáveis de sessão
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sair</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Você saiu da plataforma!</h1>
        </div>

        <div class="logout-message">
            <p>Você foi desconectado com sucesso. Até logo!</p>
            <a href="index.php" class="btn-action">Voltar ao Login</a>
        </div>
    </div>
</body>
</html>
