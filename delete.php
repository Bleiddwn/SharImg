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

		if(isset($_GET['id']))
		{	
			
	
			
			deleteImgFromFolder($_GET['id'],$_GET['c']);
			deleteImgFromXML($_GET['id'],$_GET['c']);
			echo '<script language="JavaScript">window.location="view.php?c='.$_GET['c'].'"</script>';
		}

	}
?>
</div>
<div id="page">...</div>

<?php include_once('./inc/footer.php');
