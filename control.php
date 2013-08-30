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
	if(!(isset($_GET['type'])) || $_GET['type']=='PC')
	{
	uploadPC();
	}
	else
	{
	uploadURL();
	}
}

function uploadPC()
{
echo '<form method="POST" action="upload.php?type=PC" enctype="multipart/form-data">
		<fieldset>
			<legend>Télécharger une image à partir de votre ordinateur - <a style="font-size: 9px;" href="upload.php?type=URL">Télécharger une image à partir d\'une URL</a></legend><br/>

              Fichier : <input style="width: 500px;" type="file" name="imgPC" style="color: black"><br/><br/>
			  Nom (sans extension) :
			  <div style="font-size: 9px;">Si le champ est laissé vide, le nom sera celui du fichier uploadé </div>
			  <div style="font-size: 9px;">Les espaces seront remplacés par le caractère \'_\'</div>
			  <input style="width: 500px;" type="textarea" name="imgName" style="color: black"><br/><br/>
              Description : <br/><textarea style="width: 500px;" name="imgDescription" style="color: black"></textarea>
				
              <input style="float: right" type="submit" name="Upload" value="Upload">
	     </fieldset>
       </form>';
       
       
if(isset($_FILES['imgPC']))
{
	$extension=array('png','gif','jpg','jpeg');
	$ext = substr(strrchr($_FILES['imgPC']['name'],'.'),1);
	
	
	if(!in_array($ext,$extension))
	{
		echo '<strong>[Erreur]</strong> Ce fichier ne semble pas être une image (.png .gif .jpeg .jpg)';
	}
	else
	{
		if(empty($_POST['imgName']))
		{
		$name=time().'_'.basename($_FILES['imgPC']['name']);
		}
		else
		{
		$name=time().'_'.str_replace(' ','_',$_POST['imgName']).'.'.$ext;
		}
		
		if(move_uploaded_file($_FILES['imgPC']['tmp_name'], './img/'.$name)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     	{	
			WriteXML($name, $_POST['imgDescription']);
			list($width, $height, $type, $attr) = getimagesize('./img/'.$name);

				echo '<h3>File uploaded !</h3>';
          		echo '[Name] '.$name.'<br/>';
				echo '[Height] '.$height.'px<br/>';
				echo '[Width] '.$width.'px<br/>';
				echo '<center><img src="./img/'.$name.'" width="500" height="'.round(((500*$height)/$width)).'"/></center><br/>';
	
     	}
     	else //Sinon (la fonction renvoie FALSE).
     	{
				echo '<strong>[Erreur]</strong> Echec de l\'upload ! Assurez-vous que le dossier ./img est accessible en écriture.';
     	}	
	}

}
return 0;
}



function uploadURL()
{
		$extension=array('png','gif','jpg','jpeg');

echo'	   <form method="POST" action="upload.php?type=URL" enctype="multipart/form-data">
	      <fieldset>
	<legend> Télécharger une image à partir d\'une URL - <a href="upload.php?type=PC" style="font-size: 9px;">Télécharger une image à partir de votre ordinateur</a></legend>    <br/>          
	URL : <input style="width: 500px;" type="textarea" name="imgURL" style="color: black"><br/><br/>
	        Nom (sans extension) :
			  <div style="font-size: 9px;">Si le champ est laissé vide, le nom sera celui du fichier uploadé </div>
			  <div style="font-size: 9px;">Les espaces seront remplacés par le caractère \'_\'</div>
			  <input style="width: 500px;" type="textarea" name="imgName" style="color: black"><br/><br/>
              Description : <br/><textarea style="width: 500px;" name="imgDescription" style="color: black"></textarea><input style="float: right" type="submit" name="Upload" value="Upload">
	      </fieldset>
              </form><br/>';
              
if(empty($_POST['imgURL']))
{
	echo 'Merci de spécifier une URL !';
}
else
{
	if($current = file_get_contents($_POST['imgURL']))
	{
		$extension=array('png','gif','jpg','jpeg');
		$ext = substr(strrchr($_POST['imgURL'],'.'),1);
		
		if(!in_array($ext,$extension))
		{
			echo '<strong>[Erreur]</strong> Ce fichier ne semble pas être une image (.png .gif .jpeg .jpg)';
		}
		else
		{
			if(empty($_POST['imgName']))
			{
				$name=time().'_'.end(explode("/",$_POST['imgURL']));
			}
			else
			{
				$name=time().'_'.str_replace(' ','_',$_POST['imgName']).'.'.$ext;
			}
			
			if(file_put_contents('./img/'.$name, $current))
			{
				WriteXML($name, $_POST['imgDescription']);

				echo '<h3>File uploaded !</h3>';
				list($width, $height, $type, $attr) = getimagesize('./img/'.$name);
          		echo '[Name] '.$name.'<br/>';
				echo '[Height] '.$height.'px<br/>';
				echo '[Width] '.$width.'px<br/>';
				echo '<center><img src="./img/'.$name.'" width="500" height="'.round(((500*$height)/$width)).'"/></center><br/>';
			}
	
			else //Sinon (la fonction renvoie FALSE).
     		{
          		echo '<strong>[Erreur]</strong> Echec de l\'upload ! Assurez-vous que le dossier ./img est accessible en écriture.';
     		}
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
		return $_SESSION['pseudo'].' <a href="logout.php"><strong>[Deconnexion]</strong></a>';
	}
	else
	{
		return '<a href="login.php"><strong>[Connexion]</strong></a>';
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
	
	
	for($i=0; $i<$n; $i++)
	{
		if ($i==0)
			$a=0;
		else
			$a=$table[$i-1][0]; // Pour gérer l'exeption $i=0;

		$table[$i][0] = $seq[$i] +  $a;
	}

	for($j=0; $j<$k; $j++)
	{
		$table[0][$j] = $seq[0];
	}


	for($i=1; $i<$n; $i++)
	{
		for($j=1; $j<$k; $j++)
		{
			for($x=0; $x<$i; $x++)	
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
	$sum_width=0;

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
	$final_string="";
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
			$info=getImgInfo($u);
			$width_ok=round(($ideal_height*$array_width[$u])/300); // On calcule la largeur que devrait avoir l'image avec la hauteur idéale ($ideal_height).
			if(isLogin())
				$final_string=$final_string.'
		<span class="image"><div style="width:'.$width_ok.'px; height:'.$ideal_height.'px" class="txt"><a href="delete.php?id='.$u.'" class="suppr"></a>	 <div class="txt_nom"><a href="img.php?name='.substr(strrchr($array_path[$u],'/'),1).'">'.$info['name'].'</a></div><div class="txt_description">'.$info['description'].'</div></div><img src="'.$array_path[$u].'" height="'.$ideal_height.'" width="'.$width_ok.'" /></span>';
				 // On affiche l'image.
				// Le '(countImg()-$u-1)' est crade. Je verrai si c'est fiable à long terme.
			else
	$final_string=$final_string.'
		<span class="image"><div style="width:'.$width_ok.'px; height:'.$ideal_height.'px" class="txt">	 <div class="txt_nom"><a href="img.php?id='.$u.'">'.$info['name'].'</a></div><div class="txt_description">'.$info['description'].'</div></div><img src="'.$array_path[$u].'" height="'.$ideal_height.'" width="'.$width_ok.'" /></span>';			$u++;
		}


	}
return $final_string;
	}
}

// Gestion des pages
$pagination=20	;
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





