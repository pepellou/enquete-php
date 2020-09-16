<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
if (isset($_GET['id'])) {

    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($poll) {

        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);

        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_POST['poll_answer'])) {

            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
            $stmt->execute([$_POST['poll_answer']]);

            header ('Location: result.php?id=' . $_GET['id']);
            exit;
        }
    } else {
        die ('Não existe enquete com esse ID');
    }
} else {
    die ('Nenhum ID especificado');
}
?>

<?=template_header('Vote em algum')?>

<div class="content poll-vote">
	<h2><?=$poll['title']?></h2>
	<p><?=$poll['desc']?></p>
    <form action="vote.php?id=<?=$_GET['id']?>" method="post">
        <?php for ($i = 0; $i < count($poll_answers); $i++): ?>
        <label>
            <input type="radio" name="poll_answer" value="<?=$poll_answers[$i]['id']?>"<?=$i == 0 ? ' checked' : ''?>>
            <?=$poll_answers[$i]['title']?>
        </label>
        <?php endfor; ?>
        <div>        
        <input type="submit" value="Votar" 
        <?php 
            $date = strtotime($poll['finish']);
            $nowDate = strtotime("now");
             if($date<$nowDate){ ?> disabled style="background-color: #65e6a1; cursor: default" title="desativado"<?php } ?> >

            <a href="result.php?id=<?=$poll['id']?>">Ver resultado</a>
        </div>
    </form>
</div>

<?=template_footer()?>