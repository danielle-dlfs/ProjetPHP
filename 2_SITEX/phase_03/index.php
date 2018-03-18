<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

if(isset($_GET['rq'])){
    require_once "INC/request.inc.php";
    $toSend = [];
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
}

require_once "INC/dbConnect.inc.php";
$home = 'Accueil';
$siteName = 'SITEX : phase 03 TPsem05';
$logoPath = 'IMG/04.png';
$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';
require_once "INC/layout.html.inc.php";