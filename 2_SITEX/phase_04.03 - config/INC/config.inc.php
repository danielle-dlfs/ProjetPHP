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
        if ($filename != null){
            if(!file_exists($filename)) {
                return "Le fichier demandé ($filename) n'existe pas";
            }
        } else {

        }
        // mettre a true : on obtient un tableau multidimensionnel avec les noms des sections
        return parse_ini_file($filename,true);
    }
}