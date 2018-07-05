<?php include('server.php') ?>
<?php 	

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: first.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Λογισμικό Τοπικού Καταστήματος</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="header">
		<h2> Συμπλήρωσε την φόρμα με Κεφαλαία και Ελληνικά </h2>
	</div>

	<div class="content">
	<!-- logged in user information-->
		<?php  if (isset($_SESSION['username'])) : ?>
			<p style="text-align:center;> Καλως ορίσατε </p>
			<p style="text :left;> <a href="os_shop.php?logout='1'" style="color: blue;">logout</a> </p>  
		<?php endif ?>
	</div>
	<form method="post" action="os_shop.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Start</label>
			<input type="text" name="start">
		</div>

		<div class="input-group">
			<label>Termination</label>
			<input type="text" name="termination">
		</div>

		<div class="input-group">
			<label>customer's name</label>
			<input type="text" name="customersname">
		</div>

		<div class="input-group">
			<label>customer's pass</label>
			<input type="text" name="customerspass">
		</div>


		<div class="input-group">
			<button type="submit" class="btn" name="Express">Express</button>
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="No_Express">No Express</button>
		</div>

	</form>


</body>
</html>