<?php include('server.php') ?>
<!DOCTYPE html>
<html>
  <link rel="stylesheet" type="text/css" href="style_login.css">

  <body>
  	<div class="content">
  	<?php 

  		$image = $_SESSION['myimage'];
  		
		//$image="test.png";
		print "<img src = '$image' />";

		echo "<br>Το δέμα θα κάνει τη διαδρομή: " .$_SESSION['cities_path'];
		echo "<br>Ο χρόνος σε ημέρες είναι: " .$_SESSION['xronos'];
    	echo "<br>Το κόστος σε ευρώ είναι: " .$_SESSION['kostos'];

		if (isset($_GET['back'])) {
			header("location: os.php");
		}

	?>

	<p> <a href="os.php?back='1'" style="color: brown;">back</a> </p>
  	</div>

