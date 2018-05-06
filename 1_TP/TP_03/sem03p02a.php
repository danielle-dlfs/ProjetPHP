<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
include "../../dbConnect.inc.php";
include "mesFonctions.inc.php";

$dbname = 'minicampus';
$groupe = !empty($_GET['groupe']) ? $_GET['groupe'] : '1TL2';
// NB:  la syntaxe nowdoc ne peut pas fonctionner avec une variable php
$sql = "SELECT code, faculte, intitule as libelle
FROM cours INNER JOIN course_class 
    ON cours.code = course_class.cours_id 
INNER JOIN class 
    ON class.id = course_class.class_id 
WHERE class.nom='{$groupe}'
ORDER BY code";

try {
    $dbh = new PDO("mysql:host=". getServeur() . ";dbname=$dbname", $__INFOS__['user'],$__INFOS__['pswd']);
    $result = $dbh->query($sql,PDO::FETCH_ASSOC)->fetchAll();
    echo creeTableau($result,'sans index');
    echo creeTableau($result,'avec index',true);
    $dbh = null;
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br>";
    die();
}

