<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 21-05-18
 * Time: 19:36
 */

function monPrint_r($liste){
    $out = '<pre>';
    $out .= print_r($liste, true);
    $out .= '</pre>';
    return $out;
}

function chargeConfig($filename){
    // mettre a true : on obtient un tableau multidimensionnel avec les noms des sections
    return parse_ini_file($filename,true);
}

function afficheConfig($config){
    //$out = monPrint_r($config);

    function gereBloc($blocName,$blocContenu){
        //CONFIG V2
        $oKey = ['min', 'max', 'pas']; // options du bloc
        foreach($oKey as $key){
            // memorisation dans une variable éponyme $... ['min'] est mémorisé dans $min
            // variable dynamique
            $$key = isset($blocContenu[$key]) ? $blocContenu[$key] : null; // memorisation
            unset($blocContenu[$key]); // on supprime
        }

        // CONFIG V1
        $out = [];
        //$out[] = monPrint_r($blocContenu);
        foreach($blocContenu as $k => $v){
            // SITE = $blocName || titre = $k || value = $v
            $out[] = "\t<label for='" . $blocName . "_" . $k . "'>" . $k . "</label>";
            switch($k){
                case 'taille' :
                    $options = ($min !== null ? " min=$min" : "") .
                        ($max !== null ? " max=$max" : "") .
                        ($pas !== null ? " pas=$pas" : "");
                    $options = str_replace(" pas=", " step=", $options) . " title='$options' ";
                    $out[] = "\t<input type='number' id='" . $blocName . "_" . $k ."' name='" .
                        $blocName . "[" . $k . "]' " . "value='" . $v . "' ". $options . " required><br>";
                    break;
                case 'comment':
                    $out[] = "\t<textarea cols='50' readonly disabled required>". $v ."</textarea><br>";
                    break;
                default :
                    $out[] = "\t<input type='text' id='" . $blocName . "_" . $k ."' name='" .
                        $blocName . "[" . $k . "]' " . "value='" . $v . "' required><br>";
                    break;
            }
        }
        return $out;
    }

    // Création du formulaire
    $out = [];
    $out[] = "<form id='modifConfig' name='modifConfig' method='post'>";

    foreach($config as $key => $value){
        $out[] = "<fieldset><legend>$key</legend>";
        $out = array_merge($out,gereBloc($key,$value));
        $out[]= "</fieldset>";
    }

    $out[] = "<input type='submit' name='envoie' value='Envoyer' action=''>";
    $out[] = "</form>";
    return implode("\n", $out);
}