<?php

function WriteXML($nom, $description,$cat)
{
$fileXML=new DomDocument('1.0');

	if($fileXML->load('./c/'.$cat.'/imagesXML.xml'))
	{
	$racine=$fileXML->documentElement;
	$image=$fileXML->createElement("image"); // On crée <image></image>
	
	$IMGname=$fileXML->createElement("name");	//On crée <name></name>
	$IMGname->appendChild($fileXML->createTextNode($nom));
	
	$IMGdescription=$fileXML->createElement("description");	
	$IMGdescription->appendChild($fileXML->createTextNode($description));
	
	$IMGtimestamp=$fileXML->createElement("timestamp");	
	$IMGtimestamp->appendChild($fileXML->createTextNode(time()));
	
	$image->appendChild($IMGname);
	$image->appendChild($IMGdescription);
	$image->appendChild($IMGtimestamp);
	$bar = $fileXML->documentElement->firstChild;

	$racine->insertBefore($image, $racine->firstChild); 

	$chaineXML=$fileXML->saveXML();
	$fileXML->save('./c/'.$cat.'/imagesXML.xml');
	}
	
return TRUE;
}

function deleteImgFromXML($imgID,$cat)
{

	$fileXML = new DOMDocument();
	$fileXML->load('./c/'.$cat.'/imagesXML.xml');
	$documentElement = $fileXML->documentElement;
	$image = $fileXML->getElementsByTagName("image")->item(intval($imgID));
	
	$documentElement->removeChild($image);
	$fileXML->save('./c/'.$cat.'/imagesXML.xml');

}

function getImgInfobyID($id, $cat)
{
	$info=Array();
	
	if(!($fileXML = simplexml_load_file('./c/'.$cat.'/imagesXML.xml')))
		return 0;
		
	$info['name']=$fileXML->image[intval($id)]->name;
	$info['description']=$fileXML->image[intval($id)]->description;
	$info['timestamp']=$fileXML->image[intval($id)]->timestamp;

	return $info;
}

function getImgInfobyName($name, $cat)
{
	$i=0;
	$fileXML = new DOMDocument();
	$fileXML->load('./c/'.$cat.'/imagesXML.xml');
	$listeNom=$fileXML->getElementsByTagName('name');
	
	foreach($listeNom as $imgName)
	{
		if($imgName->firstChild->nodeValue==$name)
		{
			return GetImgInfoByID($i,$cat);
		}
		$i++;
	}
	
		
}
	
