<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Portfolio</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
		<div class="container">
		<header>	
			<div class="col-sm-2"><img src="images/logo150x150.jpg" alt="logo">	</div>
			<div class="col-sm-10"><h1>Mon portfolio</h1></div>
		</header>
		<div class="navbar navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Accueil</a>
				</div>
				<div class="navbar-header">
					<a href="<?= WEBROOT; ?>works.php" class="navbar-brand">Mes réalisations</a>
				</div>
				<div class="navbar-header">
					<a href="<?= WEBROOT; ?>skills.php" class="navbar-brand">Mes compétences</a>
				</div>
				<div class="navbar-header navbar-right">
					<a class="navbar-brand" href="login.php">Administration</a>
				</div>
			</div>
		</div>
		</div>
		<div class="container">

		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>

		<?= Flash(); ?>