<?php
// En fait je viens d'éditer ce fichier en mode expérimental !
//Encore et encore :)
// [SharImg] 
// Un moyen simple de partager vos images.
//
// Licence WTFPL - do What The Fuck You Want with this code.
//
// Bleiddwn <bleiddwn@bleiddwn.com>
// http://bleiddwn.com/project/sharimg/
//

include_once('model.php');
include_once('control.php');




include_once('./inc/header.php');

$nav_width=$_GET['NavWidth'];

?>
<script language="JavaScript">

	function getQuerystring(key, default_)
	{
  		if (default_==null) default_=""; 
 		key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  		var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
  		var qs = regex.exec(window.location.href);
  		
		if(qs == null)
    			return default_;
  		else
    			return qs[1];
	}


var onresize_actif = false;
window.onresize = function() {
  if( onresize_actif)
    return;
  window.location='view.php?NavWidth='+window.innerWidth+'&page='+getQuerystring('page')+'&c='+getQuerystring('c');
  onresize_actif = true;
  setTimeout(function () { onresize_actif = false; }, 1000);
}; //Ca a pas grande importance mais du js sans ; à la fin des instructions n'est plus vraiment du js 



	

	if(window.innerWidth != getQuerystring('NavWidth'))
	{
  window.location='view.php?NavWidth='+window.innerWidth+'&page='+getQuerystring('page')+'&c='+getQuerystring('c');
	}
	//window.onresize = window.location='index.php?NavWidth='+window.innerWidth+'&page='+getQuerystring('page');
</script>
<?php

if(!isConfig())
	echo '<div id="page">config.php manquant</div><div id="main">Le fichier config.php ne semble pas exister et SharImg pas encore installé. Rendez-vous sur la <a href="install.php">page d\'installation</a> pour commencer l\'installation.</div><div id="page">...</div>';

else
{
	if(isCatExist($_GET['c']))
	{
	$m=pageInfo($_GET['c']);
	printPage($m['page'], $m['nbPage'], $_GET['c']);
	echo printCategorie($m['debut'], $m['fin'],$nav_width, $_GET['c']);
	printPage($m['page'], $m['nbPage'], $_GET['c']);
	}
	else
	{
	echo '<div id="page">Catégorie inexistante</div><div id="main">Cette catégorie n\'existe pas.</div><div id="page">...</div>';
	}

}

	
	
	
	



include_once('./inc/footer.php');
