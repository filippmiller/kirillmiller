<?php
class Custom_Menu extends WP_Widget {

    function Custom_Menu() {//settings for widget
        $widget_ops = array( 'description' => __('Use this widget to add one of your custom menus as a widget.',CURRENT_THEME) );
        parent::WP_Widget( 'nav_menu', __('Custom Menu',CURRENT_THEME), $widget_ops );
    }

    function widget($args, $instance){
        //dislpay the widget
        // Get menu
        global $cssprefix;
        global $magmenu,$menuh,$vmenuh,$ocmenu,$mhicon;

        global $fontSize1, $style1, $sidebarmenuheading;
        $style1="";
        $sidebarmenuheading = get_option('ttr_sidebarmenuheading');
        $fontSize1 = get_option('ttr_font_size_sidebarmenu');
        if(!empty($sidebarmenuheading)){
            $style1 .= "color:".$sidebarmenuheading.";";
        }
        if(!empty($fontSize1)){
            $style1 .= "font-size:".$fontSize1."px;";
        }

        $nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );
        $alignment=$instance['alignment'];
        $style=$instance['style'];
        $menustyle=$instance['menustyle'];

        if ( !$nav_menu )
            return;

        if($style == 'block')
        {
            echo  '<div class="'.$cssprefix.'verticalmenu"><div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>';
            if ( !empty($instance['title']) )
            {
                if($mhicon)
                {
                    echo '<div class="'.$cssprefix.'block_header">'.'<'.get_option('ttr_heading_tag_sidebarmenu','h3').' style="'.$style1.'" class="'.$cssprefix.'block_heading">
                    <img src="'.get_template_directory_uri().'/images/verticalmenuicon.png" alt="Verticalmenuicon" />'. $instance['title'] .'</'.get_option('ttr_heading_tag_sidebarmenu','h3').'></div>';
                }
                else
                {
                    echo '<div class="'.$cssprefix.'block_header">'.'<'.get_option('ttr_heading_tag_sidebarmenu','h3').' style="'.$style1.'" class="'.$cssprefix.'block_heading">'. $instance['title'] .'</'.get_option('ttr_heading_tag_sidebarmenu','h3').'></div>';
                }
            }
        }

        elseif($style == 'default')
        {

            echo '<div class="'.$cssprefix.'verticalmenu"><div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>';
            if ( !empty($instance['title']) )
            {
                if($mhicon)
                {
                    echo '<div class="'.$cssprefix.'verticalmenu_header">'.'<'.get_option('ttr_heading_tag_sidebarmenu','h3').' style="'.$style1.'" class="'.$cssprefix.'verticalmenu_heading">
                <img src="'.get_template_directory_uri().'/images/verticalmenuicon.png" alt="Verticalmenuicon" />' . $instance['title'] .'</'.get_option('ttr_heading_tag_sidebarmenu','h3').'></div>';
                }
                else
                {
                    echo '<div class="'.$cssprefix.'verticalmenu_header">'.'<'.get_option('ttr_heading_tag_sidebarmenu','h3').' style="'.$style1.'" class="'.$cssprefix.'verticalmenu_heading">'. $instance['title'] .'</'.get_option('ttr_heading_tag_sidebarmenu','h3').'></div>';
                }
            }
        }
        else
        {
            echo '<div class="box widget">';
            if ( !empty($instance['title']) )
            {
                echo '<div class="widget-title">'. $instance['title'].'</div>';
            }
        }

        /*  if ( !$nav_menu )
                    return;
             echo $args['before_widget'];

                if ( isset($instance['title']) )
                    echo $args['before_title'] . $instance['title'] . $args['after_title'];   */

