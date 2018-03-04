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
        default:
            return "Je ne connais pas ce genre de metier (" . $rq . "), aller voir à coté";
    }
}

// echo gereRequete('yolo');