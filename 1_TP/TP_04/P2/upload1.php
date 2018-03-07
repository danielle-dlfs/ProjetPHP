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
/* mkdir('documents/', 0777, true);*/
$finalPathName = 'DOCUMENTS/'.$nameFile;
$moveIsOK = move_uploaded_file($tmpPathName, $finalPathName);

if ($moveIsOK){
    echo "le fichier a été correctement uploadé dans " . $finalPathName;
} else {
    echo "Il y a eu une erreur";
}








