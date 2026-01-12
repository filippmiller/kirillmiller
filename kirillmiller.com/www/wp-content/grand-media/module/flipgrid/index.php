<?php
$module_info = array(
    'base'         => 'flipgrid',
    'name'         => 'flipgrid',
    'title'        => 'FlipGrid',
    'version'      => '1.4',
    'author'       => 'GalleryCreator',
    'description'  => 'Responsive AJAX Grid Gallery. The gallery is completely customisable, resizable and is compatible with all browsers and devices (iPhone, iPad and Android smartphones). Required Gmedia Gallery plugin v1.9.9+',
    'type'         => 'gallery',
    'widget'       => true,
    'branch'       => '1',
    'status'       => 'free',
    'price'        => '',
    'demo'         => 'https://codeasily.com/portfolio/gmedia-gallery-modules/flipgrid/',
    'download'     => 'http://codeasily.com/download/flipgrid-module-zip/',
    'dependencies' => ''
);
if (preg_match('#' . basename(dirname(__FILE__)) . '/' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
    if (isset($_GET['info'])) {
        echo '<pre>' . print_r($module_info, true) . '</pre>';
    } else {
        header("Location: {$module_info['demo']}");
        die();
    }
}