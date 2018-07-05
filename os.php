<?php include('server.php') ?>
<?php   

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login_staff.php');
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
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">

<script>
function showHint(str) {    
    if (str.length == 0) {                                                       //first we check if the field is empty
        document.getElementById("text").innerHTML = "";
        return;
    } else {                                                                     //if it;s not empty
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
<body>
<div class="header">
        <h2>Τοπικό κατάστημα</h2>
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

    <form method="post" action="os.php">

        <?php include('errors.php'); ?>
 
         <h2 align="center">Δημιουργία αποστολής</h2>
         <h5 align="center"> *(Συμπληρώστε τη φόρμα με Ελληνικά, Κεφαλαία γράμματα) </h5>

        <div class="input-group">
            <label>Αφαιτηρία</label>
            <input type="text" onkeyup="showHint(this.value)" name="start">
        </div>
        <p>Suggestions: <span id="text"></span></p>

        <div class="input-group">
            <label>Προορισμός</label>
            <input type="text" onkeyup="showHint(this.value)" name="termination" > 
        </div>

        <div class="input-group">
            <label>Όνομα πελάτη</label>
            <input type="text" name="customersname">
        </div>

        <div class="input-group">
            <label>Κωδικός πελάτη</label>
            <input type="password" name="customerspass">
        </div>


        <div class="input-group">
            <button type="submit" class="btn" name="Express">Express</button>
        </div>

        <div class="input-group">
            <button type="submit" class="btn" name="No_Express">No Express</button>
        </div>
        

        <h2 align="center">Παρακολούθηση αποστολής</h2>

        <div class="input-group">
            <label>Tracking number </label>
            <input type="text" name="location_num">
        </div>
        
        <div class="input-group">
            <button type="submit" class="btn" name="location">Έγινε</button>
        </div>

        <?php
            if ( isset($_POST['location_num']) ) {
                echo '<div class="error success" ><h3>';
                $_SESSION['success'] = "Το δέμα με αριθμό αποστολής {$_POST['location_num']} βρίσκεται στην πόλη: {$_SESSION['loc']}"; 
                echo $_SESSION['success']; 
                echo'</h3></div>';
            }

        ?>

    </form>



</body>
</html>

<?php 

    ini_set('error_reporting', E_STRICT);
    $myObj->Start = "Αφαιτηρία πακέτου";
    $myObj->Termination = "Προορισμός πακέτου";
   
    $myJSON = json_encode($myObj);

    echo $myJSON;

?>