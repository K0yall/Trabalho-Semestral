<?php
define('DB_HOST', 'localhost');    // Endereço do servidor
define('DB_PORT', '5432');         // Porta do PostgreSQL
define('DB_NAME', 'semestral');    // Nome do banco de dados
define('DB_USER', 'adm');  // Usuário do banco
define('DB_PASSWORD', 'adm123'); // Senha do banco

// Função para obter a string de conexão
function getStringConn()
{
    $connString = "host=" . DB_HOST .
        " port=" . DB_PORT .
        " dbname=" . DB_NAME .
        " user=" . DB_USER .
        " password=" . DB_PASSWORD;
    return $connString;
}
function buscarPergunta()
{
    try {
        $dbconn = pg_connect(getStringConn());
        if ($dbconn) {
            $query = "SELECT * FROM perguntas WHERE status = 'ativa' ORDER BY RANDOM() LIMIT 1;";
            $result = pg_query($dbconn, $query);
            $pergunta = pg_fetch_assoc($result);
            return $pergunta;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function escreverPergunta()
{
    $pergunta = buscarPergunta();

    $retornohtml = '<p class="pergunta">' . $pergunta['texto_pergunta'] . '</p>' .
        '<input type="hidden" value="' . $pergunta['id_pergunta'] . '" name="id_pergunta" id="nota_selecionada">';

    echo $retornohtml;
}
?>