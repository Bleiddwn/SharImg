<?php
session_start();

include_once('./model/XML.php');
include_once('./model/Dossier.php');


////////////////////////////////////////////////////////////////////
// Ensembles de fonctions chargées de gérer le fichier config.php //	
////////////////////////////////////////////////////////////////////

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
	

