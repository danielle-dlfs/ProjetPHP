<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

require_once "../../TP_03/mesFonctions.inc.php";

if (isset($_POST)) {
    if (!empty($_POST)) {
        unset($_POST['submit']);
        $out = [];
        /*
        echo '<pre>' . print_r(chargeConfig("config.ini.php"), 1) . '</pre>';
        echo '<hr>';
        echo '<pre>' . print_r($_POST, 1) . '</pre>';
        */
        $oldConfig = chargeConfig('config.ini.php');

        foreach ($oldConfig as $key => $value) {
            foreach ($value as $k => $v) {
                if (gettype($v) == 'array') $oldConfig[$key][$k] = [];
            }
        }

        foreach (array_replace_recursive($oldConfig, $_POST) as $k => $v) {
            $out[] = '[' . $k . ']';
            foreach ($v as $item => $value) {
                switch (gettype($value)) {
                    case 'array':
                        foreach ($value as $elem) {
                            $out[] = $item . '[] = "' . $elem . '"';
                        }
                        break;
                    default:
                        $out[] = $item . ' = "' . $value . '"';
                        break;
                }
            }
            $out[] = "\n";
        }
        file_put_contents('config.ini.php', implode("\n\r", $out));
    }
}

echo afficheConfig(chargeConfig('config.ini.php'));

// Fonctions

function chargeConfig($filename){
    // mettre a true : on obtient un tableau multidimensionnel avec les noms des sections
    return parse_ini_file($filename,true);
}

function afficheConfig($config){

    function gereBloc($blocName, $tab){

        $oKey = ['min','max','pas', 'choix'];
        foreach($oKey as $key){
            // memorisation dans une variable éponyme $... ['min'] est mémorisé dans $min
            // variable dynamique
            $$key = isset($tab[$key]) ? $tab[$key] : null; // mémorisation
            unset($tab[$key]); // suppression
        }

        $out = [];
        foreach($tab as $item => $value) {
            $out[] = '<label for="' . $blocName . '_' . $item . '">' . $item . '</label>';
            switch ($item) {
                case 'taille':
                    $options = ($min !== null ? " min=$min" : '')
                        . ($max !== null ? " max=$max" : '')
                        . ($pas !== null ? " pas=$pas" : '');
                    $options = str_replace(' pas=', ' step=', $options) . ' title="' . $options . '"';
                    $out[] = "<input type='number' id='$blocName' name='$blocName' value='$value' $options><br>";
                    break;
                case 'comment':
                    $out[] = '<textarea disabled>' . $value . '</textarea><br>';
                    break;
                case 'type':
                    $out[] = '<span id="' . $blocName . '_' . $item . '" class="checkList">';
                    foreach(explode('|',$value) as $type){
                        $out[] = '<input type="checkbox" id="' . $blocName . '_' . $item . '_' . $type . '" ';
                        $out[] = 'name="' . $blocName . '[choix][] "';
                        $isChecked = (in_array($type,$choix) ? 'checked' : '');
                        $out[] = 'value="'. $type .'" '. $isChecked . ' >';
                        $out[] = '<label for=' . $blocName . '_' . $item . '_' . $type . '">' . $type . '</label>';
                    }

                    $out[] = '</span><br>';
                    break;
                default:
                    $out[] = '<input type="text" id="' . $blocName . '_' . $item . ' ';
                    $out[] = ' "name="' . $blocName . '[' . $item . ']" value="' . $value . '" required><br>';
            }
        }
        return $out;
    }

    $out = [];
    $out[] = "<form id='modifConfig' name='modifConfig' method='post' action=''>";

    // Unset Error type
    unset($config['ERREUR']);

    foreach($config as $key => $value){
        $out[] = "<fieldset><legend>$key</legend>";
        $out = array_merge($out,gereBloc($key,$value));
        // $out[] = monPrint_r($key);
        $out[] = "</fieldset>";
    }

    $out[] = "<input type='submit' name='submit[configForm]' value='envoi'>";
    $out[] = "</form>";

    return implode("\n", $out);
}


