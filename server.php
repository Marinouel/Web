
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
	session_start();


	include('qrlib.php');
	// Declaration
	$username		 = "";
	$email   		 = "";
	$code    		 = "";
	$start 			 = "";
	$termination 	 = "";
	$a 				 ="";
	$b 				 ="";
	$c 				 ="";
	$d 				 ="";	
	$errors   		 = array(); 
	$_SESSION['success'] = "";
	$name ="";
	$path1="";
	$path2="";
	



	//create commection
	$db = mysqli_connect("localhost", "root", "", "courier");
	// Check connection
	if ($db == false) {
   		die("Connection failed: " . mysqli_connect_error());
	}
	mysqli_set_charset($db, "utf8");

//------------------------------------------------------------------------------------------------------
//- Transit_Hub- choose button

if (isset($_POST['Transit_Hub'])) {
	header('location: t_h.php');
}

//----------------------------------------------------------------------------------------

// hub.php----- Check in! 

	if (isset($_GET['barcode'])) {
		$bar = $_GET['barcode'];	

		$db = mysqli_connect("localhost", "root", "", "courier");
	    // Check connection
		
		if ($db == false) {
   			die("Connection failed: " . mysqli_connect_error());
		}
		mysqli_set_charset($db, "utf8");	

		$data = array();
		$bar = str_replace("\n", "", $bar);
		$string="";

		if (!empty($bar) ){
				$query= "SELECT path1 FROM package WHERE tracking_number = '$bar'"; 			
				$results = mysqli_query($db, $query);
				
				$data['br'] = $bar;

				if (mysqli_num_rows($results) > 0 ) { 

					$row = mysqli_fetch_array($results);
					$string = $row['path1'];
					//echo $string;

					if (strlen($string) > 0 ) { 		// an uparxei akoloythia me ari8mous, afairw ton prwto kathe fora-> kanw check in
							$sub_string = substr($string, -strlen($string)+1, 1); 	//apothikeyoyme ton xarakthra poy afairoyme
		
							$new_string = substr($string,1); 						//we remove the first char	

							$sql = "UPDATE package SET path1='$new_string' WHERE path1 ='$string' "; //update sthn bash
							$results = mysqli_query($db, $sql);

					} else { echo "To δέμα έφτασε στον προορισμό του! ";}

						//blepoyme plhrofories gia to katasthma thw polhs poy ekane check in to dema

				} else { array_push($errors, "Δεν υπάρχει το συγκεκριμένο tracking number"); }

		}
		echo json_encode($string);
	
	}

if ( (isset($_POST['Checkin']))  ){

		$Check_in = mysqli_real_escape_string($db, $_POST['Check_in']);
		if (!(empty($Check_in)) ) {
			
				$query= "SELECT path1 FROM package WHERE tracking_number = '$Check_in'"; 			
				$results = mysqli_query($db, $query);
				$string=$results;

				if (mysqli_num_rows($results) > 0 ) { 

					$row = mysqli_fetch_array($results);
					$string = $row['path1'];
					//echo $string;

					if (strlen($string) > 0 ) { 									// an uparxei akoloythia me ari8mous, afairw ton prwto kathe fora-> kanw check in

							$sub_string = substr($string, -strlen($string)+1, 1); 	//apothikeyoyme ton xarakthra poy afairoyme
		
							$new_string = substr($string,1); 						//we remove the first char	

							$sql = "UPDATE package SET path1='$new_string' WHERE path1 ='$string' "; //update sthn bash
							$results = mysqli_query($db, $sql);

					} else { echo "To δέμα έφτασε στον προορισμό του! ";}

						//blepoyme plhrofories gia to katasthma thw polhs poy ekane check in to dema

				} else { array_push($errors, "Δεν υπάρχει το συγκεκριμένο tracking number"); }

		} else { array_push($errors, "Εισάγετε όλα τα πεδία"); }



}



//--------------------------------------------------------------------------------------------------------
// - Transit_Hub- form to login

if (isset($_POST['T_H'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if ((empty($username)) || (empty($password)) ){
			array_push($errors, "Εισάγετε όλα τα πεδία");
		}

		if (count($errors) == 0) {
			$query= "SELECT * FROM th_staff WHERE name='$username' AND password='$password'"; 			
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) > 0 ) { 
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: hub.php');
			}else {
				array_push($errors, "Λάθος συνδυασμός");
			}
		}
}	

//-------------------------------------------------------------------------------------------------------	
// -Login customer-//

	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if ((empty($username)) || (empty($password)) ){
			array_push($errors, "Εισάγετε όλα τα πεδία");
		}

		if (count($errors) == 0) {
			$query= "SELECT * FROM customer WHERE name='$username' AND password='$password'"; 			
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) > 0 ) { 
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: user.php');
			}else {
				array_push($errors, "Λάθος συνδυασμός");
			}
		}
	}

//------------------------------------------------------------------------------------------------------
// -Login staff-// na ftiaxoyme bash gia toys ypallhloys

	if (isset($_POST['login_staff'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if ((empty($username)) || (empty($password)) ){
			array_push($errors, "*Εισάγετε όλα τα πεδία*");
		}

		if (count($errors) == 0) { 
			$query= "SELECT * FROM staff WHERE name='$username' AND password='$password'"; 			
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) > 0 ) { 
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: os.php');
			}else {
				array_push($errors, "*Λάθος συνδυασμός*");
			}
		}
	}
	
