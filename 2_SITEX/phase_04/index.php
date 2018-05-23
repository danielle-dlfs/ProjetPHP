<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

session_start();
if(!isset($_SESSION['start'])) {
    $_SESSION['start'] = date('YmdHis');
    $_SESSION['log'] = [];
}

require_once "INC/dbConnect.inc.php";
require_once "/ALL/kint/kint.php";
Kint::$return = true;
// imposer aux méthodes de la class Kint d'envoyer leur résultat par un return à la place d'un echo.
require_once "INC/config.inc.php";

if (!isset($_SESSION['config'])) {
    $iCfg = new Config('INC/config.ini.php');
    $_SESSION['config'] = $iCfg->load();
    $_SESSION['loadTime'] = time();
}

if(isset($_GET['rq'])){
    $_SESSION['log'][time()] = $_GET['rq'];
    $toSend = [];
    require_once "INC/request.inc.php";
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
} else {
    $_SESSION['log'][time()] = 'reset F5';
}

$site = &$_SESSION['config']['SITE']; // &  cfr 3.6.3
$logo = &$_SESSION['config']['LOGO']; // &  cfr 3.6.3

$home = 'Accueil';
$siteName = $site['titre'];
$logoPath = $site['images'] . '/' . $logo['logo'] ;
$logoAlt = 'logo';
$mainZone = 'Bienvenue';
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';

require_once "INC/layout.html.inc.php";