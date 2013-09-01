<?php

function listerCat()
{
	$listeCat=Array();
	$i=0;
	if($dossier=opendir('./c'))
	{
		while(false !== ($dir = readdir($dossier)))	
		{
			if($dir != '.' && $dir != '..')
			{
			$listeCat[$i]=$dir; // On récupère le chemin de toutes les images
			$i++;
			}
		}
		closedir($dossier);
	}
return $listeCat;
}

function getImgPath($cat)
{
$array_path=array();
$i=0;
	if($dossier = opendir('./c/'.$cat))
	{
		while(false !== ($fichier = readdir($dossier)))
		{
			if($fichier != '.' && $fichier != '..' && $fichier != 'imagesXML.xml')
			{
			$array_path[$i]='./c/'.$cat.'/'.$fichier; // On récupère le chemin de toutes les images
			$i++;
			}
		}
		closedir($dossier);
	}

	array_multisort($array_path, SORT_DESC); // On classe les images dans l'ordre
	
	return $array_path;
}


function deleteImgFromFolder($img_id,$cat)
{
$path=getImgPath($cat);

unlink($path[$img_id]);
return 0;
}

function countImg($cat)
{
$NbFichier=0;
	if($dossier = opendir('./c/'.$cat))
	{
		while(false !== ($fichier = readdir($dossier)))
		{
			if($fichier != '.' && $fichier != '..' && $fichier != 'imagesXML.xml')
			{
			$NbFichier++; // On compte le nombre d'images
			}
		}
	closedir($dossier);
	}
return $NbFichier;
}

function countSize()
{
$tailleFichier=0;
	if($dossier = opendir('./img'))
	{
		while(false !== ($fichier = readdir($dossier)))
		{
			if($fichier != '.' && $fichier != '..' && $fichier != 'index.php')
			{
			$tailleFichier=$tailleFichier+round(filesize('./img/'.$fichier)/1024.2,1);
			
			}
		}
	closedir($dossier);
	}
return $tailleFichier;
}

function deleteDir($cat)
{
if($dossier = opendir('./c/'.$cat))
	{
		while(false !== ($fichier = readdir($dossier)))
		{
			if($fichier != '.' && $fichier != '..')
			{
			unlink('./c/'.$cat.'/'.$fichier);
			}
		}
	closedir($dossier);
	}
rmdir('./c/'.$cat);
}

