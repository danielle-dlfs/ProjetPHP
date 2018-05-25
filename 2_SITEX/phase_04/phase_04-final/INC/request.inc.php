<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 24/02/18
 * Time: 17:16
 */

if (count(get_included_files()) == 1) die("--access denied--");

require_once 'mesFonctions.inc.php';
require_once 'db.inc.php';

/* ---------- GESTION DE REQUETES ---------- */

/**
 * Cette fonction gère tous les différents formulaires du site
 * Tous les formulaires pointent vers cette fonction
 */
function gereSubmit() {
    if (!isset($_POST['senderId'])) $_POST['senderId'] = '';
    switch ($_POST['senderId']) {
        case 'formTP05':
            require_once '/RES/appelAjax.php';
            toSend('#tp05result div', 'destination');
            toSend('#tp05result p', 'cacher');
            sendMakeTable(RES_appelAjax('coursGroup'));
            break;
        case 'modifConfig':
            $iCfg = new Config('INC/config.ini.php');
            $iCfg->load();
            $iCfg->save();
            if ($iCfg->getSaveError() == 0) {
                $_SESSION['config'] = $iCfg->getConfig();
                $_SESSION['loadTime'] = time();
                toSend(json_encode(['titre' => $_SESSION['config']['SITE']['titre'], 'logoPath' => $_SESSION['config']['SITE']['images'] . '/' . $_SESSION['config']['LOGO']['logo'] . '?' . rand(0, 100)]), 'layout');
            }
            break;
        case 'formLogin':
            $iDB = new Db();
            $user = $iDB->call('whoIs', array_values($_POST['login']));
            if ($user) if (isset($user['__ERR__'])) error($user['__ERR__']);
            else authentication($user[0]);
            else debug('Pseudo et/ou mot de passe incorret(s) !');
            break;
        default:
            error('<dl><dt>Error in <b>' . __FUNCTION__ . '()</b></dt><dt>'. monPrint_r(["_REQUEST" => $_REQUEST, "_FILES" => $_FILES]) .'</dt></dl>');
            break;
    }

}

/**
 * Fonction gereRequete: toutes les requètes venant du JS passe par ici
 * La fonction retourne -1 si l'utilisateur n'as pas le droit d'éffectuer une action
 * @param $rq
 * @return int
 */
function gereRequete($rq) {
    if (peutPas($rq)) return -1;

    switch ($rq) {
        case 'sem04': toSend('Cette fois je te reconnais (' . $rq . ')', 'display'); break;
        case 'sem03': toSend('Requête « ' . $rq . ' » : le TP03 est disponnible sur le serveur !', 'display'); break;
        case 'TPsem05': tpSem05(); break;
        case 'gestLog': $f = 'kLog' . (isAuthenticated() ? 'out': 'in'); $f(); break;
        case 'formSubmit': gereSubmit(); break;
        case 'displaySession':
            $_SESSION['log'][time()] = $rq;
            //debug(d($_SESSION));
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            break;
        case 'clearLog':
            $_SESSION['log'] = [];
            $_SESSION['log'][time()] = $rq;
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            break;
        case 'resetSession':
            session_unset();
            $_SESSION['start'] = date('YmdHis');
            $_SESSION['log'][time()] = $rq;
            debug(d($_SESSION['start']));
            debug(d($_SESSION['log']));
            break;
        case 'config':
            $iConfig = new Config('INC/config.ini.php');
            $iConfig->load();
            toSend($iConfig->getForm(), "formConfig");
            break;
        case 'testDB':
            $iDB = new Db();
            debug($iDB->getException());
            kint(d($iDB->call('whoIs', ['ano', 'anonyme'])));
            kint(d($iDB->call('userProfil', [8])));
            break;
        default:
            callResAjax($rq);
            //kint('requête inconnue (' . $rq . ') transférée à callResAjax()');
            break;

    }
}

/* ---------- GESTION DE DROITS ---------- */

/**
 * Fonction peutPas détermine si un utilisateur à le droit d'éffectuer une action
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

/* ---------- AUTHENTIFICATION ---------- */

/**
 * Cette fonction se charge de l'affichage du formulaire de login
 * La fonction charge le template du formulaire
 * et l'envoie dans un retour "formLogin"
 */
function kLogin() {
    $res = chargeTemplate('login');
    if ($res) toSend($res, 'formLogin');
    else error('Erreur de chargement du template');
}

/**
 * Cette fonction se charge de déconnecter l'utilisateur
 * La fonction supprime les données de l'utilisateur dans la session
 * et envoie un retour "logout" qui affiche une boite de dialogue qui confirme le logout de l'utilisateur
 */
function kLogout() {
    toSend('Au revoir <b>' . $_SESSION['user']['uPseudo'] . '</b> !', 'logout');
    unset($_SESSION['user']);
    toSend(creeMenu(), 'newMenu');
}

/**
 * Cette fonction se charge de l'authentification de l'utilisateur
 * La fonction reçoit un utilisateur en paramètre
 * Récupère les profils de l'utilisateur
 * Stocke les données de l'utilisateur dans la session
 * Crée les droits de l'utilisateur
 * @param $user
 * @return int
 */
function authentication($user) {
    $iDB = new Db();
    $profil = $iDB->call('userProfil', [$user['uid']]);
    $isActiv = false;
    foreach ($profil as $p) if ($p['pAbrev'] == 'acti') $isActiv = true;
    if ($isActiv) {
        toSend('Vous devez activer votre compte (Cfr. email envoyé)', 'peutPas');
        return -1;
    }

    $_SESSION['user'] = $user;
    $_SESSION['user']['profile'] = $profil;
    toSend(json_encode($_SESSION['user']), 'userConnu');
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

/* ---------- UTILS ---------- */

/**
 * Envoie un array à l'action JS makeTable
 * @param $tab
 */
function sendMakeTable($tab) {
    global $toSend;
    if (!isset($toSend['makeTable'])) $toSend['makeTable'] = "";
    $toSend['makeTable'] = $tab;
}

/**
 * Appelle la fonction ajax mise à dispo dans les ressources de Delvigne
 * @param $rq
 */
function callResAjax($rq) {
    require_once '/RES/appelAjax.php';
    global $toSend;
    $toSend = array_merge($toSend, (Array) json_decode(RES_appelAjax($rq, 'action')));
}

/**
 * Charge le fichier de template dont le nom est passé en paramètre
 * Le fichier doit se trouver dans le dossier INC/ et avoir un nom commencant par "template." et se terminant par ".inc.php"
 * La fonction renvoie false si le fichier n'existe pas
 * @param string $name
 * @return bool|string
 */
function chargeTemplate($name = 'yololo') {
    $name = 'INC/template.' . strtolower($name) . '.inc.php';
    return file_exists($name) ? implode("\n", file($name)) : false;
}

/**
 * Dans cette fonction se trouvent tous les envois nécessaires au fonctionnement du formulaire du tp5
 * La fonction charge le template du formulaire tp5
 * La fonction fait un appel à la procédure allGroups et renvoie les données dans un retour "data".
 * Ces 'data' servent à remplir le sélecteur de groupes
 */
function tpSem05() {
    require_once '/RES/appelAjax.php';
    toSend(chargeTemplate('tpsem05'), 'formTP05');
    toSend(RES_appelAjax('allGroups'),'data');
}