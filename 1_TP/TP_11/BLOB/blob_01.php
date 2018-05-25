<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 7/05/18
 * Time: 12:30
 */

require_once 'INC/db.inc.php';
require_once '/all/kint/kint.php';

function getProfils($id) {
    $iDB = new Db();
    $user = $iDB->call('userProfil', [$id]);
    return $user;
}

$id = 8;

d('id = ' . $id, $profiles = getProfils($id));

echo 'Liste des profils de l\'utilisateur d\'id ' . $id . '<br>';

foreach ($profiles as $prof) {
    echo '<img title="' . $prof['pAbrev'] . '" src="' . $prof['pIcon'] . '">' . $prof['pNom'] . '<br>';
}


