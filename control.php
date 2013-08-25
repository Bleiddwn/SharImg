<?php

function getDeleteCheckBox()
{
	$output='<form action="delete.php" method="post" enctype="multipart/form-data">';

 	$array_name=getImgPath();
	for($i=0;$i<count($array_name);$i++)
		$output.='<input type="checkbox" name="'.$i.'" id="'.$array_name[$i].'"/> <label for="'.$array_name[$i].'"><a href="'.$array_name[$i].'">'.$array_name[$i].'</a></label><br/>';
	
	$output.='<br/><input type="submit" value="Supprimer les images cochées" /><br/></form>';

	return $output;

}

		

	
           

	







function upload()
{	
	$extension=array('png','gif','jpg','jpeg');

	if(isset($_GET['url']))
		$field ='URL : <input style="width: 500px;" type="text" name="image_url" style="color: black" value="'.$_GET['url'].'">';
	
	else
		$field ='URL : <input style="width: 500px;" type="text" name="image_url" style="color: black">';
	


	echo '<form method="POST" action="upload.php?type=pc" enctype="multipart/form-data">
              <fieldset>
	      <legend>Télécharger une image de votre ordinateur</legend>

              File : <input style="width: 500px;" type="file" name="image_pc" style="color: black">
              <input style="float: right" type="submit" name="Upload" value="Upload">
	      </fieldset>

              </form><br/>
              <form method="POST" action="upload.php?type=url" enctype="multipart/form-data">
	      <fieldset>
              <legend>Télécharger une image à partir d\'une URL</legend>'.
		$field
	     .' <input style="float: right" type="submit" name="Upload" value="Upload">
	      </fieldset>
              </form><br/>';

	
	if($_GET['type']=='pc')
	{
	if(isset($_FILES['image_pc']))
	{ 
     		$dossier = './img/';
     		$fichier =  time().'_'.basename($_FILES['image_pc']['name']);	
		$ext = substr(strrchr($_FILES['image_pc']['name'],'.'),1);

		if(!in_array($ext,$extension))
			echo '<strong>[Erreur]</strong> Ce fichier ne semble pas être une image (.png .gif .jpeg .jpg)';
		else	
		{	
			if(move_uploaded_file($_FILES['image_pc']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     			{	
				echo '<h3>File uploaded !</h3>';
				list($width, $height, $type, $attr) = getimagesize($dossier.$fichier);
          			echo '[Name] '.$fichier.'<br/>';
				echo '[Height] '.$height.'px<br/>';
				echo '[Width] '.$width.'px<br/>';
				echo '[URL] '.$dossier.$fichier.'<br/>';
				echo '<center><img src="'.$dossier.$fichier.'" width="500" height="'.round(((500*$height)/$width)).'"/></center><br/>';
	
     			}
     			else //Sinon (la fonction renvoie FALSE).
     			{
          			echo '<strong>[Erreur]</strong> Echec de l\'upload ! Assurez-vous que le dossier ./img est accessible en écriture.';
     			}	
		}
	}
}

if($_GET['type']=='url')
{	

	if(empty($_POST['image_url']))
		echo '<strong>[Erreur]</strong> Echec de l\'upload ! Assurez-vous que le dossier ./img est accessible en écriture.';
	
	else
	{
	
		if($current = file_get_contents($_POST['image_url']))
		{
			$name = time().'_'.end(explode("/",$_POST['image_url']));
			$ext = substr(strrchr($name,'.'),1);

			if(!in_array($ext,$extension))
				echo '<strong>[Erreur]</strong> Ce fichier ne semble pas être une image (.png .gif .jpeg .jpg)';
			
			else
			{
				$file = './img/'.$name;

				if(file_put_contents($file, $current))
				{
					echo '<h3>File uploaded !</h3>';
					list($width, $height, $type, $attr) = getimagesize($file);
          				echo '[Name] '.$name.'<br/>';
					echo '[Height] '.$height.'px<br/>';
					echo '[Width] '.$width.'px<br/>';
					echo '[URL] '.$file.'<br/>';
					echo '<center><img src="'.$file.'" width="500" height="'.round(((500*$height)/$width)).'"/></center><br/>';
				}
				else //Sinon (la fonction renvoie FALSE).
     				{
          				echo '<strong>[Erreur]</strong> Echec de l\'upload ! Assurez-vous que le dossier ./img est accessible en écriture.';
     				}
			}	
		}
		else
		{
			echo '<strong>[Erreur]</strong> Echec de l\'upload ! Assurez-vous que le site dont provient l\'image ne possède pas de dispositif anti-leech.';
		}
	}

}
	


}

   




function connection()
{
	if (!isset($_POST['pseudo'])) //On est dans la page de formulaire
	{
 	   echo '<form method="post" action="login.php">
  		 <fieldset>
   		 <legend>Connexion</legend>
   		 <p>
    		 <label for="pseudo">Pseudo :</label><input name="pseudo" type="text" id="pseudo" /><br />
    		 <label for="password">Mot de passe :</label><input type="password" name="password" id="password" />
    		 </p>
    		 </fieldset>
   		 <p><input type="submit" value="Connexion" /></p></form>';

	}
	else
	{
		if (empty($_POST['pseudo']) || empty($_POST['password']) ) //Oublie d'un champ
  		{
      			echo '<p>une erreur s\'est produite pendant votre identification.
  	              Vous devez remplir tous les champs</p>
    		      <p>Cliquez <a href="./login.php">ici</a> pour revenir</p>';
		}
  		else //On check le mot de passe
    		{
      					
   			if (crypt($_POST['password'],getPassword())==getPassword() && $_POST['pseudo'].PHP_EOL==getUser()) // Acces OK !
   			{

        			$_SESSION['pseudo'] = $_POST['pseudo'];
				echo '<script language="JavaScript">alert("Vous êtes maintenant connecté(e)");window.location="index.php"</script>';
   			}
  	 		else
    	 		{
         			echo '<p>Une erreur s\'est produite 
        pendant votre identification.<br /> Le mot de passe ou le pseudo 
            entré n\'est pas correcte.</p><p>Cliquez <a href="./login.php">ici</a> 
        pour revenir à la page précédente
        <br /><br />Cliquez <a href="./index.php">ici</a> 
        pour revenir à la page d accueil</p>';
      			}

    		}

 
	}

}

function isLogin()
{
	if (isset($_SESSION['pseudo']) )
		return TRUE;
	else
		return FALSE;
}

function print_Login()
{
	if (isset($_SESSION['pseudo']) )
	{
		return $_SESSION['pseudo'].' <a href="logout.php"><strong>[Deconnection]</strong></a>';
	}
	else
	{
		return '<a href="login.php"><strong>[Connection]</strong></a>';
	}
}

function install()
{
echo '<form method="post" action="install.php">
    <fieldset>
    <legend>Installation</legend>
    <p>
    <label for="user">Pseudo :</label><input name="user" type="text" id="pseudo" /><br />
    <label for="password">Mot de passe :</label><input type="password" name="password" id="password" />
    </p>
    </fieldset>
    <p><input type="submit" value="Installation" /></p></form>';

    	if (!empty($_POST['user']) && !empty($_POST['password']))
	{
		if(WriteConfig($_POST['user'],crypt($_POST['password']))==TRUE)
		{
			echo '<script language="JavaScript">alert("L\'installation s\'est correctement déroulée !");window.location="login.php"</script>';
		}
		else
			echo 'Impossible de créer ou d\'écrire dans le fichier config.php. Vérifiez les droits d\'écriture.';
		
	}
	else
		echo 'Vous devez renseigner les champs Pseudo et Mot de Passe !';

return 0;
}

function linear_partition_table($seq, $k) // Fonction chargée d'effectuée la partition linéaire
{

	$final_string;
	// ############## LINEAR PARTITION TABLE ###############
	$n=count($seq);
	$table=array();
	$solution=array();

	for($i=0;$i<$n;$i++)
	{
		for($j=0;$j<$k;$j++)
		{ 
	   	$table[$i][$j]=0;
		}
	} 
	for($i=0;$i<$n-1;$i++)
	{
		for($j=0;$j<$k-1;$j++)
		{ 
	   	$solution[$i][$j]=0; 
		}
	} 

	for($i=0; $i<=$n; $i++)
	{
		$table[$i][0] = $seq[$i] +  $table[$i-1][0];
	}

	for($j=0; $j<=$k; $j++)
	{
		$table[0][$j] = $seq[0];
	}


	for($i=1; $i<=$n; $i++)
	{
		for($j=1; $j<=$k; $j++)
		{
			for($x=0; $x<=$i; $x++)	
			{
				$use[$x]=max($table[$x][$j-1], $table[$i][0]-$table[$x][0]);
			}

		$table[$i][$j]=min($use);
		$solution[$i-1][$j-1]=array_search(min($use), $use);		
		}
	}

	// ############## LINEAR PARTITION ###############

	$buf=array();
	$ans=array();
	$n=count($seq)-1;
	$K=$k-2;
	
	$j=0;
	$l=0;
		
	while($K >= 0)
	{
		$j=0;
		
		for($i=$solution[$n-1][$K]+1;$i<$n+1;$i++)
		{
			$buf[$j]=$seq[$i];
			$buf[$j+1]='.';
			$j=$j+2;
		}
		$l++;
		$res[$k-$l]=implode('',$buf);
		$buf=NULL;
		$n=$solution[$n-1][$K];
		$K=$K-1;
	}
			
	$l++;
	$j=0;
			
	for($i=0;$i<$n+1;$i++)
	{
		$buf[$j]=$seq[$i];
		$buf[$j+1]='.';
		$j=$j+2;
	}
		
	$res[$k-$l]=implode('',$buf);
	

	$chaine = implode('/',array_reverse($res));
	return substr($chaine,0,(strlen($chaine)-1));
}


function printImg($debut, $fin, $nav_width)
{

	if(countImg()<3)
		return '<div id="main">Il faut au minimum 3 images pour afficher la mosaïque. Rendez-vous sur la <a href="upload.php">page d\'upload</a> pour en télécharger quelques unes.</div>';

	
	else
	{
	$array_path=getImgPath();

	$SumWidth=0;

	for($i=$debut;$i<$fin;$i++)
	{
		list($width, $height, $type, $attr) = getimagesize($array_path[$i]);
		$array_width[$i]=round(($width*300)/$height,0);
		$sum_width=$sum_width+(($width*300)/$height);
	}

	$k=round($sum_width/$nav_width,0,PHP_ROUND_HALF_UP); // $k représente le nombre de "lignes" qui seront affichées.

	$partition=linear_partition_table(array_values($array_width), $k);

	// $partition est désormais une chaîne de caractère du type 123.456./789.10.34/1337.42 

	$array_line_width=explode('./', $partition);	
	// On récupère les largeurs des images pour chaque ligne. Ici $LigneWidth[0]=123.456
	//							      $LigneWidth[1]=789.10.34
	//							      $LigneWidth[2]=1337.42	
	$u=$debut;
	
	for($i=0;$i<$k;$i++) // Pour chaque ligne
	{
		$img_width=explode('.',$array_line_width[$i]); // Contient la largeur des images de la ligne $i
		$width_available=$nav_width-15-(count($img_width)+1)*5; // La largeur disponible pour placer les images est égales à :
						      // La largeur du navigateur MOINS largeur par de scroll (15px) MOINS (nombre d'images de la ligne + 1)*5
		$sum=array_sum($img_width);

/* 
   On a la largeur disponible pour les images ($width_available), ainsi que la somme des largeurs des images de la ligne ($sum).
   Il s'agit maintenant de redimensionner les images de la ligne en modulant leur hauteur afin qu'elles s'encastrent parfaitement.
   On utilise pour cela une simple règle de trois.
*/
		$ideal_height=round((($width_available)*300)/$sum);

		foreach($img_width as $image) // Pour chaque image...
		{
			$width_ok=round(($ideal_height*$array_width[$u])/300); // On calcule la largeur que devrait avoir l'image avec la hauteur idéale ($ideal_height).
			$final_string=$final_string.'<a href="'.$array_path[$u].'"><img src="'.$array_path[$u].'" height="'.$ideal_height.'" width="'.$ok_width.'" /></a>'; // On affiche l'image.
			$u++;
		}
		


	}
return $final_string;
	}
}

// Gestion des pages
$pagination=15	;
$nb_fichier=countImg();

if( isset($_GET['page']) && is_numeric($_GET['page']) )
	$page = $_GET['page'];
else
	$page = 1;

$debut = ($page-1)*$pagination;
$fin = $page*$pagination;

if ($fin > $nb_fichier)
	$fin=$nb_fichier;

$nb_page=ceil($nb_fichier/$pagination);
	if ($nb_page==0)
		$nb_page=1;

function printPage()
{
global $page;
global $nb_page;
echo '<div id="page">';

if($page==1 && $nb_page==1)
	echo '[Page 1/1]';
elseif($page==1)
	echo '<span style="color: white";><< </span>[ Page '.$page.'/'.$nb_page.' ] <a href="index.php?page='.($page+1).'">>></a>';
elseif($page==$nb_page)
	echo '<a href="index.php?page='.($page-1).'"><< </a>[ Page '.$page.'/'.$nb_page.' ]<span style="color: white";>>></span>';
else
	echo '<a href="index.php?page='.($page-1).'"><< </a>[ Page '.$page.'/'.$nb_page.' ] <a href="index.php?page='.($page+1).'">>></a>';
echo '</div>';
}


?>


