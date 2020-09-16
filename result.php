<?php
include 'functions.php';
// conecta ao mysql
$pdo = pdo_connect_mysql();
// verifica se pegou o id pela requisição get
if (isset($_GET['id'])) {
    // Consulta MySQL que seleciona os registros de enquete pela solicitação GET "id"
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Pegue o registro
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    //Verifique se o registro de enquete existe com o id especificado
    if ($poll) {
        // Consulta do MySQL que obterá todas as respostas da tabela "poll_answers" ordenadas pelo número de votos (decrescente)
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([$_GET['id']]);
        // Obter todas as respostas da enquete
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Número total de votos, será usado para calcular a porcentagem
        $total_votes = 0;
        foreach ($poll_answers as $poll_answer) {
            // Todos os votos de respostas à enquete serão adicionados ao total de votos
            $total_votes += $poll_answer['votes'];
        }
    } else {
        die ('Enquete com esse Identificador não existe');
    }
} else {
    die ('Identificador não especificado');
}
?>

<?=template_header('Resultados')?>

<div class="content poll-result">
	<h2><?=$poll['title']?></h2>
	<p><?=$poll['desc']?></p>
    <div class="wrapper">
        <?php foreach ($poll_answers as $poll_answer): ?>
        <div class="poll-question">
            <p><?=$poll_answer['title']?> <span>(<?=$poll_answer['votes']?> Votes)</span></p>
            <div class="result-bar" style= "width:<?=@round(($poll_answer['votes']/$total_votes)*100)?>%">
                <?=@round(($poll_answer['votes']/$total_votes)*100)?>%
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>