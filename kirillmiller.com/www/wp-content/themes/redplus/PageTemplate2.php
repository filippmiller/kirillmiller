<?php
/**
* Template Name:PageTemplate2
*/
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<?php $seomode = get_option('ttr_seo_enable');
if($seomode=='on'){
?>
<title>
<?php
if(get_option('ttr_seo_rewrite_titles', true)){rewrite_titles();}
else {original_titles();}
?>
</title>
<?php wp_head(); ?>
<meta name="viewport" content="width=device-width">
<meta name="keywords" content="<?php if(get_option('ttr_seo_use_keywords',true)){get_keywords();}?>"/>
<meta name="description" content="<?php get_description();?>"/>
<?php
}
else{
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
<meta name="viewport" content="width=device-width">
<meta name="description" content="Add the site description here">
<meta  name="keywords" content="First keyword, second keyword,">
<?php }
?>
<?php $theme_path = get_template_directory_uri(); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
 jQuery("#wp-submit").addClass(" btn btn-default");
 });
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
var inputs = document.getElementsByTagName('input');
for (a = 0; a < inputs.length; a++) {
if (inputs[a].type == "checkbox") {
var id = inputs[a].getAttribute("id");
if (id==null){
id=  "checkbox" +a;
}
inputs[a].setAttribute("id",id);
var container = document.createElement('div');
container.setAttribute("class", "ttr_checkbox");
var label = document.createElement('label');
label.setAttribute("for", id);
jQuery(inputs[a]).wrap(container).after(label);
}
}
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
var inputs = document.getElementsByTagName('input');
for (a = 0; a < inputs.length; a++) {
if (inputs[a].type == "radio") {
var id = inputs[a].getAttribute("id");
if (id==null){
id=  "radio" +a;
}
inputs[a].setAttribute("id",id);
var container = document.createElement('div');
container.setAttribute("class", "ttr_radio");
var label = document.createElement('label');
label.setAttribute("for", id);
jQuery(inputs[a]).wrap(container).after(label);
}
}
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
var window_height =  Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
var body_height = jQuery(document.body).height();
var content = jQuery("#ttr_content_and_sidebar_container");
if(body_height < window_height){
differ = (window_height - body_height);
content_height = content.height() + differ;
jQuery("#ttr_content_and_sidebar_container").css("min-height", content_height+"px");
}
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('#nav-expander').on('click',function(e){
e.preventDefault();
jQuery('body').toggleClass('nav-expanded');
});
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('ul.ttr_vmenu_items.nav li [data-toggle=dropdown]').on('click', function() {
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
if(window_width > 1025){
window.location.href = jQuery(this).attr('href'); 
}
});
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('.ttr_menu_items ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) { 
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
event.preventDefault();
event.stopPropagation();
jQuery(this).parent().siblings().removeClass('open');
jQuery(this).parent().toggleClass(function() {
if (jQuery(this).is(".open") ) {
window.location.href = jQuery(this).children("[data-toggle=dropdown]").attr('href'); 
return "";
} else {
return "open";
}
});
});
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('.ttr_vmenu_items ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) { 
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
if(window_width < 1025){
event.preventDefault();
event.stopPropagation();
jQuery(this).parent().siblings().removeClass('open');
jQuery(this).parent().toggleClass(function() {
if (jQuery(this).is(".open") ) {
window.location.href = jQuery(this).children("[data-toggle=dropdown]").attr('href'); 
return "";
} else {
return "open";
}
});
}
});
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
var objects = ['iframe', 'video','object'];
for(var i = 0 ; i < objects.length ; i++){
if (jQuery(objects[i]).length > 0) {
jQuery(objects[i]).addClass('embed-responsive-item');
jQuery(objects[i]).parent().addClass('embed-responsive embed-responsive-16by9');
jQuery(".embed-responsive-16by9").css("padding-bottom","56.25%");
}
}
});
</script>
<script type="text/javascript">
WebFontConfig = {
google: { families: [ 'Marmelad'] }
};
(function() {
var wf = document.createElement('script');
wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1.0.31/webfont.js';
wf.type = 'text/javascript';
wf.async = 'true';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(wf, s);
})();
</script>
<?php global $mhicon;
$mhicon = false;
$seomode = get_option('ttr_seo_enable');
 if($seomode=="on" ){
$google_webmaster= get_option('ttr_seo_google_webmaster');
$bing_webmaster= get_option('ttr_seo_bing_webmaster');
$pinterst_webmaster=get_option('ttr_seo_pinterst_webmaster');
if(!empty($google_webmaster))
echo sprintf("<meta name=\"google-site-verification\" content=\"%s\"/>\n", $google_webmaster);
if(!empty($bing_webmaster))
echo sprintf("<meta name=\"msvalidate.01\" content=\"%s\"/>\n", $bing_webmaster);
if(!empty($pinterst_webmaster))
echo sprintf("<meta name=\"p:domain_verify\" content=\"%s\"/>\n", $pinterst_webmaster);
if ((is_page() || is_single()) ) {
$profile=get_option('ttr_seo_google_plus');
if(!empty($profile)){echo '<link href="' . $profile. '" rel="author"/>';}
else{ $profile=get_option('googleplus');echo '<link href="' . $profile. '" rel="author" />';}
}
if(get_option('ttr_seo_canonical_urls',true)) {
if ( is_singular() ) echo '<link rel="canonical" href="' . get_permalink() . '" />';
}
$blog_title=get_option('blogname');
$blog_desciprtion= get_option('blogdescription');
$theme_path = get_template_directory_uri();
if(is_single()) {
if (get_option('ttr_seo_nonindex_post',true)){	$noindex = "noindex";}
else{$noindex = "index";}
if (get_option('ttr_seo_nofollow_post',true)){$nofollow = "nofollow";}
else{$nofollow = "follow";}
echo sprintf("<!--Add by easy-noindex-nofollow--><meta name=\"robots\" content=\"%s, %s\"/>\n", $noindex, $nofollow);}
else if(is_attachment()) {
if (get_option('ttr_seo_nonindex_media',true)){	$noindex = "noindex";}
else{$noindex = "index";}
if (get_option('ttr_seo_nofollow_media',true)){$nofollow = "nofollow";}
else{$nofollow = "follow";}
echo sprintf("<!--Add by easy-noindex-nofollow--><meta name=\"robots\" content=\"%s, %s\"/>\n", $noindex, $nofollow);}
else if(is_home() || is_page() || is_paged()){
if (get_option('ttr_seo_nonindex_page',true)){	$noindex = "noindex";}
else{$noindex = "index";}
if (get_option('ttr_seo_nofollow_page',true)){$nofollow = "nofollow";}
else{$nofollow = "follow";}
echo sprintf("<!--Add by easy-noindex-nofollow--><meta name=\"robots\" content=\"%s, %s\"/>\n", $noindex, $nofollow);}
else if(is_date()){
if (get_option('ttr_seo_noindex_date_archive',true)){	$noindex = "noindex";}
else{$noindex = "index";}
echo sprintf("<!--Add by easy-noindex--><meta name=\"robots\" content=\"%s\"/>\n", $noindex);}
else if(is_author() ){
if (get_option('ttr_seo_noindex_author_archive',true)){	$noindex = "noindex";}
else{$noindex = "index";}
echo sprintf("<!--Add by easy-noindex--><meta name=\"robots\" content=\"s\"/>\n", $noindex);}
else if(is_tag() ){
if (get_option('ttr_seo_noindex_tag_archive',true)){	$noindex = "noindex";}
else{$noindex = "index";}
echo sprintf("<!--Add by easy-noindex--><meta name=\"robots\" content=\"%s\"/>\n", $noindex);}
?>
<?php if(is_search()){
if (get_option('ttr_seo_noindex_search',true)){	$noindex = "noindex";}
else{$noindex = "index";}
if (get_option('ttr_seo_nofollow_search',true)){$nofollow = "nofollow";}
else{$nofollow = "follow";}
echo sprintf("<!--Add by easy-noindex-nofollow--><meta name=\"robots\" content=\"%s, %s\"/>\n", $noindex, $nofollow);}
if(is_category()){
if (get_option('ttr_seo_noindex_categories',true)){	$noindex = "noindex";}
else{$noindex = "index";}
if (get_option('ttr_seo_nofollow_categories',true)){$nofollow = "nofollow";}
else{$nofollow = "follow";}
echo sprintf("<!--Add by easy-noindex-nofollow--><meta name=\"robots\" content=\"%s, %s\"/>\n", $noindex, $nofollow);}
$home_header= get_option('ttr_seo_additional_fpage_header');
$page_header= get_option('ttr_seo_additional_post_header');
$post_header= get_option('ttr_seo_additional_page_header');
if(is_home()&& !empty($home_header)){echo '<center><h1>'.$home_header.'</h1></center>';}
else if(is_single()&& !empty($page_header)){echo '<center><h1>'.$page_header.'</h1></center>';}
else if(is_page()&& !empty($post_header)){echo '<center><h1>'.$post_header.'</h1></center>';}
}?>
<link rel="stylesheet"  href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen"/>
<!--[if lte IE 8]>
<link rel="stylesheet"  href="<?php echo get_template_directory_uri() ?>/menuie.css" type="text/css" media="screen"/>
<link rel="stylesheet"  href="<?php echo get_template_directory_uri() ?>/vmenuie.css" type="text/css" media="screen"/>
<![endif]-->
<script type="text/javascript" src="<?php echo $theme_path?>/js/prefixfree.min.js">
</script>
<!--[if IE 7]>
<style type="text/css" media="screen">
#ttr_vmenu_items  li.ttr_vmenu_items_parent {display:inline;}
</style>
<![endif]-->
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo $theme_path?>/js/html5shiv.js">
</script>
<script type="text/javascript" src="<?php echo $theme_path?>/js/respond.min.js">
</script>
<![endif]-->
</head>
<body class="PageTemplate2" <?php body_class(); ?>>
<?php if(get_option('ttr_back_to_top')): ?>
<a href="#" class="back-to-top"><input type="image" alt="Back to Top" src="<?php echo get_option('ttr_icon_back_to_top');?>"/></a>
<?php endif; ?>
<div class="ttr_banner_header">
<?php
if( is_active_sidebar( 'headerabovecolumn1'  ) || is_active_sidebar( 'headerabovecolumn2'  ) || is_active_sidebar( 'headerabovecolumn3'  ) || is_active_sidebar( 'headerabovecolumn4'  )):
?>
<div class="ttr_banner_header_inner_above0">
<?php if ( is_active_sidebar('headerabovecolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn1">
<?php theme_dynamic_sidebar( 'HAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('headerabovecolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn2">
<?php theme_dynamic_sidebar( 'HAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('headerabovecolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn3">
<?php theme_dynamic_sidebar( 'HAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('headerabovecolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn4">
<?php theme_dynamic_sidebar( 'HAWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
</div>
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<?php	$var = get_post_meta ( $post->ID, 'ttr_page_head_checkbox', true );
if ($var == "true" || $var == ""):?>
<header id="ttr_header">
<div id="ttr_header_inner">
</div>
</header>
<?php endif; ?>
<div class="ttr_banner_header">
<?php
if( is_active_sidebar( 'headerbelowcolumn1'  ) || is_active_sidebar( 'headerbelowcolumn2'  ) || is_active_sidebar( 'headerbelowcolumn3'  ) || is_active_sidebar( 'headerbelowcolumn4'  )):
?>
<div class="ttr_banner_header_inner_below0">
<?php if ( is_active_sidebar('headerbelowcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn1">
<?php theme_dynamic_sidebar( 'HBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('headerbelowcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn2">
<?php theme_dynamic_sidebar( 'HBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('headerbelowcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn3">
<?php theme_dynamic_sidebar( 'HBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('headerbelowcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn4">
<?php theme_dynamic_sidebar( 'HBWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
</div>
<div id="ttr_page" class="container">
<div class="ttr_banner_menu">
<?php
if( is_active_sidebar( 'menuabovecolumn1'  ) || is_active_sidebar( 'menuabovecolumn2'  ) || is_active_sidebar( 'menuabovecolumn3'  ) || is_active_sidebar( 'menuabovecolumn4'  )):
?>
<div class="ttr_banner_menu_inner_above0">
<?php if ( is_active_sidebar('menuabovecolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn1">
<?php theme_dynamic_sidebar( 'MAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('menuabovecolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn2">
<?php theme_dynamic_sidebar( 'MAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('menuabovecolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn3">
<?php theme_dynamic_sidebar( 'MAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('menuabovecolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn4">
<?php theme_dynamic_sidebar( 'MAWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
</div>
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<nav id="ttr_menu" class="navbar-default navbar">
   <div id="ttr_menu_inner_in">
<div class="menuforeground">
</div>
<div id="navigationmenu">
<div class="navbar-header">
<button id="nav-expander" data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
<span class="sr-only">
</span>
<span class="icon-bar">
</span>
<span class="icon-bar">
</span>
<span class="icon-bar">
</span>
</button>
<img src="<?php echo get_template_directory_uri().'/menulogo.png'; ?>" class="ttr_menu_logo" alt="Menulogo" />
</div>
<div class="menu-center collapse navbar-collapse">
<ul class="ttr_menu_items nav navbar-nav nav-center">
<?php echo theme_nav_menu('ttr_','primary','menu',False,False,False,True);?>
</ul>
</div>
</div>
</div>
</nav>
<div class="ttr_banner_menu">
<?php
if( is_active_sidebar( 'menubelowcolumn1'  ) || is_active_sidebar( 'menubelowcolumn2'  ) || is_active_sidebar( 'menubelowcolumn3'  ) || is_active_sidebar( 'menubelowcolumn4'  )):
?>
<div class="ttr_banner_menu_inner_below0">
<?php if ( is_active_sidebar('menubelowcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn1">
<?php theme_dynamic_sidebar( 'MBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('menubelowcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn2">
<?php theme_dynamic_sidebar( 'MBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('menubelowcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn3">
<?php theme_dynamic_sidebar( 'MBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('menubelowcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn4">
<?php theme_dynamic_sidebar( 'MBWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
</div>
<div id="ttr_content_and_sidebar_container">
<div id="ttr_content">
<div id="ttr_content_margin">
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<?php if (get_option("ttr_page_breadcrumb",true)):?>
<?php wordpress_breadcrumbs(); ?>
<?php endif; ?>
<?php
if( is_active_sidebar( 'contenttopcolumn1'  ) || is_active_sidebar( 'contenttopcolumn2'  ) || is_active_sidebar( 'contenttopcolumn3'  ) || is_active_sidebar( 'contenttopcolumn4'  )):
?>
<div class="contenttopcolumn0">
<?php if ( is_active_sidebar('contenttopcolumn1') ) : ?>
<div class="cell1 col-lg-12 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn1">
<?php theme_dynamic_sidebar( 'CAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-12 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('contenttopcolumn2') ) : ?>
<div class="cell2 col-lg-12 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn2">
<?php theme_dynamic_sidebar( 'CAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-12 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('contenttopcolumn3') ) : ?>
<div class="cell3 col-lg-12 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn3">
<?php theme_dynamic_sidebar( 'CAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-12 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('contenttopcolumn4') ) : ?>
<div class="cell4 col-lg-12 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn4">
<?php theme_dynamic_sidebar( 'CAWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-12 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content', 'page' ); ?>
<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>
<?php
if( is_active_sidebar( 'contentbottomcolumn1'  ) || is_active_sidebar( 'contentbottomcolumn2'  ) || is_active_sidebar( 'contentbottomcolumn3'  ) || is_active_sidebar( 'contentbottomcolumn4'  )):
?>
<div class="contentbottomcolumn0">
<?php if ( is_active_sidebar('contentbottomcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn1">
<?php theme_dynamic_sidebar( 'CBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('contentbottomcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn2">
<?php theme_dynamic_sidebar( 'CBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('contentbottomcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn3">
<?php theme_dynamic_sidebar( 'CBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('contentbottomcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn4">
<?php theme_dynamic_sidebar( 'CBWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
</div>
</div>
<div style="clear:both;">
</div>
</div>
<div class="footer-widget-area" role="complementary">
<div class="footer-widget-area_inner">
<?php
if( is_active_sidebar( 'footerabovecolumn1'  ) || is_active_sidebar( 'footerabovecolumn2'  ) || is_active_sidebar( 'footerabovecolumn3'  ) || is_active_sidebar( 'footerabovecolumn4'  )):
?>
<div class="ttr_footer-widget-area_inner_above0">
<?php if ( is_active_sidebar('footerabovecolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn1">
<?php theme_dynamic_sidebar( 'FAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('footerabovecolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn2">
<?php theme_dynamic_sidebar( 'FAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('footerabovecolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn3">
<?php theme_dynamic_sidebar( 'FAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('footerabovecolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn4">
<?php theme_dynamic_sidebar( 'FAWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
</div>
</div>
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<footer id="ttr_footer">
<div id="ttr_footer_top_for_widgets">
<div class="ttr_footer_top_for_widgets_inner">
<?php get_sidebar( 'footer' ); ?>
</div>
</div>
<div class="ttr_footer_bottom_footer">
<div class="ttr_footer_bottom_footer_inner">
<div id="ttr_footer_designed_by_links">
<a href="http://templatetoaster.com" style="color:<?php echo get_option('ttr_designedbylink');?> !important;font-size:<?php echo get_option('ttr_font_size_designedbylink');?>px;">
Wordpress Theme
</a>
<span id="ttr_footer_designed_by" style="color:<?php echo get_option('ttr_designedby');?>;font-size:<?php echo get_option('ttr_font_size_designedby');?>px;">
<?php echo(__('Designed ART-KLINIC 2018',CURRENT_THEME));?>
</span>
</div>
</div>
</footer>
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<div class="footer-widget-area" role="complementary">
<div class="footer-widget-area_inner">
<?php
if( is_active_sidebar( 'footerbelowcolumn1'  ) || is_active_sidebar( 'footerbelowcolumn2'  ) || is_active_sidebar( 'footerbelowcolumn3'  ) || is_active_sidebar( 'footerbelowcolumn4'  )):
?>
<div class="ttr_footer-widget-area_inner_below0">
<?php if ( is_active_sidebar('footerbelowcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn1">
<?php theme_dynamic_sidebar( 'FBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('footerbelowcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn2">
<?php theme_dynamic_sidebar( 'FBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-sm-block visible-md-block visible-xs-block">
</div>
<?php if ( is_active_sidebar('footerbelowcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn3">
<?php theme_dynamic_sidebar( 'FBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-xs-block">
</div>
<?php if ( is_active_sidebar('footerbelowcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn4">
<?php theme_dynamic_sidebar( 'FBWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12"  style="background-color:transparent;">
&nbsp;
</div>
<?php endif; ?>
<div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
</div>
</div>
<?php endif; ?>
</div>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
