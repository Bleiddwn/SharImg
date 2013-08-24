<?php include_once('model.php');
include_once('control.php');

include_once('./inc/header.php'); ?>
<div id="page">Connection</div>
<div id="main">
<?php

if(!isConfig())
	echo 'Le fichier config.php ne semble pas exister et SharImg pas encore installé. Rendez-vous sur la <a href="install.php">page d\'installation</a> pour commencer l\'installation.</div>';

else
{
	if(isLogin())
		echo 'Vous êtes déjà connecté !';
	else
		connection();
}

?>

</div>
<div id="page">...</div>

<? include_once('./inc/footer.php');?>
