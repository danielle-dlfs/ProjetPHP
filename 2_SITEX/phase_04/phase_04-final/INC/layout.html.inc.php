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
                <?= creeMenu() ?>
            </ul>
        </nav><!-- #navigation -->
        <footer>
            <?= $bandeau ?>
        </footer>
    </header><!-- #entete -->

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

