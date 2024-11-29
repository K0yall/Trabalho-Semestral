<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação da Recepção</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="evaluation-box">
            <h1>Avaliação da Recepção</h1>
            <p>Qual é a chance de você indicar o nosso sistema para algum amigo/familiar?</p>
            <br>
            <form action="fim.php" method="post">
                <div class="rating-bar">
                    <?php
                    $valor = isset($_POST['rating']) ? $_POST['rating'] : 0;
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
                        style="background-color: <?php echo getColorForRating($valor); ?>;"
                        onchange="this.form.submit()" />
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
            </form>
        </div>
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
