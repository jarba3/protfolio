<?php
include '../lib/includes.php';
/**
* ON SAUVEGARDE
**/
if(isset($_POST['name']) && isset($_POST['slug'])){
	checkCsrf();
	$slug = $_POST['slug'];
	if(preg_match('/^[a-z\-0-9]+$/', $slug)){
		$name = $db->quote($_POST['name']);
		$slug = $db->quote($_POST['slug']);
		$category_id = $db->quote($_POST['category_id']);
		$content = $db->quote($_POST['content']);
		/**
		* SAUVEGARDE de la réalisation
		**/
		if(isset($_GET['id'])){
			$id = $db->quote($_GET['id']);
			$db->query("UPDATE works SET name=$name, slug=$slug, content=$content, category_id=$category_id WHERE id=$id");
			setFlash('La réalisation à bien été modifiée');
		}else{
			$db->query("INSERT INTO works SET name=$name, slug=$slug, content=$content, category_id=$category_id");	
			$_GET['id'] = $db->lastInsertId();
			setFlash('La réalisation à bien été ajoutée');
		}
		/**
		*ENVOIS DES IMAGES
		**/
		$work_id = $db->quote($_GET['id']);
		$files = $_FILES['images'];
		$images = array();
		foreach($files['tmp_name'] as $k => $v){
				$images = array(
					'name' => $files['name'][$k],
					'tmp_name' => $files['tmp_name'][$k]
					);
				$extension = pathinfo($images['name'], PATHINFO_EXTENSION);
				if(in_array($extension, array('jpg', 'png', 'JPG'))){
					$db->query("INSERT INTO images SET work_id=$work_id");
					$image_id = $db->lastInsertId();
					$image_name = $image_id . '.' . $extension;
					move_uploaded_file($images['tmp_name'], IMAGES . '/works/' . $image_name);
					require '../lib/image.php';
					resizeImage(IMAGES . '/works/' . $image_name, 150,150);
					$image_name = $db->quote($image_name);
					$db->query("UPDATE images SET name=$image_name WHERE id=$image_id");
				 }
		}
		header('Location:work.php');
		die();

	}else{
		setFlash('Le slug n\'est pas valide', 'danger');
	}
}
/**
* ON RECUP REALISATION
**/
if(isset($_GET['id'])){
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT * FROM works WHERE id=$id");
		if($select->rowCount() == 0){
			setFlash("Il n'y a pas de réalisation avec cette ID", 'danger');
			header('Location:work.php');
			die();
		}
	$_POST  = $select->fetch();
}
/**
*On recupere les categories
**/
$select = $db->query("SELECT id, name FROM categories ORDER BY name ASC");
$categories = $select->fetchAll();
$categories_list = array();
foreach ($categories as $category) {
	$categories_list[$category['id']] = $category['name'];
}
/**
*On recupere les images
**/
if(isset($_GET['id'])){
	$work_id = $db->quote($_GET['id']);
	$select = $db->query("SELECT id, name FROM images WHERE work_id=$work_id");
	$images = $select->fetchAll();
}else{
	$images = array();
}

/**
*On supprime une image
**/

if(isset($_GET['delete_image'])){
	checkCsrf();
	$id = $db->quote($_GET['delete_image']);
	$select = $db->query("SELECT name, work_id FROM images WHERE id=$id");
	$image = $select->fetch();
	unlink(IMAGES . '/works/' . $image['name']);
	$db->query("DELETE FROM images WHERE id=$id");
	header('Location:work_edit.php?id=' . $image['work_id']);
	die();
}

/**
*Mise en avant image
**/
if(isset($_GET['highlight_image'])){
	checkCsrf();
	$work_id = $db->quote($_GET['id']);
	$image_id = $db->quote($_GET['highlight_image']);
	$db->query("UPDATE works SET images_id=$image_id WHERE id=$work_id");
	setFlash('L\'image à bien été mise en avant');
	header('Location:work_edit.php?id=' . $_GET['id']);
	die();
}

include '../partials/admin_header.php';
?>

<h1>Editer un réalisation</h1>

<div class="row">
		<form action="#" method="POST" enctype="multipart/form-data">
			<div class="col-sm-8">
					<div class="form-group">
						<label for="name">Nom de la réalisation</label>
						<?= input('name'); ?>
					</div>
					<div class="form-group">
						<label for="slug">Url de la réalisation</label>
						<?= input('slug'); ?>
					</div>
					<div class="form-group">
						<label for="content">Contenu</label>
						<?= textarea('content'); ?>
					</div>
					<div class="form-group">
						<label for="category_id">Catégorie</label>
						<?= select('category_id', $categories_list); ?>
					</div>
					<?= csrfInput(); ?>
					
					<button type="submit" class="btn btn-default">Enregistrer</button>
			</div>
			<div class="col-sm-4">
					<?php foreach ($images as $k => $image): ?>
						</p>
							<div class="form-group">
									<img src="<?= WEBROOT; ?>images/works/<?= $image['name']; ?>" width='100px'>
									<a href="?delete_image=<?= $image['id']; ?>&<?= csrf();?>" onclick="return confirm('Etes vous sur de vouloir faire cela ?')">Suprimer</a>
									<a href="?highlight_image=<?= $image['id']; ?>&id=<?= $_GET['id']; ?>&<?= csrf(); ?>">Mettre à la une</a>
							</div>
						<p>
							
					<?php endforeach ?>
				<div class="form-group">
					<input type="file" name="images[]">
					<input type="file" name="images[]" class="hidden" id="duplicate">
				</div>
				<div class="form-group">
					<a href="#" class="btn btn-success" id="duplicateBtn">Ajouter une image</a>
				</div>
			</div>
		</form>
</div>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">

	$('#duplicateBtn').click(function(e){
		e.preventDefault();
		var $clone = $('#duplicate').clone().attr('id', '').removeClass('hidden');
		$('#duplicate').before($clone);
	});

</script>
<?php include '../partials/footer.php'; ?>
<?php include '../lib/debug.php'; ?>