<?php
session_start();

function deleteCheckedFiles()
{
	$array_name=getImgPath();

	for($i=0;$i<count($array_name);$i++)
	{
		if(isset($_POST[$i]))
		{
			unlink($array_name[$i]);
		}
	}
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

function getImgPath()
{
$array_path=array();
$i=0;
	if($dossier = opendir('./img'))
	{
		while(false !== ($fichier = readdir($dossier)))
		{
			if($fichier != '.' && $fichier != '..' && $fichier != 'index.php')
			{
			$array_path[$i]='./img/'.$fichier; // On récupère le chemin de toutes les images
			$i++;
			}
		}
		closedir($dossier);
	}

	array_multisort($array_path, SORT_DESC); // On classe les images dans l'ordre
	
	return $array_path;
}

function getUser()
{
	if($config_file = fopen('config.php', 'rb'))
	{
		$user=fgets($config_file);
		fclose($config_file);
		return $user;
	}
	else
		return 0;
}

function getPassword()
{
	if($config_file = fopen('config.php', 'rb'))
	{
		$password=fgets($config_file);
		$password=fgets($config_file);
		fclose($config_file);
		return $password;
	}
}

function writeConfig($user, $password)
{
	if($config_file = fopen('config.php', 'w+b'))
	{
		fputs($config_file, $user.PHP_EOL.$password);
		fclose($config_file);
		return TRUE;
	}
	else
		return FALSE;
	
}

function isConfig()
{
	if(file_exists('config.php'))
		return TRUE;
	else
		return FALSE;
}
	




