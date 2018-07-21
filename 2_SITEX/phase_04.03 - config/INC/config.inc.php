<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 21-07-18
 * Time: 16:13
 */

class Config
{
    // déclaration d'une propriété
    private $filename = 'config.ini.php';

    // déclaration des constructeurs
    /**
     * Config constructor.
     * @param string $filename
     */
    public function __construct($filename = 'null') {
        $this->filename = null;
    }

    // déclaration des méthodes
    public function getFileName() {
        echo $this->filename;
    }

}