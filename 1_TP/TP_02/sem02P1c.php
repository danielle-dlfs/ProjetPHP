<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 19/02/2018
 * Time: 17:23
 */

echo ("type de protocole utilisé : ".$_SERVER['SERVER_PROTOCOL']."</br>");
echo ("dns du serveur : " . $_SERVER['SERVER_NAME']."</br>");
echo ("port du serveur : ".$_SERVER['SERVER_PORT']."</br>");
/*$pathServer = pathinfo();
echo ("chemin permettant d'aller de la racine du serveur à votre script : ". $pathServer."</br>");*/
$pathParts = pathinfo('/TP/2T/tp1718_sem02.php');
print_r($pathParts);
echo("<br>");
echo ("nom de votre script : ".$pathParts['basename']."</br>");