//-------------------------------------------------------------------------------------------------------
// -Login_Αdministrator-//

	if (isset($_POST['login_administrator'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if ((empty($username)) || (empty($password)) ){
			array_push($errors, "*Παρακαλούμε εισάγετε όλα τα πεδία*");
		}

		if (count($errors) == 0) {  
			$query= "SELECT * FROM admin WHERE name='$username' AND password='$password'"; 			
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) > 0 ) { 
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: admin.php');
			}else {
				array_push($errors, "*Λάθος συνδυασμός*");
			}
		}
	}

//-------------------------------------------------------------------------------------------------------
// -User's Profile -// user.php 

	if (isset($_POST['enter'])) {
		
		$code = $_POST['code'];
		
		$query = "SELECT path1 FROM package WHERE tracking_number='$code' "; //επιλέγουμε το path1 
		$results = mysqli_query($db, $query); 

		$_SESSION['location'] = '*ΠΑΡΑΔΟΘΗΚΕ*';
		if (mysqli_num_rows($results) > 0 ) 
		{ 
				$travel = mysqli_fetch_assoc($results); 
				$travel = substr($travel['path1'],0,1); //we take the first letter
				if ($travel) //if we still have numbers in the list
				{	 		
						if (strcasecmp("1",$travel) == 0) $_SESSION['location'] = 'ΙΩΑΝΝΙΝΑ'; 
						if (strcasecmp("2",$travel) == 0) $_SESSION['location'] = 'ΘΕΣΣΑΛΟΝΙΚΗ';
						if (strcasecmp("3",$travel) == 0) $_SESSION['location'] = 'ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ';  
						if (strcasecmp("4",$travel) == 0) $_SESSION['location'] = 'ΠΑΤΡΑ'; 
						if (strcasecmp("5",$travel) == 0) $_SESSION['location'] = 'ΛΑΡΙΣΑ';
						if (strcasecmp("6",$travel) == 0) $_SESSION['location'] = 'ΜΥΤΙΛΗΝΗ'; 
						if (strcasecmp("7",$travel) == 0) $_SESSION['location'] = 'ΚΑΛΑΜΑΤΑ';
						if (strcasecmp("8",$travel) == 0) $_SESSION['location'] = 'ΑΘΗΝΑ';
						if (strcasecmp("9",$travel) == 0) $_SESSION['location'] = 'ΗΡΑΚΛΕΙΟ';
				
					} 
		}else {
				array_push($errors, "Αυτό το Tracking Number βρέθηκε");
	    }
			
	
	}


