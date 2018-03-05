<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 05/03/2018
 * Time: 08:38
 */

// mail('d.delfosse@students.ephec.be', 'Coucou', 'Message test', 'From: delfosse.da@gmail.com');

$de = 'delfosse.da@gmail.com';
$sujet = 'coucou';
$entete = "From: d.delfosse@students.ephec.be \r\n";
$msg = 'Bonjour

Voici mon mail "structuré".

BàT.man';
mail($de,$sujet, $msg, $entete);
echo "mail envoyé si pas de message d'erreur";
