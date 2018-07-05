<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Απόλυση Προσωπικού από Κατάστημα:</h2>
	</div>

	<form method="post" action="delete_staff.php">

	<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" >
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="d_staff">Διαγραφή</button>
		</div>

		</form>
</body>
</html>