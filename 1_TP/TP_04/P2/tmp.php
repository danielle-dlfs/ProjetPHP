<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 21/03/2018
 * Time: 19:53
 */

$file = $_FILES['file'];
$nameFile = $file['name'];
$tmpPathName =  $file['tmp_name'];

$sizeFile = $file['size'];
$avatarMaxSize = 150;

$finalPathName = 'AVATARS/'.$_FILES['file']['name'];
$extensionsArray = ['jpg', 'jpeg', 'gif', 'png'];
$extension_upload = strtolower(substr(strrchr($_FILES['file']['name'],'.'),1));
if(in_array($extension_upload,$extensionsArray)) {
    echo "<br>Extension correcte";
    $moveIsOK = move_uploaded_file($file['tmp_name'], $file['name']);
} else {
    echo "<br>Extension non autorisée";
    $moveIsOK = false;
}
if ($moveIsOK){
    echo "<br>l'image a été correctement uploadé dans " . $finalPathName;
} else {
    echo "<br>Il y a eu une erreur";
}
