<?php include('server.php') ?>
<?php 
	if (isset($_GET['back'])) {
		header("location: admin.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Τροποποίηση Προσωπικού σε Αποθήκες Καταστημάτων:</h2>
	</div>


	<form method="post" action="change_staff_for_transit_hub.php">

	<?php include('errors.php'); ?>

		<div class="input-group">
			<button type="submit" class="btn" name="show_thstaff">Δείτε το προσωπικό</button>
		</div>

		<?php 
			if (isset($_POST['show_thstaff'])) {
		
				$sql= "SELECT * FROM th_staff";
				$result = mysqli_query($db, $sql);

				echo "<table border='1'>
				<tr>
				<th>username</th>
				<th>password</th>
				<th>transit_hub_city</th>
				</tr>";

				while($row = mysqli_fetch_array($result))
				{
					echo "<tr>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['password'] . "</td>";
					echo "<td>" . $row['transit_hub_city'] . "</td>";
					echo "</tr>";
				}	
				echo "</table>";
			}
		?>
		
		<p> <strong>Τροποποίηση username</strong> </p>
		<div class="input-group">
			<label>Τρέχον username</label>
			<input type="text" name="username" >
		</div>

		<div class="input-group">
			<label>Νέο username</label>
			<input type="text" name="nusername" >
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="ch_thstaff_name">Αλλαγή ονόματος χρήστη</button>
		</div>

		<p> <strong>Τροποποίηση password</strong> </p>
		<div class="input-group">
			<label>username</label>
			<input type="text" name="pusername" >
		</div>

		<div class="input-group">
			<label>Τρέχον password</label>
			<input type="text" name="password" >
		</div>

		<div class="input-group">
			<label>Νέος password</label>
			<input type="text" name="npassword" >
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="ch_thstaff_pass">Αλλαγή κωδικού</button>
		</div>

		<p> <a href="change_staff_for_transit_hub.php?back='1'" style="color: yellow;">back</a> </p>

		</form>
</body>
</html>