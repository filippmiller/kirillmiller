<?php $theme_path = get_template_directory_uri(); ?>
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
<?php $var = get_post_meta ( $post->ID, 'ttr_page_foot_checkbox', true );
if($var == "true" || $var == ""):?>
<footer id="ttr_footer">
<div id="ttr_footer_top_for_widgets">
<div class="ttr_footer_top_for_widgets_inner">
<?php get_sidebar( 'footer' ); ?>
</div>
</div>
<div class="ttr_footer_bottom_footer">
<div class="ttr_footer_bottom_footer_inner">
<?php if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):?>
<div id="ttr_footer_designed_by_links">
<a href="http://templatetoaster.com" style="color:<?php echo '#F496CB';?> !important;font-size:<?php echo get_option('ttr_font_size_designedbylink','14');?>px;">
Wordpress Theme
</a>
<span id="ttr_footer_designed_by" style="color:<?php echo '#F496CB';?>;font-size:<?php echo '14';?>px;">
<?php echo(__('Designed ART-KLINIC 2018',CURRENT_THEME));?>
</span>
</div>
<?php else: ?>
<div id="ttr_footer_designed_by_links">
<a href="http://templatetoaster.com" style="color:<?php echo get_option('ttr_designedbylink','#F496CB');?> !important;font-size:<?php echo get_option('ttr_font_size_designedbylink','14');?>px;">
Wordpress Theme
</a>
<span id="ttr_footer_designed_by" style="color:<?php echo get_option('ttr_designedby','#F496CB');?>;font-size:<?php echo get_option('ttr_font_size_designedby','14');?>px;">
<?php echo(__('Designed ART-KLINIC 2018',CURRENT_THEME));?>
</span>
</div>
<?php endif; ?>
</div>
</div>
</footer>
<?php endif; ?>
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
