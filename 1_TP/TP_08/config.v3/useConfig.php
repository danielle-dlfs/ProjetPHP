<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
// if ( count( get_included_files() ) == 1) die( '--access denied--' );

function chargeConfig($filename){
    // mettre a true : on obtient un tableau multidimensionnel avec les noms des sections
    return parse_ini_file($filename,true);
}

function afficheConfig($config){

    function gereBloc($blocName, $tab){
        $oKey = ['min','max','pas'];
        foreach($oKey as $key){
            // memorisation dans une variable éponyme $... ['min'] est mémorisé dans $min
            // variable dynamique
            $$key = isset($tab[$key]) ? $tab[$key] : null; // mémorisation
            unset($tab[$key]); // suppression
        }
        $out = [];
        foreach($tab as $item => $value){
            $out[] = '<label for="' . $blocName . '_' . $item . '">' . $item . '</label>';
            switch($item){
                case 'taille':
                    $options = ($min !== null ?" min=$min":'')
                        .($max !== null ?" max=$max":'')
                        .($pas !== null ?" pas=$pas":'');
                    $options = str_replace(' pas=',' step=',$options).' title="'.$options.'"';
                    $out[] = "<input type='number' id='$blocName' name='$blocName' value='$value' $options><br>";
                    break;
                case 'comment':
                    $out[] = '<textarea disabled>'. $value .'</textarea><br>';
                    break;
                case 'type':
                    $out;
                    break;
                default:
                    $out[] = '<input type="text" id="' . $blocName . '_' . $item . '"
                        name="' . $blocName . '"['.$item.']
                        value="'. $value .'" required><br>';
            }
        }
        return $out;
    }

    $out = [];
    $out[] = "<form id='modifConfig' name='modifConfig' method='post' action=''>";

    foreach($config as $key => $value){
        $out[] = "<fieldset><legend>$key</legend>";
        $out = array_merge($out,gereBloc($key,$value));
        $out[] = "</fieldset>";
    }

    $out[] = "<input type='submit' value='Envoi'>";
    $out[] = "</form>";

    return implode("\n", $out);
}

$config = chargeConfig('config.ini');
echo afficheConfig($config);

