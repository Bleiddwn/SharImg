<?php
session_start();

// Toutes les fonctions permettant la gestion du fichier XML et des images
function WriteXML($nom, $description)
{
$xml=new DomDocument('1.0');

	if($xml->load("imagesXML.xml"))
	{
	$racine=$xml->documentElement;
	$image=$xml->createElement("image"); // On crée <image></image>
	
	$IMGname=$xml->createElement("name");	//On crée <name></name>
	$IMGname->appendChild($xml->createTextNode($nom));
	
	$IMGdescription=$xml->createElement("description");	
	$IMGdescription->appendChild($xml->createTextNode($description));
	
	$IMGtimestamp=$xml->createElement("timestamp");	
	$IMGtimestamp->appendChild($xml->createTextNode(time()));
	
	$image->appendChild($IMGname);
	$image->appendChild($IMGdescription);
	$image->appendChild($IMGtimestamp);
	$bar = $xml->documentElement->firstChild;

	 $racine->insertBefore($image, $racine->firstChild); 

//	$xml->documentElement->appendChild($image);
	$chaineXML=$xml->saveXML();
	

	echo $chaineXML;
//	print_r($xml);
	$xml->save("imagesXML.xml");


}


return TRUE;
}

function getImgInfo($id)
{
	$info=Array();
	$img_id=intval($id);
	$xml = simplexml_load_file("imagesXML.xml");
	$info['name']=$xml->image[$img_id]->name;
	$info['description']=$xml->image[$img_id]->description;
	$info['timestamp']=$xml->image[$img_id]->timestamp;

	return $info;
}
function deleteImgXML($id)
{

	$img_id=intval($id);

		$xdoc = new DOMDocument();
	$xdoc->load('imagesXML.xml');
	$documentElement = $xdoc->documentElement;
	$item0 = $xdoc->getElementsByTagName("image")->item($img_id);
	
	$documentElement->removeChild($item0);
	$xdoc->save("imagesXML.xml");

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


function deleteImg($img_id)
{
$path=getImgPath();
unlink($path[$img_id]);
return 0;
}

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
	

