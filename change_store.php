<?php include('server.php') ?>
<?php 
	if (isset($_GET['back'])) {
		header("location: admin.php");
	}
?>
<?php

			//create commection
			$db = mysqli_connect("localhost", "root", "", "courier");
			mysqli_set_charset($db, "utf8");

			// Check connection
			if ($db == false) {
   				die("Connection failed: " . mysqli_connect_error());
			}
		
		    $query = "SELECT * FROM local_store ORDER BY name ASC";
			$result = mysqli_query($db, $query);

			mysqli_close($db);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Αλλαγή Στοιχείων σε Κατάστημα</h2>
	</div>

	<div class="content">
	<p> <strong><em>Στοιχεία τοπικών καταστημάτων</em></strong> </p>

		<table width="50%" border="1" cellspacing="3" cellpadding="3">
		<tr>
		<th><font face="Times New Roman">όνομα</font></th>
		<th><font face="Times New Roman">οδός</font></th>
		<th><font face="Times New Roman">αριθμός</font></th>
		<th><font face="Times New Roman">πόλη</font></th>
		<th><font face="Times New Roman">τηλέφωνο</font></th>
		<th><font face="Times New Roman">ΤΚ</font></th>
		<th><font face="Times New Roman">Συντεταγμένες</font></th>
		<th><font face="Times New Roman">Transit Hub</font></th>
		</tr>

		<?php
		while ($row = mysqli_fetch_assoc($result)) {
		?>

		<tr>
		<td><font face="Times New Roman"><?php echo $row['name']; ?></font></td>
		<td><font face="Times New Roman"><?php echo $row['address']; ?></font></td>
		<td><font face="Times New Roman"><?php echo $row['numb']; ?></font></td>
		<td><font face="Times New Roman"><?php echo $row['city']; ?></font></td>
		<td><font face="Times New Roman"><?php echo $row['phone']; ?></font></td>
		<td><font face="Times New Roman"><?php echo $row['tk']; ?></font></td>
		<td><font face="Times New Roman"><?php echo $row['coordinates']; ?></font></td>
		<td><font face="Times New Roman"><?php echo $row['transit_hub_city']; ?></font></td>
		</tr>

		<?php
		}
		?>	
	</table>	

	</div>

	<form method="post" action="change_store.php">

		<?php include('errors.php'); ?>

		<h2>Εισάγετε το όνομα του καταστήματος και τα πεδία που επιθυμείτε να τροποποιήσετε</h2>

		<div class="input-group">
			<label>Όνομα καταστήματος (*)</label>
			<input type="text" name="store_name">
		</div>

		<p> <strong><em>ΤΡΟΠΟΠΟΙΗΣΗ</em></strong> </p>

		<div class="input-group">
			<label>Όνομα</label>
			<input type="text" name="new_name" >
		</div>

		<div class="input-group">
			<label>Οδός</label>
			<input type="text" name="street" >
		</div>

		<div class="input-group">
			<label>Αριθμός</label>
			<input type="text" name="number" >
		</div>

		<div class="input-group">
			<label>Πόλη</label>
			<input type="text" name="city" >
		</div>

		<div class="input-group">
			<label>Τ.Κ.</label>
			<input type="text" name="tk" >
		</div>

		<div class="input-group">
			<label>Τηλέφωνο</label>
			<input type="text" name="phone" >
		</div>

		<div class="input-group">
			<label>Γεωγραφικές συντεταγμένες</label>
			<input type="text" name="coordinates">
		</div>

		<div class="input-group">
			<label>Transit Hub</label>
			<input type="text" name="transit" >
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="c_store">Τροποποίηση</button>
		</div>

		<p> <a href="change_staff.php?back='1'" style="color: yellow;">back</a> </p>
	</form>

</body>
</html>