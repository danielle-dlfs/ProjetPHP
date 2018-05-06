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
$sql = "select code, faculte, intitule from cours c 
        join course_class cc on c.code = cc.cours_id 
        join class cl on cc.class_id = cl.id 
        where cl.nom = ?
        order by code";

try {
    $dbh = new PDO("mysql:host=". getServeur() . ";dbname=$dbname", $__INFOS__['user'],$__INFOS__['pswd']);

    $sth = $dbh->prepare($sql);
    $sth->execute([$groupe]);
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo creeTableau($res, "avec index", true);
    $dbh = null;
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br>";
    die();
}

