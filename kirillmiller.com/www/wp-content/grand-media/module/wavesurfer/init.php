<?php
/** @var $gmDB
 * @var  $gmCore
 * @var  $gmGallery
 * @var  $id
 * @var  $query
 * @var  $module
 * @var  $settings
 * @var  $term
 * @var  $is_bot
 * @var  $shortcode_raw
 **/

global $wp;
$settings      = array_merge($settings, array('ID'        => $id,
                                              'nonce'     => wp_create_nonce('GmediaGallery'),
                                              'url'       => add_query_arg($_SERVER['QUERY_STRING'], '', home_url($wp->request)),
                                              'moduleUrl' => $module['url']
));
$base_url_host = parse_url($gmCore->upload['url'], PHP_URL_HOST);
$term_url      = remove_query_arg('gm' . $id, $settings['url']);

$allsettings = array_merge($module['options'], $settings);

$query['mime_type'] = 'audio/*';
$gmedias            = $gmDB->get_gmedias($query);

if(empty($gmedias)){
    echo GMEDIA_GALLERY_EMPTY;

    return;
}
$native = !empty($atts['native'])? true : false;

echo '<div class="ws-soundList' . (((int)$allsettings['compact_list'])? ' ws-compact' : '') . (!((int)$allsettings['show_cover'])? ' ws-hide-cover' : '') . '">';

