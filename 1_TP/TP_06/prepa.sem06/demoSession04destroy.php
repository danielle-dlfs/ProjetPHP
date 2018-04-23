<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 23-04-18
 * Time: 12:56
 */

include_once "menu.inc.php";
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
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>

</body>
</html>