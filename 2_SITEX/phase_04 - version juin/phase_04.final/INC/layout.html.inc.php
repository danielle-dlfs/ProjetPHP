<?php
    if (count(get_included_files()) == 1) header("Location: ../");
?><!DOCTYPE html>

<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="/all/jQui/jquery-ui.min.css">
    <!-- La feuille de styles "base.css" doit être appelée en premier. -->
    <link rel="stylesheet" type="text/css" href="CSS/base.css" media="all" />
    <link rel="stylesheet" type="text/css" href="CSS/modele04.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="CSS/index.css" media="screen" />

    <script src="/all/jQ/jquery-3.1.1.min.js"></script>
    <script src="/all/jQui/jquery-ui.1.12.1.min.js"></script>
    <script src="JS/index.js"></script>
</head>

<body style="background-color: <?= $style ?>;">

<div id="global">

    <header id="entete">
        <h1 id="titre">
            <img id="logo" alt="<?= $logoAlt ?>" src="<?= $logoPath ?>" />
            <?= $blogName ?>
        </h1>
        <nav>
            <ul id="menu" class="menu">
                <li><a href="index.html">Accueil</a></li>
                <li><a href="userProfil.html">Profil</a></li>
                <li><a href="moderation.html">Modération</a></li>
                <li><a href="config.html">Configuration</a></li>
                <li> Session
                    <ul id="sMenu" class="menu">
                        <li><a href="displaySession.html">affiche</a></li>
                        <li><a href="clearLog.html">efface log</a></li>
                        <li><a href="resetSession.html">redémarre</a></li>
                    </ul>
                </li>
                <li><a href="gestLog.html"><?= $gestLog ?></a></li>
            </ul>
        </nav><!-- #navigation -->
        <footer>
            <?= $bandeau ?>
        </footer>
    </header><!-- #entete -->

    <aside id="sous-menu" class="menu">
        <ul>
            <li><a href="tableau.html">JSON 00</a></li>
            <li><a href="sem02.html">TP02</a></li>
            <li><a href="sem03.html">TP03</a></li>
            <li><a href="sem04.html">TP04</a></li>
            <li><a href="TPsem05.html">TP05</a></li>
            <li><a href="testDB.html" id="test">test</a></li>
        </ul>
    </aside><!-- #navigation -->

    <section id="contenu">
        <?= $mainContent ?>
    </section><!-- #contenu -->

    <footer id="copyright">
        <span id="auteur"><?= $auteur ?></span> - <span>crédits</span>
        <span id="credits">
            Mise en page &copy; 2008
            <a href="http://www.elephorm.com">Elephorm</a> et
            <a href="http://www.alsacreations.com">Alsacréations</a>
        </span>
    </footer>

</div><!-- #global -->

</body>
</html>

