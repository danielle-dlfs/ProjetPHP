<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 23-04-18
 * Time: 12:55
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
echo '<pre>' . print_r($_SESSION,1) . '</pre>';
?>
</body>
</html>