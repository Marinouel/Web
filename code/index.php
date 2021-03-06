<?php include('server.php') ?>

<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<script type="text/javascript" src="webqr.js"></script>
	<script type="text/javascript" src="grid.js"></script>
	<script type="text/javascript" src="version.js"></script>
	<script type="text/javascript" src="detector.js"></script>
	<script type="text/javascript" src="formatinf.js"></script>
	<script type="text/javascript" src="errorlevel.js"></script>
	<script type="text/javascript" src="bitmat.js"></script>
	<script type="text/javascript" src="datablock.js"></script>
	<script type="text/javascript" src="bmparser.js"></script>
	<script type="text/javascript" src="datamask.js"></script>
	<script type="text/javascript" src="rsdecoder.js"></script>
	<script type="text/javascript" src="gf256poly.js"></script>
	<script type="text/javascript" src="gf256.js"></script>
	<script type="text/javascript" src="decoder.js"></script>
	<script type="text/javascript" src="qrcode.js"></script>
	<script type="text/javascript" src="findpat.js"></script>
	<script type="text/javascript" src="alignpat.js"></script>
	<script type="text/javascript" src="databr.js"></script>

</head>

<body onload="load()">

<p>Read QR codes with JS</p>

<canvas id="qr-canvas" width="640" height="480" style="display:none"></canvas>


<form method="post" action="index.php">

		<div id="result">Result here</div>

		<div class="input-group">
			<button type="submit" class="btn" name="q">Ready</button>
		</div>
	</form>

<div id="outdiv">
</div>

</body>
</html>

