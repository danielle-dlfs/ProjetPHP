<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 4/03/18
 * Time: 17:32
 */

include_once 'INC/mesFonctions.inc.php';

echo monPrint_r($_FILES);


if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {

    $acceptTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if(in_array($_FILES['image']['type'], $acceptTypes)) {

        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = explode('/', $_FILES['image']['type'])[1];
        $name = $_POST['id'] . '.' . $ext;
        $path = "AVATARS/";

        // Image functions
        $redimFonction = 'imagecreatefrom' . $ext;
        $imageToFunction = 'image' . $ext;

        // Show Avatar
        if (file_exists($path . $name)) {
            $old = $redimFonction($path . $name);
            $imageToFunction($old, $path . 'oldAvatar.' . $ext);
            echo '<p>Ancien Avatar :</p><img src='. $path . 'oldAvatar.' . $ext .' >';

        } else {
            echo '<p>Ancien Avatar :</p><img src=' . $path . 'inconnu.png>';
        }


        // Definition of max size
        $avatarMaxSize = 150;

        // Get image size
        list($width_orig, $height_orig) = getimagesize($tmp_name);
        $ratio_orig = $width_orig/$height_orig;

        // Calculate ratio
        if ($ratio_orig < 1) {
            $width = $avatarMaxSize;
            $height = $avatarMaxSize*$ratio_orig;
        } else {
            $width = $avatarMaxSize*$ratio_orig;
            $height = $avatarMaxSize;
        }

        // Redimension
        $redimFonction = 'imagecreatefrom' . $ext;
        $imageToFunction = 'image' . $ext;

        $resizedImage = imagecreatetruecolor($width, $height);
        $origImage = $redimFonction($tmp_name);
        imagecopyresampled($resizedImage, $origImage, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        if ($imageToFunction($resizedImage, $path . $name)) echo '<p>Nouvel Avatar :</p><img src=' . $path . $name . '>';
        imagedestroy($origImage);

    } else {
        echo "Error: Extension non supportée !";
    }

}
