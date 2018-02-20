<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
include ("INC/dbConnect.inc.php");
$home = 'Accueil';
$siteName = 'Nom de mon site';
$logoPath = 'IMG/04.png';
$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';
include ("INC/layout.html.inc.php");