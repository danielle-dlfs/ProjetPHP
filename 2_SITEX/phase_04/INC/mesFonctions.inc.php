<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

/*  Protection de fichier */
if ( count( get_included_files() ) == 1) die( '--access denied--' );

function monPrint_r($liste){
    $out = '<pre>';
    $out .= print_r($liste, true);
    $out .= '</pre>';
    return $out;
}