//-------------------------------------------------------------------------------------------------------
// -Λογισμικό Τοπικού Καταστήματος-// 


	if (isset($_POST['Express'])) {

		$start = $_POST['start'];
		$termination = $_POST['termination'];
		$username = mysqli_real_escape_string($db, $_POST['customersname']);
		$password = mysqli_real_escape_string($db, $_POST['customerspass']);

		if (strcasecmp($start, "ΙΩΑΝΝΙΝΑ")	 == 0)      {$a=1; $c='IW'; }
		if (strcasecmp($start,"ΘΕΣΣΑΛΟΝΙΚΗ") == 0) 	    {$a=2; $c='ΤΗ';}
		if (strcasecmp($start,"ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ") == 0)   {$a=3; $c='AL';}
		if (strcasecmp($start,"ΠΑΤΡΑ")  == 0) 			{$a=4; $c='PA';}
		if (strcasecmp($start,"ΛΑΡΙΣΑ") == 0) 			{$a=5; $c='LA';}
		if (strcasecmp($start,"ΜΥΤΙΛΗΝΗ")  == 0) 		{$a=6; $c='MI';}
		if (strcasecmp($start,"ΚΑΛΑΜΑΤΑ") == 0)  		{$a=7; $c='KA';}
		if (strcasecmp($start,"ΑΘΗΝΑ")  == 0) 			{$a=8; $c='AT';}
		if (strcasecmp($start,"ΗΡΑΚΛΕΙΟ")  == 0) 		{$a=9; $c='IR';}

		if (strcasecmp($termination,"ΙΩΑΝΝΙΝΑ" ) == 0) 		{$b=1; $d='IW';}
		if (strcasecmp($termination,"ΘΕΣΣΑΛΟΝΙΚΗ") == 0) 	{$b=2; $d='TH';}
		if (strcasecmp($termination,"ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ") == 0) {$b=3; $d='AL';}
		if (strcasecmp($termination,"ΠΑΤΡΑ")  == 0) 		{$b=4; $d='PA';}
		if (strcasecmp($termination,"ΛΑΡΙΣΑ")  == 0) 		{$b=5; $d='LA';}
		if (strcasecmp($termination,"ΜΥΤΙΛΗΝΗ") == 0) 		{$b=6; $d='MY';}
		if (strcasecmp($termination,"ΚΑΛΑΜΑΤΑ") == 0) 		{$b=7; $d='KA';}
		if (strcasecmp($termination,"ΑΘΗΝΑ")  == 0) 		{$b=8; $d='AT';}
		if (strcasecmp($termination,"ΗΡΑΚΛΕΙΟ")  == 0) 		{$b=9; $d='IR';}

		//set the time array
		$_distArr = array();
		$_distArr[1][2] = 1;
		$_distArr[1][4] = 1;
		$_distArr[2][1] = 1;
		$_distArr[2][5] = 1;
		$_distArr[2][8] = 1;
		$_distArr[2][3] = 1;
		$_distArr[3][2] = 1;
		$_distArr[3][8] = 1;
		$_distArr[3][9] = 1;
		$_distArr[4][1] = 1;
		$_distArr[4][8] = 1;
		$_distArr[4][7] = 1;
		$_distArr[5][2] = 1;
		$_distArr[5][8] = 1;
		$_distArr[6][8] = 1;
		$_distArr[7][4] = 1;
		$_distArr[7][8] = 1;
		$_distArr[7][9] = 2;
		$_distArr[8][4] = 1;
		$_distArr[8][2] = 1;
		$_distArr[8][5] = 1;
		$_distArr[8][3] = 1;
		$_distArr[8][6] = 1;
		$_distArr[8][7] = 1;
		$_distArr[8][9] = 1;
		$_distArr[9][7] = 2;
		$_distArr[9][8] = 1;
		$_distArr[9][3] = 1;
		
		// cost array 
		$_cost = array();
		$_cost [1][2] = 1;
		$_cost [1][4] = 3;
		$_cost [2][1] = 1;
		$_cost [2][5] = 1;
		$_cost [2][8] = 5;
		$_cost [2][3] = 8;
		$_cost [3][2] = 8;
		$_cost [3][8] = 10;
		$_cost [3][9] = 15;
		$_cost [4][1] = 3;
		$_cost [4][8] = 2;
		$_cost [4][7] = 2;
		$_cost [5][2] = 1;
		$_cost [5][8] = 2;
		$_cost [6][8] = 8;
		$_cost [7][4] = 2;
		$_cost [7][8] = 3;
		$_cost [7][9] = 4;
		$_cost [8][4] = 2;
		$_cost [8][2] = 5;
		$_cost [8][5] = 2;
		$_cost [8][3] = 10;
		$_cost [8][6] = 8;
		$_cost [8][7] = 3;
		$_cost [8][9] = 10;
		$_cost [9][7] = 4;
		$_cost [9][8] = 10;
		$_cost [9][3] = 15;

		//initialize the array for storing
		$S = array();//the nearest path with its parent and weight
		$Q = array();//the left nodes without the nearest path
		//$K = array();
		foreach(array_keys($_distArr) as $val) $Q[$val] = 99999;
		//foreach(array_keys($_cost) as $kostos) $K[$kostos] = 99999;
		$Q[$a] = 0;

		//start calculating
		while(!empty($Q)){
    		$min = array_search(min($Q), $Q);//the most min weight
    		if($min == $b) break;

    	foreach($_distArr[$min] as $key=>$val) if(!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
        	$Q[$key] = $Q[$min] + $val;
       		$S[$key] = array($min, $Q[$key]);       	 
    	}
    		unset($Q[$min]);
		}

		//list the path
		$path = array();
		$pos = $b;
		while($pos != $a){
			$path[] = $pos;
    		$pos = $S[$pos][0];

		}
		$path[] = $a;
		$path = array_reverse($path);

	if 	( (!empty($start)) && (!empty($termination)) && (!empty($username)) && (!empty($password))) {

		if (count($errors) == 0) {  
			$query= "SELECT * FROM customer WHERE name='$username' AND password='$password'"; 			
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) > 0 ) { 
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "Right combination";
				

				//for the begin
				$i=1; 
				$kostos1=$a; 
				$kostos  = 0;
				$kostos2  = 0;
				//$path2=0;

				$cities_path="";

				foreach ($path as $value)
				{	$path1=$value;

					if ($i>2) 
					{
						$kostos1=$kostos2;
						$kostos2=$value; 
						$kostos =$kostos + $_cost[$kostos1][$kostos2];
			
					} else if (($i<3) && ($i>1))
					{
			
						$kostos2=$value; 
						$kostos =$kostos + $_cost[$kostos1][$kostos2];
					}

					//καθε φορά προσθέτουμε στο $cities_path ενα string με το όνομα της πόλης
					if ( "$value" == '1'){
						$temp = "- ΙΩΑΝΝΙΝΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '2') 
    					{
						$temp = "- ΘΕΣΣΑΛΟΝΙΚΗ ";
						$cities_path = $cities_path."".$temp ; 
					} 
    				if ( "$value" == '3') 
    				{
						$temp = "- ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '4') 
    				{
						$temp = "- ΠΑΤΡΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '5') 
    				{
						$temp = "- ΛΑΡΙΣΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '6') 
    				{
						$temp = "- ΜΥΤΙΛΗΝΗ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '7') 
    				{
						$temp = "- ΚΑΛΑΜΑΤΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '8') 
    				{
						$temp = "- ΑΘΗΝΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '9')
    				{
						$temp = "- ΗΡΑΚΛΕΙΟ ";
						$cities_path = $cities_path."".$temp ; 
					}   

    				$i++;
    				$path2  = $path2."".$path1;	
    			
			    } 

			    $_SESSION['cities_path'] = $cities_path;

    			$t=time();
    			echo "<br />το κόστος είναι {$kostos}";
    			//$S = "$S[$b][1]";
    			echo "<br />ο χρόνος σε ώρες είναι ".$S[$b][1];
    			$cost = $S[$b][1];
    			$_SESSION['xronos'] = $cost;
    			$_SESSION['kostos'] = $kostos;


    			//here we create the tracking number
    			$tn = "{$c}{$t}{$d}" ;
				echo "<br /> Tracking num: {$tn} "; 
				
				//here we create the image from the tracking num
				QRcode::png($tn);  //output the image directly as PNG stream

				//to save the result locally as a PNG image:
				$tempDir = EXAMPLE_TMP_SERVERPATH;


				$codeContents = $tn;
				$fileName = 'qrcode_name.png';
				$fileName = $tn."".$fileName;
				$pngAbsoluteFilePath = $tempDir.$fileName;


				$urlRelativeFilePath = EXAMPLE_TMP_URLRELPATH.$fileName;
				QRcode::png($codeContents, $pngAbsoluteFilePath); 

				$_SESSION['myimage'] = $pngAbsoluteFilePath;
				//put the tracking num and the image of it into the db 
    			$sql= "INSERT INTO package (tracking_number, qr_url, customer_name, transit_hub_city, path1) VALUES ('$tn', '$pngAbsoluteFilePath', '$username', '$start', '$path2')"; 
    			header('location:  print.php');


    			if (mysqli_query($db, $sql)) {
					echo "Το tracking num καταχωρήθηκε με επιτυχία!";
				} 
				else {
    				echo "Error: " .mysqli_error($db); 
				}


			} else {array_push($errors, "*Λάθος συνδυασμός*"); }
	    }

	} else 	array_push($errors, "Παρακαλώ εισάγετε όλα τα πεδία");

}


//-----------------------------------------------------------------------------

	if (isset($_POST['No_Express'])) {

		$start = $_POST['start']; 
		$termination = $_POST['termination'];
		$username = mysqli_real_escape_string($db, $_POST['customersname']);
		$password = mysqli_real_escape_string($db, $_POST['customerspass']);
		
		if (strcasecmp($start,"ΙΩΑΝΝΙΝΑ")	== 0)       {$a=1; $c="IW";}
		if (strcasecmp($start,"ΘΕΣΣΑΛΟΝΙΚΗ") == 0) 	    {$a=2; $c='ΤΗ';}
		if (strcasecmp($start,"ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ") == 0)   {$a=3; $c='AL';}
		if (strcasecmp($start,"ΠΑΤΡΑ")  == 0) 			{$a=4; $c='PA';}
		if (strcasecmp($start,"ΛΑΡΙΣΑ") == 0) 			{$a=5; $c='LA';}
		if (strcasecmp($start,"ΜΥΤΙΛΗΝΗ")  == 0) 		{$a=6; $c='MI';}
		if (strcasecmp($start,"ΚΑΛΑΜΑΤΑ") == 0)  		{$a=7; $c='KA';}
		if (strcasecmp($start,"ΑΘΗΝΑ")  == 0) 			{$a=8; $c='AT';}
		if (strcasecmp($start,"ΗΡΑΚΛΕΙΟ")  == 0) 		{$a=9; $c='IR';}

		if (strcasecmp($termination,"ΙΩΑΝΝΙΝΑ" ) == 0) 		{$b=1; $d='IW';}
		if (strcasecmp($termination,"ΘΕΣΣΑΛΟΝΙΚΗ") == 0) 	{$b=2; $d='TH';}
		if (strcasecmp($termination,"ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ") == 0) {$b=3; $d='AL';}
		if (strcasecmp($termination,"ΠΑΤΡΑ")  == 0) 		{$b=4; $d='PA';}
		if (strcasecmp($termination,"ΛΑΡΙΣΑ")  == 0) 		{$b=5; $d='LA';}
		if (strcasecmp($termination,"ΜΥΤΙΛΗΝΗ") == 0) 		{$b=6; $d='MI';}
		if (strcasecmp($termination,"ΚΑΛΑΜΑΤΑ") == 0) 		{$b=7; $d='KA';}
		if (strcasecmp($termination,"ΑΘΗΝΑ")  == 0) 		{$b=8; $d='AT';}
		if (strcasecmp($termination,"ΗΡΑΚΛΕΙΟ")  == 0) 		{$b=9; $d='IR';}

		//set the cost array 
		$_distArr = array();
		$_distArr[1][2] = 1;
		$_distArr[1][4] = 3;
		$_distArr[2][1] = 1;
		$_distArr[2][5] = 1;
		$_distArr[2][8] = 5;
		$_distArr[2][3] = 8;
		$_distArr[3][2] = 8;
		$_distArr[3][8] = 10;
		$_distArr[3][9] = 15;
		$_distArr[4][1] = 3;
		$_distArr[4][8] = 2;
		$_distArr[4][7] = 2;
		$_distArr[5][2] = 1;
		$_distArr[5][8] = 2;
		$_distArr[6][8] = 8;
		$_distArr[7][4] = 2;
		$_distArr[7][8] = 3;
		$_distArr[7][9] = 4;
		$_distArr[8][4] = 2;
		$_distArr[8][2] = 5;
		$_distArr[8][5] = 2;
		$_distArr[8][3] = 10;
		$_distArr[8][6] = 8;
		$_distArr[8][7] = 3;
		$_distArr[8][9] = 10;
		$_distArr[9][7] = 4;
		$_distArr[9][8] = 10;
		$_distArr[9][3] = 15;

		//time array
		$_time = array();
		$_time[1][2] = 1;
		$_time[1][4] = 1;
		$_time[2][1] = 1;
		$_time[2][5] = 1;
		$_time[2][8] = 1;
		$_time[2][3] = 1;
		$_time[3][2] = 1;
		$_time[3][8] = 1;
		$_time[3][9] = 1;
		$_time[4][1] = 1;
		$_time[4][8] = 1;
		$_time[4][7] = 1;
		$_time[5][2] = 1;
		$_time[5][8] = 1;
		$_time[6][8] = 1;
		$_time[7][4] = 1;
		$_time[7][8] = 1;
		$_time[7][9] = 2;
		$_time[8][4] = 1;
		$_time[8][2] = 1;
		$_time[8][5] = 1;
		$_time[8][3] = 1;
		$_time[8][6] = 1;
		$_time[8][7] = 1;
		$_time[8][9] = 1;
		$_time[9][7] = 2;
		$_time[9][8] = 1;
		$_time[9][3] = 1;

		//initialize the array for storing
		$S = array();//the nearest path with its parent and weight
		$Q = array();//the left nodes without the nearest path
		foreach(array_keys($_distArr) as $val) $Q[$val] = 99999;
		$Q[$a] = 0;

		//start calculating
		while(!empty($Q)){
    		$min = array_search(min($Q), $Q);//the min weight
    	if($min == $b) break;
    	foreach($_distArr[$min] as $key=>$val) if(!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
        	$Q[$key] = $Q[$min] + $val;
        	$S[$key] = array($min, $Q[$key]);
    	}
    		unset($Q[$min]);
		}

		//list the path
		$path = array();
		$pos = $b;
		while($pos != $a){
	    $path[] = $pos;
	    $pos = $S[$pos][0];
		}

		$path[] = $a;
		$path = array_reverse($path);

	
	if 	( (!empty($start)) && (!empty($termination)) && (!empty($username)) && (!empty($password)) ) {
		
		if (count($errors) == 0) {  
			$query= "SELECT * FROM customer WHERE name='$username' AND password='$password'"; 			
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) > 0 )
			{ 
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "Right combination";
			
				

				//for the begin
				$i=1; 
				$xronos1 = $a; 
				$xronos  = 0;
				$xronos2 = 0;

				$cities_path="";

				foreach ($path as $value)
				{	$path1=$value;

					if ($i>2) 
					{   
						$xronos1=$xronos2;
						$xronos2=$value; 
						$xronos =$xronos + $_time[$xronos1][$xronos2];
			
					} else if (($i<3) && ($i>1))
					{
			
						$xronos2=$value; 
						$xronos =$xronos + $_time[$xronos1][$xronos2];
					}

					if ( "$value" == '1'){
						$temp = "- ΙΩΑΝΝΙΝΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '2') 
    					{
						$temp = "- ΘΕΣΣΑΛΟΝΙΚΗ ";
						$cities_path = $cities_path."".$temp ; 
					} 
    				if ( "$value" == '3') 
    				{
						$temp = "- ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '4') 
    				{
						$temp = "- ΠΑΤΡΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '5') 
    				{
						$temp = "- ΛΑΡΙΣΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '6') 
    				{
						$temp = "- ΜΥΤΙΛΗΝΗ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '7') 
    				{
						$temp = "- ΚΑΛΑΜΑΤΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '8') 
    				{
						$temp = "- ΑΘΗΝΑ ";
						$cities_path = $cities_path."".$temp ; 
					} 	
    				if ( "$value" == '9')
    				{
						$temp = "- ΗΡΑΚΛΕΙΟ ";
						$cities_path = $cities_path."".$temp ; 
					}   

					$i++;
					$path2 = $path2."".$path1;		
    			}
    			$_SESSION['cities_path'] = $cities_path;
    			
    			$t=time();
    	    	echo "<br />o χρόνος σε ώρες είναι {$xronos}";
    	    	echo "<br />το κόστος σε euro είναι ".$S[$b][1];
    			echo  "<br /> Tracking number: {$c}{$t}{$d} ";  

    			$tn = "{$c}{$t}{$d}" ;  
    			$cost = $S[$b][1];   

    			//χρησιμοπιώ μεταβήτές _$SESSION Για να εμφανίσω τα αποτελέσματα στο αρχείο print.php
    			$_SESSION['xronos'] = $xronos;
    			$_SESSION['kostos'] = $cost;

				//here we create the image from the tracking num
				QRcode::png($tn);  //output the image directly as PNG stream

				//to save the result locally as a PNG image:
				$tempDir = EXAMPLE_TMP_SERVERPATH;

				$codeContents = $tn;
				$fileName = 'qrcode_name.png';
				$fileName = $tn."".$fileName;
				$pngAbsoluteFilePath = $tempDir.$fileName;

				$urlRelativeFilePath = EXAMPLE_TMP_URLRELPATH.$fileName;
				QRcode::png($codeContents, $pngAbsoluteFilePath); 

				$_SESSION['myimage'] = $pngAbsoluteFilePath;

				//put the tracking num and the image of it into the db 
    			$sql= "INSERT INTO package (tracking_number, qr_url, customer_name, transit_hub_city, path1) VALUES ('$tn', '$pngAbsoluteFilePath', '$username', '$start', '$path2')"; 
    			header('location: print.php');


    			if (mysqli_query($db, $sql)) {
					echo "Το tracking num καταχωρήθηκε με επιτυχία!";
				} 
				else {
    				echo "Error: " .mysqli_error($db); 
				}


			} else {array_push($errors, "*Λάθος συνδυασμός*"); }
	    }

	} else 	array_push($errors, "Παρακαλώ εισάγετε όλα τα πεδία");

}

//-------------------------------------------------------------------------------------------------------
// os.php ---> location. check where the packet is 

	if (isset($_POST['location'])) {

		$location_num = $_POST['location_num'];

		if (! (empty($location_num))){

					//create commection
					$conn = mysqli_connect("localhost", "root", "", "courier");
					mysqli_set_charset($conn, "utf8");
					// Check connection
					if ($conn == false) {
    					die("Connection failed: " . mysqli_connect_error());
					} else if (count($errors) == 0) {
					 	$query = "SELECT path1 FROM package WHERE tracking_number ='$location_num'"; 		
						//location_num-> etsi na onomasoyme thn sthlh ston pinaka me toyw ariumous	
						
					 	$results = mysqli_query($db, $query);

					 	if (mysqli_num_rows($results) > 0 ) 
						{ 
							$travel = mysqli_fetch_assoc($results); 
							$travel = substr($travel['path1'],0,1); //we take the first letter
							if ($travel) //if we still have numbers in the list
							{	 		
								if (strcasecmp("1",$travel) == 0) $_SESSION['loc'] = 'ΙΩΑΝΝΙΝΑ'; 
								if (strcasecmp("2",$travel) == 0) $_SESSION['loc'] = 'ΘΕΣΣΑΛΟΝΙΚΗ';
								if (strcasecmp("3",$travel) == 0) $_SESSION['loc'] = 'ΑΛΕΞΑΝΔΡΟΥΠΟΛΗ';  
								if (strcasecmp("4",$travel) == 0) $_SESSION['loc'] = 'ΠΑΤΡΑ'; 
								if (strcasecmp("5",$travel) == 0) $_SESSION['loc'] = 'ΛΑΡΙΣΑ';
								if (strcasecmp("6",$travel) == 0) $_SESSION['loc'] = 'ΜΥΤΙΛΗΝΗ'; 
								if (strcasecmp("7",$travel) == 0) $_SESSION['loc'] = 'ΚΑΛΑΜΑΤΑ';
								if (strcasecmp("8",$travel) == 0) $_SESSION['loc'] = 'ΑΘΗΝΑ';
								if (strcasecmp("9",$travel) == 0) $_SESSION['loc'] = 'ΗΡΑΚΛΕΙΟ';
				
							} 
							}else {
								array_push($errors, "Αυτό το Tracking Number βρέθηκε");
	    					}

					}	
			
		} else { 

			array_push($errors, "Εισάγετε όλα τα πεδία"); 
		}

	}
//------------------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------------
// -Υπάλληλος-χρήστης-//

	if (isset($_POST['customer'])) {

		header('location: login_customer.php');
	}

	if (isset($_POST['staff'])) {

		header('location: login_staff.php');
	}

//-------------------------------------------------------------------------------------------------------
// -admin-//

	if (isset($_POST['administrator'])) {

		header('location:  login_administrator.php');
	}

// 1 
	if (isset($_POST['create_store'])) {

		header('location: create_store.php');
	}

// 2 
	if (isset($_POST['delete_store'])) {

		header('location: delete_store.php');
	}			

// 3 
	if (isset($_POST['change_store'])) {

		header('location: change_store.php');
	}

// 4
	if (isset($_POST['create_staff'])) {

		header('location: create_staff.php');
	}

// 5
	if (isset($_POST['delete_staff'])) {

		header('location: delete_staff.php');
	}		

// 6
	if (isset($_POST['change_staff'])) {

		header('location: change_staff.php');
	}

// 7
	if (isset($_POST['create_staff_for_transit_hub'])) {

		header('location: create_staff_for_transit_hub.php');
	}	

// 8
	if (isset($_POST['delete_staff_for_transit_hub'])) {

		header('location: delete_staff_for_transit_hub.php');
	}

// 9
	if (isset($_POST['change_staff_for_transit_hub'])) {

		header('location: change_staff_for_transit_hub.php');

	}
//-----------------------------------------------------------------------------------------
// create_store.php
	if (isset($_POST['create'])) {
			
			$name = mysqli_real_escape_string($db, $_REQUEST['name']);
			$street = mysqli_real_escape_string($db, $_REQUEST['street']);
			$number = mysqli_real_escape_string($db, $_REQUEST['number']);
			$city = mysqli_real_escape_string($db, $_REQUEST['city']);
			$phone = mysqli_real_escape_string($db, $_REQUEST['phone']);
			$tk = mysqli_real_escape_string($db, $_REQUEST['tk']);
			$coordinates = mysqli_real_escape_string($db, $_REQUEST['coordinates']);
			$transit = mysqli_real_escape_string($db, $_REQUEST['transit']);


			if ( (empty($name)) || (empty($street)) || (empty($number)) || (empty($city))  || (empty($tk))  || (empty($phone)) || (empty($coordinates))  || (empty($transit)) ) {
				array_push($errors, "* Εισάγετε υποχρεωτικά όλα τα πεδία *");
			}	
			else {
				$sql= "INSERT INTO local_store (name, address, numb, city, phone, tk, coordinates, transit_hub_city) VALUES ('$name', '$street', '$number', '$city', '$phone', '$tk', '$coordinates', '$transit')"; 	

				if (mysqli_query($db, $sql)) {
				    echo "New record created successfully into local_store table";
				} else {
    				echo "Error: " .mysqli_error($db);
				}

				header('location: admin.php');
				$_SESSION['success'] = "Store created";		
			}
	}

//delete_store.php

	if (isset($_POST['delete'])) {
			
			$name = mysqli_real_escape_string($db, $_REQUEST['name']);
			$transit = mysqli_real_escape_string($db, $_REQUEST['transit']);

			if (  (empty($name)) || (empty($transit)) ) {
				array_push($errors, "* Εισάγετε υποχρεωτικά όλα τα πεδία *");
			}	
			else {
				$sql= "DELETE FROM local_store WHERE name = '$name' "; 	

				if (mysqli_query($db, $sql)) {
				    echo "Record deleted successfully from local_store table";
				} else {
    				echo "Error: " .mysqli_error($db);
				}

				header('location: admin.php');
				$_SESSION['success'] = "Store deleted";		
			}

	}


//change_store.php
	if (isset($_POST['c_store'])) {
			//$name = "a store";
		    $st_name = mysqli_real_escape_string($db, $_REQUEST['store_name']);
			$new_name = mysqli_real_escape_string($db, $_REQUEST['new_name']);
			$street = mysqli_real_escape_string($db, $_REQUEST['street']);
			$number = mysqli_real_escape_string($db, $_REQUEST['number']);
			$city = mysqli_real_escape_string($db, $_REQUEST['city']);
			$tk1 = mysqli_real_escape_string($db, $_REQUEST['tk']);
			$phone = mysqli_real_escape_string($db, $_REQUEST['phone']);
			$coordinates = mysqli_real_escape_string($db, $_REQUEST['coordinates']);
			$transit = mysqli_real_escape_string($db, $_REQUEST['transit']);

			if (empty($st_name)) {
				array_push($errors, "* Εισάγετε πρώτα το όνομα του καταστήματος *");
			} 
			else{

				$query= "SELECT name FROM local_store WHERE name='$st_name' "; 			
				$results = mysqli_query($db, $query);

				if (mysqli_num_rows($results) > 0 ) { 
					echo "success";
				}else {
					array_push($errors, "* Λάθος όνομα, προσπαθήστε ξανά. *");
				}
			}

			if  (!empty($new_name)) {
				$query= "UPDATE local_store SET name='$new_name' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Αυτό το όνομα δεν είναι διαθέσιμο *");
			    }
			}	
			if  (!empty($street)) {
				$query= "UPDATE local_store SET address='$street' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Σφάλμα: Παραλώ εισάγετε ξανά τα στοιχεία *");
			    }
			}	
			if  (!empty($number)) {
				$query= "UPDATE local_store SET numb='$number' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Σφάλμα: Παραλώ εισάγετε ξανά τα στοιχεία *");
			    }
			}	
			if  (!empty($city)) {
				$query= "UPDATE local_store SET city='$city' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Σφάλμα: Παραλώ εισάγετε ξανά τα στοιχεία *");
			    }
			}	
			if  (!empty($tk1)) {
				$query= "UPDATE local_store SET tk='$tk1' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Σφάλμα: Παραλώ εισάγετε ξανά τα στοιχεία *");
			    }
			}	
			if  (!empty($phone)) {
				$query= "UPDATE local_store SET phone='$phone' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Σφάλμα: Παραλώ εισάγετε ξανά τα στοιχεία *");
			    }
			}	
			if  (!empty($coordinates)) {
				$query= "UPDATE local_store SET coordinates='$coordinates' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Σφάλμα: Παραλώ εισάγετε ξανά τα στοιχεία *");
			    }
			}	
			if  (!empty($transit)) {
				$query= "UPDATE local_store SET transit_hub='$transit' WHERE name='$st_name' ";	
			    if (!mysqli_query($db, $query)){
    			    array_push($errors, "* Σφάλμα: Παραλώ εισάγετε ένα υπάρχον Transit Hub *");
			    }
			}	
	
	}   

