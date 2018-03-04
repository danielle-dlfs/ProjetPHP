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
$pathParts = pathinfo($_SERVER["PHP_SELF"]);
echo '<pre>'.print_r($pathParts,1).'</pre></br>';
echo ("chemin accès : ". $pathParts['dirname']." </br>");
echo ("nom de votre script : ".$pathParts['basename']."</br>");
