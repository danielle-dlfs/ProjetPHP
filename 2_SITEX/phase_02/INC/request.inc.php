<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 27/02/2018
 * Time: 16:52
 */

/*  Protection de fichier */
if ( count( get_included_files() ) == 1) die( '--access denied--' );

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
        default:
            require_once "/RES/appelAjax.php";
            $toSend = json_decode(RES_appelAjax($rq, 'action'));
    }
}