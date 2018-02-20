<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 19/02/2018
 * Time: 17:21
 */

echo ("type de protocole utilisé : ".$_SERVER['SERVER_PROTOCOL']."</br>");
echo ("dns du serveur : " . $_SERVER['REMOTE_HOST']."</br>");
echo ("port du serveur : ".$_SERVER['SERVER_PORT']."</br>");
echo ("chemin permettant d'aller de la racine du serveur à votre script : ".$_SERVER['PHP_SELF']."</br>");
echo ("nom de votre script : ".$_SERVER['SCRIPT_FILENAME']."</br>");
