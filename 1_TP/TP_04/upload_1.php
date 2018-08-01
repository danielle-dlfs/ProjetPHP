<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 4/03/18
 * Time: 17:32
 */

include_once 'INC/mesFonctions.inc.php';

echo monPrint_r($_FILES);

if ($_FILES['fichier']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['fichier']['tmp_name'];
    $name = basename($_FILES['fichier']['name']);
    $path = "DOCUMENTS/";

    if (move_uploaded_file($tmp_name,$path . $name )) echo '<a href=' . $path . $name . '>Uploaded Image</a>';
    else echo "Failure";
}

