<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 27/02/2018
 * Time: 16:52
 */

require_once "mesFonctions.inc.php";
require_once "db.inc.php";
require_once "droits.inc.php";

/*  Protection de fichier */
if ( count( get_included_files() ) == 1) die( '--access denied--' );

/* ----------------------------------- AUTRES ---------------------------------- */
function chargeTemplate($name = 'yololo'){
    $name = 'INC/template.' . strtolower($name) . '.inc.php';
    return file_exists($name) ? implode("\n", file($name)) : false;
}

function tpSem05(){
    require_once "/RES/appelAjax.php";
    toSend(chargeTemplate('tpsem05'),'formTP05');
    toSend(RES_appelAjax('allGroups'),'data');
}

function callResAjax($rq){
    global $toSend;
    require_once "/RES/appelAjax.php";
    $toSend = array_merge($toSend,(Array)json_decode(RES_appelAjax($rq, 'action')));
    // array-merge pour éviter d'écraser (=) le contenu de $toSend
}

function sendMakeTable($tab){
    global $toSend;
    $toSend['makeTable'] = $tab;
}

/* ------------------------------ AFFICHAGE ASIDE ------------------------------ */
function toSend($txt,$action = 'display'){
    global $toSend;
    if (!isset($toSend[$action])) $toSend[$action] = '';
    $toSend[$action] .= $txt;
}

/* Remplacables par fct toSend mais on garde */

function display($txt){
    global $toSend;
    if (!isset($toSend['display'])) $toSend['display'] = '';
    $toSend['display'] .= $txt;
}

function error($txt){
    global $toSend;
    if (!isset($toSend['error'])) $toSend['error'] = '';
    $toSend['error'] .= $txt;
}

function debug($txt){
    global $toSend;
    if (!isset($toSend['debug'])) $toSend['debug'] = '';
    $toSend['debug'] .= $txt;
}

function kint($txt){
    global $toSend;
    if (!isset($toSend['kint'])) $toSend['kint'] = '';
    $toSend['kint'] .= $txt;
}

/* ------------------------------ GESTION DES CAS ------------------------------ */

function gereSubmit(){
    if(!isset($_POST['senderId'])) $_REQUEST['senderId'] = '';
    switch($_POST['senderId']){
        //case nom/id du formulaire
        case 'formTP05':
            //$_REQUEST['sender']='repéré';
            require_once "/RES/appelAjax.php";
            toSend('#tp05result p','cacher');
            toSend('#tp05result div', 'destination');
            sendMakeTable(RES_appelAjax('coursGroup'));
            break;
        case 'modifConfig':
            $iCfg = new Config('INC/config.ini.php');
            $iCfg->load();
            $iCfg->save();
            //debug($iCfg->save()); // c'est rassurant d'avoir cette confirmation haha
            if ($iCfg->getSaveError() == 0) {
                $_SESSION['config'] = $iCfg->getConfig();
                $_SESSION['loadTime'] = time();
                toSend(json_encode(['titre' => $_SESSION['config']['SITE']['titre'], 'logoPath' => $_SESSION['config']['SITE']['images'] . '/' . $_SESSION['config']['LOGO']['logo'] . '?' . rand(0, 100)]), 'layout');
            }
            break;
        case 'formLogin':
            // testez si vous avez un retour
            // S'il n'y en a pas, retournez en debug un message adéquat
            // testez si ce n'est pas une __ERReur__
            // Si c'est le cas envoyez là en error
            // Si le résultat n'est dans aucun des cas précédent, envoyez le en kint(d())
            $iDB = new Db();
            $user = $iDB->call('whoIs', array_values($_POST['login']));
            if ($user)  if (isset($user['__ERR__'])) error($user['__ERR__']);
                        else authentication($user[0], $iDB);
            else debug('Pseudo et/ou mot de passe incorret(s) !');
            break;
        default:
            error('<dl><dt>Error in <b>' . __FUNCTION__ . '()</b></dt><dt>'. monPrint_r(["_REQUEST" => $_REQUEST, "_FILES" => $_FILES]) .'</dt></dl>');
            break;
    }
}

