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

    // déclaration des constructeurs
    /**
     * Config constructor.
     * @param string $filename
     */
    public function __construct($filename = null) {
        if($filename != null) $this->filename = $filename;
        $this->fileExist = file_exists($this->filename);
    }

    // déclaration des méthodes
    public function getFileName() {
        return $this->filename;
    }

    // déclaration des getters & setters
    /**
     * @return bool
     */
    public function isFileExist()
    {
        return $this->fileExist;
    }

    // déclarations des fonctions

    function load($filename = null){
        if ($filename != null){ // S'il y a un paramètre,
            if(!file_exists($filename)) { //elle teste l'existance du fichier demandé
                return "Le fichier demandé ($filename) n'existe pas";// Dans la négative (cfr !) , elle retourne un msg
            } else {
                //sinon (=>si le paremetre est pas null) elle parse celui passé en paramètre
                return parse_ini_file($this->filename,true);
            }
        } else {
            //si le parametre est null, elle parse le fichier par défaut
            return parse_ini_file($filename,true);
        }
        return $filename;
    }
}