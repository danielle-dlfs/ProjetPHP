<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

function scriptInfos($param = 'new'){
    $param = strtolower($param);
	static $array;

    switch($param) {
        case 'new':
            $url = pathinfo($_SERVER['URL']);
			$array = array(
				'protocol' => $_SERVER['SERVER_PORT_SECURE'] . ' - ' . isset($_SERVER['HTTPS']) ? "https" : "http",
                'port' => $_SERVER['SERVER_PORT'],
                'dns' => $_SERVER['SERVER_NAME'],
                'path' => $url['dirname'],
                'name' => $url['basename'],
                'short' => $url['filename'],
                'ext' => $url['extension'],
                'isportdef' => $_SERVER['SERVER_PORT_SECURE']
			);
            break;

        case 'Empty':
			$array = null;
            echo 'Empty';
            break;

        case 'all':
            echo 'all';
			if ($array == null || !is_array($array)) $array = scriptInfos();
            break;

        case 'full':
            echo 'full';
			$array = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];            
            break;

        case 'root':
            echo 'root';
			$array = $_SERVER['URL'];
            break;

		case in_array($param, array_keys(scriptInfos())):
            $array = $aarray[$param];
            break;

		default : 
			$array = 'Error in ' . __FUNCTION__ . ' on line ' . __LINE__ . ' : param�tre inconnu (' . $param . ')';
            break;
    }

	return $array; 
}

function creeTableau($uneListe, $titre = '', $index = false){
	$out = '<table><caption>'. $titre .'</caption>';
    $out .= '<tr>';
    $keys = array_keys($uneListe[array_keys($uneListe)[0]]);
    if ($index) $out .= '<th>index</th>';
    foreach ($keys as $k) {
        $out .= '<th>' . $k . '</th>';
    }
    $out .= '</tr>';
    foreach ($uneListe as $x => $x_value) {
        $out .= '<tr>';
        if ($index) $out .= '<td>' . $x . '</td>';
        foreach ($x_value as $y => $y_value) {
            $out .= '<td>' . $y_value . '</td>';
        }
        $out .= '</tr>';
    }
    $out .= '</table>';
    return $out;
}

function monPrint_r($liste){
    $out = '<pre>';
    $out .= print_r($liste, true);
    $out .= '</pre>';
    return $out;
}