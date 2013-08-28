<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title>[SharImg]</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
 	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>





<div id="header">
	<div id="title">
		<a href="index.php">[ Sharimg<span style="font-size: 12px">Beta</span>] </a>
		<span id="description">(<?php echo countImg(); ?> images)</span>

		<span id="opt">
			<div>
				<a href="delete.php">[Supprimer une image] -</a>
				<a href="upload.php">[Uploader une image]</a>
			</div>
			<?php echo print_Login(); ?>

		</span>
	</div>

</div>
