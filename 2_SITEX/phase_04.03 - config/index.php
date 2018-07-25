<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

session_start();
if(!isset($_SESSION['start'])){
    $_SESSION['start'] = date('YmdHis');
    $_SESSION['log'] = [];
}

require_once "/ALL/kint/kint.php";
Kint::$return = true;
require_once "INC/dbConnect.inc.php";
require_once "INC/mesFonctions.inc.php";
require_once "INC/config.inc.php";

if(isset($_GET['rq'])){
    $_SESSION['log'][time()] = $_GET['rq'];
    $toSend = [];
    require_once "INC/request.inc.php";
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
} else {
    $_SESSION['log'][time()] = 'reset F5';
}

$home = 'Accueil';
$siteName = 'SITEX : phase 04 : config';
$logoPath = 'IMG/04.png';
$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';
require_once "INC/layout.html.inc.php";