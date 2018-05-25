<?php
/**
 * Created by PhpStorm.
 * User: he201440
 * Date: 19/02/2018
 * Time: 11:32
 */

if (count(get_included_files()) == 1) die("--access denied--");

function monPrint_r($tab) {
    return '<pre>' . print_r($tab, true) . '</pre>';
}