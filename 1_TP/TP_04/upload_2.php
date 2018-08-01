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
        $name = basename($_FILES['image']['name']);
        $path = "MES_IMAGES/";

        if (move_uploaded_file($tmp_name,$path . $name )) echo '<a href=' . $path . $name . '>Uploaded Image</a>';
        else echo "Failure";
    } else {
        echo "Error: Extension non supportée !";
    }

}

