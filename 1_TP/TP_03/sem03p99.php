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
require_once "INC/dbConnect.inc.php";
require_once "INC/mesFonctions.inc.php";
try {
    $dbh = new PDO("mysql:host=". getServeur() . ";dbname=$dbname", $__INFOS__['user'],$__INFOS__['pswd']);
    $sql = <<<EOD
    call 1718he201440.mc_group(?);
EOD;
    $_oh__oh___oh = '';
    $sth = $dbh->prepare($sql);
    $sth->execute([$groupe]);
    $infos = $sth->fetchAll(PDO::FETCH_ASSOC);
    if ($infos) {
        $sql = <<<'EOD'
        call 1718he201440.mc_coursesGroup(?);
EOD;
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