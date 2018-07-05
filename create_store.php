<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Δημιουργία τοπικού καταστήματος</h2>
	</div>

	<?php
			$choice = array();
			$sql = "SELECT city FROM transit_hub ORDER BY city ASC";
			$result = mysqli_query($db, $sql);

			while($row = mysqli_fetch_assoc($result)) {
				array_push($choice,$row["city"]);
			}
	?>

	<form method="post" action="create_store.php">

	<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Όνομα</label>
			<input type="text" name="name" >
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
			<select class="choose_fields" name='transit' required >
					<option selected disabled hidden value=''></option>
					<?php 
						for($i=0;$i<count($choice);$i++){
							echo "<option value='$choice[$i]'>$choice[$i]</option>";
						}
					?>			
		    </select>
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="create">Δημιουργία</button>
		</div>

		</form>
</body>
</html>