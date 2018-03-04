<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 27/02/2018
 * Time: 16:52
 */

/*  Protection de fichier */
if ( count( get_included_files() ) == 1) die( '--access denied--' );

function gereRequete($rq){
    switch($rq){
        case 'sem03':
            return "Cette fois, je te reconnais (" . $rq .")";
        case 'sem04':
            return "Requête «". $rq ."» : Le TP03 est disponible sur le serveur !";
        default:
            //return "Je ne connais pas ce genre de metier (" . $rq . "), aller voir à coté";
            require_once ("/RES/appelAjax.php");
            return  RES_appelAjax($rq, $action);
    }
}
