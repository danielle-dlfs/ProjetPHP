<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 27/02/2018
 * Time: 16:52
 */

require_once "mesFonctions.inc.php";
require_once "db.inc.php";
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

/* Remplacable par fct toSend mais on garde */

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

function display($txt){
    global $toSend;
    if (!isset($toSend['display'])) $toSend['display'] = '';
    $toSend['display'] .= $txt;
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
            kint(d($_POST));
            break;
        case 'formLogin':
            $iDb = new Db();
            // ==> ramener l'utilisateur correspondant au login-mdp transmis
            $user = $iDb->call("whoIs",$_POST['login']);

            // testez si vous avez un retour
            // S'il n'y en a pas, retournez en debug un message adéquat
            // testez si ce n'est pas une __ERReur__
            // Si c'est le cas envoyez là en error
            // Si le résultat n'est dans aucun des cas précédent, envoyez le en kint(d())
            if($user) if(isset($user['__ERR__'])) error($user['__ERR__']);
                    else authentification($user); // si ce n'est pas une erreur
            else debug("Pseudo et/ou mot de passe incorrect(s) !");

            break;
        default:
            error('<dl><dt>Error in <b>' . __FUNCTION__ . '()</b></dt><dt>'. monPrint_r(["_REQUEST" => $_REQUEST, "_FILES" => $_FILES]) .'</dt></dl>');
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
            debug(d($_SESSION));
            break;
        case 'clearLog':
//            unset($_SESSION['log']);
            $_SESSION['log'] = [];
            $_SESSION['log'][time()] = $rq;
            debug(d($_SESSION));
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
        case 'gestLog':
            kLogin();
            break;
        case 'testDB':
            $iDB = new Db;
            debug($iDB->getException());
            //kint(d($iDB->call_v1()));
            //kint(d($iDB->call('mc_allGroups')));
            //kint(d($iDB->call('mc_group',['2TL'])));
            //kint(d($iDB->call('mc_coursesGroup',['2TL'])));
            kint(d($iDB->call('whoIs', ['ano', 'anonyme'])));
            kint(d($iDB->call('userProfil', [8])));
            break;
        default:
            callResAjax($rq);
            kint('requête inconnue ('.$rq.') transférée à callResAjax()');
    }
}

/* ----------------------------- AUTHENTIFICATION ------------------------------ */

function kLogin(){
    $res = chargeTemplate('login');
    if($res) { toSend($res,'formConfig');}
    else error("blabla error kLogin");
}

/**
 *
 * Memorisez en SESSION le [user]
 * Récupérez en DB son profil
 * et mémorisez le en SESSION dans [user][profil]
 * retournez un kint(d()) de ce que vous avez mémorisé sur ce user
 * @param $user
 */
function authentification($user){
    $_SESSION['user'] = $user;
    $iDB = new Db();
    $profil = $iDB->call('userProfil', [$user['uId']]);
    // 0 car il correspond à ano
    $_SESSION['user']['profil'] = $profil;
//    toSend(json_encode($_SESSION['user']), 'userConnu');
    return kint(d($user));
}