foreach($gmedias as $item){
    $type = explode('/', $item->mime_type);
    // File url
    $file_url = "{$gmCore->upload['url']}/{$gmGallery->options['folder'][$type[0]]}/{$item->gmuid}";
    // Post url
    $post_url = get_permalink($item->post_id);

    $title = $item->title? $item->title : $item->gmuid;

    $meta   = $gmDB->get_metadata('gmedia', $item->ID);
    $length = isset($meta['_metadata'][0]['length_formatted'])? $meta['_metadata'][0]['length_formatted'] : '-:--';
    $peaks  = isset($meta['_peaks'][0])? $meta['_peaks'][0] : '';

    $tags = array();
    if((int)$allsettings['show_tags'] && ($terms = $gmDB->get_the_gmedia_terms($item->ID, 'gmedia_tag'))){
        foreach($terms as $_term){
            if($native){
                $_term->slug = $_term->name;
                $url         = get_term_link($_term);
            } else{
                $url = add_query_arg(array("gm{$id}" => array('tag__in' => $_term->term_id)), $term_url);
            }
            $tags[] = '<a href="' . urldecode($url) . '" class="ws-tag ws-link-light"><span class="ws-truncate">' . $_term->name . '</span></a>';
        }
    }

    $default_cover_web   = 'javascript: return false;';
    $default_cover_thumb = '';

    $categories = array();
    if((int)$allsettings['show_categories'] && ($terms = $gmDB->get_the_gmedia_terms($item->ID, 'gmedia_category'))){
        foreach($terms as $_term){
            if($native){
                $_term->slug = $_term->name;
                $url         = get_term_link($_term);
            } else{
                $url = add_query_arg(array("gm{$id}" => array('category__in' => $_term->term_id)), $term_url);
            }
            $categories[] = '<a href="' . urldecode($url) . '" class="ws-cat"><span>' . $_term->name . '</span></a>';
        }

        $category = reset($terms);
        if(!empty($category)){
            $category_cover_id = $gmDB->get_metadata('gmedia_term', $category->term_id, '_cover', true);
            if((int)$category_cover_id){
                $default_cover_thumb = $gmCore->gm_get_media_image($category_cover_id, 'thumb', true, $default_cover_thumb);
                $default_cover_web   = $gmCore->gm_get_media_image($category_cover_id, 'web', true, $default_cover_web);
            }
        }
    }

    $albums = array();
    if((int)$allsettings['show_albums'] && ($terms = $gmDB->get_the_gmedia_terms($item->ID, 'gmedia_album'))){
        foreach($terms as $_term){
            if($native){
                $term_post_id = $gmDB->get_metadata('gmedia_term', $_term->term_id, '_post_ID', true);
                if(!empty($term_post_id)){
                    $url = get_permalink($term_post_id);
                } else{
                    $url = $gmCore->gmcloudlink($_term->term_id, 'album');
                }
            } else{
                $url = add_query_arg(array("gm{$id}" => array('album__in' => $_term->term_id)), $term_url);
            }
            $albums[] = '<a href="' . urldecode($url) . '" class="ws-link-light"><span>' . $_term->name . '</span></a>';
        }

        $album = reset($terms);
        if(!empty($album)){
            $album_cover_id = $gmDB->get_metadata('gmedia_term', $album->term_id, '_cover', true);
            if((int)$album_cover_id){
                $default_cover_thumb = $gmCore->gm_get_media_image($album_cover_id, 'thumb', true, $default_cover_thumb);
                $default_cover_web   = $gmCore->gm_get_media_image($album_cover_id, 'web', true, $default_cover_web);
            }
        }
    }
    // Cover
    $have_cover       = false;
    $have_cover_class = '';
    $cover_thumb      = $gmCore->gm_get_media_image($item->ID, 'thumb', true, $default_cover_thumb);
    $cover_web        = $default_cover_web;
    if($cover_thumb){
        if($cover_thumb !== $default_cover_thumb){
            $cover_web        = $gmCore->gm_get_media_image($item->ID, 'web', true, $default_cover_web);
            $have_cover       = !empty($meta['_cover'][0])? true : false;
            $have_cover_class = $have_cover? 'ws-have-cover' : '';
        }
        $cover_thumb = 'background-image: url("' . $cover_thumb . '");';
        $cover_web   = 'background-image: url("' . $cover_web . '");';
    }

//    if ( ! empty( $allsettings['show_description'] ) ) {
//        $description = str_replace( array( "\r\n", "\r", "\n" ), '', wpautop( $item->description ) );
//    }
    $wavecover_meta = !empty($meta['wavecover'][0])? $meta['wavecover'][0] : false;
    if($wavecover_meta && $gmCore->is_digit($wavecover_meta)){
        $cover_web = 'background-image: url("' . $gmCore->gm_get_media_image((int)$wavecover_meta, 'web', true, $default_cover_web) . '");';
    }

    $viewslikes = array('views' => empty($meta['views'][0])? 0 : (int)$meta['views'][0],
                        'likes' => empty($meta['likes'][0])? 0 : (int)$meta['likes'][0]
    );

    ?>
    <div class="ws-soundList__item <?php echo $have_cover_class; ?>" data-id="<?php echo $item->ID; ?>">
        <div role="group" class="ws-sound">
            <?php
            if(!empty($allsettings['show_author'])){
                $author['name']       = get_the_author_meta('display_name', $item->author);
                $author['posts_link'] = get_author_posts_url($item->author);
                $avatar_img           = get_avatar($item->author, 30);
                if(preg_match("/src=['\"](.*?)['\"]/i", $avatar_img, $matches)){
                    $author['avatar'] = $matches[1];
                }
                ?>
                <div class="ws-sound__author">
                    <div class="ws-sound__userAvatar">
                        <a href="<?php echo $author['posts_link']; ?>"><img src="<?php echo $author['avatar']; ?>"></a>
                    </div>
                    <?php if(!empty($allsettings['show_uploaded'])){
                        $uploaded = $allsettings['text_uploaded']? $allsettings['text_uploaded'] . ' ' : '';
                        ?>
                        <span class="ws-sound__author_line">
                            <a href="<?php echo $author['posts_link']; ?>" class="ws-sound__usernameLink"><?php echo $author['name']; ?></a>
                            <span class="ws-sound__uploaded"><?php echo  $uploaded . date_i18n(get_option('date_format'), strtotime($item->date)); ?></span>
                        </span>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="ws-sound__body">
                <div class="ws-sound__artwork">
                    <a class="ws-sound__coverArt" href="<?php echo $post_url; ?>" data-cover="<?php echo $cover_web; ?>">
                        <span class="ws-image ws-artwork ws-artwork-placeholder">
                            <span style="<?php esc_attr_e($cover_thumb); ?>" class="ws-artwork ws-image__thumb" aria-role="img"></span>
                        </span>
                    </a>
                </div>

                <div class="ws-sound__content">
                    <?php
                    $wavebg = '';
                    if($have_cover && ((int)$allsettings['show_big_cover'] || $wavecover_meta)){
                        if('false' !== $wavecover_meta){
                            $wavebg = 'ws-have-background';
                        }
                    }
                    ?>
                    <div class="ws-visualSound__wrapper <?php echo $wavebg; ?>">
                        <?php
                        if($wavebg){
                            ?>
                            <div class="ws-visualSound__background">
                                <div aria-role="img" style="<?php esc_attr_e($cover_web); ?>"></div>
                            </div>
                        <?php } ?>
                        <div class="ws-sound__header">
                            <div class="ws-soundTitle ws-clearfix">
                                <div class="ws-soundTitle__titleContainer">
                                    <div class="ws-soundTitle__playButton">
                                        <span class="ws-button ws-button-play" tabindex="0" title="<?php _e('Play', 'grand-media'); ?>"><?php _e('Play', 'grand-media'); ?></span>
                                    </div>

                                    <div class="ws-soundTitle__titleWrapper">
                                        <div class="ws-soundTitle__secondary ws-type-light"><?php echo count($albums)? implode(', ', $albums) : '&nbsp;'; ?></div>
                                        <a class="ws-soundTitle__title ws-link-dark" >
                                            <span><?php echo $title; ?></span>
                                        </a>
                                    </div>
                                    <div class="ws-soundTitle__additionalContainer">
                                        <div class="ws-soundTitle__tags"><?php echo count($tags)? implode(' ', $tags) : '&nbsp;'; ?></div>
                                        <div class="ws-soundTitle__catContainer">
                                            <?php echo implode('', $categories); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ws-sound__waveform">
                            <div class="ws-waveform">
                                <div class="ws-waveform__layer" data-key="ws<?php echo $item->ID; ?>" data-file="<?php echo $file_url; ?>" data-peaks="<?php echo $peaks; ?>">
                                    
                                    <wave><?php // Here will be waveform
                                        ?></wave>
                                </div>
                                <div class="ws-waveform__time">
                                    <span class="ws-time ws-wave_time"></span>
                                    <span class="ws-time ws-track_time"><?php echo $length; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="ws-sound__footer">
                        <div class="ws-sound__footerRight">
                            <div class="ws-sound__soundStats">
                                <div class="ws-ministats-group">
                                    <?php
                                    if((int)$allsettings['show_views']){
                                        $views = (intval($viewslikes['views']) >= 10000)? round($viewslikes['views'] / 1000, 1) . 'k' : $viewslikes['views'];
                                        $views = (intval($views) >= 10000)? round($views / 1000, 1) . 'M' : $views;
                                        ?>
                                        <div title="<?php echo $viewslikes['views']; ?> plays" class="ws-ministats-item">
                                            <span class="ws-ministats ws-ministats-plays ws-icon-play">
                                                <span><?php echo $views; ?></span>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    if((int)$allsettings['show_comments']){
                                        $cc = wp_count_comments($item->post_id);
                                        $cc = $cc->approved;
                                        ?>
                                        <div title="<?php echo $cc; ?> comments" class="ws-ministats-item">
                                            <a href="<?php echo $post_url . ((int)$cc? '#comments' : '#respond'); ?>" target="<?php echo $native? '_self' : '_blank' ?>" class="ws-ministats ws-ministats-comments ws-icon-comment" rel="nofollow">
                                                <span><?php echo $cc; ?></span>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="ws-sound__soundActions">
                            <div class="ws-button-toolbar">
                                <div class="ws-button-group">
                                    <?php
                                    if((int)$allsettings['show_like_button']){
                                        $likes = (intval($viewslikes['likes']) >= 10000)? round($viewslikes['likes'] / 1000, 1) . 'k' : $viewslikes['likes'];
                                        $likes = (intval($likes) >= 10000)? round($likes / 1000, 1) . 'M' : $likes;
                                        ?>
                                        <span class="ws-button-like ws-button ws-button-small ws-icon-heart-1" tabindex="0" title="<?php _e('Like', 'grand-media'); ?>"><?php echo $likes; ?></span>
                                        <?php
                                    }
                                    if((int)$allsettings['show_share_button']){
                                        ?>
                                        <span class="ws-button-share ws-button ws-button-small ws-icon-export" tabindex="0" role="button" title="<?php _e('Share', 'grand-media'); ?>"><?php _e('Share', 'grand-media'); ?></span>
                                        <?php
                                    }
                                    if((int)$allsettings['show_download_button']){
                                        if(!empty($meta['download'][0])){
                                            $download = $meta['download'][0];
                                        } else{
                                            $download = $file_url;
                                        }
                                        ?>
                                        <a rel="nofollow" href="<?php echo $download; ?>" class="ws-button-download ws-button ws-button-small ws-icon-download" tabindex="0" download="<?php esc_attr_e($title); ?>" title="<?php _e('Download this track', 'grand-media'); ?>"><?php _e('Download', 'grand-media'); ?></a>
                                        <?php
                                    }
                                    if((int)$allsettings['show_link_button'] && $item->link){
                                        $link_target = '';
                                        $url_host    = parse_url($item->link, PHP_URL_HOST);
                                        if($url_host == $base_url_host || empty($url_host)){
                                            $link_target = '_self';
                                        } else{
                                            $link_target = '_blank';
                                        }
                                        if(isset($meta['link_target'][0])){
                                            $link_target = $meta['link_target'][0];
                                        }
                                        if(isset($meta['link_text'][0])){
                                            $link_text = $meta['link_text'][0];
                                        } else{
                                            $link_text = $allsettings['link_button_text'];
                                        }
                                        ?>
                                        <a href="<?php echo $item->link; ?>" class="ws-button-link ws-button ws-button-small" tabindex="0" target="<?php echo $link_target; ?>"><?php echo $link_text; ?></a>
                                        <?php
                                    }

                                    if(empty($gmGallery->options['license_key'])){
                                        echo "<a class='gm-buylink' target='_blank' href='{$module['info']['demo']}'>" . __('', 'grand-media') . "</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
echo '</div>';
echo '<div class="ws-soundCompactList' . (!((int)$allsettings['show_cover'])? ' ws-hide-cover' : '') . '"></div>';
?>

<?php if($shortcode_raw){
    echo '<pre style="display:none">';
}
?>
    <script type="text/javascript">
        jQuery(function($) {
            var settings = <?php echo json_encode($settings); ?>;
            $('#GmediaGallery_<?php echo $id; ?>').gmWaveSurfer(settings);
        });
    </script><?php if($shortcode_raw){
    echo '</pre>';
}
?>

<?php
$cssid      = "GmediaGallery_{$id}";
$module_css = '';
if(isset($allsettings['color4'])){
    $color4    = $gmCore->color($allsettings['color4']);
    $color4_0  = $color4->getHex();
    $color4_d1 = $color4->darken(10);
    $color4_d2 = $color4->darken(20);

    if($color4->isDark()){
        $color4_0_cover = 'ffffff';
    } else{
        $color4_0_cover = '000000';
    }

    $module_css .= "
#{$cssid} input {border-color:#{$color4_d2};}
#{$cssid} .ws-button {background-color:#{$color4_0};border-color:#{$color4_d1};color:#{$color4_0_cover};}
#{$cssid} .ws-button:hover {background-color:#{$color4_d1};border-color:#{$color4_d2};color:#{$color4_0_cover};}
#{$cssid} .ws-soundCompactList,
#{$cssid} .ws-soundCompactList .ws-soundList__item {border-color:#{$color4_d1};}
#{$cssid} .ws-cat {color:#{$color4_0_cover};border-color:#{$color4_d1};background:#{$color4_0};}
#{$cssid} .ws-cat:hover {color:#{$color4_0_cover};border-color:#{$color4_d2};background:#{$color4_d1};}
";
}
if(isset($allsettings['color3'])){
    $color3   = $gmCore->color($allsettings['color3']);
    $color3_0 = $color3->getHex();

    if($color3->isDark()){
        $color3_2       = $color3->lighten(20);
        $color3_0_cover = 'ffffff';
    } else{
        $color3_2       = $color3->darken(20);
        $color3_0_cover = '000000';
    }

    $module_css .= "
#{$cssid} a.ws-link-dark {color:#{$color3_0};}
#{$cssid} a.ws-link-dark:hover {color:#{$color3_2};}
#{$cssid} a.ws-link-light:hover {color:#{$color3_0};}
#{$cssid} .ws-have-background .ws-soundTitle__title span {color:#{$color3_0_cover};background-color:#{$color3_0}}
#{$cssid} .ws-have-background .ws-soundTitle__title:hover span {color:#{$color3_0_cover};background-color:#{$color3_2}}
#{$cssid} .ws-have-background .ws-soundTitle__secondary a:hover span {color:#{$color3_0_cover};background-color:#{$color3_0}}
#{$cssid} .ws-ministats,
#{$cssid} a.ws-ministats {color:#{$color3_0};}
#{$cssid} a.ws-ministats:hover {color:#{$color3_2};}
";
}
if(isset($allsettings['color1']) || isset($allsettings['color2'])){
    $color2    = $gmCore->color($allsettings['color2']);
    $color2_0  = $color2->getHex();
    $color2_d4 = $color2->darken('40%');
    $color2_d8 = $color2->darken('80%');
    $color2_l1 = $color2->lighten('10%');
    $color2_l2 = $color2->lighten('20%');
    $color2_l3 = $color2->lighten('30%');
    $color2_l8 = $color2->lighten('80%');

    if($color2->isDark($color2_l1)){
        $color2_l1_cover = 'ffffff';
    } else{
        $color2_l1_cover = '000000';
    }

    $color1    = $gmCore->color($allsettings['color1']);
    $color1_0  = $color1->getHex();
    $color1_d1 = $color1->darken();
    $color1_l1 = $color1->lighten();

    $module_css .= "
#{$cssid} .ws-artwork.ws-artwork-placeholder,
.ws-playControls[data-id='{$cssid}'] .ws-artwork.ws-artwork-placeholder { background-image: linear-gradient(135deg, #{$color1_l1}, #{$color2_l1}); }";

    if(isset($allsettings['color2'])){
        $module_css .= "
#{$cssid} wave:before {background-color:#{$color2_0};}
#{$cssid} a:hover {color:#{$color2_d4};}
#{$cssid} a.ws-link-light {color:#{$color2_l1};}
#{$cssid} .ws-have-background .ws-soundTitle__secondary a span {color:#{$color2_l1_cover};background-color:#{$color2_l1}}
#{$cssid} .ws-button-play {border-color:#{$color2_l3};color:#{$color2_d4};}
#{$cssid} .ws-button-play:hover {color:#{$color2_d4};border-color:#{$color2_d4};}
#{$cssid} .ws-type-light {color:#{$color2_l1};}
#{$cssid} .ws-soundTitle__categories {color:#{$color2_l2};}
#{$cssid} .ws-time.ws-track_time {color:#{$color2_l8};}
#{$cssid} .ws-g-dark {color:#{$color2_l1};}
.ws-playControls[data-id='{$cssid}'] .ws-playbackSoundBadge__title {color:#{$color2_d8};}";
    }
    if(isset($allsettings['color1'])){
        $module_css .= "
#{$cssid} wave wave:before,
#{$cssid} .ws-soundCompactList .ws-soundList__item .ws-item-progress {background-color:#{$color1_0};}
#{$cssid} .ws-time.ws-wave_time {color:#{$color1_0};}
#{$cssid} .ws-button-active,
#{$cssid} .ws-liked .ws-button-like { color: #{$color1_d1}; }
#{$cssid} .ws-button-active:hover
#{$cssid} .ws-liked .ws-button-like:hover { color: #{$color1_d1}; border-color: #{$color1_d1}; }
#{$cssid} .ws-button-play,
#{$cssid} .ws-button-pause,
#{$cssid} .ws-button-play:hover,
#{$cssid} .ws-button-pause:hover { background-color: #{$color1_0}; }
#{$cssid} .ws-button-play:active,
#{$cssid} .ws-button-pause:active { border-color: #{$color1_d1}; background-color: #{$color1_d1}; }
.ws-playControls[data-id='{$cssid}'] .ws-volume__sliderBackground {background-color:#{$color1_l1};}
.ws-playControls[data-id='{$cssid}'] .ws-playbackTimeline__timePassed { color: #{$color1_d1}; }
.ws-playControls[data-id='{$cssid}'] .ws-volume__sliderProgress,
.ws-playControls[data-id='{$cssid}'] .ws-volume__sliderProgress::after {background-color: #{$color1_d1}; }";
    }
}
if(isset($settings['show_big_cover']) && isset($settings['big_cover_alpha'])){
    $opacity = $allsettings['big_cover_alpha'] / 100;
    $module_css .= "
#{$cssid} .ws-visualSound__background {opacity:{$opacity};}";
}

if($module_css){
    echo "<style type='text/css'>/**** Module CSS ****/{$module_css}</style>";
}
