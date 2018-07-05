<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Διαγραφή καταστήματος:</h2>
	</div>

	<form method="post" action="delete_store.php">

		<?php include('errors.php'); ?>
	
		<div class="input-group">
			<label>Όνομα</label>
			<input type="text" name="name" >
		</div>
		<div class="input-group">
			<label>Transit Hub</label>
			<input type="text" name="transit" >
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="delete">Διαγραφή</button>
		</div>

	</form>
</body>
</html>
