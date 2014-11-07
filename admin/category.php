<?php
include '../lib/includes.php';
include '../partials/admin_header.php';

/**
* SUPPRESSION
**/

if(isset($_GET['delete'])){
	checkCsrf();
	$id = $db->quote($_GET['delete']);
	$db->query("DELETE FROM categories WHERE id=$id");
	setFlash('La catégorie à bien été supprimer');
	header('Location:category.php');
	die();
}

/**
*CATEGORIES
**/

$select = $db->query('SELECT id, name, slug FROM categories');
$categories = $select->fetchAll();

?>

<h1>Les catégories</h1>

<p><a href="category_edit.php" class="btn btn-success">Ajouter une catégorie</a></p>

<table class="table table-striped">
	<thead>
		<tr>
			<td>Id</td>
			<td>Nom</td>
			<td>Actions</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($categories as $category): ?>
			<tr>
				<td><?= $category['id']; ?></td>
				<td><?= $category['name']; ?></td>
				<td>
					<a href="category_edit.php?id=<?= $category['id']; ?>" class="btn btn-default">Modifier</a>
					<a href="?delete=<?= $category['id']; ?>&<?= csrf(); ?>" class="btn btn-error" onclick="return confirm('Etes vous sur de vouloir faire ça ?');">Supprimer</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php include '../partials/footer.php'; ?>
<?php include '../lib/debug.php'; ?>