        if($alignment=='nostyle'){
            if(!isset($args['widget_id']))
                $args['widget_id'] ='';
            wp_nav_menu( array( 'menu' => $nav_menu,'class_name'=>$args['widget_id'] ) );

        }
        else if($alignment=='default'){

            if($style=='default')
            {
                if($menustyle=='hmenu')
                {
                    echo '<div class="ttr_verticalmenu_content">';
                    echo '<ul class="'.$cssprefix.'menu_items nav nav-pills nav-stacked">';
                    //	 echo theme_nav_menu($cssprefix,'primary','menu',False,$menuname=$nav_menu);
                    echo theme_nav_menu($cssprefix,'primary','menu',$magmenu,$menuh,$vmenuh,$ocmenu,$menuname=$nav_menu);
                    echo '</ul>';
                    echo '</div>';
                }
                else if($menustyle=='vmenu')
                {
                    echo '<div class="ttr_verticalmenu_content">';
                    echo '<ul class="'.$cssprefix.'vmenu_items nav nav-pills nav-stacked">';
                    //   echo theme_nav_menu($cssprefix,'primary','menu',False,$menuname=$nav_menu);
                    echo theme_nav_menu($cssprefix,'left','vmenu',$magmenu,$menuh,$vmenuh,$ocmenu,$menuname=$nav_menu);
                    echo '</ul>';
                    echo '</div>';
                }
            }
            elseif($style=='block')
            {
                if($menustyle=='hmenu')
                {
                    echo '<div id="%1$s" class="ttr_block_content">';
                    echo '<ul class="'.$cssprefix.'menu_items nav nav-pills nav-stacked">';
                    //	 echo theme_nav_menu($cssprefix,'primary','menu',False,$menuname=$nav_menu);
                    echo theme_nav_menu($cssprefix,'primary','menu',$magmenu,$menuh,$vmenuh,$ocmenu,$menuname=$nav_menu);
                    echo '</ul>';
                    echo '</div>';
                }
                else if($menustyle=='vmenu')
                {
                    echo '<div id="%1$s" class="ttr_block_content">';
                    echo '<ul class="'.$cssprefix.'vmenu_items nav nav-pills nav-stacked">';
                    //   echo theme_nav_menu($cssprefix,'primary','menu',False,$menuname=$nav_menu);
                    echo theme_nav_menu($cssprefix,'left','vmenu',$magmenu,$menuh,$vmenuh,$ocmenu,$menuname=$nav_menu);
                    echo '</ul>';
                    echo '</div>';
                }
            }

        }

