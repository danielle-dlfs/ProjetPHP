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

function gereRequete($rq){
    require_once "/RES/appelAjax.php";
    global $toSend;
    switch($rq){
        case 'sem03':
            display("Cette fois, je te reconnais( $rq )");
            break;
        case 'sem04':
            display("Requête « $rq » : Le TP03 est disponible sur le serveur !");
            break;
        case 'TPsem05':
            toSend(chargeTemplate('tpsem05'),'formTP05');
            toSend(RES_appelAjax('allGroups'),'data');
            break;
        case 'formSubmit':
            debug(monPrint_r($_REQUEST));
            break;
        default:
            $toSend = json_decode(RES_appelAjax($rq, 'action'));
    }
}