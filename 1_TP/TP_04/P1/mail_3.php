<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 05/03/2018
 * Time: 09:24
 */

$pour = 'd.delfosse@students.ephec.be';
$sujet = $_POST['sujet'];
$entete = "From:". $_POST['de'] ."\r\n";
$entete .= "Content-Type: text/html; charset=utf-8\r\n";
$msg = $_POST['message'];
$ok = mail($pour,$sujet, $msg, $entete);