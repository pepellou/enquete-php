<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Verifica se o ID da pesquisa existe
if (isset($_GET['id'])) {
    // Seleciona o registro que será excluído
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$poll) {
        die ('Não existe nenhuma enquete com esse ID');
    }
    // Certifica de que o usuário confirme antes da exclusão
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Se o usuário clicou no botão "Sim", excluir registro
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            // e também é preciso deletar as respostas dessa enquete
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE poll_id = ?');
            $stmt->execute([$_GET['id']]);
            // mensagem de saída
            $msg = 'Você deletou essa enquete!';
        } else {
            // Se o usuário clicou no botão "Não", redirecionando-o de volta para a página inicial / índice
            header('Location: index.php');
            exit;
        }
    }
} else {
    die ('ID não identificado!');
}
?>

<?=template_header('Apagar enquete?')?>

<div class="content delete">
	<h2>Apagar enquete #<?=$poll['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Você tem certeza que deseja apagar o #<?=$poll['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$poll['id']?>&confirm=yes">Sim</a>
        <a href="delete.php?id=<?=$poll['id']?>&confirm=no">Não</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>