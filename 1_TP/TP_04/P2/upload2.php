<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 06/03/2018
 * Time: 17:39
 */

/* 2.1 */
$file = $_FILES['file'];
print_r($file);
$nameFile = $file['name'];
$typeFile = $file['type'];
$tmpPathName =  $file['tmp_name'];
$error = $file['error'];
$sizeFile = $file['size'];
$finalPathName = 'MES_IMAGES/'.$nameFile;
$extensionsArray = ['jpg', 'jpeg', 'gif', 'png'];
//1. strrchr renvoie l'extension avec le point (« . »).
//2. substr(chaine,1) ignore le premier caractère de chaine.
//3. strtolower met l'extension en minuscules.
$extension_upload = strtolower(substr(strrchr($_FILES['file']['name'],'.'),1));
if(in_array($extension_upload,$extensionsArray)) {
    echo "<br>Extension correcte";
    $moveIsOK = move_uploaded_file($tmpPathName, $finalPathName);
} else {
    echo "<br>Extension non autorisée";
    $moveIsOK = false;
}
if ($moveIsOK){
    echo "<br>l'image a été correctement uploadé dans " . $finalPathName;
} else {
    echo "<br>Il y a eu une erreur";
}