        //  echo $args['after_widget'];
        echo '</div>';
    }

    function update($new_instance, $old_instance ) {
        //update the widget
        $instance = $old_instance;
        $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        $instance['alignment'] = $new_instance['alignment'];
        $instance['menustyle'] = $new_instance['menustyle'];
        $instance['style'] = $new_instance['style'];
        $instance['color1'] = $new_instance['color1'];
        $instance['color2'] = $new_instance['color2'];
        $instance['color3'] = $new_instance['color3'];

        return $instance;
    }

    function form( $instance) {//form of the widget
        $instance = wp_parse_args( (array) $instance, array( 'style' => 'default','menustyle' => 'hmenu','color1'=>'#ffffff','color2'=>'#ffffff','color3'=>'#ffffff','alignment' => 'nostyle') );
        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

        if ( !isset($instance['style']) )
            $instance['style'] = null;
        if ( !isset($instance['menustyle']) )
            $instance['menustyle'] = null;
        if ( !isset($instance['alignment']) )
            $instance['alignment'] = null;
        // Get menus
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

        // If no menus exists, direct the user to go and create some.
        if ( !$menus ) {
            echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.',CURRENT_THEME), admin_url('nav-menus.php') ) .'</p>';
            return;
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:',CURRENT_THEME) ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:',CURRENT_THEME); ?></label>
            <select style="width:100%;" id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <?php
                foreach ( $menus as $menu ) {
                    $selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
                    echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
                }
                ?>
            </select>
        </p>

        <div class="menuoptions">

            <label for="<?php echo $this->get_field_id('alignment'); ?>"><?php echo(__('Menu Display:',CURRENT_THEME));?>
            </label>
            <select style="width:100%;" onchange="color_display(this);" id="<?php echo $this->get_field_id('alignment'); ?>" name="<?php echo $this->get_field_name('alignment'); ?>">
                <option <?php selected($instance['alignment'], 'nostyle');?> value="nostyle"><?php _e('No Style',CURRENT_THEME); ?>
                </option>
                <option <?php selected($instance['alignment'], 'default');?>value="default"><?php _e('TT Default',CURRENT_THEME); ?>
                </option>
            </select>

            <label for="<?php echo $this->get_field_id('menustyle'); ?>"><?php echo(__('Menu Style:',CURRENT_THEME));?>
            </label>
            <select style="width:100%;" id="<?php echo $this->get_field_id('menustyle'); ?>" name="<?php echo $this->get_field_name('menustyle'); ?>">
                <option <?php selected($instance['menustyle'], 'hmenu');?>value="hmenu"><?php _e('Horizontal Menu',CURRENT_THEME); ?>
                </option>
                <option <?php selected($instance['menustyle'], 'vmenu');?>value="vmenu"><?php _e('Vertical Menu',CURRENT_THEME); ?>
                </option>
            </select>
            <?php if($instance['alignment']=='default'){
                echo ' <div class="menucolorpickers" style="display:none;">';
            }
            else
            {
                echo  '<div class="menucolorpickers" >';
            }
            ?>

            <label for="<?php echo $this->get_field_id('color1'); ?>"><?php _e('Active Color',CURRENT_THEME); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('color1'); ?>" name="<?php echo $this->get_field_name('color1'); ?>" type="text" value="<?php if(isset($instance['color1'])) { echo $instance['color1']; } else { echo '#ffffff'; } ?>" />
            <div id="<?php echo $this->get_field_id('color1').'div'; ?>" class="cw-color-picker1" rel="<?php echo $this->get_field_id('color1'); ?>"></div>
            <label for="<?php echo $this->get_field_id('color2'); ?>"><?php _e('Hover Color',CURRENT_THEME); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('color2'); ?>" name="<?php echo $this->get_field_name('color2'); ?>" type="text" value="<?php if(isset($instance['color2'])) { echo $instance['color2']; } else { echo '#ffffff'; } ?>" />
            <div id="<?php echo $this->get_field_id('color2').'div'; ?>" class="cw-color-picker2" rel="<?php echo $this->get_field_id('color2'); ?>"></div>
            <label for="<?php echo $this->get_field_id('color3'); ?>"><?php _e('Normal Color',CURRENT_THEME); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('color3'); ?>" name="<?php echo $this->get_field_name('color3'); ?>" type="text" value="<?php if(isset($instance['color3'])) { echo $instance['color3']; } else { echo '#ffffff'; } ?>" />
            <div id="<?php echo $this->get_field_id('color3').'div'; ?>" class="cw-color-picker3" rel="<?php echo $this->get_field_id('color3'); ?>"></div>
        </div>
        </div>

        <script type="text/javascript">

            function color_display(obj) {

                ( function() {
                    var parentname=document.getElementById(obj.id).parentNode;
                    var node = jQuery(parentname).find('> div:first');


                    if(obj.value=='nostyle')
                        node.show();

                    else
                        node.hide();

                } )();
            }
        </script>

        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready(function()
            {
                // colorpicker field
                jQuery('.cw-color-picker1').each(function(){
                    var zz = jQuery(this),
                        id = zz.attr('rel');



                    jQuery('#' + id+'div').hide();
                    jQuery('#' + id+'div').farbtastic('#' + id);
                    jQuery('#' + id).click(function() {
                        jQuery('#' + id+'div').fadeIn();

                    });
                    jQuery(document).mousedown(function() {

                        var display = jQuery('#' + id+'div').css('display');
                        if ( display == 'block' )
                            jQuery('#' + id+'div').fadeOut();

                    });


                });
                jQuery('.cw-color-picker2').each(function(){
                    var $this = jQuery(this),
                        id = $this.attr('rel');


                    jQuery('#' + id+'div').hide();
                    jQuery('#' + id+'div').farbtastic('#' + id);
                    jQuery('#' + id).click(function() {
                        jQuery('#' + id+'div').fadeIn();
                    });

                    jQuery(document).mousedown(function() {

                        var display = jQuery('#' + id+'div').css('display');
                        if ( display == 'block' )
                            jQuery('#' + id+'div').fadeOut();

                    });


                    jQuery(document).mousedown(function() {

                        var display = jQuery('#' + id+'div').css('display');
                        if ( display == 'block' )
                            jQuery('#' + id+'div').fadeOut();

                    });

                });

                jQuery('.cw-color-picker3').each(function(){
                    var $this = jQuery(this),
                        id = $this.attr('rel');

                    jQuery('#' + id+'div').hide();
                    jQuery('#' + id+'div').farbtastic('#' + id);
                    jQuery('#' + id).click(function() {
                        jQuery('#' + id+'div').fadeIn();
                    });

                    jQuery(document).mousedown(function() {

                        var display = jQuery('#' + id+'div').css('display');
                        if ( display == 'block' )
                            jQuery('#' + id+'div').fadeOut();

                    });
                    //});
                    //});
                });
            });
            //]]>
        </script>
        <?php

        return $instance;
    }
}

