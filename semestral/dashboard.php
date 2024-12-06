<?php
// Conexão com o banco de dados PostgreSQL
$dsn = 'pgsql:host=localhost;dbname=semestral';  // Ajuste o nome do banco de dados
$username = 'postgres';  // Ajuste o usuário do banco de dados
$password = 'password';  // Ajuste a senha do banco de dados
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
    exit;
}

// Processar criação de uma nova pergunta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_pergunta'])) {
    $nova_pergunta = trim($_POST['nova_pergunta']);
    if (!empty($nova_pergunta)) {
        $stmt = $pdo->prepare("INSERT INTO Perguntas (Texto_Pergunta) VALUES (:texto_pergunta)");
        try {
            $stmt->execute([':texto_pergunta' => $nova_pergunta]);
            header("Location: dashboard.php"); // Recarrega a página após criar a pergunta
            exit;
        } catch (PDOException $e) {
            echo 'Erro ao criar pergunta: ' . $e->getMessage();
        }
    }
}

// Consultar perguntas e respostas existentes
$query = "
    SELECT p.texto_pergunta, a.resposta, a.feedback_textual 
    FROM Perguntas p
    LEFT JOIN Avaliacoes a ON p.id_pergunta = a.id_pergunta
    ORDER BY p.id_pergunta";
$stmt = $pdo->prepare($query);
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consultar estatísticas gerais
$query_media = "SELECT AVG(Resposta) AS media FROM Avaliacoes";
$stmt_media = $pdo->prepare($query_media);
$stmt_media->execute();
$media_respostas = $stmt_media->fetchColumn();

$query_feedbacks = "SELECT COUNT(*) AS total FROM Avaliacoes WHERE Feedback_Textual IS NOT NULL AND Feedback_Textual != ''";
$stmt_feedbacks = $pdo->prepare($query_feedbacks);
$stmt_feedbacks->execute();
$total_comentadas = $stmt_feedbacks->fetchColumn();
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
    <header class="dashboard-header">
        <h1>Dashboard</h1>
        <nav>
            <ul>
                <li><a href="#perguntas">Perguntas</a></li>
                <li><a href="#estatisticas">Estatísticas</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <!-- Seção de estatísticas -->
        <section id="estatisticas">
            <h2>Estatísticas Gerais</h2>
            <div class="statistics-box">
                <div class="stat-item">
                    <h3>Média Geral</h3>
                    <p><strong><?php echo $media_respostas ? number_format($media_respostas, 2) : 'Sem dados'; ?></strong>
                    </p>
                </div>
                <div class="stat-item">
                    <h3>Feedbacks Comentados</h3>
                    <p><strong><?php echo $total_comentadas ?? 0; ?></strong></p>
                </div>
            </div>
        </section>

        <!-- Seção de perguntas e respostas -->
        <section id="perguntas">
            <h2>Perguntas e Respostas</h2>
            <div class="questions-list">
                <?php if (!empty($dados)): ?>
                    <?php foreach ($dados as $item): ?>
                        <div class="question-box">
                            <h3><?php echo htmlspecialchars($item['texto_pergunta']); ?></h3>
                            <p><strong>Resposta:</strong>
                                <?php echo htmlspecialchars($item['resposta'] ?? 'Nenhuma resposta'); ?></p>
                            <p><strong>Feedback:</strong>
                                <?php echo htmlspecialchars($item['feedback_textual'] ?? 'Nenhum feedback'); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Não há perguntas ou respostas disponíveis no momento.</p>
                <?php endif; ?>
            </div>
        </section>


        <!-- Seção para criar perguntas -->
        <section id="criar-perguntas">
            <h2>Criar Nova Pergunta</h2>
            <form action="dashboard.php" method="post">
                <label for="nova_pergunta">Digite a nova pergunta:</label>
                <input type="text" name="nova_pergunta" id="nova_pergunta" placeholder="Digite sua pergunta aqui..."
                    required>
                <button type="submit" class="submit-button-main">Criar Pergunta</button>
            </form>
        </section>
    </main>

    <footer>
        <p>© 2024 Seu Sistema de Avaliação</p>
    </footer>
</body>

</html>