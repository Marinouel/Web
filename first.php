<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer or Staff</title>
	<link rel="stylesheet" type="text/css" href="style_login.css">
</head>
<body>

	<div class="header">
		<h2>Καλωσήρθατε στην υπηρεσία Courier</h2>
	</div>
	
	<form method="post" action="first.php">

		<?php include('errors.php'); ?>

		<h3>Σύνδεση ως:</h3>

		<div class="input-group">
			<button type="submit" class="btn" name="administrator">Διαχειριστής</button>
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="customer">Πελάτης</button>
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="staff">Προσωπικό καταστήματος</button>
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="Transit_Hub">Προσωπικό αποθήκης</button>
		</div>

	</form>


</body>
</html>