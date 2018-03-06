<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 05/03/2018
 * Time: 09:02
 */

$pour = 'delfosse.da@gmail.com';
$sujet = 'coucou';
$de =  "d.delfosse@students.ephec.be";
$entete = "From: ". $de ." \r\n";
$entete .= "Content-Type: text/html; charset=utf-8\r\n";
$msg = 'Bonjour <br><br> Voici un lien vers la <a href="https://193.190.65.92/HE201409/2_SITEX/phase_01/index.php">phase 1</a> du sitex';
mail($pour,$sujet, $msg, $entete);
echo "mail envoyé";
