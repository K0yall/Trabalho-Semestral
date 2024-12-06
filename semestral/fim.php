<?php
// Página de encerramento
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação Concluída</title>
    <link rel="stylesheet" href="styles1.css"> <!-- Link para o CSS externo -->
</head>

<body>
    <div class="container">
        <h1>Obrigado por sua avaliação!</h1>
        <p class="subtext">
            <br>
            O Hospital Regional Alto Vale (HRAV) agradece sua resposta.<br>
            <br>
            Sua opinião é fundamental para melhorarmos continuamente nossos serviços.
        </p>
        <p class="countdown">
            Você será redirecionado em <span id="contador">5</span> segundos...
        </p>
    </div>

    <script>
        let countdown = 5;

        function updateCountdown() {
            const contador = document.getElementById('contador');
            contador.textContent = countdown;

            if (countdown === 0) {
                window.location.href = 'avaliacao_geral.php'; // Substitua pelo URL correto
            } else {
                countdown--;
                setTimeout(updateCountdown, 1000);
            }
        }

        // Inicia o contador quando a página é carregada
        window.onload = updateCountdown;
    </script>
</body>

</html>
