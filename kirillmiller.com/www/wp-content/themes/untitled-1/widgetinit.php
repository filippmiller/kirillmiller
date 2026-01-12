<?php
global $justify;
global $magmenu;
global $menuh;
global $vmenuh;
global $ocmenu;
$magmenu = false;
$menuh = true;
$vmenuh = false;
$justify = false;
global $cssprefix;
$cssprefix="ttr_";
global $fontSize1, $style1, $sidebarmenuheading;
$style1="";
$sidebarmenuheading = get_option('ttr_sidebarmenuheading');
$fontSize1 = get_option('ttr_font_size_sidebarmenu');
add_shortcode( 'widget', 'my_widget_shortcode' );
function my_widget_shortcode( $atts ) {
global $cssprefix;
extract( shortcode_atts(
array(
'type'  => '',
'title' => '',
'style' => '',
),
$atts));
if($style=='block'):
$args = array(
'before_widget' => '<div class="'.$cssprefix.'block"><div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>',
'after_widget'  => '</div>',
'before_title'  => '<div class="'.$cssprefix.'block_header"><h3 style="color:#FFFFFF;font-size:16px;margin: 0 5px;"class="'.$cssprefix.'block_heading">',
'after_title'   => '</h3></div>',
);
else:
$args = array(
'before_widget' => '<div class="box widget">',
'after_widget'  => '</div>',
'before_title'  => '<div class="widget-title">',
'after_title'   => '</div>',
);
endif;
the_widget( $type, $atts, $args );
}
add_action('wp_enqueue_scripts', 'my_scripts_method');
function my_scripts_method() {
wp_enqueue_script('jquery');
if(get_option('ttr_back_to_top',true)): 
wp_enqueue_script('totop', get_template_directory_uri() . '/js/totop.js', array(), '1.0', true);
endif;
}
function twentythirteen_widgets_init() {
global $cssprefix;
$cssprefix="ttr_";
global $theme_widget_args;
global $fontSize, $style;
$style="";
  $blockheading = get_option('ttr_blockheading');
  $fontSize = get_option('ttr_font_size_block');
 if(!empty($blockheading)){
 $style .= "color:".$blockheading.";";
 }
 if(!empty($fontSize)){
 $style .= "font-size:".$fontSize."px;";
 }
if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):
$theme_widget_args = array('before_widget' => '<div class="'.$cssprefix.'block"><div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div> <div class="'.$cssprefix.'block_header">',
'after_widget' => '</div></div>~tt',
'before_title' => '<h3 style="'.$style.'" class="'.$cssprefix.'block_heading">
',
'after_title' => '</h3></div> <div id="%1$s" class="'.$cssprefix.'block_content">',
);
else:
$theme_widget_args = array('before_widget' => '<div class="'.$cssprefix.'block"><div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div> <div class="'.$cssprefix.'block_header">',
'after_widget' => '</div></div>~tt',
'before_title' => '<'.get_option('ttr_heading_tag_block','h3').' style="'.$style.'" class="'.$cssprefix.'block_heading">
',
'after_title' => '</'.get_option('ttr_heading_tag_block','h3').'></div> <div id="%1$s" class="'.$cssprefix.'block_content">',
);
endif;
extract($theme_widget_args);
register_sidebar( array(
'name' => __( 'CAWidgetArea00', CURRENT_THEME ),
'id' => 'contenttopcolumn1',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CAWidgetArea01', CURRENT_THEME ),
'id' => 'contenttopcolumn2',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CAWidgetArea02', CURRENT_THEME ),
'id' => 'contenttopcolumn3',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CAWidgetArea03', CURRENT_THEME ),
'id' => 'contenttopcolumn4',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea00', CURRENT_THEME ),
'id' => 'headerabovecolumn1',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea01', CURRENT_THEME ),
'id' => 'headerabovecolumn2',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea02', CURRENT_THEME ),
'id' => 'headerabovecolumn3',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea03', CURRENT_THEME ),
'id' => 'headerabovecolumn4',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea00', CURRENT_THEME ),
'id' => 'headerbelowcolumn1',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea01', CURRENT_THEME ),
'id' => 'headerbelowcolumn2',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea02', CURRENT_THEME ),
'id' => 'headerbelowcolumn3',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea03', CURRENT_THEME ),
'id' => 'headerbelowcolumn4',
'description' => __( 'An optional widget area for your site header', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea00', CURRENT_THEME ),
'id' => 'menuabovecolumn1',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea01', CURRENT_THEME ),
'id' => 'menuabovecolumn2',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea02', CURRENT_THEME ),
'id' => 'menuabovecolumn3',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea03', CURRENT_THEME ),
'id' => 'menuabovecolumn4',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea00', CURRENT_THEME ),
'id' => 'menubelowcolumn1',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea01', CURRENT_THEME ),
'id' => 'menubelowcolumn2',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea02', CURRENT_THEME ),
'id' => 'menubelowcolumn3',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea03', CURRENT_THEME ),
'id' => 'menubelowcolumn4',
'description' => __( 'An optional widget area for your site menu', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea00', CURRENT_THEME ),
'id' => 'contentbottomcolumn1',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea01', CURRENT_THEME ),
'id' => 'contentbottomcolumn2',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea02', CURRENT_THEME ),
'id' => 'contentbottomcolumn3',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea03', CURRENT_THEME ),
'id' => 'contentbottomcolumn4',
'description' => __( 'An optional widget area for your site content', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea00', CURRENT_THEME ),
'id' => 'footerabovecolumn1',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea01', CURRENT_THEME ),
'id' => 'footerabovecolumn2',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea02', CURRENT_THEME ),
'id' => 'footerabovecolumn3',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea03', CURRENT_THEME ),
'id' => 'footerabovecolumn4',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea00', CURRENT_THEME ),
'id' => 'footerbelowcolumn1',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea01', CURRENT_THEME ),
'id' => 'footerbelowcolumn2',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea02', CURRENT_THEME ),
'id' => 'footerbelowcolumn3',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea03', CURRENT_THEME ),
'id' => 'footerbelowcolumn4',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'first-footer-widget-area', CURRENT_THEME ),
'id' => 'first-footer-widget-area',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'second-footer-widget-area', CURRENT_THEME ),
'id' => 'second-footer-widget-area',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'third-footer-widget-area', CURRENT_THEME ),
'id' => 'third-footer-widget-area',
'description' => __( 'An optional widget area for your site footer', CURRENT_THEME ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'widgets_init', 'twentythirteen_widgets_init' );?>