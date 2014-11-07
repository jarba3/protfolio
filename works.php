<?php 
$auth = 0;
include 'lib/includes.php'; 
include 'partials/header.php';

$select = $db->query("
	SELECT works.name, works.id, works.slug, images.name AS image_name 
	FROM works 
	LEFT JOIN images 
	ON images.name = works.images_id");
$works = $select->fetchAll();
?>

<h1>Mon portfolio en PHP</h1>


<div class="row">
	<?php foreach ($works as $k => $work): ?>
		<div class="col-sm-3">
			<a href="view.php?id=<?= $work['id']; ?>" >
			<img src="<?= WEBROOT; ?>images/works/<?= $work['image_name']; ?>" width='150px' height='150px' alt="">
				<h4><?= $work['name']; ?></h4>
			</a>
		</div>
	<?php endforeach; ?>
</div>

<?php include 'lib/debug.php'; ?>			
<?php include 'partials/footer.php'; ?>