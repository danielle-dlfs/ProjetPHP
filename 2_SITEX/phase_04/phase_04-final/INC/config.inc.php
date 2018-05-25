<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 28/04/18
 * Time: 17:06
 */

if (count(get_included_files()) == 1) die("--access denied--");

/**
 * Class Config
 * Gère la récupération de configuration depuis des fichiers .ini
 * Gère la génération dynamique d'un formulaire HTML5 pour modifier la config
 * Gère la sauvegarde dans un fichier .ini de la nouvelle config
 */
class Config
{

    /* ---------- ATTRIBUTES ---------- */

    /**
     * Nom du fichier de config
     * @var null|string
     */
    private $filename = 'config.ini.php';
    /**
     * Vrai si le fichier de config demandé existe
     * @var bool
     */
    private $fileExist = false;
    /**
     * Tableau multidimensionnel contenant la configuration une fois chargée
     * @var array
     */
    private $config = [];
    /**
     * Contient les erreurs rencontrées durant le processus de sauvegarde
     * @var int
     */
    private $saveError = 0;

    /* ---------- CONSTRUCTOR ---------- */

    /**
     * Config constructor.
     * Si reçoit un filename en paramètre, il le stocke dans l'attribu et vérife son existance
     * @param null $filename
     */
    public function __construct($filename = null) {
        if ($filename != null) $this->filename = $filename;
        $this->fileExist = file_exists($this->filename);
    }


    /* ---------- GETTERS ---------- */

    /**
     * Retourne le nom du fichier de config
     * @return null|string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Renvoie true si le fichier existe, false si le fichier de config n'existe pas
     * @return bool
     */
    public function isFileExist() {
        return $this->fileExist;
    }

    /**
     * Renvoie la config actuellement chargée ou un chaine si aucune config n'est chargée
     * @return array|string
     */
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

    /**
     * Charge le fichier de config demandé dans l'attribut config
     * Renvoie la config si le chargement s'est bien passé
     * Renvoie un string si le fichier demandé n'existe pas
     * Renvoie false si la fonction de lecture du fichier a rencontré une erreur
     * @param null $filename
     * @return array|bool|string
     */
    public function load($filename = null) {
        if ($filename != null) {
            if (!file_exists($filename)) return 'Le fichier demandé (' . $filename . ') n\'existe pas';
            return $this->config = parse_ini_file($filename, true);
        } else {
            return $this->config = parse_ini_file($this->filename, true);
        }
    }

    /* ---------- METHODS ---------- */

    /**
     * Sauvegarde la nouvelle configuration (contenue dans $_POST) à l'emplacement demandé
     * Si une erreur est rencontrée durant le processus, renvoie une chaine avec l'erreur
     * @param null $filename
     * @return string
     */
    public function save($filename = null) {
        if (!$filename) $filename = $this->filename;

        unset($_POST['rq']);
        unset($_POST['senderId']);
        unset($_POST['envoie']);

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

    /**
     * Génère dynamiquement un formulaire en se basant sur le fichier de config actuellement chargé
     * Renvoie un string contenant le formulaire HTML5
     * @return array|string
     */
    public function getForm() {

        $config = $this->getConfig();
        if (empty($this->config)) return $config;

        $out = [];
        $out[] = '<form id="modifConfig" name="modifConfig" action="formSubmit.html" method="post">';

        // Unset Error type
        unset($config['ERREUR']);
        unset($config['EPHEC']);
        if (!isAdmin()) unset($config['DB']);

        foreach ($config as $k => $v) {
            $out[] = '<fieldset><legend>' . $k . '</legend>';
            $out = array_merge($out, $this->getBloc($k, $v));
            $out[] = '</fieldset>';
        }

        $out[] = '<input type="submit" name="envoie" value="Envoyer"></form>';
        return implode($out, "\n");
    }

    /**
     * Génère les différents blocs du formulaire
     * Retourne un tableau des différentes lignes du bloc généré
     * @param $k Nom du bloc
     * @param $v tableau des éléments de ce bloc
     * @return array
     */
    private function getBloc($k, $v) {

        /**
         * @var $min String
         * @var $max String
         * @var $pas String
         * @var $choix Array
         */

        $oKey = ['min', 'max', 'pas', 'choix'];

        foreach ($oKey as $key) {
            $$key = isset($v[$key]) ? $v[$key] : [];
            unset($v[$key]);
        }

        $out = [];

        foreach ($v as $item => $value) {
            $out[] = '<label for="' . $k . '_' . $item . '">' . $item . ' </label>';
            switch ($item) {
                case 'taille':
                    $out[] = '<input type="number" ' .
                        'id="' . $k . '_' . $item . '" ' .
                        'name="' . $k . '[' . $item .  ']' . '" ' .
                        'value="' . $value . '" required ' .
                        ($min ? 'min="' . $min . '"': '') .
                        ($max ? 'max="' . $max . '"': '') .
                        ($pas ? 'step="' . $pas . '"': '') .
                        'title="'. ($min ? 'min=' . $min . ' ': '') . ($max ? 'max=' . $max . ' ': '') . ($pas ? 'step=' . $pas . ' ': '') .'"' .
                        '><br>';
                    break;

                case 'type':
                    $out[] = ': ';
                    $out[] = '<span id="' . $k . '_' . $item . '">';
                    foreach (explode('|', $value) as $type) {
                        $out[] = '<input type="checkbox" id="' . $k . '_' . $item . '_' . $type . '" name="' . $k . '[choix][]' . '" value="' . $type . '" ' . (in_array($type, $choix) ? 'checked': '') . '>';
                        $out[] = '<label for="' . $k . '_' . $item . '_' . $type . '">' . $type . ' </label>';
                    }
                    $out[] = '</span>';
                    break;

                case 'comment':
                    $out[] = '<textarea cols="50" readonly disabled required>' . $value . '</textarea><br>';
                    break;

                case 'pswd':
                    $out[] = '<input type="password" id="' . $k . '_' . $item . '" name="' . $k . '[' . $item .  ']' . '" value="' . $value . '" required><br>';
                    break;

                default:
                    $out[] = '<input type="text" id="' . $k . '_' . $item . '" name="' . $k . '[' . $item .  ']' . '" value="' . $value . '" required><br>';
                    break;
            }

        }

        return $out;
    }

    /**
     * Sauvegarde le bon message d'erreur dans l'attribut en fonction du numéro d'érreur passé en paramètre
     * @param $error
     * @return string
     */
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