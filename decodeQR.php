
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">

  <body>

  <?php
  	if(isset($_POST['reset_cam'])){
  		header('location: decodeQR.php');
  	}

  ?>	
  <div class="content">  
  <video autoplay></video>
        <button id="reset" class="btn1" name="reset_cam">Reset camera</button>
  <?php  
   		require __DIR__ . "/qr-composer/vendor/autoload.php";
		$qrcode = new QrReader('path/to_image');
		$text = $qrcode->text(); //return decoded text from QR Code
  ?> 

</div>
</body>
</head>
</html>
