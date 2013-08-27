<?php
include_once('model.php');
include_once('control.php');

include_once('./inc/header.php'); ?>
<div id="page">Supprimer une image</div>
<div id="main">
<?php
	if(!isLogin())
	{
		echo 'Vous n\'êtes pas connecté ! Connectez-vous sur <a href="login.php">cette page</a>.';
	}
	
	else 
	{
		deleteCheckedFiles();
		echo getDeleteCheckBox();

	}
?>
</div>
<div id="page">...</div>

<? include_once('./inc/footer.php');?>
