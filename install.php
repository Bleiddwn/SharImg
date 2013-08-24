<?php
include_once('model.php');
include_once('control.php');

include_once('./inc/header.php'); ?>
<div id="page">Installation</div>
<div id="main">
<?php
	if(isConfig()==TRUE)
		echo 'Il semblerait que le fichier config.php soit déjà existant dans le répertoire courant. Supprimez-le manuellement pour relancer la procédure d\'installation';
	else 
		install();
?>
</div>
<div id="page">...</div>

<? include_once('./inc/footer.php');?>
