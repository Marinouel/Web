<?php include('server.php') ?>
<?php 	

	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login_customer.php');
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
    <title>Home</title>
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
        <h2>Πρoφίλ Πελάτη</h2>
    </div>

    <div class="content">

        <!-- notification message -->
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

        <!-- logged in user information-->
       
        <h3 align="center">Δίκτυο καταστημάτων και Transit Hub</h3>
        <div id="map" style="width:650px;height:550px;margin: 0 auto 0 auto;"></div>

         <!-- Παίρνουμε από την php  την πόλη και τις συντεταγμένες και τα εκχωρούμε σε πίνακα.
         	Αργότερα θα περστούν με τη βοήθεια του json στη javascript για να τα συμπεριλάβουμε στους 
         	markers του χάρτη -->
        <?php 
        	$query1 = mysqli_query($db, "SELECT transit_hub_city FROM local_store");
        	$query2 = mysqli_query($db, "SELECT coordinates FROM local_store");
        	$query3 = mysqli_query($db, "SELECT name, address, numb, city, phone, tk FROM local_store");
        	$count = 0;
        	
        	$city = array();
        	$coordinates = array();
        	$data = array();

        	while ( ($row = mysqli_fetch_assoc($query1)) && ($r = mysqli_fetch_assoc($query2)) && ($d = mysqli_fetch_assoc($query3)) ) {
        		$city[] = $row;
        		$coordinates[] = $r;
        		$data[] = $d;


        		$count++;
        	}
	
        	for ($i=0; $i < $count ; $i++) {
        		$cor[$i] = explode(",", $coordinates[$i]['coordinates']);
        	}

        ?>

        <script>   
        		var city = <?php echo json_encode($city); ?>;
        		var cor = <?php echo json_encode($cor); ?>;
        		var count = <?php echo json_encode($count); ?>;
        		var data = <?php echo json_encode($data); ?>;

                function initMap() {
                    var myLatlng = new google.maps.LatLng(37.984593, 23.727694);
                    var mapOptions = {
                        center: myLatlng,
                        zoom: 6,
                        mapTypeId: google.maps.MapTypeId.roadmap
                    }

                    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
                    var infowindow = [];
                    
                    for (var i = 0; i < count; i++) {

                      var myLatlng1 = new google.maps.LatLng(cor[i][0], cor[i][1]);

                      var contentString = data[i]['name'] + '<br>'
                       + data[i]['address'] + ' ' + data[i]['numb'] + '<br>'
                       + data[i]['city'] + ' ' + '<br>' + 'τ.κ.: '
                       + data[i]['tk'] + '<br>' + 'τηλ.:'
                       + data[i]['phone'];


                      infowindow[i] = new google.maps.InfoWindow({
   						 content: contentString
  					  });
                      	
                      var marker = new google.maps.Marker({
                          position: myLatlng1,
                          map: map,
                          title: city[i]
                      });
                   
                       google.maps.event.addListener(marker, 'click', (function(marker, i) {
        			     return function() {
                           infowindow[i].open(map, marker);
                         }
                       })(marker, i)); 
                   
                    } //for 

                }//InitMap() 

        </script>

        <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGFNUZC6-4gbXGjFxUOSdR8depuN2gVxo&callback=initMap">
        </script>

    </div>

    <form method="post" action="user.php">

    	<h3 align="center">Δείτε που βρίσκεται το δέμα σας</h3>
        <!--take the tracking num-->
        <div class="input-group">
            <label >Tracking number</label>
            <input type="text" name="code" >
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="enter">Enter</button>
        </div>

        <?php
        	if ( isset($_POST['code']) ) {
        		echo '<div class="error success" ><h3>';
        		$_SESSION['success'] = "Το δέμα σας βρίσκεται: {$_SESSION['location']}"; 
        		echo $_SESSION['success']; 
        		echo'</h3></div>';
        	}

        ?>

    </form>


     <div class="header">
         <h2 align="center">Αναζήτηση καταστήματος</h2>
     </div>
    
    <form method="post" action="user.php">

        <?php include('errors.php'); ?>

        <form method="post" action="user.php">


        <?php include('errors.php'); ?>

        <h3 align="center">Eπιλέξτε την πόλη που επιθυμείτε: </h3>

        <div class="input-group">
            <label>ΠΟΛΗ</label>
            <input type="text" onkeyup="showHint(this.value)" name="shearch_city">
        </div>
        <p align="justify">Επιλογές: <span id="text"></span></p>


        <div class="input-group">
            <button type="submit" class="btn" name="town">Αναζήτηση</button>
        </div>

        
       		<?php 
       			if ( isset($_POST['town']) ) {
        			$city = mysqli_real_escape_string($db, $_REQUEST['shearch_city']);
       				$count=0;
        			$info = array();

        			$result = mysqli_query($db, "SELECT name, address, numb, city FROM local_store WHERE transit_hub_city = '$city'");

        			echo '<div class="error success" ><h3>';
       				while ( $r = mysqli_fetch_assoc($result) ) {
       	 				$info[] = $r;
       	 				$_SESSION['success'] = "*{$info[$count]['name']}, {$info[$count]['address']} {$info[$count]['numb']}, {$info[$count]['city']} \n ";
       	 				echo $_SESSION['success'];
       	 				$count++;
       	 			} 
       	 			echo'</h3></div>';
 				}
       		 ?>
       			

        <h3 align="center">Βρείτε το πλησιέστερο κατάστημα με βάση τον Τ.Κ. σας:</h3>

        <div class="input-group">
            <label>Τ.Κ.</label>
            <input type="text" onkeyup="showHint(this.value)" name="search_tk">
        </div>
  
        <div class="input-group">
            <button type="submit" class="btn" name="tk">Αναζήτηση</button>
        </div>

         <?php 
       			if ( isset($_POST['tk']) ) {
        			$tk = mysqli_real_escape_string($db, $_REQUEST['search_tk']);
       				$count=0;
        			$info = array();

        			$result = mysqli_query($db, "SELECT name, address, numb, city FROM local_store WHERE tk = '$tk'");

        			echo '<div class="error success" ><h3>';
       				while ( $r = mysqli_fetch_assoc($result) ) {
       	 				$info[] = $r;
       	 				$_SESSION['success'] = "*{$info[$count]['name']}, {$info[$count]['address']} {$info[$count]['numb']}, {$info[$count]['city']} \n ";
       	 				echo $_SESSION['success'];
       	 				$count++;
       	 			} 
       	 			echo'</h3></div>';
 				}
       		 ?>

    </form>

</body>
</html>