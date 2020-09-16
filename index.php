<?php
include 'functions.php';
// Conectando com MySQL
$pdo = pdo_connect_mysql();
// Consulta MySQL que seleciona todas as pesquisas e respostas
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Signo Web')?>

<div class="content home">
	<h2>Vote e have fun!</h2>
	<p>Essa é a página inicial! Aqui tem todos os <i>quizzes</i></p>
	<a href="create.php" class="create-poll">Crie seu quiz!</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Título</td>
                <td>Respostas</td>
                <td>Status</td>

                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($polls as $poll): ?>
            <tr>
                <td><?=$poll['id']?></td>
                <td><?=$poll['title']?></td>
                <td><?=$poll['answers']?></td>
                <td>
                <?php
                    $date = strtotime($poll['finish']);
                    $nowDate = strtotime("now");
                    if ($date<$nowDate){
                        echo 'Finalizada';
                    } elseif ($date>$nowDate){
                       echo 'Em andamento';
                    }
                ?>
                </td>

                <td class="actions">
					<a href="vote.php?id=<?=$poll['id']?>" class="view" title="Visualizar"><i class="fas fa-eye fa-xs"></i></a>
                    <a href="edit.php?id=<?=$poll['id']?>" class="view" title="Editar"><i class="fas fa-edit fa-xs"></i></a>
                    <a href="delete.php?id=<?=$poll['id']?>" class="trash" title="Deletar"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>