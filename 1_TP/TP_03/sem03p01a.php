<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
include "../../dbConnect.inc.php";
include "mesFonctions.inc.php";

$dbname = 'minicampus';

/* syntaxe nowdoc */
$sql = <<<'SQL'
SELECT code, faculte, intitule as libelle
FROM cours INNER JOIN course_class 
    ON cours.code = course_class.cours_id 
INNER JOIN class 
    ON class.id = course_class.class_id 
WHERE class.nom='1TL2'
ORDER BY code
SQL;

try {
    $dbh = new PDO("mysql:host=". getServeur() . ";dbname=$dbname", $__INFOS__['user'],$__INFOS__['pswd']);
    //foreach($dbh->query($sql) as $row)
    foreach($dbh->query($sql,PDO::FETCH_ASSOC) as $row){
        echo monPrint_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br>";
    die();
}