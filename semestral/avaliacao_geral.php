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

// Processar o envio do formulário (feedback)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os valores do formulário
    $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;  // Nota de 0 a 10
    $feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';  // Comentário do feedback

    // ID da pergunta - você pode ajustar conforme necessário
    $id_pergunta = 1; // A ID da pergunta sendo avaliada (ajuste conforme necessário)

    // Inserir o feedback e a pontuação no banco de dados
    $stmt = $pdo->prepare("INSERT INTO respostas (id_pergunta, valor_feedback, comentario_feedback) 
                        VALUES (:id_pergunta, :valor_feedback, :comentario_feedback)");

    $stmt->execute([
        ':id_pergunta' => $id_pergunta,
        ':valor_feedback' => $rating,
        ':comentario_feedback' => $feedback
    ]);

    // Redireciona para a próxima página após a inserção
    header('Location: avaliacao_enfermagem.php'); // Substitua "proxima_pagina.php" pelo nome da próxima página
    exit;  // Certifique-se de que o código PHP pare de ser executado após o redirecionamento
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação Geral</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="evaluation-box">
            <h1>Avaliação Geral</h1>
            <p>Como você avalia, de forma geral, o nosso hospital?</p>
            <br>
            <form action="avaliacao_geral.php" method="post">
                <div class="rating-bar">
                    <?php
                    $valor = isset($_POST['rating']) ? $_POST['rating'] : 0;
                    ?>
                    <div class="numbers">
                        <?php for ($i = 0; $i <= 10; $i++) { ?>
                            <span class="number" data-value="<?php echo $i; ?>"
                                style="background-color: <?php echo getColorForRating($i); ?>"
                                onclick="changeRating(<?php echo $i; ?>)">
                                <?php echo $i; ?>
                            </span>
                        <?php } ?>
                    </div>
                    <input type="range" name="rating" id="rating" min="0" max="10" step="1"
                        value="<?php echo $valor; ?>"
                        style="background-color: <?php echo getColorForRating($valor); ?>;"
                        onchange="this.form.submit()" />
                </div>

                <div class="feedback">
                    <label for="feedback">Deixe um comentário (opcional):</label>
                    <textarea name="feedback" id="feedback" rows="4"
                        placeholder="Digite seu feedback aqui..."></textarea>
                </div>

                <div class="buttons">
                    <button type="submit" class="submit-button-main">Próximo</button>
                </div>

                <!-- Rodapé dentro da caixa, logo abaixo do botão -->
                <p style="text-align: center; font-size: 12px; color: #777; margin-top: 10px;">
                    Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.
                </p>
            </form>
        </div>
    </div>

    <?php
    function getColorForRating($value)
    {
        $colors = [
            "#ff0000", "#ff4000", "#ff8000", "#ffc000", "#ffff00",
            "#bfff00", "#80ff00", "#40ff00", "#00ff00", "#00ff80", "#00ffb3"
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
