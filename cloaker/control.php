<html>
<head>
<title>wpCloaker Admin Panel</title>
</title>
<style>
body { 
	background-color: #f0f0f0;
}

.submit input {
	height: 2em;
	width: 6em;
	font-weight: bold;
	font-size: 2em;
	padding: 10 10 10 10;
}

#content {
	width: 900px;
	margin: 20 auto 20 auto;
	font-family: Arial, sans;
	border: 1px solid darkgrey;
	padding: 10px 10px 10px 10px;
	background-color: white;
}
	
.updated {
	background-color: #ccff66;
	padding-top: 10px;
	padding-bottom: 5px;
	padding-left: 10px;
}

</style>
<body>
<div id="content">
<?php require_once('wpcloaker.php'); wpcloaker_options(); ?>
</div>
</body>
</html>