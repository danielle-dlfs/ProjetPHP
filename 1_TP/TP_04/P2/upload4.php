<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 21/03/2018
 * Time: 18:41
 */

$file = $_FILES['file'];

if(checkImage()){
    $uploadFile = 'AVATARS/'.$file['name'];
    move_uploaded_file($file['tmp_name'], $uploadFile);
    resizeImage($uploadFile);
    echo "L'image a été correctement uploadé <a href='$uploadFile'><i>ici</i></a><br>";
} else {
    echo "Il y a eu un problème à l'upload, recommencer";
}

function checkImage(){
    global $file;
    $extArray = ['jpg', 'jpeg', 'gif', 'png'];
    //1. strrchr renvoie l'extension avec le point (« . »).
    //2. substr(chaine,1) ignore le premier caractère de chaine.
    //3. strtolower met l'extension en minuscules.
    $extFile = strtolower(substr(strrchr($file['name'],'.'),1));
    if(in_array($extFile,$extArray)) {
        // echo "Extension correcte";
        return true;
    } else {
        echo "Extension non autorisée";
        return false;
    }
};

function resizeImage($uploadFile){
    global $file;
    $avatarMaxSize = 150;

    // Calcul des nouvelles dimensions
    list($origWidth, $origHeight) = getimagesize($uploadFile);
    $origRatio = $origWidth / $origHeight;
    $newWidth = $avatarMaxSize;
    $newHeight = $avatarMaxSize;

    if($origRatio < 1){// si l'image est plus haute que large
        $newWidth = $newHeight * $origRatio;
    } else {
        $newHeight = $newWidth * $origRatio;
    }
    // Redimensionnement
    $image_p = imagecreatetruecolor($newWidth, $newHeight);
    $image = imagecreatefromjpeg($uploadFile);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

}

