<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 06/03/2018
 * Time: 17:39
 */

/* 2.1 */
if(checkImage()){
    $dst_path = 'AVATARS/'.$_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $dst_path);
    echo "L'image a été correctement uploadé dans $dst_path";
}


function checkImage(){
    $file = $_FILES['file'];
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






