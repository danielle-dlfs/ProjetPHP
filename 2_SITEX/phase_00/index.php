<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
$home = 'Accueil';
$siteName = 'Nom de mon site';
$logoPath = 'IMG/04.png';
$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
include ("INC/dbConnect.inc.php");
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom'];
include ("INC/layout.html.inc.php");