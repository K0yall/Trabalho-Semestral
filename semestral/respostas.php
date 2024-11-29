<?php
// Configuração de erro para exibir todos os erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão com o banco de dados
$dsn = 'pgsql:host=localhost;dbname=semestral';  // Ajuste o nome do banco de dados
$username = 'adm';  // Ajuste o usuário do banco de dados
$password = 'adm123';  // Ajuste a senha do banco de dados
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}

// Obter respostas com as perguntas
$sql = "SELECT p.texto_pergunta, r.valor_feedback, r.comentario_feedback 
        FROM respostas r
        JOIN perguntas p ON r.id_pergunta = p.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$respostas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respostas e Avaliações</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Respostas e Avaliações</h1>
        <div class="evaluation-box">
            <table class="evaluation-table">
                <thead>
                    <tr>
                        <th>Pergunta</th>
                        <th>Avaliação</th>
                        <th>Comentário</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($respostas as $resposta): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($resposta['texto_pergunta']); ?></td>
                        <td><?php echo htmlspecialchars($resposta['valor_feedback']); ?>/10</td>
                        <td><?php echo htmlspecialchars($resposta['comentario_feedback'] ?? 'Nenhum comentário'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
