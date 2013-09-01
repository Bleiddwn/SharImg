<?php 
include_once('model.php');
include_once('control.php');
include_once('./inc/header.php'); 

echo '<div id="page">Catégories</div><div id="main">';
	if(!isLogin())
	{
				echo 'Vous n\'êtes pas connecté ! Connectez-vous sur <a href="login.php">cette page</a>.';

}
else
{
	
AddCat();
supprCat();
}
echo '</div><div id="page">...</div>';
include_once('./inc/footer.php');
