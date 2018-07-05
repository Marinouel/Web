<?php include('server.php') ?>
<?php 	

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: t_h.php');
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
         <link rel="stylesheet" type="text/css" href="style.css">

<script>
function showHint(str) {    
    if (str.length == 0) {                                                       //first we check if the field is empty
        document.getElementById("text").innerHTML = "";
        return;
    } else {                                                                     //if it's not empty
        var xmlhttp = new XMLHttpRequest();                                      //create an XMLHttpRequest object
        xmlhttp.onreadystatechange = function() {                                //We Create the function to be executed when the server response is ready
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("text").innerHTML = this.responseText;   //Send the request off to a PHP file (gethetown.php) on the server
            }                                                                   
        };
        xmlhttp.open("GET", "gethetown.php?q=" + str, true);                     // q parameter is added gethint.php?q="+str
        xmlhttp.send();                                                          //The str variable holds the content of the input field
    }
}
</script>
</head>
         <link rel="stylesheet" type="text/css" href="style.css">
<body>
<div class="header">
        <h2>Transit Hub</h2>
    </div>

    <div class="content">
    <!-- logged in user information-->
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
                <p> <a href="os.php?logout='1'" style="color: brown;">logout</a> </p>
            </div>
        <?php endif ?>
    </div>

    <form method="post" action="hub.php">

        <?php include('errors.php'); ?>


        <div class="input-group">
            <button type="submit" class="btn" name="scanqr">Σάρωση QR</button>
        </div>

        <?php 
            if (isset ($_POST['scanqr'])){
              header('location: index.html');
            } 

        ?>

        <h3 align="center">Check in: Eισάγετε το tracking number</h3>
        <div class="input-group">
            <label>Tracking number</label>
            <input type="password" name="Check_in">
        </div>

        <div class="input-group">
            <button type="submit" class="btn" name="Checkin">Check</button>
        </div>



    </form>

</body>
</html>


      