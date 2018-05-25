<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 14/05/18
 * Time: 10:09
 */

if (count(get_included_files()) == 1) die("--access denied--");

$toSend = [];

/**
 * Affiche la chaine passée en paramètre dans la zone #contenu du site
 * @param $txt
 */
function display($txt) {
    global $toSend;
    if (!isset($toSend['display'])) $toSend['display'] = "";
    $toSend['display'] .= $txt;
}

/**
 * Affiche la chaine passée en paramètre dans la zone #error du site
 * @param $txt
 */
function error($txt) {
    global $toSend;
    if (!isset($toSend['error'])) $toSend['error'] = "";
    $toSend['error'] .= $txt;
}

/**
 * Affiche la chaine passée en paramètre dans la zone #debug du site
 * @param $txt
 */
function debug($txt) {
    global $toSend;
    if (!isset($toSend['debug'])) $toSend['debug'] = "";
    $toSend['debug'] .= $txt;
}

/**
 * Affiche la chaine passée en paramètre dans la zone kint du site
 * Le paramètre de cette fonction doit TOUJOURS être un retour de la fonction "d()" de la librairie kint
 * @param $txt
 */
function kint($txt) {
    global $toSend;
    if (!isset($toSend['kint'])) $toSend['kint'] = "";
    $toSend['kint'] .= $txt;
}

/**
 * Fonction d'envoie d'informations vers JS au retour de l'appel AJAX
 * Le premier paramètre est la chaine de données à transmetre
 * Le second paramètre est l'action à laquelle on envoit les informations (action gérée dans le JS)
 * @param $txt
 * @param string $action
 */
function toSend($txt, $action = 'display') {
    global $toSend;
    if (!isset($toSend[$action])) $toSend[$action] = "";
    $toSend[$action] .= $txt;
}