<?php
function multiexplode ($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

function cap_title($title){
    $title=ucwords($title);
    return $title;
}
// function to set the original title of the site pages ---shifting to functions.php
function original_titles(){
    $home_title=get_option('ttr_seo_home_title');
    if ( is_home() && !empty($home_title)) {
        echo $home_title;
    }
    else if ( is_home() && empty($home_title)) {
        $home_title = get_option( 'blogname' ). ' | ' . get_bloginfo( 'description' ) ;
        echo $home_title;
    } else if ( is_page() || is_paged() ) {
        echo get_the_title();
    } else if ( is_single() ) {
        echo get_the_title();
    } else if ( is_category() ) {
        echo single_cat_title('', false);
    } else if ( is_post_type_archive() or is_date()) {
        echo get_the_date();
    }else if (  is_post_type_archive() or is_author()) {
        echo get_the_author();
    } else if (  is_post_type_archive() or is_tag()) {
        echo single_tag_title();
    }else if ( is_search() ) {
        echo 'Search Results For: '.get_search_query();
    }else if ( is_404() ) {
        echo 'Object Not Found !!!'. get_search_query();
    }
}
// function to set the format of the different types of site pages ---shifting to functions.php
function rewrite_titles(){
    $home_title=get_option('ttr_seo_home_title');
    if ( is_single()|| is_page() || is_paged()  || is_author() ) {
        if(get_option('ttr_seo_capitalize_titles',true)){
            add_filter('the_title','cap_title');
        }
    }
    if ( is_home() && !empty($home_title)) {
        echo $home_title;
    }
    else if ( is_home() && empty($home_title)) {
        $home_title = get_option( 'blogname' ). ' | ' . get_bloginfo( 'description' ) ;
        echo $home_title;
    }else if ( is_page() || is_paged() ) {
        $title=get_option('ttr_seo_page_title');
        switch ($title){
            case "%page_title%":echo get_the_title();break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%page_title% | %blog_title%":echo get_the_title()." - ". get_bloginfo('name');break;
            case"%blog_title% | %page_title%":echo get_bloginfo('name')." - ".get_the_title();break;
            default:echo get_the_title();
        }
    } else if ( is_single() ) {
        $posttitle=get_option('ttr_seo_post_title');
        switch ($posttitle)	{
            case "%post_title%":echo get_the_title();break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%post_title% | %blog_title%":echo get_the_title()." - ". get_bloginfo('name');break;
            case "%blog_title% | %post_title%":echo get_bloginfo('name')." - ".get_the_title();break;
            default:echo get_the_title();
        }
    } else if ( is_category() ) {
        $category=get_option('ttr_seo_category_title');
        $str = single_cat_title("", false);
        if(get_option('ttr_seo_capitalize_category',true)){
            $str= ucwords($str);
        }
        switch ($category)	{
            case "%category_title%":echo $str;break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%category_title% | %blog_title%":echo $str." - ". get_bloginfo('name');break;
            case "%blog_title% | %category_title%":echo get_bloginfo('name')." - ".$str;break;
            default:echo $str;
        }
    } else if ( is_post_type_archive() or is_date()) {
        $archive=get_option('ttr_seo_date_archive_title');
        switch ($archive){
            case "%date%":echo get_the_date();break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%date% | %blog_title%":echo get_the_date()." - ". get_bloginfo('name');break;
            case "%blog_title% | %date%":echo get_bloginfo('name')." - ".get_the_date();break;
            default:echo get_the_date();
        }
    } else if (  is_post_type_archive() or is_author()) {
        $author=get_option('ttr_seo_anchor_archive_title');
        switch ($author){
            case "%author%":echo get_the_author();break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%author% | %blog_title%":echo get_the_author()." - ". get_bloginfo('name');break;
            case "%blog_title% | %author%":echo get_bloginfo('name')." - ".get_the_author();break;
            default:echo get_the_author();
        }
    } else if (  is_post_type_archive() or is_tag()) {
        $tag=get_option('ttr_seo_tag_title');
        switch ($tag){
            case "%tag%":echo single_tag_title();break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%tag% | %blog_title%":echo single_tag_title()." - ". get_bloginfo('name');break;
            case"%blog_title% | %tag%":echo get_bloginfo('name')." - ".single_tag_title();break;
            default:echo single_tag_title();
        }
    } else if ( is_search() ) {
        $search=get_option('ttr_seo_search_title');
        switch ($search){
            case "%search%":echo 'Search Results For: '.get_search_query();break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%search% | %blog_title%":echo 'Search Results For: '.get_search_query()." - ". get_bloginfo('name');break;
            case "%blog_title% | %search%":echo get_bloginfo('name')." - ".'Search Results For: '.get_search_query();break;
            default:echo 'Search Results For: '.get_search_query();
        }
    }else if ( is_404() ) {
        $posttitle=get_option('ttr_seo_404_title');
        switch ($posttitle)	{
            case "%request_words%":echo 'Object Not Found !!!'. get_search_query();break;
            case "%blog_title%":echo get_bloginfo('name');break;
            case "%request_words% | %blog_title%":'Object Not Found !!!'.get_search_query()." - ". get_bloginfo('name');break;
            case "%blog_title% | %request_words%":echo get_bloginfo('name')." - ".'Object Not Found !!!'.get_search_query();break;
            default:echo get_search_query();
        }
    }
}
// function that collect the keywords for site ---shifting to functions.php
function get_keywords(){
    $default=get_option('ttr_seo_default_keywords');
    if(!empty($default)){$keys=$default;}
    else{$keys = "one, two, three,";}
    $home=get_option('ttr_seo_home_keywords');
    $c=get_option('ttr_seo_categories_meta_keywords',true);
    $t=get_option('ttr_seo_tags_meta_keywords',true);
    $d=get_option('ttr_seo_dynamic_keywords',true);
    $cats = get_the_category();
    $tags= get_the_tags();

    if(is_home()&& !empty($home)){
        $keywords=explode(',', $home);
        $key=array_unique( $keywords ,SORT_REGULAR);
        $words = array_slice($key,0,15);
        echo implode( ',', $words );
    }
    else{

        if($c && $t){
            if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ',';

            if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ',';
        }
        if($c){
            if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ',';
        }
        if($t){
            if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ',';
        }
        $keywords=explode(',', $keys);
        $keys=array_unique( $keywords ,SORT_REGULAR);
        $words = array_slice($keys,0,15);
        echo implode( ',', $words );
    }
}
// function that collect description for the site	 ---shifting to functions.php
function get_description(){
    $home=get_option('ttr_seo_home_desc');
    $des=get_option('blogdescription');
    $automatic=get_option('ttr_seo_autogenerate_description',true);
    if(is_home()&& !empty($home)){
        echo $home;
    }
    else if($automatic){
        echo auto_generate_description();
    }
    else{
        if ( is_single()){
            bloginfo('name');wp_title();echo (' by '.blog_desciprtion.'');
        } else if ( is_page() || is_paged()) {
            bloginfo('name');wp_title();
        } else if ( is_archive() ) {
            if ( is_category() ) {
                bloginfo('name');wp_title();echo (' Category Archive Page: '.$blog_desciprtion.'');}
            else if ( is_tag() ) {
                bloginfo('name');echo ('Tag Archives Page: '.$blog_desciprtion.'');wp_title();}
            else if ( is_date() ) {
                bloginfo('name');wp_title();echo (' Date Archive Page: '.$blog_desciprtion.'');}
            else if ( is_author() ) {
                bloginfo('name');echo (' Author Archives Page: '.$blog_desciprtion.'');wp_title();}
        } else if ( is_search() ) {
            bloginfo('name');echo (' Search Results Page: '.$blog_desciprtion.'');
        } else if ( is_404() ) {
            bloginfo('name');echo (' 404 Error (Page Not Found): '.$blog_desciprtion.'');
        }
    }
}
// automatic generate description ---shifting to functions.php
function auto_generate_description(){
    global $post;
    if ( ! is_singular() )
        return;
    $meta = strip_tags( $post->post_content );
    $meta = str_replace( array( "\\n", "\\r", "\\t" ), ' ', $meta);
    $meta = substr( $meta, 0, 125 );
    echo $meta;
}
// Generate/Update  Sitemap
function xls_sheet(){
    $xsl='<?xml version="1.0" ?>
	<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template  match="/">
	<html>
	<head>
	<title>XML Sitemap</title>
				</head>
		<body>
			<center><h2>Sitemap of Website</h2>
			<table border="1">
			<tr bgcolor="#9acd32">
			<th>Location</th>
			<th>Last Modified</th>
			<th>Change Frequency</th>
			</tr>
			<xsl:for-each select="urlset/url">
			<tr>
				<td><a><xsl:attribute name="href"><xsl:value-of select="loc"/> </xsl:attribute><xsl:value-of select="loc"/> </a></td>
				<td><xsl:value-of select="lastmod"/></td>
				<td><xsl:value-of select="changefreq"/></td>
			</tr>
			</xsl:for-each>
			</table>
			</center>
		</body>
	</html>
	</xsl:template>
	</xsl:stylesheet>';
    $fp = fopen(ABSPATH . "sitemap.xsl", 'w');
    fwrite($fp, $xsl);
    fclose($fp);
}

function create_sitemap() {
    if(get_option('ttr_seo_exclude_page',true)&& get_option('ttr_seo_exclude_post',true)&&get_option('ttr_seo_exclude_media',true)){
        $posttypes=array('page','post','attachment');
    }
    elseif(get_option('ttr_seo_exclude_page',true)&& get_option('ttr_seo_exclude_post',true)){
        $posttypes=array('page','post');}
    elseif(get_option('ttr_seo_exclude_post',true)&& get_option('ttr_seo_exclude_media',true)){
        $posttypes=array('post','attachment');	}
    elseif(get_option('ttr_seo_exclude_media',true)&& get_option('ttr_seo_exclude_page',true)){
        $posttypes=array('page','attachment');	}
    else{ 
        if(get_option('ttr_seo_exclude_page',true)){$posttypes=array('page');};
        if(get_option('ttr_seo_exclude_post',true)){$posttypes=array('post');};
        if(get_option('ttr_seo_exclude_media',true)){$posttypes=array('attachment');};
        }
$postsForSitemap = get_posts(array(
'numberposts' => -1,
'orderby' => 'modified',
'post_type'  => $posttypes,
'order'    => 'DESC'
));
xls_sheet();
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .='<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>';
    $sitemap .= '<urlset>';

    foreach($postsForSitemap as $post) {
        setup_postdata($post);

        $postdate = explode(" ", $post->post_modified);

        $sitemap .= '<url>'.
            '<loc>'. get_permalink($post->ID) .'</loc>'.
            '<lastmod>'. $postdate[0] .'</lastmod>'.
            '<changefreq>monthly</changefreq>'.
            '</url>';
    }

    $sitemap .= '</urlset>';

    $fp = fopen(ABSPATH . "sitemap.xml", 'w');
    fwrite($fp, $sitemap);
    fclose($fp);
}

?>