<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 26-07-18
 * Time: 15:09
 */

require_once "config.inc.php";

class Db
{

    private $db = [];
    private $pdoException = null;
    private $iPdo;

    /**
     * Db constructor.
     */
    public function __construct()
    {
        $iCfg = new Config('config.ini.php');
        $config = $iCfg->load();
        $this->db = $config['DB'];
        try {
            $this->iPdo = $this->iPdo = new PDO('mysql:host=' . $this->getServer() . ';dbname=' . $this->db['dbname'],
                $this->db['user'], $this->db['pswd']);
            // cfr pour setAttribut http://php.net/manual/fr/pdo.query.php#74943
            $this->iPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->pdoException = $e;
        }
    }

    public function getException()
    {
        return "PDOException : " . ($this->pdoException ? $this->pdoException->getMessage() : 'aucune');
    }

    private function getServer()
    {
        return in_array($_SERVER['SERVER_NAME'], ['193.190.65.92', 'devweb.ephec.be'])
            ? 'localhost'
            : '193.190.65.92';
    }

    public function call_v1()
    {
        try {
            $sth = $this->iPdo->prepare('call mc_allGroups()');
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->pdoException = $e;
            return ['__ERR__' => $this->getException()];
        }
    }

    public function call($nom, $param = []) {
        $p = []; //accumule les ? des futurs param à passer
        switch ($nom) {
            // 2 parametres
            case 'whoIs' : $p[]= '?';
            // 1 parametre
            case 'userProfil':
            case 'mc_group':
            case 'mc_coursesGroup': $p[] = '?';
            // 0 parametre
            case 'mc_allGroups':
                try {
                    $appel = 'call ' . $nom . '('.implode(',',$p) . ')';
                    $sth = $this->iPdo->prepare($appel);
                    $sth->execute($param);
                    return $sth->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $this->pdoException = $e;
                    return ['__ERR__' => $this->getException()];
                }
                break;
            default:
                return ['__ERR__' => 'call impossible à ' . $nom];
        }
    }
}