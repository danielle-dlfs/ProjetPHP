<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */
$groupe = !empty($_GET['groupe']) ? $_GET['groupe'] : '';
?>
    <form method="get" action="">
        <input type="text" name="groupe" placeholder="groupe recherché" value="<?= $groupe ?>">
        <input type="submit" value="envoi">
    </form>
<?php
if (!isset($_GET['groupe']) || $_GET['groupe'] == "") die();
require_once "dbConnect.inc.php";
require_once "mesFonctions.inc.php";
try {
    $dbName = 'minicampus';
    $dbh = new PDO("mysql:host=". getServeur() . ";dbname=$dbname", $__INFOS__['user'],$__INFOS__['pswd']);
    $sql = "SELECT c.id, cp.nom as parentName FROM class c
        JOIN class cp on c.parent_id = cp.id
        WHERE c.nom = ?";
    $_oh__oh___oh = '';
    $sth = $dbh->prepare($sql);
    $sth->execute([$groupe]);
    $infos = $sth->fetchAll(PDO::FETCH_ASSOC);
    if ($infos) {
        $sql = "SELECT code, faculte, intitule FROM cours c 
        JOIN course_class cc ON c.code = cc.cours_id 
        JOIN class cl ON cc.class_id = cl.id 
        WHERE cl.nom = ?
        ORDER BY code";
        $sth = $dbh->prepare($sql);
        $sth->execute([$groupe]);
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        $_oh__oh___oh .= 'Groupe : ' . $groupe . '<br>';
        $_oh__oh___oh .= 'Nom du parent : ' . $infos[0]['parentName'] . '<br>';
        if ($res) $_oh__oh___oh .= creeTableau($res, "avec index", true);
        else $_oh__oh___oh .= 'Aucun cours n\'est rattaché à ce groupe !';
        $dbh = null;
    } else {
        $_oh__oh___oh .= 'Ce groupe n\'existe pas';
        $dbh = null;
    }
    echo $_oh__oh___oh;
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br>";
    die();
}

