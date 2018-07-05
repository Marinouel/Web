<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Πρόσληψη Προσωπικού σε Αποθήκες Καταστημάτων</h2>
	</div>

	<?php
			$choice = array();
			$sql = "SELECT city FROM transit_hub ORDER BY city ASC";
			$result = mysqli_query($db, $sql);

			while($row = mysqli_fetch_assoc($result)) {
				array_push($choice,$row["city"]);
			}
	?>

	<form method="post" action="create_staff_for_transit_hub.php">

	<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="th_staff_username" >
		</div>

		<div class="input-group">
			<label>Password</label>
			<input type="password" name="th_staff_password">
		</div>

		<div class="input-group">
			<label>Transit hub</label>
			<select class="choose_fields" name="transit" required >
					<option selected disabled hidden value=''></option>
					<?php 
						for($i=0;$i<count($choice);$i++){
							echo "<option value='$choice[$i]'>$choice[$i]</option>";
						}
					?>			
		    </select>
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="cr_staff_t_h">Δημιουργία</button>
		</div>

		</form>
</body>
</html>