<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 23-04-18
 * Time: 12:54
 */

// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="demoSession.css"/>
</head>
<body>
<?php
include "menu.inc.php";

// Set session variables
$_SESSION["startTime"] = date('l jS \of F Y h:i:s A');
// demandé mais pas fait : format pour le temps : 2016 Mar 02 17h42'13'' // Année Mois Jour Heure Minute Seconde
//$_SESSION["lastVisit"] = ;
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
?>

</body>
</html>