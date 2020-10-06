<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Verifique se os dados POST não estão vazios
if (!empty($_POST)) {
    // Os dados de postagem não estão vazios insira um novo registro
    // Verifique se a variável POST "title" existe, se não for o padrão, o valor ficará em branco, basicamente o mesmo para todas as variáveis
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
    $initial = isset($_POST['initial']) ? $_POST['initial'] : '';
    $finish = isset($_POST['finish']) ? $_POST['finish'] : '';
    // Insira um novo registro na tabela "poll"
    $stmt = $pdo->prepare('INSERT INTO polls VALUES (NULL, ?, ?, ?, ?)');
    $stmt->execute([$title, $desc, $initial, $finish]);
    // Abaixo obterá o último ID de inserção, este será o ID da enquete
    $poll_id = $pdo->lastInsertId();
    // Obtenha as respostas e converta a string multilinha em um array, para que possamos adicionar cada resposta à tabela "poll_answers"
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
    foreach ($answers as $answer) {
	$answer = trim($answer);
        //Se a resposta estiver vazia, não há necessidade de inserir
        if (empty($answer)) continue;
        // Adicionando questionário a tabela poll_awnwers
        $stmt = $pdo->prepare('INSERT INTO poll_answers VALUES (NULL, ?, ?, 0)');
        $stmt->execute([$poll_id, $answer]);
    }
    // Mensagem de saída
    $msg = 'Quiz criado com sucesso!';
}
?>

<?=template_header('Criando quiz')?>

<div class="content update">
	<h2>Criando um quiz...</h2>
    <form action="create.php" method="post" class="create">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" required>
        <label for="desc">Descrição</label>
        <input type="text" name="desc" id="desc" required>
        <label for="initial">Data de inicio</label>
        <input type="date" id="initial" name="initial" required> 
        <label for="initial">Data de finalização</label>
        <input type="date" id="finish" name="finish" required>
        <label for="answers" >Respostas (separe por linhas)</label>
        <textarea name="answers" id="answers" required></textarea>
        <input type="submit" value="Criar ">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
