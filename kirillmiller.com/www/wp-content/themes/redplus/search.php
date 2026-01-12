<?php
get_header(); ?>
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
<?php  query_posts($query_string. '&showposts='.get_option('ttr_query_result')); ?>
<?php if ( have_posts() ) : ?>
<h1>
<?php printf( __( 'Search Results for: %s', CURRENT_THEME ), '<span>' . get_search_query() . '</span>' ); ?>
</h1>
<?php twentythirteen_content_nav( 'nav-above' ); ?>
<?php if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):
$layoutoption=1;
$featuredpost=1;
else:
$layoutoption=get_option('ttr_post_layout',1);
$featuredpost=get_option('ttr_featured_post',1);
endif;?>
<?php
if($layoutoption==1)
{
while ( have_posts())
{
the_post();
get_template_part( 'content',get_post_format());
}
}
else
{
$featuredcount=1;
$columncount=0;
$lastpost=true;
$flag=true;
while( have_posts())
{
$lastpost=true;
if($featuredcount<=$featuredpost)
{
echo '<div class="row">';
echo '<div class="col-lg-12">';
the_post();
get_template_part( 'content',get_post_format());
echo '</div></div>';
$featuredcount++;
$lastpost=false;
}
else
{
if($flag){
echo '<div class=" row">';
$flag=false;}
$class_suffix_lg  = round((12/$layoutoption));
if(empty($class_suffix_lg)){ 
$class_suffix_lg  =1;
}
 $md =1;
$class_suffix_md  = round((12 / $md));
 $xs =1;
$class_suffix_xs  = round((12 / $xs));
echo '<div class="col-lg-'.$class_suffix_lg.' col-md-'.$class_suffix_md.' col-sm-'.$class_suffix_md.' col-xs-'.$class_suffix_xs.'">';
the_post();
get_template_part( 'content',get_post_format());
echo '</div>';
$columncount++;
if($columncount % $xs == 0 && $columncount != 0){ echo '<div class="clearfix visible-xs-block"></div>';}
if($columncount % $md == 0 && $columncount != 0){ echo '<div class="clearfix visible-sm-block"></div>';
echo '<div class="clearfix visible-md-block"></div>';}
if($columncount % $layoutoption == 0 && $columncount != 0){ echo '<div class="clearfix visible-lg-block"></div>';}
$lastpost=true;
}
}
echo '</div>';
}
?>
<div style="clear:both;">
<?php twentythirteen_content_nav( 'nav-below' ); ?>
</div>
<?php else : ?>
<h3 class="ttr_post_title">
<?php _e( 'Nothing Found', CURRENT_THEME ); ?></h3>
<div class="postcontent">
<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', CURRENT_THEME ); ?></p>
<?php get_search_form(); ?>
<div style="clear:both;"></div>
</div>
<?php endif; ?>
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
<?php get_footer(); ?>
