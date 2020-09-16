<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
        $pollQuery = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $pollQuery->execute([$_GET['id']]);
        $poll_answers = $pollQuery->fetchAll(PDO::FETCH_ASSOC);
        foreach ($poll_answers as $poll_answer) {
            $poll_answer['title'];
        }
    }

if (!empty($_POST)) {
//TODO
}
?>

<?=template_header('Editando quiz')?>
<div class="content update">
	<h2>Editando um quiz...</h2>
    <form action="edit.php" method="post" class="create">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" value="<?php echo $poll['title']?>">
        <label for="descr">Descrição</label>
        <input type="text" name="descr" id="descr" value="<?php echo $poll['desc']?>">
        <label for="initial">Data de inicio</label>
        <input type="date" id="initial" name="initial" value="<?php echo $poll['initial']?>">
        <label for="initial">Data de finalização</label>
        <input type="date" id="finish" name="finish" value="<?php echo $poll['finish']?>">
        <label for="answers">Respostas (separe por linhas)</label>
        <textarea name="answers" id="answers">
            <?php
            foreach ($poll_answers as $poll_answer) {
                echo $poll_answer['title'];
            }
            ?>
        </textarea>
        <input type="submit" value="Editar ">
    </form>
</div>

<?=template_footer()?>