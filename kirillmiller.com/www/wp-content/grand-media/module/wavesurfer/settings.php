<?php
$default_options = array(
    'compact_list'         => '0',
    'play_next_in_list'    => '1',
    'show_author'          => '1',
    'show_uploaded'        => '1',
    'text_uploaded'        => __('uploaded on', 'grand-media'),
    'show_tags'            => '1',
    'show_categories'      => '1',
    'show_albums'          => '1',
    'show_cover'           => '1',
    'show_big_cover'       => '0',
    'big_cover_alpha'      => '100',
    'show_like_button'     => '1',
    'show_share_button'    => '1',
    'show_download_button' => '0',
    'show_link_button'     => '1',
    'link_button_text'     => __('More', 'grand-media'),
    'show_views'           => '1',
    'show_comments'        => '1',
    'color1'               => 'ff8800',
    'color2'               => 'a1a1a1',
    'color3'               => '000000',
    'color4'               => 'ffffff',
);
$options_tree    = array(
    array(
        'label'  => __('Common Settings', 'grand-media'),
        'fields' => array(
            'compact_list'         => array(
                'label' => __('Compact Playlist', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'play_next_in_list'    => array(
                'label' => __('After track finish play go to next track in the list', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_author'          => array(
                'label' => __('Display Author', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_uploaded'        => array(
                'label' => __('Display Uploaded Date', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'text_uploaded'        => array(
                'label' => __('Text before uploaded date', 'grand-media'),
                'tag'   => 'input',
                'attr'  => 'type="text"',
                'text'  => ''
            ),
            'show_tags'            => array(
                'label' => __('Display Tags', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_categories'      => array(
                'label' => __('Display Categories', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_albums'          => array(
                'label' => __('Display Album', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_cover'           => array(
                'label' => __('Display Music Cover', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_big_cover'       => array(
                'label' => __('Display Cover as Wave Background', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'big_cover_alpha'      => array(
                'label' => __('Wave BG Cover Alpha Transparency', 'grand-media'),
                'tag'   => 'input',
                'attr'  => 'type="number" min="0" max="100" step="1"',
                'text'  => ''
            ),
            'show_like_button'     => array(
                'label' => __('Show Like Button', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_share_button'    => array(
                'label' => __('Show Share Button', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_download_button' => array(
                'label' => __('Show Download Button', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_link_button'     => array(
                'label' => __('Show Link Button', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'link_button_text'     => array(
                'label' => __('Link Button Text', 'grand-media'),
                'tag'   => 'input',
                'attr'  => 'type="text"',
                'text'  => __('To set text individual for music track just add "link_text" custom field with text you need. Also you can change "link_target" via custom fields', 'grand-media')
            ),
            'show_views'           => array(
                'label' => __('Show Plays Counter', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
            'show_comments'        => array(
                'label' => __('Show Comments Counter', 'grand-media'),
                'tag'   => 'checkbox',
                'attr'  => '',
                'text'  => ''
            ),
        )
    ),
    array(
        'label'  => __('Color Settings', 'grand-media'),
        'fields' => array(
            'color1' => array(
                'label' => __('Color 1', 'grand-media'),
                'tag'   => 'input',
                'attr'  => 'type="text" data-type="color"',
                'text'  => ''
            ),
            'color2' => array(
                'label' => __('Color 2', 'grand-media'),
                'tag'   => 'input',
                'attr'  => 'type="text" data-type="color"',
                'text'  => ''
            ),
            'color3' => array(
                'label' => __('Color 3', 'grand-media'),
                'tag'   => 'input',
                'attr'  => 'type="text" data-type="color"',
                'text'  => ''
            ),
            'color4' => array(
                'label' => __('Color 4', 'grand-media'),
                'tag'   => 'input',
                'attr'  => 'type="text" data-type="color"',
                'text'  => ''
            ),
        )
    ),
    array(
        'label'  => __('Advanced Settings', 'grand-media'),
        'fields' => array(
            'customCSS' => array(
                'label' => __('Custom CSS', 'grand-media'),
                'tag'   => 'textarea',
                'attr'  => 'cols="20" rows="10"',
                'text'  => 'You can enter custom style rules into this box if you\'d like. IE: <i>a{color: red !important;}</i><br />This is an advanced option! This is not recommended for users not fluent in CSS... but if you do know CSS, anything you add here will override the default styles',
                'grand-media'
            )
        )
        /*,
        'loveLink' => array(
            'label' => __('Display LoveLink?', 'grand-media'),
            'tag' => 'checkbox',
            'attr' => '',
            'text' => __('Selecting "Yes" will show the lovelink icon (codeasily.com) somewhere on the gallery', 'grand-media')
        )*/
    )
);
