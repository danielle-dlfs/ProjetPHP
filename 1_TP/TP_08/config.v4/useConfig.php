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
        $oKey = ['min', 'max', 'pas', 'choix']; // options du bloc
        foreach($oKey as $key){
            // memorisation dans une variable éponyme $... ['min'] est mémorisé dans $min
            // variable dynamique
            $$key = isset($blocContenu[$key]) ? $blocContenu[$key] : null; // memorisation
            unset($blocContenu[$key]); // on supprime
        }

        // CONFIG V1
        $out = [];
        // $out[] = monPrint_r($blocContenu);
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
                case 'type' :
                    // AVATAR = $blocName || type = $k || value = $v || jpg = $type
                    $out[] = "<span id='" . $blocName . "_" . $k . "' class='checkList'>";
                    foreach(explode('|',$v) as $type){
                        $out[] = "<input type='checkbox' id='" . $blocName . "_" . $k . "_" . $type . "' ";
                        $checked = (in_array($type,$choix) ? 'checked ' : '');
                        $out[] = "name='" . $blocName . "[choix][]' value='" . $type . "' " . $checked . ">";
                        $out[] = "<label for='" . $blocName . "_" . $k . "_" . $type . "'>" . $type . "</label>";
                    }
                    $out[] = "</span>";
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

    $out[] = "<input type='submit' name='submit[configForm]' value='Envoyer' action=''>";
    $out[] = "</form>";
    return implode("\n", $out);
}

/*function sauveConfig($filename){
    unset($_POST['submit']);
    echo "nom du fichier : " . $filename;
    echo monPrint_r($_POST);
}*/

function sauveConfig($filename)
{
    unset($_POST["submit"]);
    //echo 'nom du fichier : '. $filename . "<br>";
    //monPrint_r($_POST);
    $error = 0;
    $oldConfig = parse_ini_file("config.ini", true);
    $newConfig = array_replace_recursive($oldConfig, $_POST);
    //print_r($newConfig);
    if (file_exists($filename)) {
        if ($f = fopen($filename, 'w')) {
            foreach ($newConfig as $blocName => $blocContent) {
                //die(monPrint_r($blocName));
                fwrite($f, "[" . $blocName . "]\n");
                foreach ($blocContent as $key => $value) {
                    switch ($key) {
                        case "choix":
                            foreach ($value as $choix) {
                                //die(monPrint_r($value));
                                fwrite($f, "choix[] = \"" . $choix . "\"\n");
                            }
                            break;
                        default :
                            fwrite($f, "$key = \"$value\"\n");
                    }
                }
            }
            fclose($f);
        } else $error = 2;
    } else $error = 1;
    switch ($error) {
        case 0:
            echo 'Sauvegarde effectuée !';
            break;
        case 1:
            echo 'Le fichier n\'existe pas';
            break;
        case 2:
            echo 'Problème d\'ouveture du fichier de config';
            break;
        default:
            echo _FILE_ . ' : erreur inconnue';
            break;
    }
}