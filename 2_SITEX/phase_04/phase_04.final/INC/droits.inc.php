<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 14/05/18
 * Time: 09:35
 */

if (count(get_included_files()) == 1) die("--access denied--");

function isAuthenticated() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isAuthenticated() && in_array('admin', $_SESSION['user']['lesProfils']);
}

function isSousAdmin() {
    return isAuthenticated() && in_array('sAdmin', $_SESSION['user']['lesProfils']);
}

function isReactiv() {
    return isAuthenticated() && in_array('réac', $_SESSION['user']['lesStatuts']);
}

function isMdpp() {
    return isAuthenticated() && in_array('mdpp', $_SESSION['user']['lesStatuts']);
}

function isEdit() {
    return isAdmin() || isReactiv();
}

function creeDroits() {
    $_SESSION['droitsDeBase'] = ['index', 'gestLog', 'pasvorto', 'formSubmit', 'formLogin'];

    if (isset($_SESSION['user']['droits'])) {
        $_SESSION['droits'] = &$_SESSION['user']['droits'];
    } else {
        $_SESSION['droits'] = &$_SESSION['droitsDeBase'];
    }

    if ( ! isAuthenticated()) return -1;

    $listeDesStatuts = [];
    $listeDesProfils = [];
    foreach ($_SESSION['user']['profile'] as $profil) {
        if ($profil['pEstStatus']) array_push($listeDesStatuts, $profil['pAbrev']);
        else array_push($listeDesProfils, $profil['pAbrev']);
    }

    $_SESSION['user']['lesStatuts'] = $listeDesStatuts;
    $_SESSION['user']['lesProfils'] = $listeDesProfils;

    $listeDesDroits = [];
    switch($listeDesProfils[0]) {
        case 'admin': $listeDesDroits = array_merge($listeDesDroits, ['modifConfig', 'displaySession', 'clearLog', 'resetSession']);
        case 'sAdmin': $listeDesDroits = array_merge($listeDesDroits, ['testDB', 'config']);
        case 'modo': $listeDesDroits = array_merge($listeDesDroits, ['tableau', 'moderation']);
        case 'memb': $listeDesDroits = array_merge($listeDesDroits, ['sem02', 'sem03', 'sem04', 'TPsem05', 'formTP05', 'userProfil']);
        case 'ano': $listeDesDroits = array_merge($listeDesDroits, $_SESSION['droitsDeBase']);
    }
    $_SESSION['user']['droits'] = $listeDesDroits;
    if (!isReactiv()) return -2;

    $perdu = [
        'memb' => ['formTP05'],
        'modo' => ['moderation'],
        'sAdmin' => ['config']
    ];

    $listeDesDroitsPerdus = [];
    foreach ($listeDesProfils as $profil) {
        if (isset($perdu[$profil])) $listeDesDroitsPerdus = array_merge($listeDesDroitsPerdus, $perdu[$profil]);
    }

    if (!empty($listeDesDroitsPerdus)) {
        $_SESSION['user']['droitsPerdus'] = $listeDesDroitsPerdus;
        $_SESSION['user']['droits'] = array_diff($_SESSION['user']['droits'], $_SESSION['user']['droitsPerdus']);
    }

    //debug(d($_SESSION['user']));
}