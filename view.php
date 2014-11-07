<?php 
$auth = 0;
include 'lib/includes.php'; 

 if(!isset($_GET['id'])){
 	header('HTTP/1.1 301 Moved Permanently');
 	header('Location:index.php');
 	die();
 }

$work_id = $db->quote($_GET['id']);
$select = $db->query("SELECT * FROM works WHERE id=$work_id");
$works = $select->fetch();

$select = $db->query("SELECT * FROM images WHERE work_id=$work_id");
$images = $select->fetchAll();

include 'partials/header.php';
?>


<h1><?= $works['name']; ?></h1>


<div class="row">
		<div class="col-sm-6">
			<?= $works['content'] ?>
		</div>
		
		<?php foreach ($images as $k => $image): ?>
			<div class="col-sm-3">
				
					<a href="#" class="thumbnail" >
						<img src="<?= WEBROOT; ?>images/works/<?= $image['name']; ?>" width='200px' height='200px' alt="" >
					</a>
				
			</div>
		<?php endforeach ?>
</div>

<?php include 'lib/debug.php'; ?>			
<?php include 'partials/footer.php'; ?>