//------------------------------------------------------------------

//create_staff_for_transit_hub	

	if (isset($_POST['cr_staff_t_h'])) {
			
		$username = mysqli_real_escape_string($db, $_REQUEST['th_staff_username']);
		$password = mysqli_real_escape_string($db, $_REQUEST['th_staff_password']);
		$transit = mysqli_real_escape_string($db, $_REQUEST['transit']);
		if ((empty($username)) || (empty($password)) || (empty($transit))) {
			array_push($errors, "* Εισάγετε υποχρεωτικά όλα τα πεδία *");
		} 
		else {
			$sql= "INSERT INTO th_staff (name, password, transit_hub_city) VALUES ('$username', '$password', '$transit')"; 	

			if (mysqli_query($db, $sql)) {
				echo "Η εγγραφή καταχωρήθηκε με επιτυχία!";
				header('location: admin.php');
				$_SESSION['success'] = "Η εγγραφή καταχωρήθηκε με επιτυχία!";
			} 
			else {
    			//echo "Error: " .mysqli_error($db);
    			array_push($errors, "* Αυτό το username δεν είναι διαθέσιμο *");
			}
						
		}
	}

//delete_staff_for_transit_hub	

	if (isset($_POST['d_staff_t_h'])) {

			$username = mysqli_real_escape_string($db, $_REQUEST['th_staff_username']);
			$tr_hu = mysqli_real_escape_string($db, $_REQUEST['tr_hu']);

			if ( (empty($username))  || (empty($tr_hu)) ) {
				array_push($errors, "* Εισάγετε το username *");
			}
			else {
				$sql= "DELETE FROM th_staff WHERE name = '$username' AND transit_hub_city = '$tr_hu'";

				if (mysqli_query($db, $sql)) {
				    echo "Record deleted successfully from th_staff table";
				} else {
    				echo "Error: " .mysqli_error($conn);
				}

				header('location: admin.php');
				$_SESSION['success'] = "Ο υπάλληλος του transit hub διαγράφηκε!";
			}

	}

