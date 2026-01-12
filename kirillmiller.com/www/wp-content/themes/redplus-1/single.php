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
<nav id="nav-single">
<?php if(get_option('ttr_post_navigation_post')){?>
<h3 class="assistive-text"><?php _e( 'Post navigation', CURRENT_THEME ); ?></h3>
<?php } ?>
<?php if(get_option('ttr_previous_next_links')){?>
<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', CURRENT_THEME ) ); ?></span>
<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', CURRENT_THEME ) ); ?></span>
<?php } ?>
</nav>
<?php get_template_part( 'content', get_post_format() ); ?>
<?php comments_template( '', true ); ?>
<?php endwhile;?>
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
