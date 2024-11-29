<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Adicionar nova pergunta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nova_pergunta'])) {
    $nova_pergunta = $_POST['nova_pergunta'];
    $stmt = $pdo->prepare("INSERT INTO perguntas (texto_pergunta) VALUES (:texto)");
    $stmt->execute(['texto' => $nova_pergunta]);
    header("Location: gerenciar_perguntas.php");
    exit();
}

// Excluir pergunta
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM perguntas WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header("Location: gerenciar_perguntas.php");
    exit();
}

// Listar perguntas
$perguntas = $pdo->query("SELECT * FROM perguntas ORDER BY id")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Perguntas</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <h1>Gerenciar Perguntas</h1>

    <form method="POST">
        <input type="text" name="nova_pergunta" placeholder="Digite uma nova pergunta" required>
        <button type="submit">Adicionar</button>
    </form>

    <ul>
        <?php foreach ($perguntas as $pergunta): ?>
            <li>
                <?php echo htmlspecialchars($pergunta['texto_pergunta']); ?>
                <a href="?excluir=<?php echo $pergunta['id']; ?>">Excluir</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Sair</a>
</body>
</html>
