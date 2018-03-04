<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

if(isset($_GET['rq'])){
    require_once ("INC/request.inc.php");
    die(gereRequete($_GET['rq']));
}

require_once ("INC/dbConnect.inc.php");
$home = 'Accueil';
$siteName = 'Nom de mon site';
$logoPath = 'IMG/04.png';
$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';
require_once ("INC/layout.html.inc.php");