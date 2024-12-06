<?php
// Configuração de erro para exibir todos os erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Processar o envio do formulário (feedback)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os valores do formulário
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;  // Nota de 0 a 10
    $feedback = isset($_POST['feedback']) ? trim($_POST['feedback']) : '';  // Comentário do feedback

    // IDs fixos - ajuste conforme necessário
    $id_setor = 1;       // ID do setor (exemplo fixo)
    $id_dispositivo = 1; // ID do dispositivo (exemplo fixo)
    $id_pergunta = $_POST['id_pergunta'];    // ID da pergunta (exemplo fixo)

    // Inserir a avaliação no banco de dados
    $stmt = $pdo->prepare("
        INSERT INTO Avaliacoes (ID_Setor, ID_Pergunta, ID_Dispositivo, Resposta, Feedback_Textual) 
        VALUES (:id_setor, :id_pergunta, :id_dispositivo, :resposta, :feedback)
    ");

    try {
        $stmt->execute([
            ':id_setor' => $id_setor,
            ':id_pergunta' => $id_pergunta,
            ':id_dispositivo' => $id_dispositivo,
            ':resposta' => $rating,
            ':feedback' => $feedback
        ]);

        // Redireciona para a próxima página após a inserção
        header('Location: fim.php');
        exit;
    } catch (PDOException $e) {
        echo 'Erro ao inserir avaliação: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação Geral</title>
    <link rel="stylesheet" href="styles1.css">
</head>

<body>
    <div class="container">
        <form class="evaluation-box" action="avaliacao_geral.php" method="post"> 
            <h1>Avaliação Geral</h1>
            <?php
                require_once('controle_pergunta.php');
                escreverPergunta();
            ?>
            <div >
                <div class="rating-bar">
                    <?php
                    $valor = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
                    ?>
                    <div class="numbers">
                        <?php for ($i = 0; $i <= 10; $i++) { ?>
                            <span class="number" data-value="<?php echo $i; ?>"
                                style="background-color: <?php echo getColorForRating($i); ?>;"
                                onclick="changeRating(<?php echo $i; ?>)">
                                <?php echo $i; ?>
                            </span>
                        <?php } ?>
                    </div>
                    <input type="range" name="rating" id="rating" min="0" max="10" step="1"
                        value="<?php echo $valor; ?>"
                        style="background-color: <?php echo getColorForRating($valor); ?>;" />
                </div>

                <div class="feedback">
                    <label for="feedback">Deixe um comentário (opcional):</label>
                    <textarea name="feedback" id="feedback" rows="4"
                        placeholder="Digite seu feedback aqui..."></textarea>
                </div>

                <div class="buttons">
                    <button type="submit" class="submit-button-main">Finalizar</button>
                </div>
                <!-- Rodapé dentro da caixa, logo abaixo do botão -->
                <p style="text-align: center; font-size: 12px; color: #777; margin-top: 10px;">
                    Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.
                </p>
            </div>
        </form>
    </div>

    <?php
    function getColorForRating($value)
    {
        $colors = [
            "#ff0000",
            "#ff4000",
            "#ff8000",
            "#ffc000",
            "#ffff00",
            "#bfff00",
            "#80ff00",
            "#40ff00",
            "#00ff00",
            "#00ff80",
            "#00ffb3"
        ];
        return $colors[$value];
    }
    ?>

    <script>
        function changeRating(value) {
            const color = getColorForRating(value);
            document.getElementById('rating').value = value;
            document.getElementById('rating').style.backgroundColor = color;
        }

        function getColorForRating(value) {
            const colors = [
                "#ff0000", "#ff4000", "#ff8000", "#ffc000", "#ffff00",
                "#bfff00", "#80ff00", "#40ff00", "#00ff00", "#00ff80", "#00ffb3"
            ];
            return colors[value];
        }
    </script>
</body>

</html>