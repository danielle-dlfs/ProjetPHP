<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

if ( count( get_included_files() ) == 1) die( '--access denied--' );


class Config
{
    private $filename = 'config.ini.php'; // faux ami c'est juste pour créer la variable il est pas utilisable
    private $fileExist = false;
    private $config = [];

    /**
     * Contient les erreurs rencontrées durant le processus de sauvegarde
     * @var int
     */
    private $saveError = 0;

    function __construct($filename = null) {
        if($filename!=null) $this->filename = $filename;
        $this->fileExist = file_exists($this->filename);
    }

    // ----------------------------- GETTERS -------------------------------
    public function getFilename() {
        return $this->filename;
    }

    public function isFileExist() {
//        return $this->fileExist ? 1 : 0;
        return $this->fileExist;
    }

    public function getConfig() {
        if (empty($this->config)) return 'Config non chargée';
        return $this->config;
    }

    /**
     * Renvoie une valeur != 0 si le processus de sauvegarde a rencontré une erreur
     * @return int
     */
    public function getSaveError() {
        return $this->saveError;
    }

    // ----------------------------- FONCTIONS -------------------------------
    public function load($filename = null){
        if($filename != null){
            if(!file_exists($filename)) {
                return "Le fichier demandé ($filename)n'existe pas";
            }
            else {  $this->config = parse_ini_file($filename, true);
            }
        } else {
             return $this->config = parse_ini_file($this->filename, true);
        }
    }

    public function getForm(){
        $config = $this->getConfig();
        if (empty($this->config)){
            return $config;
        }
        //$out = monPrint_r($config);
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
        if (!$filename) $filename = $this->filename;

        unset($_POST['rq']);
        unset($_POST['senderId']);
        unset($_POST['submit']);

        $out = [];
        $error = 0;

        if (!$this->config) $error = 1;
        else {
            $oldConfig = $this->config;
            foreach ($oldConfig as $key => $value) {
                foreach ($value as $k => $v) {
                    if (gettype($v) == 'array') $oldConfig[$key][$k] = [];
                }
            }
            foreach ($this->config = array_replace_recursive($oldConfig, $_POST) as $k => $v) {
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
                $out[] = "";
            }
            file_put_contents($filename, implode("\n", $out));
        }

        $this->saveError = $error;
        return $this->saveErrorMessage($error);
    }

    public function saveErrorMessage($error) {
        $errorMsg = "";
        switch ($error) {
            case 1:
                $errorMsg = "Vous devez charger la config avant de la sauver !";
                break;
            case 0:
                $errorMsg = "Sauvegarde effectuée";
                break;
        }
        return $errorMsg;
    }
}