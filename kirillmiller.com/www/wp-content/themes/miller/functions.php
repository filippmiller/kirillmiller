<?php
// //Delete RSS
// function fb_disable_feed() {
// 	wp_redirect(get_option('siteurl'));
// }
//
// add_action('do_feed', 'fb_disable_feed', 1);
// add_action('do_feed_rdf', 'fb_disable_feed', 1);
// add_action('do_feed_rss', 'fb_disable_feed', 1);
// add_action('do_feed_rss2', 'fb_disable_feed', 1);
// add_action('do_feed_atom', 'fb_disable_feed', 1);
add_action('wp_enqueue_scripts', 'load_resources');
//
// remove_action('wp_head', 'feed_links_extra', 3);
// remove_action('wp_head', 'feed_links', 2);
// remove_action('wp_head', 'rsd_link');
// remove_action('wp_head', 'wp_generator');
// remove_action('wp_head', 'wlwmanifest_link');

add_theme_support('post-thumbnails');

if (function_exists('add_image_size')) {
    add_image_size('left-panel', 160, 300);
    add_image_size('record-image', 560, 368);
    add_image_size('record-image2', 400, 263);
    add_image_size('record-image3', 250, 145);
}

//Add menu support
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
}

add_theme_support( 'responsive-embeds' );

function load_resources()
{
    $theme_uri = get_template_directory_uri();

    if (!is_admin()) {
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
        wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css');
        // wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/jquery.fancybox.min.css');
        // wp_enqueue_script("jquery", array('', 'jquery'));
        // wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array(), '', true );
        wp_enqueue_script('magicimages-gallery', get_template_directory_uri() . '/js/magicimages-gallery.js', array(), '', true);
        wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array(), '', true);

        wp_enqueue_script('site', get_template_directory_uri() . '/js/site.js', array(), '', true);

    }
}

// add_action('wp_default_scripts', function ($scripts) {
//     if (!empty($scripts->registered['jquery'])) {
//         $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
//     }
// });

// Вохможность для вывода подменю отдельно
add_filter('wp_nav_menu_objects', 'submenu_limit', 10, 2);

function submenu_limit($items, $args)
{

    // Типа если нет подменю
    if (empty($args->submenu))
        return $items;


    foreach ($items as $item) {
        // Проходим по корневым записям, если не корневая не обрабатываем
        if ($item->post_parent != 0) continue;
        foreach ($item->classes as $class) {
            if (strrpos($class, 'current-') !== false) {
                $parent_id = $item->ID;
                goto next;
            }
        }
    }

    next:

    $children = submenu_get_children_ids($parent_id, $items);

    foreach ($items as $key => $item) {

        if (!in_array($item->ID, $children))
            unset($items[$key]);
    }

    return $items;
}

function submenu_get_children_ids($id, $items)
{

    $ids = wp_filter_object_list($items, array('menu_item_parent' => $id), 'and', 'ID');
    foreach ($ids as $id) {

        $ids = array_merge($ids, submenu_get_children_ids($id, $items));
    }

    return $ids;
}

$galleryID = 1;

add_filter('render_block', function ($block_content, $block) {
    if ('core/gallery' !== $block['blockName'] || !isset($block['attrs']['ids'])) {
        return $block_content;
    }

    global $galleryID;
    $res = "<div class='gallery nicegallery-block' id='nicegallery-block".$galleryID."'>";
    $imageSize = 'large';
    foreach ((array)$block['attrs']['ids'] as $id) {
        $sizes = wp_get_attachment_image_src($id, $imageSize);
        $res .= '<a href="' . wp_get_attachment_image_url($id, 'full') . '" data-fancybox="gallery' . $galleryID . '" data-caption="' . wp_get_attachment_caption($id) . '">';
        // $res .= wp_get_attachment_image($id, $imageSize, false, ['data-width' => $sizes[1], 'data-height' => $sizes[2]]);
        $res .= '<img data-width="'.$sizes[1].'" data-height="'.$sizes[2].'" src="'.wp_get_attachment_image_url($id, $imageSize).'">';
        $res .= '</a>';
    }
    $galleryID++;
    $res .= "</div>";
    return $res;
}, 10, 2);
