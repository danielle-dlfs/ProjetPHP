<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 5/05/18
 * Time: 19:35
 */

if (count(get_included_files()) == 1) die("--access denied--");

require_once 'INC/config.inc.php';

/**
 * Class Db
 * Gère la connection à la base de donnée et les appels de procédures
 */
class Db
{

    /* ---------- ATTRIBUTES ---------- */

    /**
     * Contient les informations de connection de la DB depuis la config
     * @var array
     */
    private $db = [];
    /**
     * Contient les exceptions renvoyées par la connexion à la DB
     * @var Exception|null|PDOException
     */
    private $pdoException = null;
    /**
     * Contient l'objet PDO
     * @var null|PDO
     */
    private $iPdo = null;


    /* ---------- CONSTRUCTOR ---------- */

    /**
     * Db constructor
     * Initialise la connection à la DB sur base des infos de connexion venant de la config
     */
    public function __construct()
    {
        $iCfg = new Config('config.ini.php');
        $config = $iCfg->load();
        $this->db = $config['DB'];
        try {
            $this->iPdo = new PDO('mysql:host='.$this->getServer().';dbname='.$this->db['dbname'],$this->db['user'], $this->db['pswd']);
            $this->iPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->pdoException = $e;
        }
    }

    /* ---------- GETTERS ---------- */

    /**
     * Renvoie l'exception catché durant la connexion ou le call de procédure
     * @return string
     */
    public function getException() {
        return 'PDOException : ' . ($this->pdoException ? $this->pdoException->getMessage() : 'aucune !');
    }

    /**
     * Retourne le serveur sur lequel l'application tourne actuellement
     * @return string
     */
    private function getServer() {
        return in_array($_SERVER['SERVER_NAME'], ['193.190.65.92', 'devweb.ephec.be']) ? 'localhost' : '193.190.65.92';
    }

    /* ---------- METHODS ---------- */

    /**
     * Effectue un call à la procédure mc_allGroups
     * @return array
     */
    public function call_v1() {
        try {
            $sth = $this->iPdo->prepare('call mc_allGroups()');
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
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
    public function call($name, $param = []) {
        $p = [];
        switch ($name) {
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
                        $appel = 'call ' . $name . '('. implode(',', $p) .')';
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
            default: return ['__ERR__' => 'call impossible à ' . $name];

        }


    }
}