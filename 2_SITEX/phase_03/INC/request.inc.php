<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 27/02/2018
 * Time: 16:52
 */

require_once "mesFonctions.inc.php";
/*  Protection de fichier */
if ( count( get_included_files() ) == 1) die( '--access denied--' );

function chargeTemplate($name = 'yololo'){
    $name = 'INC/template.' . strtolower($name) . '.inc.php';
    return file_exists($name) ? implode("\n", file($name)) : false;
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

function display($txt){
    global $toSend;
    if (!isset($toSend['display'])) $toSend['display'] = '';
    $toSend['display'] .= $txt;
}

function toSend($txt,$action = 'display'){
    global $toSend;
    if (!isset($toSend[$action])) $toSend[$action] = '';
    $toSend[$action] .= $txt;
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
    $toSend = json_decode(RES_appelAjax($rq, 'action'));
}

function sendMakeTable($tab){
    global $toSend;
    $toSend['makeTable'] = $tab;
}

function gereRequete($rq){
    switch($rq){
        case 'sem03': display("Cette fois, je te reconnais( $rq )"); break;
        case 'sem04': display("Requête « $rq » : Le TP03 est disponible sur le serveur !"); break;
        case 'TPsem05': tpSem05(); break;
        case 'formSubmit': gereSubmit(); break;
        default: callResAjax($rq);
    }
}