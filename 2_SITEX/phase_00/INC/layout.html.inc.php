<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        Gabarit 04: minimaliste, menu vertical à gauche, largeur fluide
    </title>
    <!-- La feuille de styles "base.css" doit être appelée en premier. -->
    <link rel="stylesheet" type="text/css" href="CSS/base.css" media="all" />
    <link rel="stylesheet" type="text/css" href="CSS/modele04.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="CSS/index.css" media="screen" />
</head>

<body>

<div id="global">

    <header id="entete">
        <h1>
            <img id=logo alt="<?php echo $logoAlt; ?>" src="<?php echo $logoPath; ?>" />
            <?php echo $siteName; ?>

        </h1>
        <aside id="menu" class="menu">
            <ul>
                <li><a href="accueil.html">Accueil</a></li>
                <li><a href="profil.html">Profil</a></li>
                <li><a href="mesInfos.html">Mes infos</a></li>
                <li><a href="Configuration.html">Configuration</a></li>
                <li><a href="Connexion.html">Connexion</a></li>
            </ul>
        </aside>
    </header>

    <aside id="sous-menu" class="menu">
        <ul>
            <li><a href="TP01.html">TP01</a></li>
            <li><a href="TP02.html">TP02</a></li>
            <li><a href="TP03.html">TP03</a></li>
            <li><a href="TP04.html">TP04</a></li>
        </ul>
    </aside>

    <main id="contenu">
        <h2>À propos du gabarit 04</h2>
        <h3>Code HTML et CSS</h3>
        <p>Ce gabarit est structuré de la manière suivante:</p>
<pre><code>&lt;div id="global"&gt;
        &lt;div id="entete"&gt;...&lt;/div&gt;
        &lt;div id="navigation"&gt;...&lt;/div&gt;
        &lt;div id="contenu"&gt;...&lt;/div&gt;
        &lt;/div&gt;</code></pre>
        <p>Il est mis en forme par deux feuilles de styles:</p>
        <ol>
            <li><a href="CSS/base.css">base.css</a> (mise en forme minimale
                du texte, commune à tous les gabarits)</li>
            <li><strong><a href="CSS/modele04.css">modele04.css</a></strong>,
                qui contient tous les styles propres à ce gabarit, et que je vous
                invite à consulter.</li>
        </ol>
        <p>Pour voir le détail du code HTML de cette page, utilisez la fonction
            d'affichage de la source de votre navigateur web (ex: «Affichage &gt;
            Code source de la page»).</p>
        <h3>À noter</h3>
        <ol>
            <li><p>Dans ce gabarit, nous utilisons la propriété CSS
                    <code>float</code> pour placer deux blocs à la même hauteur plutôt
                    que l'un en dessous de l'autre. Voir les notes de la feuille de
                    style du gabarit pour en savoir plus.</p></li>
            <li><p>Le bloc de droite n'utilise pas la propriété
                    <code>float</code>, mais une simple marge à gauche
                    (<code>margin-left</code>).</p>
                <p>Pour mieux comprendre le fonctionnement du positionnement
                    flottant, vous pouvez, avec un outil tel que
                    <a href="https://addons.mozilla.org/fr/firefox/addon/1843">Firebug</a>,
                    désactiver la marge de gauche de <code>div#contenu</code>.</p></li>
        </ol>
    </main>
    <footer id="copyright">
        Mise en page &copy; 2008
        <a href="http://www.elephorm.com" target="_blank">Elephorm</a> et
        <a href="http://www.alsacreations.com" target="_blank">Alsacréations</a>
    </footer>

</div><!-- #global -->

</body>
</html>

