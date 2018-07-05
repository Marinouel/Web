<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Store</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>

<body>
	<div class="header">
		<h2>Πρόσληψη Προσωπικού σε Κατάστημα:</h2>
	</div>

	<?php
			$choice = array();
			$sql = "SELECT name FROM local_store ORDER BY name ASC";
			$result = mysqli_query($db, $sql);

			while($row = mysqli_fetch_assoc($result)) {
				array_push($choice,$row["name"]);
			}
	?>

	<form method="post" action="create_staff.php">

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
			<label>Κατάστημα</label>
			<select class="choose_fields" name='store' required >
					<option selected disabled hidden value=''></option>
					<?php 
						for($i=0;$i<count($choice);$i++){
							echo "<option value='$choice[$i]'>$choice[$i]</option>";
						}
					?>			
		    </select>
		</div>

		

		<div class="input-group">
			<button type="submit" class="btn" name="c_staff">Δημιουργία</button>
		</div>

		</form>
</body>
</html>