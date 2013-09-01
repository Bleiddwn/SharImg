<?php

include_once('model.php');
include_once('control.php');
include_once('./inc/header.php'); 
$img_url='./c/'.$_GET['c'].'/'.$_GET['name'];
echo '<div id="page">'.$_GET['name'].'</div><div id="main">';

list($width, $height, $type, $attr) = getimagesize($img_url);

$info=getImgInfobyName($_GET['name'], $_GET['c']);

echo '<strong>Nom : </strong>'.$_GET['name'].'<br/>';
echo '<strong>Description : </strong>'.$info['description'].'<br/><br/>';

getImgInfobyName('aa', $_GET['c']);

echo '<strong>Hauteur : </strong> '.$height.'px<br/>';
echo '<strong>Largeur : </strong> '.$width.'px<br/>';
echo '<strong>Poids : </strong> '.round(filesize($img_url)/1024.2,1).' Ko<br/><br/>';
echo '<center><img src="'.$img_url.'"/></center>';


echo '</div>';
echo '<div id="page">...</div>';

include_once('./inc/footer.php');
