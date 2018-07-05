<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Απόλυση Προσωπικού σε Αποθήκες Καταστημάτων:</h2>
	</div>

	<form method="post" action="delete_staff_for_transit_hub.php">

	<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="th_staff_username" >
		</div>

		<div class="input-group">
			<label>Transit Hub</label>
			<input type="text" name="tr_hu" >
		</div>


		<div class="input-group">
			<button type="submit" class="btn" name="d_staff_t_h">Διαγραφή</button>
		</div>

		</form>
</body>
</html>