function myplugin_register_widgets() {//register my widget
    register_widget( 'Custom_Menu' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );//function to load my widget


if (!function_exists('my_unregister_default_wp_widgets')) {
    function my_unregister_default_wp_widgets() {
        unregister_widget('WP_Nav_Menu_Widget');
    }
    add_action('widgets_init', 'my_unregister_default_wp_widgets', 1);
}


function my_style() {
    global $wp_registered_sidebars,$wp_registered_widgets;

    $sidebars_widgets = wp_get_sidebars_widgets();
    //print_r($wp_registered_sidebars);
    foreach((array) $wp_registered_sidebars as $index => $value)
    {


        if ( empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $sidebars_widgets) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
            continue;
        $sidebar = $wp_registered_sidebars[$index];

        foreach ( (array) $sidebars_widgets[$index] as $id ) {

            $params = array_merge(
                array( array_merge( (array)$sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
                (array) $wp_registered_widgets[$id]['params']);
            $widget_id = $params[0]['widget_id'];

            $widget_obj = $wp_registered_widgets[$widget_id];

            $widget_opt = get_option($widget_obj['callback'][0]->option_name);

            $widget_num = $widget_obj['params'][0]['number'];

            if(isset($widget_opt[$widget_num]['alignment']))
                $alignment = $widget_opt[$widget_num]['alignment'];
            else
                $alignment = '';

            if(isset($widget_opt[$widget_num]['menustyle']))
            {
                $menustyle = $widget_opt[$widget_num]['menustyle'];
            }
            else
                $menustyle = '';

            if(isset($widget_opt[$widget_num]['color1']))
                $color1 = $widget_opt[$widget_num]['color1'];
            else
                $color1 = '';
            if(isset($widget_opt[$widget_num]['color2']))
                $color2 = $widget_opt[$widget_num]['color2'];
            else
                $color2 = '';
            if(isset($widget_opt[$widget_num]['color3']))
                $color3 = $widget_opt[$widget_num]['color3'];
            else
                $color3 = '';

            if($params[0]['widget_name']==__('Custom Menu',CURRENT_THEME)){

                if($alignment=='nostyle'){

                    echo '<style>';

                    echo '#'.$widget_id.' ul li a{color:'.$color3.' !important;}';

                    echo'#'.$widget_id.' ul li.current-menu-item a{color:'.$color1.' !important;}';

                    echo '#'.$widget_id.' ul li a:hover{color:'.$color2.' !important;}';
                    if($menustyle=='hmenu')
                    {
                        echo '#'.$widget_id.' ul li {display:inline !important;}';
                    }
                    else
                    {
                        echo '#'.$widget_id.' ul li {list-style:none !important;}';
                    }

                    echo '#'.$widget_id.' li a:visited{color:'.$color3.' !important;}</style>';
                }
            }
        }
    }
}

function sample_load_color_picker_script() {
    wp_enqueue_script('farbtastic');
}
function sample_load_color_picker_style() {
    wp_enqueue_style('farbtastic');
}
add_action('admin_print_scripts-widgets.php', 'sample_load_color_picker_script');
add_action('admin_print_styles-widgets.php', 'sample_load_color_picker_style');
add_action( 'wp_head', 'my_style' );
?>