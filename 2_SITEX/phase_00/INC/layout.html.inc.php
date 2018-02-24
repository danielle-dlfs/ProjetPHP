<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns="" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= $home ?></title>
    <!-- La feuille de styles "base.css" doit être appelée en premier. -->
    <link rel="stylesheet" type="text/css" href="CSS/base.css" media="all" />
    <link rel="stylesheet" type="text/css" href="CSS/modele04.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="CSS/index.css" media="screen" />
    <script type="text/javascript" src="/all/jQ/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="JS/index.js"></script>
</head>

<body>

<div id="global">

    <header id="entete">
        <h1>
            <img id=logo alt="<?= $logoAlt ?>" src="<?= $logoPath ?>" />
            <?= $siteName ?>

        </h1>
        <nav id="menu" class="menu">
            <ul>
                <li><a href="accueil.html">Accueil</a></li>
                <li><a href="profil.html">Profil</a></li>
                <li><a href="mesInfos.html">Mes infos</a></li>
                <li><a href="Configuration.html">Configuration</a></li>
                <li><a href="Connexion.html">Connexion</a></li>
            </ul>
        </nav>
    </header>

    <nav id="sous-menu" class="menu">
        <ul>
            <li><a href="TP01.html">TP01</a></li>
            <li><a href="TP02.html">TP02</a></li>
            <li><a href="TP03.html">TP03</a></li>
            <li><a href="TP04.html">TP04</a></li>
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