//change_staff_for_transit_hub	
//change username for transit hub staff	

	if (isset($_POST['ch_thstaff_name'])) {

		$username = mysqli_real_escape_string($db, $_REQUEST['username']);
		$nusername = mysqli_real_escape_string($db, $_REQUEST['nusername']);
		
		
		if ( (empty($username)) || (empty($nusername)) ) {
			array_push($errors, "* Παρακαλώ εισάγετε και τα δύο πεδία *");
		} 
		else {
			$sql = "UPDATE th_staff SET name='$nusername' WHERE name='$username' ";

			if (mysqli_query($db, $sql)) {
				    $_SESSION['success'] = "Το username άλλαξε επιτυχώς!";
			} else {
    				echo "Error: " .mysqli_error($db);
    				array_push($errors, "* Αυτό το username δε βρέθηκε *");
			}

		}	
	}
	
//change password for transit hub staff	
	if (isset($_POST['ch_thstaff_pass'])) {

		$username = mysqli_real_escape_string($db, $_REQUEST['pusername']);
		$password = mysqli_real_escape_string($db, $_REQUEST['password']);
		$npassword = mysqli_real_escape_string($db, $_REQUEST['npassword']);

		 if ( (empty($password)) || (empty($npassword)) || (empty($username)) ) {
		 	array_push($errors, "* Παρακαλώ εισάγετε όλα τα πεδία *");
		 }
		 else {
			$sql = "UPDATE th_staff SET password ='$npassword' WHERE name='$username' and password='$password' ";
			if (mysqli_query($db, $sql)) {
				    $_SESSION['success'] = "Ο κωδικός άλλαξε επιτυχώς!";
			} else {
    				echo "Error: " .mysqli_error($db);
    				array_push($errors, "* Λάθος username ή password *");
			}

		}

	}


