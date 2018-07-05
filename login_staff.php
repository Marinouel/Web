<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login staff</title>
	<link rel="stylesheet" type="text/css" href="style_login.css">
</head>
<body>

	<div class="header">
		<h2>Σύνδεση υπαλλήλου</h2>
	</div>
	
	<form method="post" action="login_staff.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" >
		</div>

		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="login_staff">Login</button>
		</div>

	</form>


</body>
</html>