<div id="ttr_sidebar_right_margin"> 
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<div class="ttr_sidebar_right_padding"> 
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<?php if(!theme_dynamic_sidebar(2)){
global $theme_widget_args;
extract($theme_widget_args);
echo ($before_widget.$before_title.__('Category',CURRENT_THEME).$after_title); ?>
<ul>
<?php wp_list_categories(); ?>
</ul>
<?php echo substr($after_widget,0,-3); ?>
<?php echo ($before_widget.$before_title.__('Archive',CURRENT_THEME).$after_title); ?>
<ul>
<?php wp_get_archives(); ?>
</ul>
<?php echo substr($after_widget,0,-3);
}
?>
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
</div>
</div>