//show staff
	
//------------------------------------------------------------------

//create_staff 

	if (isset($_POST['c_staff'])) {
		
		$username = mysqli_real_escape_string($db, $_REQUEST['username']);
		$password = mysqli_real_escape_string($db, $_REQUEST['password']);
		$store = mysqli_real_escape_string($db, $_REQUEST['store']);
		
		if ((empty($username)) || (empty($password)) || (empty($store))) {
			array_push($errors, "* Εισάγετε υποχρεωτικά όλα τα πεδία *");
		} 
		else {
			$sql= "INSERT INTO staff (name, password, local_store_name) VALUES ('$username', '$password', '$store')"; 	

			if (mysqli_query($db, $sql)) {
				echo "Η εγγραφή καταχωρήθηκε με επιτυχία!";

				header('location: admin.php');
				$_SESSION['success'] = "Η εγγραφή καταχωρήθηκε με επιτυχία!";		
			} 
			else {
    			echo "Error: " .mysqli_error($db); 
    			array_push($errors, "* Αυτό το username δεν είναι διαθέσιμο *");
			}
				
		}
	}	

//delete_staff 

	if (isset($_POST['d_staff'])) {
			$username = mysqli_real_escape_string($db, $_REQUEST['username']);

			if (empty($username)) {
				array_push($errors, "* Εισάγετε το username *");
			}
			else {
				$sql= "DELETE FROM staff WHERE name = '$username'";

				if (mysqli_query($db, $sql)) {
				    echo "Record deleted successfully from staff table";
				} else {
    				echo "Error: " .mysqli_error($conn);
				}

				header('location: admin.php');
				$_SESSION['success'] = "Ο υπάλληλος του transit hub διαγράφηκε!";
			}
	}	

