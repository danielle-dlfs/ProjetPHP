<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 26-07-18
 * Time: 12:42
 */
?>

<section id="login">
    <form id="formLogin" method="post" action="formSubmit.html">
        <fieldset>
            <legend>Connexion</legend>
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="login[pseudo]" required><br>
            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="login[mdp]" required>
            <a id="logMdPP" href="pasvorto.html">(perdu ou oublié ?)</a><br>
            <input type="submit" value="connexion">
        </fieldset>
    </form>
    <link rel="stylesheet" type="text/css" href="CSS/template.login.css" media="screen" />
</section>