<?php

function deleteImgFromFolder($img_id)
{
$path=getImgPath();
unlink($path[$img_id]);
return 0;
}

function countImg()
{
$NbFichier=0;
	if($dossier = opendir('./img'))
	{
		while(false !== ($fichier = readdir($dossier)))
		{
			if($fichier != '.' && $fichier != '..' && $fichier != 'index.php')
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

