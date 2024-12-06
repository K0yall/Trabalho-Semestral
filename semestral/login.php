<?php
session_start();
require_once 'config.php'; // Arquivo de conexão com o banco de dados

// Variável de erro
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar se o usuário existe
    $sql = "SELECT * FROM Usuarios_Administrativos WHERE Login = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);

    // Verifica se o usuário existe e a senha está correta
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        if ($password == $user['senha']) { // Corrigido para 'senha' em minúsculo
            $_SESSION['usuario'] = $username;
            header("Location: dashboard.php"); // Redireciona para o painel de administração
            exit();
        } else {
            $erro = "Senha incorreta!";
        }        
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles2.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="username">Usuário:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <?php if (isset($erro)) {
                    echo "<p class='error-message'>$erro</p>";
                } ?>

                <div class="button-group">
                    <button type="submit" class="login-btn">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
