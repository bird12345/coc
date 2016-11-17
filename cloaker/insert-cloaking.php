<?php
$files = array_merge(glob('../*.php'), glob('../*.html'), glob('../*.htm'));

function add_cloaking($f)
{
	$cstring = "<?php include 'cloaker/cloaker.php' ?>\n";
	$f = str_replace('_', '.', $f);
	$s = file_get_contents($f);
	if (strpos($s, 'cloaker.php') === false)
		file_put_contents($f, $cstring . $s);
}

if (isset($_POST['save'])) {
	foreach ($_POST as $k => $v) {
		if ($v == "on") add_cloaking($k);
	}
}

?>
<html>
<head>
<title>Add Cloaking to Pages</title>
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
	<?php if (isset($_POST['save'])) echo "<p class='updated'>Adding cloaked to all selected files</p>"; ?>
	
	<p>This script will add php code to the top of every file checked off below</p>
	<br />
	<form action="insert-cloaking.php" method="post">
		<?php foreach($files as $f) : ?>
			<input type="checkbox" checked="yes" name="<?php echo $f; ?>" /><?php echo $f; ?><br />
		<?php endforeach; ?>
		<input class="submit" type="submit" name="save" value="Start!" />
	</form>
</div>
</body>
</html>