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

function chargeTemplate($name = 'yololo'){
    $name = 'INC/template.' . strtolower($name) . '.inc.php';
    return file_exists($name) ? implode("\n", file($name)) : false;
}

function gereSubmit(){
    if(!isset($_POST['senderId'])) $_REQUEST['senderId'] = '';
    switch($_POST['senderId']){
        case 'formTP05':
            //$_REQUEST['sender']='repéré';
            require_once "/RES/appelAjax.php";
            toSend('#tp05result p','cacher');
            toSend('#tp05result div', 'destination');
            sendMakeTable(RES_appelAjax('coursGroup'));
            break;
        case 'modifConfig':
            //kint(d($_POST));
            $iCfg = new Config("INC/config.ini.php");
            $iCfg->load();
            debug($iCfg->save());
            if($iCfg->getSaveError() == 0){ // si sauvegarde effectuée
                $_SESSION['config'] = $iCfg->getConfig();
                $_SESSION['loadTime'] = time();
                $site = $_SESSION['config'];
                toSend(json_encode(['titre' => $site['SITE']['titre'], 'logoPath' => $site['SITE']['images'] . '/' . $_SESSION['config']['LOGO']['logo'] . '?' . rand(0, 100)]), 'layout');
            }
            break;
        case 'formLogin':
            // testez si vous avez un retour
            // S'il n'y en a pas, retournez en debug un message adéquat
            // testez si ce n'est pas une __ERReur__
            // Si c'est le cas envoyez là en error
            // Si le résultat n'est dans aucun des cas précédent, envoyez le en kint(d())
            $iDB = new Db();
            $user = $iDB->call('whoIs',array_values($_POST['login']));
            if($user) if(isset($user['__ERR__'])) error($user['__ERR__']);
            //else if (isActiv()) toSend('Vous devez activer votre compte (Cfr. email) pour pouvoir vous connecter !','peutPas');
            else authentification($user[0]);
            else debug('Pseudo et/ou mot de passe incorrect(s)');
            break;
        default:
            error('<dl><dt>Error in <b>' . __FUNCTION__ . '()</b></dt><dt>'. monPrint_r(["_REQUEST" => $_REQUEST, "_FILES" => $_FILES]) .'</dt></dl>');
    }
}

function tpSem05(){
    require_once "/RES/appelAjax.php";
    toSend(chargeTemplate('tpsem05'),'formTP05');
    toSend(RES_appelAjax('allGroups'),'data');
}

function callResAjax($rq){
    require_once "/RES/appelAjax.php";
    global $toSend;
    $toSend = array_merge($toSend,(Array)json_decode(RES_appelAjax($rq, 'action')));
    // array-merge pour éviter d'écraser (=) le contenu de $toSend
}

function sendMakeTable($tab){
    global $toSend;
    $toSend['makeTable'] = $tab;
}

function gereRequete($rq){
    if(peutPas($rq)) return -1;
    switch($rq){
        case 'sem03': display("Cette fois, je te reconnais( $rq )"); break;
        case 'sem04': display("Requête « $rq » : Le TP03 est disponible sur le serveur !"); break;
        case 'TPsem05': tpSem05(); break;
        case 'formSubmit': gereSubmit(); break;
        case 'displaySession': debug(d($_SESSION['start']));
                               debug(d($_SESSION['log']));
                               break;
        case 'clearLog': $_SESSION['log'] = []; // on réinitialise la var de session 'log'
                         $_SESSION['log'][time()] = $rq; // on recrée la var de session 'log'
                         debug(d($_SESSION));
                         break;
        case 'resetSession': session_unset();
                             $_SESSION['start'] = date('YmdHis');
                             $_SESSION['log'][time()] = $rq;
                             debug(d($_SESSION));
                             break;
        case 'config':  $iConfig = new Config('INC/config.ini.php');
                        $iConfig->load();
                        $cfg = $iConfig->getForm();
                        toSend($cfg,"formConfig");
                        break;
        //case 'gestLog': kLogin(); break;
        case 'gestLog': $f = 'kLog' . (isAuthenticated() ? 'out' : 'in'); $f(); break;
        case 'testDB': $iDB = new Db();
                        debug($iDB->getException());
                        kint(d($iDB->call_v1()));
                        //kint(d($iDB->call('mc_allGroups')));
                        //kint(d($iDB->call('mc_group',['2TL'])));
                        //kint(d($iDB->call('mc_coursesGroup',['2TL'])));
                        kint(d($iDB->call('whoIs',['ano','anonyme'])));
                        kint(d($iDB->call('userProfil',[8])));
                        break;
        default: callResAjax($rq);
                 //kint('requête inconnue ('.$rq.') transférée à callResAjax()');
    }
}

function kLogin(){
    $res = chargeTemplate("login");
    if($res) { toSend($res,'formLogin');}
    else error("Erreur de chargement du formulaire de connexion");
}

function kLogout(){
    toSend("Au revoir " . $_SESSION['user']['pseudo'], 'logout');
    unset($_SESSION['user']);
}

function authentification($user){
    $iDB = new Db();
    $profil = $iDB->call('userProfil', [$user['id']]);
    $isActiv = false;

    foreach ($profil as $p) {
        if ($p['pAbrev'] == 'acti') $isActiv = true;
    }
    kint(d($user,$profil,$isActiv));
    if ($isActiv) {
        toSend('Vous devez activer votre compte (Cfr. email envoyé)', 'peutPas');
        return -1;
    }

    $_SESSION['user'] = $user;
    $_SESSION['user']['profil'] = $profil;
    toSend(json_encode($_SESSION['user']),'userConnu');
    creeDroits();

    if(isReactiv()){
        toSend('Vous n\'avez pas encore validé votre nouveau mail (Cfr. mail de confirmation envoyé à la nouvelle adresse mail','peutPas');
        toSend('<div id="enReact">Vous devez valider votre nouveau mail (Cfr. mail de confirmation)</div>', 'estReact');
    }
}

function peutPas($rq){
    if ($rq == 'formSubmit' && isset($_POST['senderId'])) {
        $rq = $_POST['senderId'];
    }
    $peutPas = !in_array($rq,$_SESSION['droits']);
    $msg = 'Droits Insuffisants !';

    if($peutPas){
        if (isReactiv()) {
            if (isset($_SESSION['user']['droitsPerdus'])) {
                if (in_array($rq, $_SESSION['user']['droitsPerdus'])) {
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