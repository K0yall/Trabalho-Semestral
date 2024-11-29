<?php
// Incluir a conexão com o banco de dados
include 'config.php'; // Este arquivo deve conter a configuração de conexão PDO

// Adicionar pergunta
if (isset($_POST['adicionar'])) {
    $texto_pergunta = $_POST['texto_pergunta'];
    $sql = "INSERT INTO perguntas (texto_pergunta) VALUES (:texto_pergunta)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':texto_pergunta', $texto_pergunta);
    $stmt->execute();
}

// Alterar pergunta
if (isset($_POST['alterar'])) {
    $id_pergunta = $_POST['id_pergunta'];
    $novo_texto = $_POST['novo_texto'];
    $sql = "UPDATE perguntas SET texto_pergunta = :novo_texto WHERE id = :id_pergunta";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':novo_texto', $novo_texto);
    $stmt->bindParam(':id_pergunta', $id_pergunta);
    $stmt->execute();
}

// Listar perguntas
$sql = "SELECT * FROM perguntas";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$perguntas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perguntas</title>
    <link rel="stylesheet" href="styles3.css"> <!-- Aqui você pode adicionar seu próprio CSS -->
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Perguntas</h1>
        </div>

        <!-- Formulário para adicionar pergunta -->
        <form method="POST">
            <input type="text" name="texto_pergunta" placeholder="Digite a pergunta" required>
            <button type="submit" name="adicionar">Adicionar Pergunta</button>
        </form>

        <!-- Listar perguntas -->
        <div class="questions-list">
            <h2>Lista de Perguntas:</h2>
            <ul>
                <?php foreach ($perguntas as $pergunta): ?>
                    <li>
                        <p><?php echo $pergunta['texto_pergunta']; ?></p>
                        <form method="POST">
                            <input type="hidden" name="id_pergunta" value="<?php echo $pergunta['id']; ?>">
                            <input type="text" name="novo_texto" placeholder="Novo texto da pergunta">
                            <button type="submit" name="alterar">Alterar Pergunta</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
