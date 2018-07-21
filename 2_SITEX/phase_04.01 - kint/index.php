<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

if(isset($_GET['rq'])){
    $toSend = [];
    require_once "/ALL/kint/kint.php";
    Kint::$return = true;
    require_once "INC/request.inc.php";
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
}

require_once "INC/dbConnect.inc.php";
$home = 'Accueil';
$siteName = 'SITEX : phase 04 : kint';
$logoPath = 'IMG/04.png';
$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';
require_once "INC/layout.html.inc.php";