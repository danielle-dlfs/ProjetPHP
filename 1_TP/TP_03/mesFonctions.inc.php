<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

function scriptInfos($param = 'new'){
    $paramLowCase = strtolower($param);

    switch($paramLowCase) {
        case 'new':
           /* static $tableau = [
                "protocol" => $_SERVER['SERVER_PROTOCOL'],
                "port" => $_SERVER['SERVER_PORT'],
                ];*/
            break;
        case 'Empty':
            echo 'Empty';
            break;
        case 'Protocol':
            echo $_SERVER['SERVER_PROTOCOL'];
            break;
        case 'Port':
            echo $_SERVER['SERVER_PORT'];
            break;
        case 'isPortDef':
            echo 'isPortDef';
            break;
        case 'dns':
            echo 'dns';
            break;
        case 'path':
            echo 'path';
            break;
        case 'name':
            echo 'name';
            break;
        case 'short':
            echo 'short';
            break;
        case 'ext':
            echo 'extension';
            break;
        case 'all':
            echo 'all';
            break;
        case 'full':
            echo 'full';
            break;
        case 'root':
            echo 'root';
            break;
    }
}

function creeTableau($uneListe, $titre, $index){

}

function monPrint_r($liste){
    $out = '<pre>';
    $out .= print_r($liste, true);
    $out .= '</pre>';
    return $out;
}

function getServeur(){
    if($_SERVER['SERVER_NAME'] == "devweb.ephec.be" || $_SERVER['SERVER_NAME'] == "193.190.65.92"){
        return 'localhost';
    } else {
        return '193.190.65.92';
    }
}