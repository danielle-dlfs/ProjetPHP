<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 05/03/2018
 * Time: 08:38
 */

$pour = 'delfosse.da@gmail.com';
$sujet = 'Mail de test';
$msg = "Bonjour \r\n\r\nVoici mon mail \"structuré\".\r\n\r\nBàT.man";
$de = "From: d.delfosse@students.ephec.be";
mail($pour,$sujet,$msg,$de);
echo 'mail envoyé si pas de message d\'erreur';