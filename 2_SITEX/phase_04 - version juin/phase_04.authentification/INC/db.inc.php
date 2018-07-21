<?php
/**
 * Created by PhpStorm.
 * User: HE201409
 */

require_once "INC/config.inc.php";

/**
 * Class Db
 */
class Db {
    /* ------------------------------ VARIABLES ------------------------------ */

    /**
     * @var array
     * reçoit seulement la partie de la config qui concerne la DB
     */
    private $db = [];

    /**
     * @var null|PDO
     */
    private $iPdo = null;

    /**
     * @var Exception|null|PDOException
     */
    private $pdoException = null;

    /* ------------------------------ CONSTRUCTEURS ------------------------------ */

    /**
     * Db constructor.
     */
    public function __construct(){
        $iCfg = new Config('config.ini.php'); // instancie la config
        $config = $iCfg->load();  // charge la config
        $this->db = $config['DB']; // récuperer la partie DB
        try {
            $this->iPdo = new PDO('mysql:host='.$this->getServer().';dbname='.$this->db['dbname'],$this->db['user'], $this->db['pswd']);
            // cfr pour setAttribut http://php.net/manual/fr/pdo.query.php#74943
            $this->iPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            $this->pdoException = $e;
        }
    }

    /* ------------------------------ GETTERS ------------------------------ */
    /**
     * @return string
     */
    public function getException() {
        return "PDOException : " . ($this->pdoException ? $this->pdoException->getMessage() : 'aucune');
    }

    /**
     * @return string
     */
    private function getServer(){
        return in_array($_SERVER['SERVER_NAME'], ['193.190.65.92', 'devweb.ephec.be']) ? 'localhost' : '193.190.65.92';
    }

    /* ------------------------------  METHODES ------------------------------ */

    /**
     * Effectue un call à la procédure mc_allGroups
     * @return array
     */
    public function call_v1(){
        try {
            $sth = $this->iPdo->prepare('call mc_allGroups()');
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            $this->pdoException = $e;
            return ['__ERR__' => $this->pdoException];
        }
    }

    /**
     * Effectue un call intelligent avec les paramètres passé à la fonction
     * @param $name Nom de la procédure à call
     * @param array $param Tableau contenant tous les paramètres à passer à la procédure
     * @return array Retour de la procédure
     */
    public function call($nom, $param = []){
        $p = [];
        switch ($nom) {
            // 2 params
            case 'whoIs': $p[] = '?';
            // 1 param
            case 'userProfil':
            case 'mc_group':
            case 'mc_coursesGroup': $p[] = '?';
            // 0 param
            case 'mc_allGroups':
                if (!$this->pdoException) {
                    try {
                        $appel = 'call ' . $nom . '('. implode(',', $p) .')';
                        $sth = $this->iPdo->prepare($appel);
                        $sth->execute($param);
                        return $sth->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        $this->pdoException = $e;
                        return ['__ERR__' => $this->pdoException];
                    }
                } else {
                    return ['__ERR__' => $this->pdoException];
                }
                break;
            default: return ['__ERR__' => 'call impossible à ' . $nom];
        }
    }
}