<?php
include '../lib/includes.php';
include '../partials/admin_header.php';

/**
* SUPPRESSION
**/

if(isset($_GET['delete'])){
	checkCsrf();
	$id = $db->quote($_GET['delete']);
	$db->query("DELETE FROM works WHERE id=$id");
	setFlash('La réalisation à bien été supprimer');
	header('Location:work.php');
	die();
}

/**
*CATEGORIES
**/

$select = $db->query("SELECT id, name, slug FROM works");
$works = $select->fetchAll();

?>

<h1>Mes réalisations</h1>

<p><a href="work_edit.php" class="btn btn-success">Ajouter une réalisation</a></p>

<table class="table table-striped">
	<thead>
		<tr>
			<td>Id</td>
			<td>Nom</td>
			<td>Actions</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($works as $work): ?>
			<tr>
				<td><?= $work['id']; ?></td>
				<td><?= $work['name']; ?></td>
				<td>
					<a href="work_edit.php?id=<?= $work['id']; ?>" class="btn btn-default">Modifier</a>
					<a href="?delete=<?= $work['id']; ?>&<?= csrf(); ?>" class="btn btn-error" onclick="return confirm('Etes vous sur de vouloir faire ça ?');">Supprimer</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php include '../partials/footer.php'; ?>
<?php include '../lib/debug.php'; ?>