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
	<title>Administrator's Home</title>
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>
<body>

	<div class="header">
		<h2>Πίνακας ελέγχου κεντρικού διαχειριστή</h2>
	</div>

	<form method="post" action="admin.php">

		 <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
                <h3>
                    <?php 
                        $username = $_SESSION['username'];
                        $_SESSION['success'] = "Συνδεθήκατε ως " .$username;
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </h3>
                <p> <a href="user.php?logout='1'" style="color: brown;">logout</a> </p>
            </div>
        <?php endif ?>

<!--local store    1     -->
		<!---Create -->
		<div class="input-group">
			<button type="submit" class="btn1" name="create_store">Δημιουργία καταστήματος</button>
		</div>

		<!---Delete   2  -->
		<div class="input-group">
			<button type="submit" class="btn1" name="delete_store">Διαγραφή καταστήματος</button>
		</div>

		<!---change  3   -->
		<div class="input-group">
			<button type="submit" class="btn1" name="change_store">Τροποποίηση καταστήματος</button>
		</div>

<!--staff-->
		<!---Create Staff  4  -->
		<div class="input-group">
			<button type="submit" class="btn1" name="create_staff">Δημιουργία υπαλλήλου τοπικού καταστήματος</button>
		</div>

		<!---Delete   5  -->
		<div class="input-group">
			<button type="submit" class="btn1" name="delete_staff">Διαγραφή υπαλλήλου τοπικού καταστήματος</button>
		</div>

		<!---change   6  -->
		<div class="input-group">
			<button type="submit" class="btn1" name="change_staff">Τροποποίηση υπαλλήλου τοπικού καταστήματος</button>
		</div>

<!--staff in transit hubs -->
		<!---	Create  7  -->
		<div class="input-group">
			<button type="submit" class="btn1" name="create_staff_for_transit_hub">Δημιουργία υπαλλήλου transit hub</button>
		</div>

		<!---	Delete  8 	-->
		<div class="input-group">
			<button type="submit" class="btn1" name="delete_staff_for_transit_hub">Διαγραφή υπαλλήλου transit hub</button>
		</div>

		<!---	change 	9   -->
		<div class="input-group">
			<button type="submit" class="btn1" name="change_staff_for_transit_hub">Τροποποίηση υπαλλήλου transit hub</button>
		</div>

	    </form>


</body>

</html>