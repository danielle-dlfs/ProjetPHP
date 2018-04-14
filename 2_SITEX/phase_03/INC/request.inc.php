<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 27/02/2018
 * Time: 16:52
 */

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

function gereRequete($rq){
    global $toSend;
    switch($rq){
        case 'sem03':
            display("Cette fois, je te reconnais( $rq )");
            break;
        case 'sem04':
            display("Requête « $rq » : Le TP03 est disponible sur le serveur !");
            break;
        case 'TPsem05':
            $res = chargeTemplate($rq);
            if('tpsem05') display($res);
            else error("Template non trouvé" . $res);
            break;
        default:
            require_once "/RES/appelAjax.php";
            $toSend = json_decode(RES_appelAjax($rq, 'action'));
    }
}

