<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
// protection quand mon pwsd était en clair...
// if ( count( get_included_files() ) == 1) die( '--access denied--' );

function chargeConfig($filename){
    // mettre a true : on obtient un tableau multidimensionnel avec les noms des sections
    return parse_ini_file($filename,true);
}

function afficheConfig($config){

    function gereBloc($blocName, $tab){
        $out = [];
        foreach($tab as $item => $value){
            $out[] = '<label for="' . $blocName . '_' . $item . '">' . $item . '</label>';
            switch($item){
                case 'taille':
                    $out[] = '<input type=number id="' . $blocName . '_' . $item . '"
                        name="' . $blocName . '"['.$item.']
                        value="'. $value .'" required><br>';
                    break;
                case 'comment':
                    $out[] = '<textarea disabled>'. $value .'</textarea><br>';
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

