<?php
include '../lib/includes.php';

if(isset($_POST['name']) && isset($_POST['slug'])){
	checkCsrf();
	$slug = $_POST['slug'];
	if(preg_match('/^[a-z\-0-9]+$/', $slug)){
		$name = $db->quote($_POST['name']);
		$slug = $db->quote($_POST['slug']);
		if(isset($_GET['id'])){
			$id = $db->quote($_GET['id']);
			$db->query("UPDATE categories SET name=$name, slug=$slug WHERE id=$id");	
			setFlash('La catégorie à bien été modifiée');
		}else{
			$db->query("INSERT INTO categories SET name=$name, slug=$slug");	
			setFlash('La catégorie à bien été ajoutée');
		}
		header('Location:category.php');
		die();

	}else{
		setFlash('Le slug n\'est pas valide', 'danger');
	}
}

if(isset($_GET['id'])){
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT * FROM categories WHERE id=$id");
	if($select->rowCount() == 0){
		setFlash("Il n'y a pas de catégorie avec cette ID", 'danger');
		header('Location:category.php');
		die();
	}
		$_POST  = $select->fetch();
}

include '../partials/admin_header.php';
?>

<h1>Editer un catégorie</h1>

<form action="#" method="post">
	<div class="form-group">
		<label for="name">Nom de la catégorie</label>
		<?= input('name'); ?>
	</div>
	<div class="form-group">
		<label for="slug">Url de la catégorie</label>
		<?= input('slug'); ?>
	</div>
	<?= csrfInput(); ?>
	<button type="submit" class="btn btn-default">Enregistrer</button>
</form>

<?php include '../partials/footer.php'; ?>
<?php include '../lib/debug.php'; ?>