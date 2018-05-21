<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
// protection pour quand mon pwsd était en clair...
//if ( count( get_included_files() ) == 1) die( '--access denied--' );

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

function sauveConfig($filename){
    unset($_POST['submit']);
    // echo "nom du fichier : $filename";
    // echo monPrint_r($_POST);
    $error = 0;
    $oldConfig = chargeConfig('config.ini');
    $newConfig = array_replace_recursive($oldConfig, $_POST);

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
    }
    file_put_contents($config, implode("\n", $out));
    echo"sauvegarde effectuée";

 /*   if(($filename)){
       if(){
           foreach($newConfig as $a => $b ){
               fwrite($f,$blocName);
               foreach($tab as $key => $value){
                   switch($key){
                       case 'type':
                           foreach ($value as $c){
                               fwrite($f, "choix[] = " $choix "\n ");
                           } break;
                       default : fwrite($f, " = ");
                   }
               }
           }
       } else $error = '1';
    }    else $error = '2';
*/
    /*switch($error){
        case '0' : 'Sauvegarde effectuée' ; break;
        case '1' : 'Le fichier de config n\'existe pas'  ; break;
        case '2' : 'Problème d\'ouverture du fichier de config' ; break;
        default : echo __FILE__.' : erreur inconnue !'; break;
    }*/
}

echo afficheConfig(chargeConfig('config.ini'));
if(isset($_POST['submit']) && !empty($_POST['submit']['configForm'])){
    sauveConfig('config.ini');
}
