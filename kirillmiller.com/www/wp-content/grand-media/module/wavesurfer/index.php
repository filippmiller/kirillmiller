<?php
$module_info = array(
    'base'         => 'wavesurfer',
    'name'         => 'wavesurfer',
    'title'        => 'WaveSurfer',
    'version'      => '1.8',
    'author'       => 'Rattus',
    'description'  => 'Music Player with waveform. Support music covers, albums, tags, categories, likes & plays counters, comments. Additional buttons: share, download, custom link button. Global Player controls for playlist with volume contol and repeat track switcher.',
    'type'         => 'gallery',
    'branch'       => '1',
    'status'       => 'premium',
    'price'        => '$15',
    'demo'         => 'http://codeasily.com/portfolio/gmedia-gallery-modules/wavesurfer/',
    'download'     => 'http://codeasily.com/download/wavesurfer-module-zip/',
    'dependencies' => 'wavesurfer'
);
if (preg_match('#' . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
    if (isset($_GET['info'])) {
        echo '<pre>' . print_r($module_info, true) . '</pre>';
    } else {
        header("Location: {$module_info['demo']}");
        die();
    }
}