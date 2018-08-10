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
require_once "INC/droits.inc.php";
require_once "INC/sender.inc.php";

if(!isset($_SESSION['config'])){
    $iConfig = new Config("INC/config.ini.php");
    $_SESSION['config'] = $iConfig->load();
    $_SESSION['loadTime'] = time();
}

creeDroits();

if(isset($_GET['rq'])){
    $_SESSION['log'][time()] = $_GET['rq'];
    require_once "INC/request.inc.php";
    gereRequete($_GET['rq']);
    die(json_encode($toSend));
} else {
    $_SESSION['log'][time()] = 'reset F5';
}

$site = &$_SESSION['config']['SITE'];
$logo = &$_SESSION['config']['LOGO'];

$home = 'Accueil';
$siteName = $site['titre'];
$logoPath = $site['images'] . '/' . $logo['logo'];

$logoAlt = 'Logo';
$mainZone = 'Bienvenue';
$mail = ___MATRICULE___ . '@students.ephec.be';
$author = '<a href="mailto:' . $mail . '" title="'. $mail . '">' . $__INFOS__['nom'] . ' ' . $__INFOS__['prenom']. '</a>';

//$gestLog = "Connexion"; deplacé dans droits.inc.php
$style = "";

$bandeau = '';

if (isReactiv()) {
    $bandeau = '<div id="enReact">Vous devez valider votre nouveau mail (Cfr. mail de confirmation)</div>';
}


if (isAuthenticated()) {
    $gestLog = 'Deconnexion';
    $style = '#4C4F22';
    $mainZone = 'Page rafraichie: vous êtes toujours connecté ' . $_SESSION['user']['pseudo'] . ' !';
}

require_once "INC/layout.html.inc.php";