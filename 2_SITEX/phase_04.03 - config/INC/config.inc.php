<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 21-07-18
 * Time: 16:13
 */

if ( count( get_included_files() ) == 1) die( '--access denied--' );

class Config
{
    // déclaration d'une propriété
    private $filename = 'config.ini.php';
    private $fileExist = false;
    private $config = [];

    // --------------------------------------------------- CONSTRUCTEURS
    /**
     * Config constructor.
     * @param string $filename
     */
    public function __construct($filename = null) {
        if($filename != null) $this->filename = $filename;
        $this->fileExist = file_exists($this->filename);
    }

    // --------------------------------------------------- METHODES
    public function getFileName() {
        return $this->filename;
    }

    // --------------------------------------------------- GETTERS & SETTERS
    /**
     * @return bool
     */
    public function isFileExist() {
        return $this->fileExist;
    }

    /**
     * @return array
     */
    public function getConfig(){
        if(empty($this->config)) { // on utilise empty car $config est un tableau
            return "Config non chargée";
        } else {
            return $this->config;
        }
    }

    // --------------------------------------------------- FONCTIONS
    public function load($filename = null){
        //S'il y a un paramètre, elle teste l'existance du fichier demandé.
        //Dans la négative, elle retourne le message Le fichier demandé (.....) n'existe pas (où le ... est le paramètre passé)
        //Si le paramètre est null, elle parse le fichier par défaut sinon elle parse celui passé en paramètre (pas besoin de test puisque fait dans le constructeur)
        //Le parse est sauvegardé dans une variable privée config qui était initialisée à []
        //La fonction retourne le contenu de cette variable

        if ($filename != null){ // S'il y a un paramètre,
            if(!file_exists($filename)) { //elle teste l'existance du fichier demandé
                return "Le fichier demandé ($filename) n'existe pas";// Dans la négative (cfr !) , elle retourne un msg
            } else {
                //sinon (=>si le parametre est pas null) elle parse celui passé en paramètre
                //parse_ini_file($this->filename,true);
                $this->config = parse_ini_file($filename, true);
            }
        } else { //parametre est null
            //elle parse le fichier par défaut (le parse est sauvé dans la var privée config
            $this->config = parse_ini_file($this->filename, true);
        }

        return $this->config;
    }

}

