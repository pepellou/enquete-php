<?php
function pdo_connect_mysql() {
    // Configurações do banco de dados
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'phppoll';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	//Se houver um erro na conexão, pare o script e exiba o erro.
    	die ('Conexão falhou ao conectar com o nosso próprio banco! Desculpa, tenta novamente mais tarde =)');
    }
}

// header template
function template_header($title) {
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Signo<strong>WEB</strong></h1>
                <a href="index.php"><i class="fas fa-poll-h"></i>Enquetes</a>
            </div>
        </nav>
    EOT;
}

    // fotter footer
function template_footer() {
    echo <<<EOT
        </body>
    </html>
    EOT;
}