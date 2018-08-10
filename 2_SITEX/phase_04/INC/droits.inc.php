<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 06-08-18
 * Time: 20:47
 */

if ( count( get_included_files() ) == 1) die( '--access denied--' );

function creeDroits(){
    $_SESSION['droitsDeBase'] = ['index','gestLog','pasvorto','formLogin','formSubmit'];

    if(isset($_SESSION['user']['droits'])){
        $_SESSION['droits'] = &$_SESSION['user']['droits'];
    } else {
        $_SESSION['droits'] = &$_SESSION['droitsDeBase'];
    }

    //if(!isset($_SESSION['user'])) return -1;
    if(!isAuthenticated()) return -1;

    $listeDesStatuts = [];
    $listeDesProfils = [];

    foreach ($_SESSION['user']['profil'] as $aProfil){
        if($aProfil['pEstStatus']) array_push($listeDesStatuts, $aProfil['pAbrev']);
        else array_push($listeDesProfils, $aProfil['pAbrev']);
    }

    $_SESSION['user']['lesStatuts'] = $listeDesStatuts;
    $_SESSION['user']['lesProfils'] = $listeDesProfils;

    $listeDesDroits = [];
    switch($listeDesProfils[0]){
        case 'admin': $listeDesDroits = array_merge($listeDesDroits, ['modifConfig', 'displaySession', 'clearLog', 'resetSession']);
        case 'sAdmin': $listeDesDroits = array_merge($listeDesDroits, ['testDB', 'config']);
        case 'modo': $listeDesDroits = array_merge($listeDesDroits, ['tableau', 'moderation']);
        case 'memb': $listeDesDroits = array_merge($listeDesDroits, ['sem02', 'sem03', 'sem04', 'TPsem05', 'formTP05', 'userProfil']);
        case 'ano': $listeDesDroits = array_merge($listeDesDroits, $_SESSION['droitsDeBase']);
    }

    $_SESSION['user']['droits'] = $listeDesDroits;
    kint(d($_SESSION['user']));

    if(!isReactiv() || isAdmin()) return -2;

    $perdu = [  'memb' => ['formTP05'],
                'modo' => ['moderation'],
                'sAdmin' => ['config']
             ];
    // tableau attribut/valeur

    $listeDesDroitsPerdus = [];
    foreach ($listeDesProfils as $profil){
        if(isset($perdu[$profil])) $listeDesDroitsPerdus = array_merge($listeDesDroitsPerdus,$perdu[$profil]);
        //s'il y a pas de valeur pour le profil 'actuel' il faut pas retirer
    }

    if(!empty($listeDesDroitsPerdus)){
        $_SESSION['user']['droitsPerdus'] = $listeDesDroitsPerdus;
        $_SESSION['user']['droits'] = array_diff($_SESSION['user']['droits'],$_SESSION['user']['droitsPerdus']);
    }

    kint(d($_SESSION['user']));
}


function creeMenu(){
    $gestLog = 'Connexion';
    $profil = 'ano';
    if (isAuthenticated()) {
        $gestLog = 'Déconnexion';
        $profil = $_SESSION['user']['lesProfils'][0];
    }
    $menu = [];
//HEREDOC <<<motClé MENU
//attention colonne 0 pour l'heredoc le second mot clé
    array_unshift($menu, <<<MENU
        <li><a href='gestLog.html'>$gestLog</a></li>
MENU
    );
    switch($profil){
        case 'admin':
        case 'sAdmin' : array_unshift($menu, <<<MENU
            <li>Admin
                <ul class="menu sMenu">
                    <li><a href="testDB.html" id="test">test</a></li>
                    <li><a href="config.html">Configuration</a></li>
                    <li>Session
                        <ul class="menu sMenu">
                            <li><a href="displaySession.html">affiche</a></li>
                            <li><a href="clearLog.html">efface log</a></li>
                            <li><a href="resetSession.html">redémarre</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
MENU
        );
        case 'modo' : array_unshift($menu, <<<MENU
            <li>Modo
                <ul class="menu sMenu">
                    <li><a href="tableau.html">JSON 00</a></li>
                    <li><a href="moderation.html">Modération</a></li>
                </ul>
            </li>
MENU
        );
        case 'memb' : array_unshift($menu, <<<MENU
            <li>Membre
                <ul class="menu sMenu">
                    <li><a href="userProfil.html">Profil</a></li>
                    <li>TP
                        <ul class="menu sMenu">
                            <li><a href="sem02.html">TP02</a></li>
                            <li><a href="sem03.html">TP03</a></li>
                            <li><a href="sem04.html">TP04</a></li>
                            <li><a href="TPsem05.html">TP05</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
MENU
        );
        case 'ano' : array_unshift($menu,<<<MENU
            <li><a href='index.html'>Accueil</a></li>
MENU
        );
    }
    return implode("\n",$menu);
}

/* GESTION DES STATUTS */

function isAuthenticated(){
    return isset($_SESSION['user']);
}

function isAdmin(){
    return isAuthenticated() && in_array('admin', $_SESSION['user']['lesProfils']);
}

function isSousAdmin(){
    return isAuthenticated() && in_array('sAdmin', $_SESSION['user']['lesProfils']);
}

/*function isActiv(){
    return isAuthenticated() && in_array('acti', $_SESSION['user']['lesStatuts']);
}*/

function isReactiv(){
    return isAuthenticated() && in_array('réact', $_SESSION['user']['lesStatuts']);
}

function isMdpp(){
    return isAuthenticated() && in_array('mdpp', $_SESSION['user']['lesStatuts']);
}

function isEdit(){
    return isAdmin() || !isReactiv();
}

