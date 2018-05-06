<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

function chargeConfig($filename){
    // mettre a true : on obtient un tableau multidimensionnel avec les noms des sections
    return parse_ini_file($filename,true);
}

function afficheConfig($config){
    require_once "mesFonctions.inc.php";

    function gereBloc($bloc, $tab){ // fonction interne a une autre
        $out = [];
        $out[] = monPrint_r();
        return $out;
    }

    $out = [];
    $out[] = "<form id='modifConfig' name='modifConfig' method='post' action=''>";
    foreach($config as $key => $value){
        //echo $key;
        $out[] .= "<fieldset><legend>$key</legend>";
        $out[] .= monPrint_r($value);
        $out[] .= "</fieldset>";
    }
    $out[] .= "<input type='submit' value='Envoi'>";
    $out[] .= "</form>";
    //return monPrint_r($config);
    return implode("\n", $out);
}

$config = chargeConfig('config.ini');
echo afficheConfig($config);

