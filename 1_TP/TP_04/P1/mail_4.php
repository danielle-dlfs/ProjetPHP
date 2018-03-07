<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 06/03/2018
 * Time: 17:29
 */


/* Mail 01 */
$destinataire = 'd.delfosse@students.ephec.be';
$expediteur = $_GET['expediteur'];
$sujet = $_POST['sujet'];
$entete = "From:" . $expediteur .  "\r\n";
$entete .= "Content-Type: text/html; charset=utf-8\r\n";
$msg = $_POST['message'];

$mailContact = mail($destinataire,$sujet, $msg, $entete);

if(!$mailContact){
    echo 'erreur';
} else {
    $enteteConfirmation = "From:" . $destinataire .  "\r\n";
    $enteteConfirmation .= "Content-Type: text/html; charset=utf-8\r\n";
    $sujetConfirmation = 'Comfirmation de votre prise de contact';
    $msgConfirmation = "voila";
//    $msgConfirmation = "<h1>Confirmation</h1><table><tr><th>Expediteur</th><td>". $expediteur. "</td></tr><tr><th>Sujet</th><td>". $sujet ."</td></tr><tr><th>Contenu</th><td>". $msg ."</td></tr></table>";
    mail($expediteur, $sujetConfirmation, $msgConfirmation, $enteteConfirmation);
}