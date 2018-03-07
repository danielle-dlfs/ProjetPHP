<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 05/03/2018
 * Time: 09:24
 */

$destinataire = $_POST['destinataire'];
$expediteur = 'd.delfosse@students.ephec.be';
$sujet = $_POST['sujet'];
$entete = "From:" .$expediteur .  "\r\n";
$entete .= "Content-Type: text/html; charset=utf-8\r\n";
$msg = $_POST['message'];

mail($destinataire,$sujet, $msg, $entete);
