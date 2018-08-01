<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 25-07-18
 * Time: 22:31
 */

if ( count( get_included_files() ) == 1) die( '--access denied--' );

class Config {

    // ----------------------------------- VARIABLES
    private $filename = 'config.ini.php';
    private $fileExist = false;
    private $config = [];
    private $saveError = 0;

    // ----------------------------------- CONSTRUCTEURS
    /**
     * Config constructor.
     * @param string $filename
     */
    public function __construct($filename = null) {
        if($filename != null){
            $this->filename = $filename;
        }
        // teste l'existance du fichier mémorisé en privé
        $this->fileExist = file_exists($this->filename);
    }

    // ----------------------------------- GETTERS & SETTERS

    /**
     * @return null|string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * @return bool
     */
    public function isFileExist() {
        return $this->fileExist;
    }

    /**
     * @return array
     */
    public function getConfig() {
        if(empty($this->config)) {
            return "Config non chargée";
        } else {
            return $this->config;
        }
    }

    /**
     * @return int
     */
    public function getSaveError() {
        return $this->saveError;
    }

    // ----------------------------------- METHODES

    public function load($filename= null){
        if($filename != null){
            if(!file_exists($filename)){
                return "Le fichier demandé ($filename) n'existe pas !";
            } else {
                $this->config = parse_ini_file($filename,true);
            }
        } else {
            $this->config = parse_ini_file($this->filename,true);
        }
        return $this->config;
    }

    public function getForm(){

        $config = $this->getConfig();
        if (empty($this->config)) return $config;
        // Création du formulaire
        $out = [];
        $out[] = "<form id='modifConfig' name='modifConfig' method='post' action='formSubmit.html'>";

        // UNSET ERROR TYPE
        unset($config['ERREUR']);
        unset($config['DB']);

        foreach($config as $key => $value){
            $out[] = "<fieldset><legend>$key</legend>";
            $out = array_merge($out,$this->getBloc($key,$value));
            $out[]= "</fieldset>";
        }

        $out[] = "<input type='submit' name='submit[configForm]' value='Envoyer' action=''>";
        $out[] = "</form>";
        return implode("\n", $out);
    }

    private function getBloc($blocName,$blocContenu){
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

    public function save($filename = null) {
        if(!$filename) $filename = $this->filename;

        unset($_POST["submit"]);
        unset($_POST["senderId"]);
        $error = 0;
        if(!$this->config) $error = 1;
        else {
            $oldConfig = $this->config;

            // la boucle foreach du prof pour vérifier toutes des possibilites cfr 3.5.1
            /* foreach ($oldConfig as $key => $value){
                //coucou
            }*/

            $newConfig = array_replace_recursive($oldConfig, $_POST);
            $this->config = $newConfig;
            if ($f = fopen($filename, 'w')) {
                foreach ($newConfig as $blocName => $blocContent) {
                    fwrite($f, "[" . $blocName . "]\n");
                    foreach ($blocContent as $key => $value) {
                        switch ($key) {
                            case "choix":
                                foreach ($value as $choix) {
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
        }

        // gestion des erreurs
        $this->saveError = $error;
        return $this->saveErrorMessage($error);
    }

    /**
     * @param $error
     * @return string
     */
    public function saveErrorMessage($error){
        switch ($error) {
            case 0:
                $msgErr = 'Sauvegarde effectuée !';
                break;
            case 1:
                $msgErr = 'Vous devez charger la config avant de sauver';
                break;
            case 2:
                $msgErr = 'Problème d\'ouveture du fichier de config';
                break;
            default:
                $msgErr = _FILE_ . ' : erreur inconnue';
                break;
        }
        return $msgErr;
    }
}
