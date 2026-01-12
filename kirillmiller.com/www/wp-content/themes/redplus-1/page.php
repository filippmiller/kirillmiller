<?php get_header(); ?>
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
<?php get_footer(); ?>