function gereRequete($rq){
    //kint(d($rq));
    switch($rq){
        case 'sem03': display("Cette fois, je te reconnais( $rq )"); break;
        case 'sem04': display("Requête « $rq » : Le TP03 est disponible sur le serveur !"); break;
        case 'TPsem05': tpSem05(); break;
        case 'formSubmit': gereSubmit(); break;
        case 'displaySession':
            $_SESSION['log'][time()] = $rq;
            //debug(d($_SESSION));
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            break;
        case 'clearLog':
            //unset($_SESSION['log']);
            $_SESSION['log'] = [];
            $_SESSION['log'][time()] = $rq;
            //debug(d($_SESSION));
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            break;
        case 'resetSession':
            session_unset();
            $_SESSION['start'] = date('YmdHis');
            $_SESSION['log'][time()] = $rq;
            debug(d($_SESSION));
            break;
        case 'config':
            $iConfig = new Config('INC/config.ini.php');
            //debug("Le nom du fichier est : " .$iConfig->getFilename() . d($iConfig->isFileExist()));
            $iConfig->load();
            $cfg = $iConfig->getForm();
            toSend($cfg,"formConfig");
            break;
//        case 'gestLog': $f = 'kLog' . (isset($_SESSION['user']) ? 'out': 'in'); $f(); break;
//        case 'gestLog': kLogin(); break;
        case 'gestLog': $f = 'kLog' . (isAuthenticated() ? 'out': 'in'); $f(); break;
        case 'testDB':
            $iDB = new Db;
            debug($iDB->getException());
            //kint(d($iDB->call_v1()));
            //kint(d($iDB->call('mc_allGroups')));
            //kint(d($iDB->call('mc_group',['2TL'])));
            //kint(d($iDB->call('mc_coursesGroup',['2TL'])));
            kint(d($iDB->call('whoIs', ['ano', 'anonyme'])));
            kint(d($iDB->call('userProfil', [$_SESSION['user']['id']])));
            break;
        default:
            callResAjax($rq);
            //kint('requête inconnue ('.$rq.') transférée à callResAjax()');
    }
}

/* ----------------------------- AUTHENTIFICATION ------------------------------ */

function kLogin(){
    $res = chargeTemplate('login');
    if($res) { toSend($res,'formLogin');}
    else error("error kLogin");
}

function kLogout() {
    toSend('Au revoir <b>' . $_SESSION['user']['pseudo'] . '</b> !', 'logout');
    unset($_SESSION['user']);
}

/**
 *
 * Memorisez en SESSION le [user]
 * Récupérez en DB son profil
 * et mémorisez le en SESSION dans [user][profil]
 * retournez un kint(d()) de ce que vous avez mémorisé sur ce user
 * @param $user
 */

function authentication($user) {
    $iDB = new Db();
    $profil = $iDB->call('userProfil', [$user['id']]); // le 'id' selon la routine userprofil

    $isActiv = false;
    foreach ($profil as $p) if ($p['pAbrev'] == 'acti') $isActiv = true;
    if ($isActiv) {
        toSend('Vous devez activer votre compte (Cfr. email envoyé)', 'peutPas');
        return -1;
    }

    $_SESSION['user'] = $user;
    $_SESSION['user']['profil'] = $profil;
    //toSend(d($profil), 'kint');
    toSend((json_encode(d($_SESSION['user']))), 'userConnu');

    creeDroits();
    if (isReactiv()) {
        toSend('Vous n\'avez pas encore validé votre nouveau mail (Cfr. mail de confirmation envoyé à la nouvelle adresse mail)', 'peutPas');
        toSend('<div id="enReact">Vous devez valider votre nouveau mail (Cfr. mail de confirmation)</div>', 'estRéac');
    }
    if (isMdpp()) {
        toSend('Vous aviez demandé un changement de mot de passe mais manifestement vous avez retrouvé votre mot de passe. Nous annulons votre demande', 'peutPas');
    }
    toSend(creeMenu(), 'newMenu');

}

/* ----------------------------- GESTION DE DROITS ------------------------------ */

/**
 * Fonction peutPas détermine si un utilisateur a le droit d'éffectuer une action
 * Renvoie false si l'utilisateur à le droit, renvoie true si l'utilisateur ne peut pas.
 * @param $req
 * @return bool
 */
function peutPas($req) {
    if ($req == 'formSubmit' && isset($_POST['senderId'])) {
        $req = $_POST['senderId'];
    }
    $peutPas = !in_array($req, $_SESSION['droits']);
    $msg = 'Droits Insuffisants !';
    if ($peutPas) {
        if (isReactiv()) {
            if (isset($_SESSION['user']['droitsPerdus'])) {
                if (in_array($req, $_SESSION['user']['droitsPerdus'])) {
                    if (isSousAdmin()) {
                        $msg = 'Valider votre nouveau mail (Cfr. mail envoyé) pour ne plus voir ce message';
                        $peutPas = false;
                    } else {
                        $msg = 'Valider votre nouveau mail (Cfr. mail envoyé) pour récupérer ce droit';
                    }
                }
            } else {
                $msg = 'Droits Insuffisants !';
            }
        }
        toSend($msg, 'peutPas');
    }
    return $peutPas;
}