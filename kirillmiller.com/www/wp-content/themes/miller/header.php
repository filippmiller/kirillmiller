<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html <?php language_attributes(); ?>>
<head>

    <link rel="icon" href="<?php bloginfo('template_url'); ?>/images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.png" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php the_title() ?></title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <?php wp_head(); ?>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

</head>
<body <?php body_class(); ?>>
<div class="container">
    <div class="row">
        <div class="col text-center header">
            <div class="miller">
                <div class="d-none d-sm-block">
                    <a href="/">
                        <img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="" class="logo">
                    </a>
                </div>
                <div class="d-block d-sm-none my-3">
                    <a href="/">
                        <img src="<?php bloginfo('template_url'); ?>/images/mobile_logo.png" alt="">
                    </a>
                </div>
            </div>
            <div class="menu-block main-menu-block mb-2">
                <ul class="menu d-none d-sm-block">
                    <?php
                    wp_nav_menu(array('menu' => 'Menu 1', 'container' => false, 'depth' => 1, 'items_wrap' => '%3$s'));
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="col py-2 sub-menu-block d-none d-sm-block">
            <?php
            // print_r(wp_get_nav_menu_items('Menu 1'));
            $subMenu = wp_nav_menu(array('menu' => 'Menu 1', 'container' => false, 'submenu' => true, 'menu_class' => 'menu', 'echo' => false));
            if ($subMenu != '') {
                ?>
                <div class="menu-block">
                    <?php echo $subMenu; ?>
                </div>
            <?php } ?>
        </div>
        <div class="col py-2 mobule-menu d-block d-sm-none">
            <div class="text-center">
                <a href="#" id="mobile-menu-button" class="text-uppercase">Меню</a>
            </div>
            <div id="mobile-menu-show" style="display: none" class="text-start">
                <?php
                wp_nav_menu(array('menu' => 'Menu 1', 'container' => false));
                ?>
            </div>
        </div>
    </div>
</div>
