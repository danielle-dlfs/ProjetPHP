<?php /*  Protection de fichier */
if ( count( get_included_files() ) == 1) die( '--access denied--' );?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns="" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= $home ?></title>

    <link rel="stylesheet" href="/all/jQui/jquery-ui.min.css">
    <!-- La feuille de styles "base.css" doit être appelée en premier. -->
    <link rel="stylesheet" type="text/css" href="CSS/base.css" media="all" />
    <link rel="stylesheet" type="text/css" href="CSS/modele04.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="CSS/index.css" media="screen" />

    <script type="text/javascript" src="/all/jQ/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/all/jQui/jquery-ui.1.12.1.min.js"></script>
    <script type="text/javascript" src="JS/index.js"></script>
</head>

<body style="background-color: <?= $style ?>;">

<div id="global">

    <header id="entete">
        <h1 id="titre">
            <img id=logo alt="<?= $logoAlt ?>" src="<?= $logoPath ?>" />
            <?= $siteName ?>

        </h1>
        <nav>
            <ul id="menu" class="menu">
                <li><a href="index.html">Accueil</a></li>
                <li><a href="userProfil.html">Profil</a></li>
                <li><a href="userInfos.html">Mes infos</a></li>
                <li><a href="config.html">Configuration</a></li>
                <li>Session
                    <ul id="menu" class="menu sMenu">
                        <li><a href="displaySession.html">affiche</a></li>
                        <li><a href="clearLog.html">efface log</a></li>
                        <li><a href="resetSession.html">redémarre</a></li>
                    </ul>
                </li>
                <li><a href="gestLog.html"><?= $gestLog ?></a></li>
            </ul>
        </nav>
    </header>

    <nav id="sous-menu" class="menu">
        <ul>
            <li><a href="tableau.html">JSON 00</a></li>
            <li><a href="sem02.html">TP02</a></li>
            <li><a href="sem03.html">TP03</a></li>
            <li><a href="sem04.html">TP04</a></li>
            <li><a href="TPsem05.html" id="formTP05">TP05</a></li>
            <li><a href="testDB.html" id="test">test</a></li>
        </ul>
    </nav>

    <main id="contenu">
        <?= $mainZone ?>
    </main>
    <footer id="copyright">
        <span id="auteur"><?= $author?></span>@2018
        -
        <span>Crédits</span>
        <span id="credits">
            Mise en page &copy; 2008
            <a href="http://www.elephorm.com">Elephorm</a> et
            <a href="http://www.alsacreations.com">Alsacréations</a>
        </span>
    </footer>

</div><!-- #global -->
</body>
</html>
