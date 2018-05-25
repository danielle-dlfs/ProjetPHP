<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 9/02/18
 * Time: 17:34
 */

// SESSION

session_start();
if (!isset($_SESSION['start'])) {
    $_SESSION['start'] = date('YmdHis');
    $_SESSION['log'] = [];
}

// Prerequired includes

require_once "INC/dbConnect.inc.php";
require_once "INC/mesFonctions.inc.php";
require_once "/ALL/kint/kint.php";
Kint::$return=true;
require_once "INC/config.inc.php";
require_once "INC/droits.inc.php";
require_once "INC/sender.inc.php";

if (!isset($_SESSION['config'])) {
    $iCfg = new Config('INC/config.ini.php');
    $_SESSION['config'] = $iCfg->load();
    $_SESSION['loadTime'] = time();
}

creeDroits();

if (isset($_GET['rq'])) {
    $_SESSION['log'][time()] = $_GET['rq'];
    require_once "INC/request.inc.php";
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
} else {
    $_SESSION['log'][time()] = 'resetF5';
}

// Variables initalisation

$site = &$_SESSION['config']['SITE'];
$logo = &$_SESSION['config']['LOGO'];

$title = 'Accueil';
$blogName = $site['titre'];
$logoPath = $site['images'] . '/' . $logo['logo'];
$logoAlt = 'logo';
$mainContent = 'Bienvenue';

$mail = ___MATRICULE___ . '@students.ephec.be';
$auteur = "<a href=mailto:$mail title=$mail>". $__INFOS__['nom'] ." ". $__INFOS__['prenom'] ."@2018</a>";

$gestLog = 'Connexion';
$style = '';

$bandeau = '';
if (isReactiv()) {
    $bandeau = '<div id="enReact">Vous devez valider votre nouveau mail (Cfr. mail de confirmation)</div>';
}

if (isAuthenticated()) {
    $gestLog = 'Déconnexion';
    $style = '#4C4F22';
    $mainContent = 'Page rafraichie: vous êtes toujours connecté ' . $_SESSION['user']['uPseudo'] . ' !';
}

require_once "INC/layout.html.inc.php";