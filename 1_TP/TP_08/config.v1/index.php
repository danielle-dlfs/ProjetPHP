<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 * Date: 21-05-18
 * Time: 19:31
 */

require_once "useConfig.php";

$config = chargeConfig("config.ini");
echo afficheConfig($config);