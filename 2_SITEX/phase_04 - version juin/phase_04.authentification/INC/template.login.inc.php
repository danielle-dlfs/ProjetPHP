<?php
if ( count( get_included_files() ) == 1) die( '--access denied--' );
?>

<section id="login">
    <form id="formLogin" method="post" action="formSubmit.html">
        <fieldset>
            <legend>Connexion</legend>
            <label for="login[pseudo]">Pseudo </label>
            <input id="pseudo" type="text" name="login[pseudo]" required><br>
            <label for="login[mdp]">Mot de passe </label>
            <input type="password" id="mdp" name="login[mdp]" required>
            <a href="pasvorto.html" id="logMdPP"> (perdu ou oublié ?)</a><br>
            <input type="submit" value="connexion">
        </fieldset>
    </form>
    <link rel="stylesheet" type="text/css" href="CSS/template.login.css" media="screen" />
</section>