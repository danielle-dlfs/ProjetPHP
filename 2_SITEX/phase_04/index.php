<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

session_start();
if(!isset($_SESSION['start'])) $_SESSION['start'] = date('amjhms');
$_SESSION['log'] = [];

if(isset($_GET['rq'])){
    $toSend = [];

    require_once "/ALL/kint/kint.php";
    Kint::$return = true;
    // imposer aux méthodes de la class Kint d'envoyer leur résultat par un return à la place d'un echo.
    require_once "INC/request.inc.php";
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
}

require_once "INC/dbConnect.inc.php";
require_once "INC/mesFonctions.inc.php";

$home = 'Accueil';
$siteName = 'SITEX : phase 04';
$logoPath = 'IMG/04.png';
$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
$mainZone .= ' kint est la';

$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';
require_once "INC/layout.html.inc.php";