//change_staff	
	
	//change staff name
	if (isset($_POST['ch_staff_name'])) {
		$username = mysqli_real_escape_string($db, $_REQUEST['username']);
		$nusername = mysqli_real_escape_string($db, $_REQUEST['nusername']);
		
		
		if ( (empty($username)) || (empty($nusername)) ) {
			array_push($errors, "* Παρακαλώ εισάγετε και τα δύο πεδία *");
		} 
		else {
			$sql = "UPDATE staff SET name='$nusername' WHERE name='$username' ";

			if (mysqli_query($db, $sql)) {
				    $_SESSION['success'] = "Το username άλλαξε επιτυχώς!";
			} else {
    				echo "Error: " .mysqli_error($db);
    				array_push($errors, "* Αυτό το username δεν είναι διαθέσιμο *");
			}

		}	
	}

    // change staff password	
	if (isset($_POST['ch_staff_pass'])) {

		$username = mysqli_real_escape_string($db, $_REQUEST['pusername']);
		$password = mysqli_real_escape_string($db, $_REQUEST['password']);
		$npassword = mysqli_real_escape_string($db, $_REQUEST['npassword']);

		 if ( (empty($password)) || (empty($npassword)) || (empty($username)) ) {
		 	array_push($errors, "* Παρακαλώ εισάγετε όλα τα πεδία *");
		 }
		 else {
		 	$query = "SELECT name FROM staff WHERE name = '$username' AND password = '$password'";
		 	$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) > 0 ) { 
				$sql = "UPDATE staff SET password ='$npassword' WHERE name='$username' AND password='$password' ";
				if (mysqli_query($db, $sql)) {
				    $_SESSION['success'] = "Ο κωδικός άλλαξε επιτυχώς!";
				} else {
    				echo "Error: " .mysqli_error($db);
				}
			}else {
				array_push($errors, "* Λάθος username ή password, προσπαθήστε ξανά. *");
			}

		}

	}



//------------------------------------------------------------------


?>