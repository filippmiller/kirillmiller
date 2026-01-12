<div id="ttr_sidebar_left_margin"> 
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<div class="ttr_sidebar_left_padding">
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
<?php if(!theme_dynamic_sidebar(1)){
global $theme_widget_args;
extract($theme_widget_args);
echo ($before_widget.$before_title.__('Search',CURRENT_THEME).$after_title);
get_search_form();
echo substr($after_widget,0,-3);
echo ($before_widget.$before_title.__('Calendar',CURRENT_THEME).$after_title);
get_calendar();
echo substr($after_widget,0,-3);
}
?>
<div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
 </div> 
</div>
