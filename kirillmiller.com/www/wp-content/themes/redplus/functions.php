<?php
ob_start();
global $classes_post;
$classes_post = array(
    'ttr_post'
);

/**
 * Twenty Thirteen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentythirteen_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentythirteen_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
$WP_Theme = wp_get_theme();
@define('CURRENT_THEME', $WP_Theme);
global $theme_widget_args;

if ( ! isset( $content_width ) )
    $content_width = 584;

/**
 * Tell WordPress to run theme_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'theme_setup' );

if ( ! function_exists( 'theme_setup' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * To override theme_setup() in a child theme, add your own theme_setup to your child theme's
     * functions.php file.
     *
     * @uses load_theme_textdomain() For translation/localization support.
     * @uses add_editor_style() To style the visual editor.
     * @uses add_theme_support() To add support for post thumbnails, automatic feed links, and Post Formats.
     * @uses register_nav_menus() To add support for navigation menus.
     * @uses add_custom_background() To add support for a custom background.
     * @uses add_custom_image_header() To add support for a custom header.
     * @uses register_default_headers() To register the default custom header images provided with the theme.
     * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
     *
     * @since Twenty Thirteen 1.0
     */
    function theme_setup() {

        /* Make Twenty Thirteen available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and replace
	 * to change 'twentythirteen' to the name of your theme in all the template files.
	 */
        load_theme_textdomain( CURRENT_THEME, get_template_directory() . '/languages' );
        include 'widgetinit.php';
        require_once('functions-1.php');
        require_once('custommenu.php');
        require_once('loginform.php');
// Theme review change Start
        require_once('seo.php');
        require_once('backup_recovery.php');
// Theme review change end
        global $classes_post,$cssprefix;
        $classes_post = array(
            $cssprefix.'post'
        );

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // Load up our theme options page and related code.




        // Add default posts and comments RSS feed links to <head>.
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );

        if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):
            $width  = 150;
            $height = 150;
        else:
            $width  = get_option( 'ttr_featured_image_width' );
            $height = get_option( 'ttr_featured_image_height' );
        endif;

        set_post_thumbnail_size( $width, $height,true );

        // Add support for a variety of post formats

        add_theme_support( 'post-formats', array(
            'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
        ) );

        add_filter( 'use_default_gallery_style', '__return_false' );

        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
        register_default_headers( array(
            'wheel' => array(
                'url' => '%s/images/headers/wheel.jpg',
                'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Wheel', CURRENT_THEME )
            ),
            'shore' => array(
                'url' => '%s/images/headers/shore.jpg',
                'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Shore', CURRENT_THEME )
            ),
            'trolley' => array(
                'url' => '%s/images/headers/trolley.jpg',
                'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Trolley', CURRENT_THEME )
            ),
            'pine-cone' => array(
                'url' => '%s/images/headers/pine-cone.jpg',
                'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Pine Cone', CURRENT_THEME )
            ),
            'chessboard' => array(
                'url' => '%s/images/headers/chessboard.jpg',
                'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Chessboard', CURRENT_THEME )
            ),
            'lanterns' => array(
                'url' => '%s/images/headers/lanterns.jpg',
                'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Lanterns', CURRENT_THEME )
            ),
            'willow' => array(
                'url' => '%s/images/headers/willow.jpg',
                'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Willow', CURRENT_THEME )
            ),
            'hanoi' => array(
                'url' => '%s/images/headers/hanoi.jpg',
                'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
                /* translators: header image description */
                'description' => __( 'Hanoi Plant', CURRENT_THEME )
            )
        ) );
    }
endif; // twentythirteen_setup




function twentythirteen_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'twentythirteen_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function twentythirteen_continue_reading_link() {
    if(get_option('ttr_read_more_button')){
        return ' <a href="'. esc_url( get_permalink() ) . '">' . __( '<span class="btn btn-default">'.get_option('ttr_read_more').'<span class="meta-nav">&rarr;</span></span>', CURRENT_THEME ) . '</a>';
    }
    else {
        return ' <a href="'. esc_url( get_permalink() ) . '">' . __( get_option('ttr_read_more').'<span class="meta-nav">&rarr;</span>', CURRENT_THEME ) . '</a>';

    }


}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentythirteen_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function twentythirteen_auto_excerpt_more( $more ) {
    return ' &hellip;' . twentythirteen_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentythirteen_auto_excerpt_more' );

/**
Trim the content lenght without deleting tags
 */
function ttr_trim_words( $text,$more=null) {
    $num_words=get_option("ttr_read_length");
    if ( null === $more )
        $more = '&hellip;';

    $text = preg_replace("/<img[^>]+\>/i", "", $text);
    $text = preg_replace("/<a[^>]+\>/i", "", $text);

    $text = strip_shortcodes($text);
    /* translators: If your word count is based on single characters (East Asian characters),
		 	 enter 'characters'. Otherwise, enter 'words'. Do not translate into your own language. */
    if ( 'characters' == _x( 'words', 'word count: words or characters?' ) && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
        $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
        preg_match_all( '/./u', $text, $words_array );
        $words_array = array_slice( $words_array[0], 0, $num_words + 1 );
        $sep = '';
    } else {
        $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
        $sep = ' ';
    }
    if ( count( $words_array ) > $num_words ) {
        array_pop( $words_array );
        $text = implode( $sep, $words_array );
        $text = $text . $more;

    } else {
        $text = implode( $sep, $words_array );
    }

    return force_balance_tags($text);
}


/**
Read more link function on enabling the tag in theme options
 */
function ttr_the_content_filter($content) {


    global $post;
    $morelink = ' &hellip;' . twentythirteen_continue_reading_link();
    if(get_option('ttr_post1_enable') && !is_single() && !is_page() && empty( $post->post_excerpt ))
    {
        return ttr_trim_words($content,$more=$morelink);
    }
    else if(!empty($post->post_excerpt) && !is_single() && !is_page() && get_option('ttr_post1_enable'))
    {
        return $post->post_excerpt.$morelink;
    }
    else {
        return $content;
    }
}

add_filter( 'the_content', 'ttr_the_content_filter' );



/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function twentythirteen_custom_excerpt_more( $output ) {
    if ( has_excerpt() && ! is_attachment() ) {
        $output .= twentythirteen_continue_reading_link();
    }
    return $output;
}
add_filter( 'get_the_excerpt', 'twentythirteen_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function twentythirteen_page_menu_args( $args ) {
    $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'twentythirteen_page_menu_args' );




/**
 * Display navigation to next/previous pages when applicable
 */
function twentythirteen_content_nav( $nav_id ) {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo $nav_id; ?>">
            <?php if(get_option('ttr_post_navigation',true)):?>
                <h3 class="assistive-text"><?php echo(__( 'Navigation',CURRENT_THEME )); ?></h3>
            <?php endif; ?>



            <?php
            if(get_option('ttr_pagination_link_posts')){
                global $wp_query;

                $big = 999999999;
                $pge = paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'prev_next'    => True,
                    'format' => '?paged=%#%',
                    'prev_text'    => __('Previous',CURRENT_THEME),
                    'next_text'    => __('Next',CURRENT_THEME),
                    'current' => max( 1, get_query_var('paged') ),
                    'type' => 'array',
                    'total' => $wp_query->max_num_pages
                ) );
                if ($wp_query->max_num_pages > 1) :
                    ?>
                    <ul class="pagination">
                        <?php
                        foreach ( $pge as $page )
                        {
                            if(strpos($page,'current') !== false )
                            {
                                echo '<li class="active">' . $page . '</li>';
                            }
                            else
                            {
                                echo '<li>' . $page . '</li>';
                            }
                        }
                        ?>
                    </ul>
                <?php endif; ?>


            <?php
            }
            if(get_option('ttr_older_newer_posts',true))
            { ?>
                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', CURRENT_THEME ) ); ?></div>
                <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', CURRENT_THEME ) ); ?></div>
            <?php } ?>
        </nav><!-- #nav-above -->
    <?php endif;
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Thirteen 1.0
 * @return string|bool URL or false when no link is present.
 */
function twentythirteen_url_grabber() {
    if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
        return false;

    return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function twentythirteen_footer_sidebar_class() {
    $count = 0;

    if ( is_active_sidebar( 'sidebar-3' ) )
        $count++;

    if ( is_active_sidebar( 'sidebar-4' ) )
        $count++;

    if ( is_active_sidebar( 'sidebar-5' ) )
        $count++;

    $class = '';

    switch ( $count ) {
        case '1':
            $class = 'one';
            break;
        case '2':
            $class = 'two';
            break;
        case '3':
            $class = 'three';
            break;
    }

    if ( $class )
        echo 'class="' . $class . '"';
}
if ( ! function_exists( 'twentythirteen_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentythirteen_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_comment( $comment, $args, $depth ) {
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );
$GLOBALS['comment'] = $comment;
switch ( $comment->comment_type ) :
case 'pingback' :
case 'trackback' :
?>
<li class="post pingback">
    <p><?php _e( 'Pingback:', CURRENT_THEME ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', CURRENT_THEME ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
    break;
    default :
    ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
<!--<div id="comment-<?php comment_ID(); ?>" class="comment">-->
<div>
    <!--<footer class="comment-meta">-->
    <div class="comment-author vcard">
        <?php
        $avatar_size = 68;
        if ( '0' != $comment->comment_parent )
            $avatar_size = 39;

        echo get_avatar( $comment, $avatar_size );

        /* translators: 1: comment author, 2: date and time */
        printf( __( '%1$s on %2$s <span class="says">said:</span>', CURRENT_THEME ),
            sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
            sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                esc_url( get_comment_link( $comment->comment_ID ) ),
                get_comment_time( 'c' ),
                /* translators: 1: date, 2: time */
                sprintf( __( '%1$s at %2$s', CURRENT_THEME ), get_comment_date(), get_comment_time() )
            )
        );
        ?>

        <?php edit_comment_link( __( 'Edit', CURRENT_THEME ), '<span class="edit-link">', '</span>' ); ?>
    </div><!-- .comment-author .vcard -->

    <?php if ( $comment->comment_approved == '0' ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', CURRENT_THEME ); ?></em>
        <br />
    <?php endif; ?>
    <!--
</footer>-->

    <div class="comment-content"><?php comment_text(); ?></div>

    <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', CURRENT_THEME ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div><!-- .reply -->
</div><!-- #comment-## -->

<?php
break;
endswitch;
}
endif; // ends check for twentythirteen_comment()


if ( ! function_exists( 'mytheme_entry_meta' ) ) :
    /**
     * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
     *
     * Create your own mytheme_entry_meta() to override in a child theme.
     *
     * @since Twenty Thirteen 1.0
     *
     * @return void
     */
    function mytheme_entry_meta() {
        if ( is_sticky() && is_home() && ! is_paged() )
            echo '<span class="featured-post">' . __( 'Sticky', CURRENT_THEME ) . '</span>';

        if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
            mytheme_entry_date();

        // Translators: used between list items, there is a space after the comma.
        if(! has_post_format(array('chat','status'))):
            $categories_list = get_the_category_list( __( ', ', CURRENT_THEME ) );
            if ( $categories_list ) {
                if(get_option('ttr_remove_post_category'))
                    echo '<span class="categories-links"> ' . $categories_list . ' |</span>';
            }
        endif;

        // Translators: used between list items, there is a space after the comma.
        $tag_list = get_the_tag_list( '', __( ', ', CURRENT_THEME ) );
        if ( $tag_list ) {
            echo '<span class="tags-links"> |' . $tag_list . '</span>';
        }

        // Post author
        if(! has_post_format(array('chat', 'status', 'aside', 'quote'))):
            if ( 'post' == get_post_type() ) {
                printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author"> %3$s | </a></span>',
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    esc_attr( sprintf( __( 'View all posts by %s', CURRENT_THEME ), get_the_author() ) ),
                    get_the_author()
                );
            }
        endif;
    }
endif;
if ( ! function_exists( 'mytheme_entry_date' ) ) :
    /**
     * Prints HTML with date information for current post.
     *
     * Create your own mytheme_entry_date() to override in a child theme.
     *
     * @since Twenty Thirteen 1.0
     *
     * @param boolean $echo Whether to echo the date. Default true.
     * @return string The HTML-formatted post date.
     */
    function mytheme_entry_date( $echo = true ) {
        if ( has_post_format( array( 'chat', 'status' ) ) )
            $format_prefix = _x( '%1$s on %2$s ', '1: post format name. 2: date', CURRENT_THEME );
        else
            $format_prefix = '%2$s ';

        if(get_option('ttr_remove_date')):
            $date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
                esc_url( get_permalink() ),
                esc_attr( sprintf( __( 'Permalink to %s', CURRENT_THEME ), the_title_attribute( 'echo=0' ) ) ),
                esc_attr( get_the_date( 'c' ) ),
                esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
            );


            if ( has_post_format( array( 'chat' ) ) ):
                if ( $echo )
                    echo $date ;

                return $date ;
            else:
                if ( $echo )
                    echo $date .'|';

                return $date .'|';
            endif;

        endif;
    }
endif;

function mytheme_get_link_url() {
    $content = get_the_content();
    $has_url = get_url_in_content( $content );

    return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

if ( ! function_exists( 'twentythirteen_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     * Create your own twentythirteen_posted_on to override in a child theme
     *
     * @since Twenty Thirteen 1.0
     */
    function twentythirteen_posted_on($date,$author) {

        if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):

            echo '<div class="postedon">';
            if ( is_sticky() && is_home() && ! is_paged() ){
                echo '<span class="featured-post"></span>';
                echo '<span style="clear:both;">'.__( 'Sticky', CURRENT_THEME ).'</span>';
            }
            if($date && $author)
            {

                printf( __( '<span class="meta"> Posted on </span> <img alt="date" src="'. get_template_directory_uri().'/images/datebutton.png"/><a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta"> by </span> <img alt="author" src="'.get_template_directory_uri().'/images/authorbutton.png"/>   <a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                    esc_url( get_permalink() ),
                    esc_attr( get_the_time() ),
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                    esc_html( get_the_author() )
                );
            }
            else if($date && !$author)
            {
                printf( __( '<span class="meta"> Posted on </span> <img alt="date" src="'. get_template_directory_uri().'/images/datebutton.png"/><a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta"> by </span><a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                    esc_url( get_permalink() ),
                    esc_attr( get_the_time() ),
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                    esc_html( get_the_author() )
                );

            }
            elseif(!$date && $author)
            {
                printf( __( '<span class="meta"> Posted on </span> <a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta"> by </span><img alt="author" src="'.get_template_directory_uri().'/images/authorbutton.png"/>   <a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                    esc_url( get_permalink() ),
                    esc_attr( get_the_time() ),
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                    esc_html( get_the_author() )
                );
            }
            else
            {
                printf( __( '<span class="meta"> Posted on </span> <a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta"> by </span><a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                    esc_url( get_permalink() ),
                    esc_attr( get_the_time() ),
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                    esc_html( get_the_author() )
                );

            }
            echo '</div>';

        else:
            $var_date=get_option('ttr_remove_date',true);
            $var_author=get_option('ttr_remove_author_name',true);
            echo '<div class="postedon">';
            if ( is_sticky() && is_home() && ! is_paged() ){
                echo '<span class="featured-post"></span>';
                echo '<span style="clear:both;">'.__( 'Sticky', CURRENT_THEME ).'</span>';
            }
            if($date && $author)
            {

                if($var_date && $var_author)
                {
                    printf( __( '<span class="meta"> '. __('Posted on',CURRENT_THEME ). '</span> <img alt="date" src="'. get_template_directory_uri().'/images/datebutton.png"/><a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta">  '. __('by ',CURRENT_THEME ). ' </span> <img alt="author" src="'.get_template_directory_uri().'/images/authorbutton.png"/>   <a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() ),
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                        esc_html( get_the_author() )
                    );
                }
                else if($var_author){
                    printf( __( '<span class="meta-sep"> '. __('Posted by',CURRENT_THEME ). '</span> <img alt="author" src="'.get_template_directory_uri().'/images/authorbutton.png"/> %1$s', CURRENT_THEME ),
                        sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url( get_the_author_meta( 'ID' ) ),
                            sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                            get_the_author())
                    );
                }

                else if($var_date)
                {
                    printf( __( '<span class="meta">  '. __('Posted on',CURRENT_THEME ). '</span><img alt="date" src="'. get_template_directory_uri().'/images/datebutton.png"/> <time datetime="%3$s" pubdate>%4$s</time></a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() )
                    );
                }
            }

            else if($date && !$author)
            {
                if($var_date && $var_author)
                {
                    printf( __( '<span class="meta"> '. __('Posted on',CURRENT_THEME ). '</span> <img alt="date" src="'. get_template_directory_uri().'/images/datebutton.png"/><a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta"> '. __('by ',CURRENT_THEME ). '</span><a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() ),
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                        esc_html( get_the_author() )
                    );
                }
                else if($var_author){
                    printf( __( '<span class="meta-sep"> '. __('Posted by',CURRENT_THEME ). '</span> %1$s ', CURRENT_THEME ),
                        sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url( get_the_author_meta( 'ID' ) ),
                            sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                            get_the_author())
                    );
                }

                else if($var_date)
                {
                    printf( __( '<span class="meta"> '. __('Posted on',CURRENT_THEME ). '</span> <img alt="date" src="'. get_template_directory_uri().'/images/datebutton.png"/> <time datetime="%3$s" pubdate>%4$s</time></a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() )
                    );
                }
            }
            elseif(!$date && $author)
            {
                if($var_date && $var_author)
                {
                    printf( __( '<span class="meta"> '. __('Posted on',CURRENT_THEME ). '</span> <a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta">  '. __('by ',CURRENT_THEME ). ' </span><img alt="author" src="'.get_template_directory_uri().'/images/authorbutton.png"/>   <a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() ),
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                        esc_html( get_the_author() )
                    );
                }
                else if($var_author){
                    printf( __( '<span class="meta-sep"> '. __('Posted by',CURRENT_THEME ). '</span> <img alt="author" src="'.get_template_directory_uri().'/images/authorbutton.png"/> %1$s  ', CURRENT_THEME ),
                        sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url( get_the_author_meta( 'ID' ) ),
                            sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                            get_the_author())
                    );
                }

                else if($var_date)
                {
                    printf( __( '<span class="meta">  '. __('Posted on',CURRENT_THEME ). ' <time datetime="%3$s" pubdate>%4$s</time></a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() )
                    );
                }
            }
            else
            {

                if($var_date && $var_author)
                {
                    printf( __( '<span class="meta"> '. __('Posted on',CURRENT_THEME ). '</span> <a href="%1$s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s" pubdate>%4$s</time></a><span class = "meta"> '. __('by ',CURRENT_THEME ). '</span><a href="%5$s" title="%6$s" rel="author">%7$s</a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() ),
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                        esc_html( get_the_author() )
                    );
                }
                else if($var_author){
                    printf( __( '<span class="meta-sep"> '. __('Posted by',CURRENT_THEME ). '</span>  %1$s  ', CURRENT_THEME ),
                        sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url( get_the_author_meta( 'ID' ) ),
                            sprintf( esc_attr__( 'View all posts by %s', CURRENT_THEME ), get_the_author() ),
                            get_the_author())
                    );
                }

                else if($var_date)
                {
                    printf( __( '<span class="meta"> '. __('Posted on',CURRENT_THEME ). '<time datetime="%3$s" pubdate>%4$s</time></a>', CURRENT_THEME ),
                        esc_url( get_permalink() ),
                        esc_attr( get_the_time() ),
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() )
                    );
                }

            }
            echo '</div>';
        endif;
    }
endif;


/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_body_classes( $classes ) {

    if ( ! is_multi_author() ) {
        $classes[] = 'single-author';
    }

    if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
        $classes[] = 'singular';

    return $classes;
}
add_filter( 'body_class', 'twentythirteen_body_classes' );


function theme_nav_menu($cssprefix,$location,$mmenu,$magmenu,$menuh,$vmenuh,$ocmenu,$menuname='')
{
    global $justify;
	
    $output='';
    if($menuname=='')
    {
        $locations = get_nav_menu_locations();

        if(empty($locations))
            $menu=NULL;
        else
            $menu = wp_get_nav_menu_object( $locations[ $location] );
    }
    else {
        $menu = wp_get_nav_menu_object($menuname);
    }

    if($menu==NULL)
    {
        return generate_menu($cssprefix,$mmenu,$magmenu,$menuh,$vmenuh, $ocmenu);
    }
    else
	{
       $menu_items = wp_get_nav_menu_items( $menu->term_id );
       $count= 0;
	   
        foreach($menu_items as $key=>$menu_item )
        {
		    if($menu_item->menu_item_parent!=0)
                continue;
				$count++;		
	    }
		
		$count1=0;
		
        foreach($menu_items as $key=>$menu_item )
        {

            $menu_item->classes = empty( $menu_item->classes ) ? (array) get_post_meta( $menu_item->ID, '_menu_item_classes', true ) : $menu_item->classes;
            $liclass = $menu_item->classes[0];

            if($menu_item->menu_item_parent!=0)
                continue;
            $childs=theme_getsubmenu($menu_items,$menu_item);
         
            if( !empty($menu_item->url) )
            {
                $count1++;
			
                if(empty($childs))
                {

                    if( theme_curPageURL()===$menu_item->url)
                    {
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="' . $menu_item->url . '" class="'.$cssprefix.$mmenu.'_items_parent_link_active" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                    }
                    else if (function_exists('woocommerce_get_page_id') && (int) woocommerce_get_page_id('shop') == $menu_item->object_id &&  is_shop())
                    {
                        $shop_page = (int) woocommerce_get_page_id('shop');
                        if ( $shop_page == $menu_item->object_id)
                        {
                            $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="' . $menu_item->url . '" class="'.$cssprefix.$mmenu.'_items_parent_link_active" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                        }

                    }
                    else
					{
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown"><a href="' . $menu_item->url . '" class="'.$cssprefix.$mmenu.'_items_parent_link" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                    }
					
                    if ($count1 != $count)
				   {
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        }
                        else
                        {
						    $output .= ('</a><hr class="horiz_separator" />');
                        }
                    }
					else
					{
					 $output .= ('</a>');
					}

                    $output.='</li>';
                }
                else
                {

                    if(theme_curPageURL()===$menu_item->url)
                    {
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="' . $menu_item->url . '" class="'.$cssprefix.$mmenu.'_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                    }
                    else if (function_exists('woocommerce_get_page_id') && (int) woocommerce_get_page_id('shop') == $menu_item->object_id &&  is_shop())
                    {
                        $shop_page = (int) woocommerce_get_page_id('shop');
                        if ( $shop_page == $menu_item->object_id)
                        {
                            $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="' . $menu_item->url . '" class="'.$cssprefix.$mmenu.'_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"  target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                        }

                    }
                    else
					{
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown"><a href="' . $menu_item->url . '" class="'.$cssprefix.$mmenu.'_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown"  target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                    }
					
                   if ($count1 != $count)
				   {
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        }
                        else
                        {
						    $output .= ('</a><hr class="horiz_separator" />');
                        }
                    }
					else
					{
					 $output .= ('</a>');
					}
					
                    $output.=generate_level1_custom_children($menu_items, $childs, $mmenu, $magmenu, $menuh, $vmenuh);
                    $output.='</li>';
                }

            }
            else
            {
                if(empty($childs))
                {

                    if( theme_curPageURL()===$menu_item->url)
                    {
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="javascript:void(0)" class="'.$cssprefix.$mmenu.'_items_parent_link_active" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                    }
                    else if (function_exists('woocommerce_get_page_id') && (int) woocommerce_get_page_id('shop') == $menu_item->object_id &&  is_shop())
                    {
                        $shop_page = (int) woocommerce_get_page_id('shop');
                        if ( $shop_page == $menu_item->object_id)
                        {
                            $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="javascript:void(0)" class="'.$cssprefix.$mmenu.'_items_parent_link_active" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                        }

                    }
                    else
					{
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown"><a href="javascript:void(0)" class="'.$cssprefix.$mmenu.'_items_parent_link" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                    }
					
                    if ($count1 != $count)
				   {
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        }
                        else
                        {
						    $output .= ('</a><hr class="horiz_separator" />');
                        }
                    }
					else
					{
					 $output .= ('</a>');
					}
					
                    $output.='</li>';
                }
                else
                {

                    if(theme_curPageURL()===$menu_item->url)
                    {
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="javascript:void(0)" class="'.$cssprefix.$mmenu.'_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                    }
                    else if (function_exists('woocommerce_get_page_id') && (int) woocommerce_get_page_id('shop') == $menu_item->object_id &&  is_shop())
                    {
                        $shop_page = (int) woocommerce_get_page_id('shop');
                        if ( $shop_page == $menu_item->object_id)
                        {
                            $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown active"><a href="javascript:void(0)" class="'.$cssprefix.$mmenu.'_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"  target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title ;
                        }

                    }
                    else
					{
                        $output.='<li class="'.$liclass." ".$cssprefix.$mmenu.'_items_parent dropdown"><a href="javascript:void(0)" class="'.$cssprefix.$mmenu.'_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown"  target="'.$menu_item->target.'"><span class="menuchildicon"></span>' . $menu_item->title  ;
                    }

                   if ($count1 != $count)
				   {
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        }
                        else
                        {
						    $output .= ('</a><hr class="horiz_separator" />');
                        }
                    }
					else
					{
					 $output .= ('</a>');
					}

                    $output.=generate_level1_custom_children($menu_items, $childs, $mmenu, $magmenu, $menuh, $vmenuh);
                    $output.='</li>';
                }

            }


        }

        return $output;
    }
}


function theme_curPageURL() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}


function theme_getsubmenu($menu_items,$parent){
    $submenu = array();  // all menu items under $menuID

    foreach($menu_items as $key => $item){
        if($item->menu_item_parent == $parent->ID)
        {

            $submenu[] = $item;

        }

    }
    return $submenu;
}



function generate_menu($cssprefix="ttr_",$meenu, $magmenu, $menuh, $vmenuh, $ocmenu)
{
   
    global $justify;

    $output='';
    if( is_front_page())
    {
        $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown active"><a href="' . get_home_url(null,'/') . '" class="'.$cssprefix.$meenu.'_items_parent_link_active"><span class="menuchildicon"></span>'.__('Home',CURRENT_THEME) ;
       
	   /* $output .= ('</a><hr class="horiz_separator" />'); */
		
		     if($justify)
             {
              $output .= ('<hr class="horiz_separator" /> </a>');

             }
             else
             {
              $output .= ('</a><hr class="horiz_separator" />');
             }
						
        $output .= '</li>';
    }
    else
	{
        $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown"><a href="' . get_home_url(null,'/') . '" class="'.$cssprefix.$meenu.'_items_parent_link"><span class="menuchildicon"></span>'.__('Home',CURRENT_THEME) ;
       
	   /* $output .= ('</a><hr class="horiz_separator" />'); */
		
		     if($justify)
             {
              $output .= ('<hr class="horiz_separator" /> </a>');

             }
             else
             {
              $output .= ('</a><hr class="horiz_separator" />');
             }
		
        $output .= '</li>';
    }

   $pages=get_pages(array('child_of' => 0,'hierarchical' => 0,'parent' => 0,'sort_column' => 'menu_order,post_title'));
  
   $count = count($pages);

	    $count2= 0;
        foreach($pages as $key=>$pagg )
        {
		    if($pagg->post_parent==0)
                continue;
				$count2++;		
	    }
		$count1=0;

    foreach($pages as $key=>$pagg )
    {
        $childs=get_pages(array('child_of' => $pagg->ID,'hierarchical' => 0,'parent' => $pagg->ID,'sort_column' => 'menu_order,post_title'));

         $count1++;
		 
        if(empty($childs))
        {
            if(home_url()!=untrailingslashit(get_permalink( $pagg->ID)))
            {

                if( get_permalink()===get_permalink( $pagg->ID))
                {
                    $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown active"><a href="' . get_permalink( $pagg->ID ) . '" class="'.$cssprefix.$meenu.'_items_parent_link_active"><span class="menuchildicon"></span>' . $pagg->post_title ;
				
				/* 
                 if ($key != ($count - 1))
                        $output .= ('<hr class="horiz_separator" />'); 
				     */
						
				   if ($count1 != $count2)
					{
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /> </a>');

                        }
                        else
                        {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }

                    }
                   else
					{
					 $output .= ('</a>');
					}        

					$output .= '</li>';
                }
                else if (function_exists('woocommerce_get_page_id') && (int) woocommerce_get_page_id('shop') === $pagg->ID &&  is_shop())
                {
                    $shop_page = (int) woocommerce_get_page_id('shop');
                    if ( $shop_page === $pagg->ID)
                    {
                        $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown active"><a href="' . get_permalink( $pagg->ID ) . '" class="'.$cssprefix.$meenu.'_items_parent_link_active"><span class="menuchildicon"></span>' . $pagg->post_title ;
                     
				 /*  if ($key != ($count - 1))
                         $output .= ('<hr class="horiz_separator" />'); 
				      */
							
				    if ($count1 != $count2)
					{
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /> </a>');

                        }
                        else
                        {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }

                    }
					else
					{
					 $output .= ('</a>');
					}
						
                        $output .= '</li>';
                   }

                }
                else
                {
                    $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown"><a href="' . get_permalink( $pagg->ID ) . '" class="'.$cssprefix.$meenu.'_items_parent_link"><span class="menuchildicon"></span>' . $pagg->post_title ;
                   
				   /* if ($key != ($count - 1))
                        $output .= ('<hr class="horiz_separator" />'); 
					    */
					
					if ($count1 != $count2)
					{
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /> </a>');

                        }
                        else
                        {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }

                    }
					else
					{
					 $output .= ('</a>');
					}
					
                    $output .= '</li>';
                }
            }
        }
        else{
            if(home_url()!=untrailingslashit(get_permalink( $pagg->ID)))
            {
                if(get_permalink()===get_permalink( $pagg->ID))
                {
                    $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown active"><a href="' . get_permalink( $pagg->ID ) . '" class="'.$cssprefix.$meenu.'_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" ><span class="menuchildicon"></span>' . $pagg->post_title ;
                }
                else if (function_exists('woocommerce_get_page_id') && (int) woocommerce_get_page_id('shop') === $pagg->ID &&  is_shop())
                {
                    $shop_page = (int) woocommerce_get_page_id('shop');
                    if ( $shop_page === $pagg->ID)
                    {
                      $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown active"><a href="' . get_permalink( $pagg->ID ) . '" class="'.$cssprefix.$meenu.'_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" ><span class="menuchildicon"></span>' . $pagg->post_title ;
                    }

                }
                else
				{
                    $output.='<li class="'.$cssprefix.$meenu.'_items_parent dropdown"><a href="' . get_permalink( $pagg->ID ) . '" class="'.$cssprefix.$meenu.'_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown" ><span class="menuchildicon"></span>' . $pagg->post_title ;
                }
            }
           
		   /* if ($key != ($count - 1))
                $output .= ('<hr class="horiz_separator" />'); 
				*/
				
				    if ($count1 != $count2)
					{
                        if($justify)
                        {
                            $output .= ('<hr class="horiz_separator" /></a>');

                        }
                        else
                        {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }

                    }
                    else
					{
					 $output .= ('</a>');
					}		
					
            $output.=generate_level1_children($childs, $meenu, $magmenu, $menuh, $vmenuh);
            $output.='</li>';
        }

    }

    return $output;

}

function generate_level1_children($args, $mmenu, $magmenu, $menuh, $vmenuh)
{
    $output='';

    if('menu' == $mmenu)
    {
        $output.='<ul class="child dropdown-menu" role="menu">';
    }
    else
    {
        if($menuh)
        {
            /* if($vmenuh)
             {
                 $output.='<ul id="dropdown-menu" class="child dropdown-menu">';
             }
             else
             {
                 $output.='<ul id="dropdown-menu" class="child dropdown-menu">';
             }*/

            $output.='<ul id="dropdown-menu" class="child dropdown-menu" role="menu">';

        }
        else
        {
            $output.='<ul id="dropdown-menu" class="child collapse" role="menu">';

        }
    }

    $count = count($args);

    foreach($args as $key=>$child)
    {
        $child->classes = empty( $child->classes ) ? (array) get_post_meta( $child->ID, '_menu_item_classes', true ) : $child->classes;
        $liclass = $child->classes[0];
        $childs=get_pages(array('child_of' => $child->ID,'hierarchical' => 0,'parent' => $child->ID,'sort_column' => 'menu_order,post_title'));
        if(empty($childs))
        {
            if($magmenu)
            {
                $output.= '<li class="'.$liclass.'span1 unstyled dropdown dropdown-submenu"><a class="subchild dropdown toggle" data-toggle="dropdown" href="' .  get_permalink( $child->ID ) .  '" target="'.$child->target.'"><span class="menuchildicon"></span>' .   $child->post_title .  '</a>';
            }
            else
            {
                $output.= '<li class="'.$liclass.'dropdown dropdown-submenu"><a class="subchild dropdown toggle" data-toggle="dropdown" href="' .  get_permalink( $child->ID ) .  '" target="'.$child->target.'"><span class="menuchildicon"></span>' .   $child->post_title .  '</a>';
            }

            if($magmenu)
            {
                $output .= ('<hr class="separator" />');
            }
            else
            {
                if ($key != ($count - 1))
                {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output.= ('</li>');
        }
        else
        {

            if($magmenu)
            {
                $output.='<li class="span1 unstyled dropdown dropdown-submenu">';
                $output.='<a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink( $child->ID ) . '" class="subchild" target="'.$child->target.'"><span class="menuchildicon"></span>' .  $child->post_title . '</a>';
                if($magmenu)
                {
                    $output .= ('<hr class="separator" />');
                }
                else
                {
                    if ($key != ($count - 1))
                    {
                        $output .= ('<hr class="separator" />');
                    }
                }

            }
            else
            {
                $output.='<li class="'.$liclass.'dropdown dropdown-submenu"><a class="subchild dropdown toggle" data-toggle="dropdown" href="' . get_permalink( $child->ID ) . '" class="subchild" target="'.$child->target.'"><span class="menuchildicon"></span>' .  $child->post_title . '</a>';


                if($magmenu)
                {
                    $output .= ('<hr class="separator" />');
                }
                else
                {
                    if ($key != ($count - 1))
                    {
                        $output .= ('<hr class="separator" />');
                    }
                }
            }

            if($magmenu)
            {
                $output.= generate_level2_children($childs,$mmenu,$magmenu,$menuh, $vmenuh);
                $output.='</li>';
            }
            else
            {
                $output.= generate_level2_children($childs,$mmenu,$magmenu,$menuh, $vmenuh);
                $output.='</li>';
            }

        }
    }

    $output.='</ul>';
    return $output;
}

function generate_level2_children($args,$mmenu,$magmenu,$menuh,$vmenuh)
{
    $output='';

    if('menu'==$mmenu)
    {
        if($magmenu)
        {
            $output.='<ul role="menu">';
        }
        elseif($menuh)
        {
            $output.='<ul class="sub-menu" role="menu">';
        }
        else
        {
            $output.='<ul id="dropdown-menu" class="dropdown-menu sub-menu" role="menu">';
        }

    }
    else
    {
        if($magmenu)
        {
            $output.='<ul role="menu">';
        }
        elseif($menuh)
        {
            if($vmenuh)
            {
                $output.='<ul class="sub-menu" role="menu">';
            }
            else
            {
                $output.='<ul id="dropdown-menu" class="dropdown-menu sub-menu">';
            }
        }
        else
        {
            $output.='<ul class="sub-menu" role="menu">';
        }

    }

    $count = count($args);
    foreach($args as $key=>$child)
    {
        $child->classes = empty( $child->classes ) ? (array) get_post_meta( $child->ID, '_menu_item_classes', true ) : $child->classes;
        $liclass = $child->classes[0];
        $childs=get_pages(array('child_of' => $child->ID,'hierarchical' => 0,'parent' => $child->ID,'sort_column' => 'menu_order,post_title'));
        if(empty($childs))
        {
            $output.='<li class="'.$liclass.'"><a href="' . get_permalink( $child->ID ) . '" target="'.$child->target.'"><span class="menuchildicon"></span>' . $child->post_title . '</a>';
            if($magmenu)
            {
                $output .= ('<hr class="separator" />');
            }
            else
            {
                if ($key != ($count - 1))
                {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output.='</li>';
        }
        else{
            $output.='<li class="'.$liclass.'"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink( $child->ID ) . '" target="'.$child->target.'"><span class="menuchildicon"></span>' . $child->post_title . '</a>';
            if($magmenu)
            {
                $output .= ('<hr class="separator" />');
            }
            else
            {
                if ($key != ($count - 1))
                {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output.= generate_level2_children($childs,$mmenu, $magmenu,$menuh, $vmenuh);
            $output.='</li>';
        }
    }
    $output.='</ul>';
    return $output;
}


function generate_level1_custom_children($menu_items, $args, $mmenu, $magmenu, $menuh, $vmenuh)
{
    $output='';

    if('menu' == $mmenu)
    {
        $output.='<ul class="child dropdown-menu" role="menu">';
    }
    else
    {
        if($menuh)
        {
            /*   if($vmenuh)
               {
                   $output.='<ul id="dropdown-menu" class="child dropdown-menu" role="menu">';
               }
               else
               {
                   $output.='<ul class="child dropdown-menu" role="menu">';
               }*/
            $output.='<ul id="dropdown-menu" class="child dropdown-menu" role="menu">';

        }
        else
        {
            $output.='<ul id="dropdown-menu" class="child collapse" role="menu">';

        }

    }
    $count = count($args);

    foreach($args as $key=>$child)
    {
        $child->classes = empty( $child->classes ) ? (array) get_post_meta( $child->ID, '_menu_item_classes', true ) : $child->classes;
        $liclass = $child->classes[0];
        $childs=theme_getsubmenu($menu_items,$child);
        if(empty($childs))
        {
            if($magmenu)
            {
                $output .= '<li class="' . $liclass . 'span1 unstyled dropdown dropdown-submenu"><a class="subchild dropdown toggle" data-toggle="dropdown" href="' . $child->url . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
            }
            else
            {
                $output .= '<li class="' . $liclass . 'dropdown dropdown-submenu"><a class="subchild dropdown toggle" data-toggle="dropdown" href="' . $child->url . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
            }
            if($magmenu)
            {
                $output .= ('<hr class="separator" />');
            }
            else
            {
                if ($key != ($count - 1))
                {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output.= '</li>';

        }

        else
        {

            if($magmenu)
            {
                $output.='<li class="span1 unstyled dropdown dropdown-submenu">';
                $output.='<a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink( $child->ID ) . '" class="subchild" target="'.$child->target.'"><span class="menuchildicon"></span>' .  $child->title . '</a>';
                if($magmenu)
                {
                    $output .= ('<hr class="separator" />');
                }
                else
                {
                    if ($key != ($count - 1))
                    {
                        $output .= ('<hr class="separator" />');
                    }
                }
            }
            else
            {

                $output.='<li class="'.$liclass.'dropdown dropdown-submenu"><a class="subchild dropdown toggle" data-toggle="dropdown" href="' . get_permalink( $child->ID ) . '" class="subchild" target="'.$child->target.'"><span class="menuchildicon"></span>' .  $child->title . '</a>';
                if($magmenu)
                {
                    $output .= ('<hr class="separator" />');
                }
                else
                {
                    if ($key != ($count - 1))
                    {
                        $output .= ('<hr class="separator" />');
                    }
                }

            }

            if($magmenu)
            {
                $output.= generate_level2_custom_children($menu_items,$childs,$mmenu,$magmenu,$menuh,$vmenuh);
                $output.='</li>';
            }
            else
            {
                $output.= generate_level2_custom_children($menu_items,$childs,$mmenu,$magmenu,$menuh,$vmenuh);
                $output.='</li>';
            }

        }

    }

    $output.='</ul>';
    return $output;
}



function generate_level2_custom_children($menu_items,$args,$mmenu,$magmenu,$menuh,$vmenuh)
{
    $output='';
    $count = count($args);

    if('menu'==$mmenu)
    {
        if($magmenu)
        {
            $output.='<ul role="menu">';
        }
        elseif($menuh)
        {
            $output.='<ul class="sub-menu" role="menu">';
        }
        else
        {
            $output.='<ul id="dropdown-menu" class="dropdown-menu sub-menu" role="menu">';
        }

    }
    else
    {
        if($magmenu)
        {
            $output.='<ul role="menu">';
        }
        elseif($menuh)
        {
            if($vmenuh)
            {
                $output.='<ul class="sub-menu" role="menu">';
            }
            else
            {
                $output.='<ul id="dropdown-menu" class="dropdown-menu sub-menu">';
            }
        }
        else
        {
            $output.='<ul class="sub-menu" role="menu">';
        }

    }

    foreach($args as $key=>$child)
    {
        $child->classes = empty( $child->classes ) ? (array) get_post_meta( $child->ID, '_menu_item_classes', true ) : $child->classes;
        $liclass = $child->classes[0];
        $childs=theme_getsubmenu($menu_items,$child);
        if(empty($childs))
        {
            $output.='<li class="'.$liclass.'"><a href="' . $child->url . '" target="'.$child->target.'"><span class="menuchildicon"></span>' . $child->title . '</a>';
            if($magmenu)
            {
                $output .= ('<hr class="separator" />');
            }
            else
            {
                if ($key != ($count - 1))
                {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output.='</li>';
        }
        else
        {
            $output.='<li class="'.$liclass.'"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . $child->url . '"  target="'.$child->target.'"><span class="menuchildicon"></span>' . $child->title . '</a>';
            if($magmenu)
            {
                $output .= ('<hr class="separator" />');
            }
            else
            {
                if ($key != ($count - 1))
                {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output.= generate_level2_custom_children($menu_items,$childs,$mmenu,$magmenu,$menuh,$vmenuh);
            $output.='</li>';
        }
    }
    $output.='</ul>';
    return $output;
}




function theme_dynamic_sidebar($index){
    global $wp_registered_sidebars, $wp_registered_widgets, $cssprefix, $params, $menuclass;

    if ( is_int($index) ) {
        $index = "sidebar-$index";
        $i=0;
    } else {
        $i = 0;
        $index = sanitize_title($index);
        foreach ( (array) $wp_registered_sidebars as $key => $value ) {
            if ( sanitize_title($value['name']) == $index ) {
                $index = $key;
                break;
            }
        }
    }

    $sidebars_widgets = wp_get_sidebars_widgets();
    if ( empty( $sidebars_widgets ) )
        return false;



    if ( empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $sidebars_widgets) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
        return false;

    $sidebar = $wp_registered_sidebars[$index];

    ob_start();
    if(!dynamic_sidebar($index)){
        return FALSE;
    }
    $sidebarcontent=ob_get_clean();

    $data = explode("~tt", $sidebarcontent);

    foreach ( (array) $sidebars_widgets[$index] as $id ) {
        $params = array_merge(
            array( array_merge( (array)$sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
            (array) $wp_registered_widgets[$id]['params']);
        if (!isset($data[$i]))
        {
            continue;
        }

        $classname_ = '';
        foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn ) {
            if ( is_string($cn) )
                $classname_ .= '_' . $cn;
            elseif ( is_object($cn) )
                $classname_ .= '_' . get_class($cn);
        }
        $classname_ = ltrim($classname_, '_');
        $params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);
        $params = apply_filters( 'dynamic_sidebar_params', $params );

        $widget = $data[$i];

        $i++;
        if(!is_string($widget) || strlen(str_replace(array('&nbsp;', ' ', "\n", "\r", "\t"), '', $widget)) == 0) continue;
        if(strlen(str_replace(array('&nbsp;', ' ', "\n", "\r", "\t"), '', $params[0]['before_title'])) == 0)
        {
            $widget = preg_replace('#(\'\').*?('.$params[0]['after_title'].')#', '$1$2', $widget);
        }

        $pos=strpos($widget,$params[0]['after_title']);

        $widget_id = $params[0]['widget_id'];

        $widget_obj = $wp_registered_widgets[$widget_id];

        $widget_opt = get_option($widget_obj['callback'][0]->option_name);

        $widget_num = $widget_obj['params'][0]['number'];

        if(isset($widget_opt[$widget_num]['style']))
        {
            $style = $widget_opt[$widget_num]['style'];
        }
        else
            $style = '';

        if($style == "block")
        {
            if ($pos===FALSE) {

                $widget =str_replace($params[0]['before_widget'],'<div class = "'.$cssprefix.'block"> <div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
			<div class = "'.$cssprefix.'block_without_header"> </div> <div id="'.$widget_id.'" class="'.$cssprefix.'block_content">', $widget);
            }
            else
            {
                $widget =str_replace($params[0]['before_widget'],'<div class="'.$cssprefix.'block"><div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div> <div class="'.$cssprefix.'block_header">',$widget);
            }
            $params[0]['after_widget'] = str_replace('~tt', '', $params[0]['after_widget']);
            $widget =str_replace($params[0]['after_widget'], '</div></div>', $widget);
            $widget =str_replace($params[0]['after_title'],'</'.get_option('ttr_heading_tag_block').'></div> <div id="'.$widget_id.'" class="'.$cssprefix.'block_content">',$widget);
            $widget =str_replace($params[0]['before_title'],'<'.get_option('ttr_heading_tag_block').' style="'. 'color:'.get_option('ttr_blockheading').';font-size:'.get_option('ttr_font_size_block').'px;" class="'.$cssprefix.'block_heading">',$widget);
        }
        else if ($style == "none") {
            $classname_ = '';
            foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn ) {
                if ( is_string($cn) )
                    $classname_ .= '_' . $cn;
                elseif ( is_object($cn) )
                    $classname_ .= '_' . get_class($cn);
            }
            $classname_ = ltrim($classname_, '_');
            $widget =str_replace($params[0]['before_widget'], sprintf('<aside id="%1$s" class="widget %2$s">', $id, $classname_), $widget);
            $params[0]['after_widget'] = str_replace('~tt', '', $params[0]['after_widget']);
            $widget =str_replace($params[0]['after_widget'], '</aside>', $widget);
            $widget =str_replace($params[0]['after_title'],'</h3>', $widget);
            $widget =str_replace($params[0]['before_title'],'<h3 class="widget-title">', $widget);
        }
        else
        {
            if($index=='sidebar-1' || $index=='sidebar-2' )
            {

                if ($pos===FALSE) {

                    $widget =str_replace($params[0]['before_widget'],'<div class = "'.$cssprefix.'block"> <div style="height:0px;width:0px;overflow:hidden;-webkit-margin-top-collapse: separate;"></div>
			<div class = "'.$cssprefix.'block_without_header"> </div> <div id="'.$widget_id.'" class="'.$cssprefix.'block_content">', $widget);
                }
            }
        }

        echo $widget;

    }


    return true;
}

function theme_comment_form( $args = array(), $post_id = null,$cssprefix="ttr_" ) {
    global $user_identity, $id;

    if ( null === $post_id )
        $post_id = $id;
    else
        $id = $post_id;

    $commenter = wp_get_current_commenter();

    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields =  array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name',CURRENT_THEME ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .'<br/>'.
            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
        'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email',CURRENT_THEME ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .'<br/>'.
            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
        'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website',CURRENT_THEME ) . '</label>' .'<br/>'.
            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
    );

    $required_text = sprintf( ' ' . __('Required fields are marked %s',CURRENT_THEME), '<span class="required">*</span>' );
    $defaults = array(
        'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun',CURRENT_THEME ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'.'<br/>',
        'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.',CURRENT_THEME ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>',CURRENT_THEME ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.',CURRENT_THEME ) . ( $req ? $required_text : '' ) . '</p>',
        'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s',CURRENT_THEME ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'title_reply'          => __( 'Leave a Reply',CURRENT_THEME ),
        'title_reply_to'       => __( 'Leave a Reply to %s',CURRENT_THEME ),
        'cancel_reply_link'    => __( 'Cancel reply',CURRENT_THEME ),
        'label_submit'         => __( 'Post Comment',CURRENT_THEME ),
    );

    $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

    ?>
    <?php if ( comments_open() ) : ?>
        <?php do_action( 'comment_form_before' ); ?>

        <!--<div id="respond">-->
        <?php if(get_option('ttr_comments_form',true)): ?>
            <div class="<?php echo $cssprefix?>comment">
                <div class="<?php echo $cssprefix?>comment_header">
                    <div class="<?php echo $cssprefix?>comment_header_left_border_image">
                        <div class="<?php echo $cssprefix?>comment_header_right_border_image">
                        </div>
                    </div>
                </div>
                <div class="<?php echo $cssprefix?>comment_content">
                    <div class="<?php echo $cssprefix?>comment_content_left_border_image">
                        <div class="<?php echo $cssprefix?>comment_content_right_border_image">

                            <div class="<?php echo $cssprefix?>comment_content_inner">


                                <h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
                                <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
                                    <?php echo $args['must_log_in']; ?>
                                    <?php do_action( 'comment_form_must_log_in_after' ); ?>
                                <?php else : ?>
                                    <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
                                        <?php do_action( 'comment_form_top' ); ?>
                                        <?php if ( is_user_logged_in() ) : ?>
                                            <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
                                            <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
                                        <?php else : ?>
                                            <?php echo $args['comment_notes_before']; ?>
                                            <?php
                                            do_action( 'comment_form_before_fields' );
                                            foreach ( (array) $args['fields'] as $name => $field ) {
                                                echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                                            }
                                            do_action( 'comment_form_after_fields' );
                                            ?>
                                        <?php endif; ?>
                                        <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                                        <?php echo $args['comment_notes_after']; ?>
                                        <div class="form-submit">
						<span class="<?php echo $cssprefix?>button" onmouseover="this.className='<?php echo $cssprefix?>button_hover1';" onmouseout="this.className='<?php echo $cssprefix?>button';">

							<input name="submit" class="btn btn-default" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							</span>
                                            <div style="clear:both;"></div>
                                            <?php comment_id_fields( $post_id ); ?>
                                        </div>
                                        <?php do_action( 'comment_form', $post_id ); ?>
                                    </form>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="<?php echo $cssprefix?>comment_footer">
                    <div class="<?php echo $cssprefix?>comment_footer_left_border_image">
                        <div class="<?php echo $cssprefix?>comment_footer_right_border_image">
                        </div>
                    </div>
                </div>

                <!--	</div>--><!-- #respond -->
            </div>
        <?php endif; ?>
        <?php do_action( 'comment_form_after' ); ?>
    <?php else : ?>
        <?php do_action( 'comment_form_comments_closed' ); ?>
    <?php endif; ?>
<?php
}

function count_sidebar_widgets( $sidebar_id) {
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return FALSE;
    else
        return count( $the_sidebars[$sidebar_id] );
}

function seo_enable_array()
{
    $seo = array(
        array("type" => "open"),
        array("name"=> __("Enable SEO Mode:",CURRENT_THEME),
            "desc" =>"Enable SEO Mode",
            "id" => "ttr_seo_enable",
            "type" => "checkbox",
            "std" => ""),
			array("type" => "close")
    );
    return $seo;
}

function home_settings_array()
{
    $homeseo = array(
        array("type" => "open"),
        array( "name" => __("Home Title",CURRENT_THEME),
            "desc" => "Set the title of home page ",
            "id"=> "ttr_seo_home_title",
            "type" => "textarea",
            "std" => ""),
        array( "name" => __("Home Description",CURRENT_THEME),
            "desc" => "set the description of home page",
            "id"=> "ttr_seo_home_desc",
            "type" => "textarea",
            "std" => ""),
        array( "name" => __("Home Keywords \n\n(Comma Separated)",CURRENT_THEME),
            "desc" => "set the keywords of home page",
            "id"=> "ttr_seo_home_keywords",
            "type" => "textarea",
            "class" => "ttr_seo_use_keywords_select",
            "std" => ""),
        array( "name" => __("Rewrite Titles Format",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE the  Rewrite Page Titles",
            "id"=> "ttr_seo_rewrite_titles",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Capitalize Titles",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE the Capitalize Page Titles",
            "id"=> "ttr_seo_capitalize_titles",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Capitalize Category Titles",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE the Capitalize Category Titles",
            "id"=> "ttr_seo_capitalize_category",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Page Title Format:",CURRENT_THEME),
            "desc" => "on/off the Page Title Format",
            "id"=> "ttr_seo_page_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "%page_title% | %blog_title%",
            "options" => array("%page_title%","%blog_title%","%page_title% | %blog_title%","%blog_title% | %page_title%")),
        array( "name" => __("Post Title Format:",CURRENT_THEME),
            "desc" => "on/off the Post Title Format",
            "id"=> "ttr_seo_post_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "%page_title% | %blog_title%",
            "options" => array("%post_title%","%blog_title%","%post_title% | %blog_title%","%blog_title% | %post_title%")),
        array( "name" => __("Category Title Format:",CURRENT_THEME),
            "desc" => "on/off the Category Title Format",
            "id"=> "ttr_seo_category_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "%category_title% | %blog_title%",
            "options" => array("%category_title%","%blog_title%","%category_title% | %blog_title%","%blog_title% | %category_title%")),
        array( "name" => __("Date Archive Title Format:",CURRENT_THEME),
            "desc" => "on/off the Date Archive Title Format:",
            "id"=> "ttr_seo_date_archive_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "%date% | %blog_title%",
            "options" => array("%date%","%blog_title%","%date% | %blog_title%","%blog_title% | %date%")),
        array( "name" => __("Author Archive Title Format:",CURRENT_THEME),
            "desc" => "on/off the Anchor Archive Title Format",
            "id"=> "ttr_seo_anchor_archive_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "%author% | %blog_title%",
            "options" => array("%author%","%blog_title%","%author% | %blog_title%","%blog_title% | %author%")),
        array( "name" => __("Tag Title Format:",CURRENT_THEME),
            "desc" => "on/off the Tag Title Format",
            "id"=> "ttr_seo_tag_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "%tag% | %blog_title%",
            "options" => array("%tag%","%blog_title%","%tag% | %blog_title%","%blog_title% | %tag%")),
        array( "name" => __("Search Title Format:",CURRENT_THEME),
            "desc" => "on/off the Search Title Format:",
            "id"=> "ttr_seo_search_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "%search% | %blog_title%",
            "options" => array("%search%","%blog_title%","%search% | %blog_title%","%blog_title% | %search%")),
        array( "name" => __("404 Title Format:",CURRENT_THEME),
            "desc" => "on/off the 404 Title Format",
            "id"=> "ttr_seo_404_title",
            "type" => "select",
            "class" => "ttr_seo_rewrite_titles_select",
            "std" => "Nothing found for %request_words%",
            "options" => array("%request_words%","%blog_title%","%request_words% | %blog_title%","%blog_title% | %request_words%")),
        array("type" => "close")
    );
    return $homeseo;
}
function general_settings_array()
{
    $generalseo = array(
        array("type" => "open"),
        array( "name" => __("Canonical URLs:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE the Canonical URLs",
            "id"=> "ttr_seo_canonical_urls",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Use Meta Keywords:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Keywords",
            "id"=> "ttr_seo_use_keywords",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Set Default Keywords (Comma Separated):",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE the Canonical URLs",
            "id"=> "ttr_seo_default_keywords",
            "type" => "text",
            "std" => ""),
        array( "name" => __("Use Categories as Keywords:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Categories for META Keywords",
            "id"=> "ttr_seo_categories_meta_keywords",
            "type" => "checkbox",
            "class" => "ttr_seo_use_keywords_select",
            "std" => "true"),
        array( "name" => __("Use Tags as Keywords:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_tags_meta_keywords",
            "type" => "checkbox",
            "class" => "ttr_seo_use_keywords_select",
            "std" => "true"),
        array( "name" => __("Autogenerate Descriptions:",CURRENT_THEME),
            "desc" => "Check this box if you would like to enable Autogenerate Descriptions",
            "id"=> "ttr_seo_autogenerate_description",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Set default to Non-Index for all:",CURRENT_THEME),
            "desc" => " simply shows the label as Default To Non-Index",
            "id"=> "ttr_seo_nonindex",
            "type" => "label",
            "std" => ""),
        array( "name" => __("Post:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_nonindex_post",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Page:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_nonindex_page",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Set default to No-Follow for all:",CURRENT_THEME),
            "desc" => " simply shows the label as Default To No-Follow",
            "id"=> "ttr_seo_nofollow",
            "type" => "label",
            "std" => ""),
        array( "name" => __("Post:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_nofollow_post",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Page:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_nofollow_page",
            "type" => "checkbox",
            "std" => "true"),
        array("type" => "close")
    );
    return $generalseo;
}

function web_social_array()
{
    $webseo = array(
        array("type" => "open"),
        array("name"=> __("Google Webmaster Tools:",CURRENT_THEME),
            "desc" =>"For Webmaster Verification",
            "id" => "ttr_seo_google_webmaster",
            "type" => "text",
            "std" => ""),
        array("name"=> __("Bing Webmaster Tools:",CURRENT_THEME),
            "desc" =>"For Webmaster Verification",
            "id" => "ttr_seo_bing_webmaster",
            "type" => "text",
            "std" => ""),
        array("name"=> __("Pinterst Webmaster Tools:",CURRENT_THEME),
            "desc" =>"For Webmaster Verification",
            "id" => "ttr_seo_pinterst_webmaster",
            "type" => "text",
            "std" => ""),
        array("name"=> __("Google Plus Default Profile:",CURRENT_THEME),
            "desc" =>"For Google Analytics",
            "id" => "ttr_seo_google_plus",
            "type" => "text",
            "std" => ""),
        array("type" => "close")
    );
    return $webseo;
}
function sitemap_array()
{
    $sitemapseo = array(
        array("type" => "open"),
        array( "name" => __("You can find your XML Sitemap here:",CURRENT_THEME),
            "desc" => "By using this button sitemap is opened ",
            "id"=> "ttr_seo_sitemap",
            "type" => "link",
            "std" => "Sitemap.xml"),
        array( "name" => __("Include Post types for Sitemap:",CURRENT_THEME),
            "desc" => "By using this button sitemap is opened ",
            "id"=> "ttr_seo_exclude_types",
            "type" => "label",
            "std" => ""),
        array( "name" => __("Pages (page):",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Categories for META Keywords",
            "id"=> "ttr_seo_exclude_page",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Post (post):",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_exclude_post",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Media (attachment):",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_exclude_media",
            "type" => "checkbox",
            "std" => "true"),
        array("type" => "close")
    );
    return $sitemapseo;
}
function advanced_array()
{
    $advancedseo = array(
        array("type" => "open"),
        array( "name" => __("Use No-index for Date Archive:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Categories for META Keywords",
            "id"=> "ttr_seo_noindex_date_archive",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Use No-index for Author Archive:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_noindex_author_archive",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Use No-index for Tag Archive:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_noindex_tag_archive",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Use No-index for Categories:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Keywords",
            "id"=> "ttr_seo_noindex_categories",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Use No-follow for Categories:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Keywords",
            "id"=> "ttr_seo_nofollow_categories",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Use No-index for Search Archive:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_noindex_search",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Use No-follow for Search Archive:",CURRENT_THEME),
            "desc" => "Check this box if you would like to DISABLE Use Original Titles",
            "id"=> "ttr_seo_nofollow_search",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Additional Post Headers:",CURRENT_THEME),
            "desc" => "Give any Additional Post Headers ",
            "id"=> "ttr_seo_additional_post_header",
            "type" => "textarea",
            "std" => ""),
        array( "name" => __("Additional Page Headers:",CURRENT_THEME),
            "desc" => "Give any Additional Page Headers",
            "id"=> "ttr_seo_additional_page_header",
            "type" => "textarea",
            "std" => ""),
        array( "name" => __("Additional Front Page Headers:",CURRENT_THEME),
            "desc" => "Give any Additional Front page Headers",
            "id"=> "ttr_seo_additional_fpage_header",
            "type" => "textarea",
            "std" => ""),
        array("type" => "close")
    );
    return $advancedseo;
}

function dashboard_array(){
    $dashboard = array(
        array("type" => "open"),
        array("name"=> __("Next scheduled backups:",CURRENT_THEME),
            "desc" =>"For showing Next scheduled Backup Recovery Mode",
            "id" => "ttr_next_scheduled_backup",
            "type" => "label",
            "std" => "-- N/A --"),
        array("name"=> __("Last Manual Backup job run:",CURRENT_THEME),
            "desc" =>"For showing last backup details Backup Recovery Mode",
            "id" => "ttr_last_backup",
            "type" => "label",
            "std" => "-- N/A --"),
        array("name"=> __("FTP Server Address:",CURRENT_THEME),
            "desc" =>"Takes the ftp address from the user",
            "id" => "ttr_ftp_server_address",
            "type" => "text",
            "std" => ""),
        array("name"=> __("FTP User name:",CURRENT_THEME),
            "desc" =>"Takes the ftp user name from the user",
            "id" => "ttr_ftp_user_name",
            "type" => "text",
            "std" => ""),
        array("name"=> __("FTP User password:",CURRENT_THEME),
            "desc" =>"Takes the ftp user password from the user",
            "id" => "ttr_ftp_user_password",
            "type" => "password",
            "std" => ""),
        array("name"=> __("Email of recipient :",CURRENT_THEME),
            "desc" =>"Takes the email address of receiver from the user",
            "id" => "ttr_ftp_recipient_email",
            "type" => "text",
            "std" => ""),
        array("type" => "close")
    );
    return $dashboard;
}

function backup_array()
{
    $backup = array(
        array("type" => "open"),
        array( "name" => __(" Database Backup (.sql file):",CURRENT_THEME),
            "desc" => "Check this box if you would like to enable backup/recovery mode",
            "id"=> "ttr_manual_database_backup",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Enable Automatic Backup/Recovery Mode:",CURRENT_THEME),
            "desc" => "Check this box if you would like to enable backup/recovery mode",
            "id"=> "ttr_automatic_backup_recovery_enable",
            "type" => "checkbox",
            "std" => ""),
        array("name"=> __("Include Plugins ",CURRENT_THEME),
            "desc" =>"enable to include plugins to backup folder",
            "id" => "ttr_include_plugin_backup",
            "type" => "checkbox",
            "std" => "true"),
        array("name"=> __("Include Themes",CURRENT_THEME),
            "desc" =>"enable to include themes to backup folder",
            "id" => "ttr_include_theme_backup",
            "type" => "checkbox",
            "std" => "true"),
        array("name"=> __("Include Uploads",CURRENT_THEME),
            "desc" =>"enable to include uploads to backup folder",
            "id" => "ttr_include_uploads_backup",
            "type" => "checkbox",
            "std" => "true"),
        array( "name" => __("Backup Folder name:",CURRENT_THEME),
            "desc" => "Give the folder name to take the backup ",
            "id"=> "ttr_backup_folder_name",
            "type" => "text",
            "std" => "Backup"),
        array( "name" => __("Automatic Backup intervals:",CURRENT_THEME),
            "desc" => "Select the database interval to take backup",
            "id"=> "ttr_automatic_backup_interval",
            "type" => "select",
            "std" => "Select",
            "options" => array(__("Every 10 mins",CURRENT_THEME), __("Every hour",CURRENT_THEME), __("Every 4 hours",CURRENT_THEME), __("Every 8 hours",CURRENT_THEME), __("Every 12 hours",CURRENT_THEME), __("Daily",CURRENT_THEME), __("Weekly",CURRENT_THEME))),
        array( "name" => __("Choose your Remote Storage:",CURRENT_THEME),
            "desc" => "Select the time to the backup",
            "id"=> "ttr_storage_backup",
            "type" => "select",
            "std" => "- Select -",
            "options" =>  array( __("Local",CURRENT_THEME), __("FTP",CURRENT_THEME),__("Email",CURRENT_THEME))),
        array("type" => "close")
    );
    return $backup;
}
function recovery_array()
{
    $recovery = array(
        array("type" => "open"),
			array("name"=> __("Select Backup Folder (.zip file only) ",CURRENT_THEME),
            "desc" =>"allows you to select the Zip folder",
            "id" => "ttr_browse",
            "type" => "file",
            "std" => ""),
        array("name"=> __("Restore Database(.sql) ",CURRENT_THEME),
            "desc" =>"enable to include datbases to backup folder",
            "id" => "ttr_include_database_restore",
            "type" => "checkbox",
            "std" => ""),
        array("name"=> __("Restore Plugins ",CURRENT_THEME),
            "desc" =>"enable to include plugins to backup folder",
            "id" => "ttr_include_plugin_restore",
            "type" => "checkbox",
            "std" => ""),
        array("name"=> __("Restore Themes",CURRENT_THEME),
            "desc" =>"enable to include themes to backup folder",
            "id" => "ttr_include_theme_restore",
            "type" => "checkbox",
            "std" => ""),
        array("name"=> __("Restore Uploads",CURRENT_THEME),
            "desc" =>"enable to include uploads to backup folder",
            "id" => "ttr_include_uploads_restore",
            "type" => "checkbox",
            "std" => ""),
        array("type" => "close")
    );
    return $recovery;
}

function my_schedules() {
    return array(
        'twomins' => array(
            'interval' => 120, // 60 seconds * 2 minutes
            'display' => 'twomins'
        ),
        'tenmins' => array(
            'interval' => 600, // 60 seconds * 10 minutes
            'display' => 'tenmins'
        ),
        'onehour' => array(
            'interval' => 3600, // 60 seconds * 60 minutes
            'display' => 'onehour'
        ),
        'fourhours' => array(
            'interval' => 14400, // 60 seconds * 60 minutes * 4
            'display' => 'fourhours'
        ),
        'eighthours' => array(
            'interval' => 28800, // 60 seconds * 60 minutes * 8 hours
            'display' => 'eighthours'
        ),
        'twelvehours' => array(
            'interval' => 43200, // 60 seconds * 60 minutes * 12 hours
            'display' => 'twelvehours'
        ),
        'daily' => array(
            'interval' => 86400, // 60 seconds * 60 minutes * 24 hours * 1 day
            'display' => 'daily'
        ),
        'weekly' => array(
            'interval' => 604800, // 60 seconds * 60 minutes * 24 hours * 7 days
            'display' => 'weekly'
        ),

    );
}
add_filter('cron_schedules', 'my_schedules');

add_action( 'prefix_hourly_event', 'prefix_do_this_hourly' );

function prefix_do_this_hourly() {
    autobackup_db();
}

add_action('admin_menu', 'mytheme_add_admin');

function mytheme_add_admin() {

    global $themename, $shortname, $contactformoptions;
    if (  function_exists( 'header_options_array' ) )
        $headeroptions = header_options_array();
    else
        $headeroptions="";


    if (  function_exists( 'postcontent_array' ) )
        $postcontentoptions = postcontent_array();

    if (  function_exists( 'footer_options_array' ) )
        $footeroptions = footer_options_array();
    else
        $footeroptions="";

    if ( function_exists( 'sidebar_options_array' ) )
        $sidebaroptions = sidebar_options_array();
    else
        $sidebaroptions="";

    if (  function_exists( 'general_options_array' ) )
        $generaloptions = general_options_array();

    if (  function_exists( 'mm_options_array' ) )
        $mmoptions = mm_options_array();

    if (  function_exists( 'error_options_array' ) )
        $error = error_options_array();

    if (  function_exists( 'googlemap_options_array' ) )
        $gmapoptions = googlemap_options_array();

	if (  function_exists( 'seo_enable_array' ) )
        $seoenable = seo_enable_array();
	
    if (  function_exists( 'home_settings_array' ) )
        $seooptions = home_settings_array();

    if (  function_exists( 'general_settings_array' ) )
        $genoptions = general_settings_array();

    if (  function_exists( 'web_social_array' ) )
        $weboptions = web_social_array();

    if (  function_exists( 'advanced_array' ) )
        $advancedoptions = advanced_array();

    if (  function_exists( 'sitemap_array' ) )
        $sitemapoptions = sitemap_array();

    if (  function_exists( 'dashboard_array' ) )
        $dashboardoptions = dashboard_array();

    if (  function_exists( 'backup_array' ) )
        $backupoptions = backup_array();

    if (  function_exists( 'recovery_array') )
        $recoveryoptions = recovery_array();

    if (get_bloginfo('version') >= 3.4)
    {    $themename = wp_get_theme(); }
    else
    {    $themename = get_current_theme(); }
    $url = get_template_directory_uri();

    if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__)) {

        if ( isset ( $_GET['tab'] ) )
            $tab = $_GET['tab'];
        else
            $tab = 'postcontent';


        if ( isset ( $_GET['subtab'] ) )
            $subtab = $_GET['subtab'];
        else
            $subtab = 'homepage';

        if ($tab == "header")
        {
            $options = $headeroptions;
        }
        else if ($tab == "postcontent")
        {
            $options = $postcontentoptions;
        }
        else if ($tab == "sidebar")
        {
            $options = $sidebaroptions;
        }
        else if ($tab == "footer")
        {
            $options = $footeroptions;
        }
        else if ($tab == "generaloptions")
        {
            $options = $generaloptions;
        }
        else if ($tab == "mmoptions")
        {
            $options = $mmoptions;
        }
        else if ($tab == "gmap")
        {
            $options = $gmapoptions;
        }

        else if ($tab == "seooptions")
        {
			if ($subtab == "homepage")
            {
                $options = $seoenable;
            }
            else if ($subtab == "home")
            {
                $options = $seooptions;
            }
            else if ($subtab == "general")
            {
                $options = $genoptions;
            }
            else if ($subtab == "web"){
                $options = $weboptions;
            }
            else if ($subtab == "sitemap"){
                $options = $sitemapoptions;
            }
            else{
                $options = $advancedoptions;
            }
        }
        else if ($tab == "backuprecovery")
        {
            if ($subtab == "homepage")
            {
                $options = $dashboardoptions;
            }
            else if ($subtab == "backup")
            {
                $options = $backupoptions;
            }
            else
            {
                $options = $recoveryoptions;
            }
        }

        else
        {
            $options = $error;
        }

        $_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );

       if(isset($_REQUEST['action']))
	   {
            if ( 'ttrsave' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); }  }


                header("Location: admin.php?page=functions.php&tab=".$tab."&saved=true");
                die;
            }

            if ( 'ttrsubsave' == $_REQUEST['action'] ) {
				 foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); }  }
				
                header("Location: admin.php?page=functions.php&tab=".$tab."&subtab=".$subtab."&saved=true");
                die;
            }

            if ( 'ttrsitemap' == $_REQUEST['action'] ) {

                create_sitemap();
                header("Location: admin.php?page=functions.php&tab=".$tab."&subtab=".$subtab."&saved=true");
                die;
            }

            if ( 'ttrbackup' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); }  }
               	backup_db();
				
              //header("Location: admin.php?page=functions.php&tab=".$tab."&subtab=".$subtab."&saved=true");
                
            }
            if ( 'ttrautobackup' == $_REQUEST['action'] ) {
                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); }  }

                $ch=get_option('ttr_automatic_backup_interval');
                $autobackup=get_option('ttr_automatic_backup_recovery_enable',true);
                if($autobackup=="on"){
                    switch($ch){
                        case "Every 2 mins":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'twomins', 'prefix_hourly_event' );
                            }break;
                        case "Every 10 mins":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'tenmins', 'prefix_hourly_event' );
                            }break;
                        case "Every hour":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'onehour', 'prefix_hourly_event' );
                            }break;
                        case "Every 4 hours":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'fourhours', 'prefix_hourly_event' );
                            }break;
                        case "Every 8 hours":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'eighthours', 'prefix_hourly_event' );
                            }break;
                        case "Every 12 hours":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'twelvehours', 'prefix_hourly_event' );
                            }break;
                        case "Daily":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'daily', 'prefix_hourly_event' );
                            }break;
                        case "Weekly":
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'weekly', 'prefix_hourly_event' );
                            }break;
                        default :
                            if (!wp_next_scheduled('prefix_hourly_event')) {
                                wp_schedule_event( time(), 'weekly', 'prefix_hourly_event' );
                            }break;


                            $temp1 = wp_next_scheduled('prefix_hourly_event');
                            $next_timestamp = date("d-m-Y H:i:s",$temp1);
                            update_option('ttr_next_scheduled_backup',$next_timestamp);
                    }}
                else{
                    wp_clear_scheduled_hook( 'prefix_hourly_event' );
                } 
            }
            if ( 'ttrdownload' == $_REQUEST['action'] ) {

                $dir=ABSPATH . 'wp-admin/';
                $files = glob($dir.'*.zip');
                if(!empty($files)){
                    array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_DESC,$files);
                    $file=basename($files[0]);
                    header('Content-type: application/application/zip');
                    header('Content-Disposition: attachment; filename="'.$file.'"');
                    header('Content-Transfer-Encoding: binary');
                    header('Content-Length: '.filesize($file));
                    readfile($file);

                }

            }

            if ( 'ttrrestore' == $_REQUEST['action'] ) {
                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); }  }

						    $filename = $_FILES["ttr_browse"]["name"];
						    $source = $_FILES["ttr_browse"]["tmp_name"];
						    $type = $_FILES["ttr_browse"]["type"];
						    $name = explode(".", $filename);
						    $target_path = ABSPATH.'wp-content/Backup/upload/'.$filename;;
						    if(move_uploaded_file($source, $target_path)) {?>
								<p><b><font color='green'> What you want to restore?</font></b></p>
								
						   <?php  } else { ?>
						   		<p><b><font color='red'> Sorry Zip is not Selected, Try again</font></b></p>
						   <?php }
					
					
                restore_db($target_path);
                print"Restore done";
                header("Location: admin.php?page=functions.php&tab=".$tab."&subtab=".$subtab."&saved=true");
                die;
            }

        }
    }

    add_object_page("Options", __("Theme Options",CURRENT_THEME), 'edit_theme_options', basename(__FILE__), 'mytheme_admin', $url.'/images/settings_theme.png' );
}


add_action('init', 'load_theme_scripts');
function load_theme_scripts() {
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );


}

function my_add_init()

{
    $screen = get_current_screen();
    wp_register_script( 'upload', get_template_directory_uri() .'/js/upload.js', array('jquery','media-upload','thickbox') );
    wp_register_script( 'addtextbox', get_template_directory_uri() .'/js/addtextbox.js', array(),1.0,false );
    wp_enqueue_script( 'addtextbox', get_template_directory_uri() .'/js/addtextbox.js', array(),1.0,false );
    if ($screen->id =='toplevel_page_functions')
    {

        wp_enqueue_script('jquery');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('upload');
        wp_enqueue_style('thickbox');

    }
}
add_action('admin_enqueue_scripts', 'my_add_init');

function options_setup() {
    global $pagenow;

    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
    }
}
add_action( 'admin_init', 'options_setup' );

function replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'functions.php' );
        if ( $referer != '' ) {
            return __('Select this image!',CURRENT_THEME);
        }
    }
    return $translated_text;
}

function options_code($value)
{
    switch ($value['type']) {

        case 'open':
            
            echo '<table class="table table-hover table-bordered">';
            	break;

        case 'close':
           
            echo '</table>';
              break;

        case 'label':
            
            echo '<tr><td><h6>' . $value['name']. '</h6></td>
                <td><label>';
				 if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } 
				 else { echo $value['std']; update_option( $value['id'], $value['std'] ); } 
				 echo '</label></td> </tr>';
            	break;
				
        case 'link':
            echo '<tr><td><h6>'.$value['name'] .'</h6></td>
                <td><a href="../sitemap.xml">'. $value['std']; 
				update_option( $value['id'], $value['std'] );
				echo '</a></td></tr>';
          	break;

        case 'select':
           
           echo  '<tr> <td><h6>'.$value['name'].'</h6></td>
                <td ><select name="'.$value['id'].'" id="'. $value['id'].'">';
				foreach ($value['options'] as $option) {
					 echo '<option';
					  if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; }
					 echo '>';
					 echo $option.'</option>'; } 
                echo '</select></td> </tr>';

           break;

        case 'checkbox':          
			
           echo '<tr>
                <td ><h6>'; 
				echo $value['name'] . '</h6></td>
                <td>'; 
				 if(get_option($value['id'])) { $checked = "checked=\"checked\""; }
				 else { $checked = ""; } 
                 echo '<div class="normal-toggle-button">
                        <input type="checkbox" name="'. $value['id'].'" id="'.$value['id'].'"'.$checked.' />
                    </div>
                </td>
            </tr>';
          	break;

        case 'text':
            
            echo '<tr>
                <td><h6>'.$value['name'].'</h6></td>
                <td><input name="'. $value['id'].'" id="'. $value['id'].'" type="'. $value['type'].'" value="'; 
				if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } 
				else { echo $value['std']; update_option( $value['id'], $value['std'] ); }
				echo '" /></td></tr>';
          	break;

        case 'password':
		
		echo '<tr>
                <td><h6>';
		 		echo $value['name'].'</h6></td>
                <td><input name="'. $value['id'].'" id="'. $value['id'].'" type="'. $value['type'].'" value="';
				 if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; update_option( $value['id'], $value['std'] ); }
				  echo'" /></td>
            </tr>';
            break;

        case 'textarea':
            echo '<tr>
                <td><h6>';
		    echo $value['name'].'</h6></td>
                <td><textarea name="'.  $value['id'].'" id="'. $value['id'].'" type="'. $value['type'].'">';
				 if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); }
				  else { echo $value['std']; update_option( $value['id'], $value['std'] ); }
				   echo'" </textarea></td>
            </tr>';
           	break;

        case 'media': 
		echo '<tr>
                <td><h6>';
             echo $value['name'].'</h6></td>
                <td><input type="text" class="upload" id="'. $value['id'].'" name="'. $value['id'].'" value="'; 
				if ( get_option( $value['id'] ) != "") { echo esc_url(get_option( $value['id'] )); } 
				else { echo esc_url($value['std']); update_option( $value['id'], $value['std'] ); }
				 echo'" />
                    <input type="button" class="ttrbutton" value="'; _e( 'Upload',CURRENT_THEME);
					 echo '" /></td></tr>';

            break;
        case 'radiobutton' :
            echo '<tr>
                <td><h6>';
			echo $value['name'].'</h6></td>
                <td>'; 
				foreach ($value['options'] as $option){ 
				if(get_option($value['id'])== $option) { $checked = "checked=\"checked\""; } 
				else { $checked = ""; }
				echo '<input type="radio" name="'. $value['id'].'" id="'. $value['id'].'" value="'.$option .'"'. $checked .'/>'. $option ; }
				echo '</td>
            </tr>';

             break;
			
			case 'file':
              echo '<tr>
                <td><h6>';
			echo $value['name'].'</h6></td>
                <td><input name="'.$value['id'].'" id="'. $value['id'].'" type="'. $value['type'].'"/>'; 
				if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; update_option( $value['id'], $value['std'] ); } 
				echo '</td>
            </tr>';
            break;
       
	    	case 'none':
           echo ' <tr>
                <td colspan="2"><h6>'. $value['name'].'</h6></td></tr>';

            break;

    }
}



function mytheme_admin() {

    global $themename, $shortname, $typographyoptions;
    if (  function_exists( 'color_array' ) )
        $colors=color_array();
    if (  function_exists( 'header_options_array' ) )
        $headeroptions=header_options_array();
    else
        $headeroptions="";

    if (  function_exists( 'postcontent_array' ) )
        $postcontentoptions=postcontent_array();
    if (  function_exists( 'footer_options_array' ) )
        $footeroptions=footer_options_array();
    else
        $footeroptions="";

    if (  function_exists( 'sidebar_options_array' ) )
        $sidebaroptions= sidebar_options_array();
    else
        $sidebaroptions="";

    if (  function_exists( 'general_options_array' ) )
        $generaloptions = general_options_array();

    if (  function_exists( 'mm_options_array' ) )
        $mmoptions = mm_options_array();

    if (  function_exists( 'googlemap_options_array' ) )
        $gmapoptions = googlemap_options_array();

    if (  function_exists( 'error_options_array' ) )
        $error = error_options_array();

	if (  function_exists( 'seo_enable_array' ) )
        $seoenable = seo_enable_array();

    if (  function_exists( 'home_settings_array' ) )
        $seooptions = home_settings_array();

    if (  function_exists( 'general_settings_array' ) )
        $genoptions = general_settings_array();

    if (  function_exists( 'web_social_array' ) )
        $weboptions = web_social_array();

    if (  function_exists( 'sitemap_array' ) )
        $sitemapoptions = sitemap_array();

    if (  function_exists( 'advanced_array' ) )
        $advancedoptions = advanced_array();

    if (  function_exists( 'dashboard_array' ) )
        $dashboardoptions = dashboard_array();

    if (  function_exists( 'backup_array' ) )
        $backupoptions = backup_array();

    if (  function_exists( 'recovery_array' ) )
        $recoveryoptions = recovery_array();
    ?>
    <div id="aq_container" class="wrap">
    <div id="header">
        <div class="navbar">
            <div class="navbar-inner">
                <div id="info_bar">
                    <div id="expand_options" class="expand">Expand</div>
                </div>
                <a class="brand" href="<?php echo admin_url("admin.php?page=functions.php"); ?>"><?php echo $themename; ?></a>
                <div class="icon-option"> </div>
            </div>
        </div>
    </div>
    <div id="main">
    <?php if ( isset ( $_GET['tab'] ) ) admin_tabs($_GET['tab']); else admin_tabs('postcontent'); ?>
    <?php if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
    else $tab = 'postcontent';
    ?>
    <?php switch($tab) {

        case "header":
            if (is_array($headeroptions)):
                ?>
                <div id="content">
                    <form method="post">
                        <?php
                        foreach ($headeroptions as $value) {
                            options_code($value);
                        }
                        ?>
                        <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                        <input type="hidden" name="action" value="ttrsave"></input>
                    </form>
                </div>
            <?php endif; ?>
            <?php break;

        case "postcontent": ?>
            <div id="content">
                <form method="post">
                    <?php
                    foreach ($postcontentoptions as $value) {
                        options_code($value);
                    }
                    ?>
                    <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                    <input type="hidden" name="action" value="ttrsave"></input>

                </form>
            </div>

            <?php break;

        case "sidebar":
            if (is_array($sidebaroptions)):
                ?>
                <div id="content">
                    <form method="post">
                        <?php
                        foreach ($sidebaroptions as $value) {
                            options_code($value);
                        }
                        ?>
                        <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                        <input type="hidden" name="action" value="ttrsave"></input>
                    </form>
                </div>
            <?php endif; ?>
            <?php break;

        case "footer":
            if (is_array($footeroptions)):
                ?>
                <div id="content">
                    <form method="post">
                        <?php
                        foreach ($footeroptions as $value) {
                            options_code($value);
                        }
                        ?>

                        <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                        <input type="hidden" name="action" value="ttrsave"></input>
                    </form>
                </div>
            <?php endif; ?>
            <?php
            break;

        case "colors":
            if (is_array($headeroptions) || is_array($sidebaroptions) || is_array($footeroptions)):
                ?>

                <div id="content">

                <?php 	if ( isset($_POST['update_options'])) { color_picker_option_update(); }
                ?>
                <form method="POST">
                <table class="table table-hover table-bordered">
                <tbody>
                <?php if (is_array($headeroptions)):?>
                    <tr>
                        <td><h6><?php echo(__('Site Title Color',CURRENT_THEME)); ?></h6></td>
                        <td>

                            <!--<input type="text" id="color1" value="<?php /*echo get_option('ttr_title'); */?>" name="color_picker_color1" />-->

                            <input type="text" id="color1" value="<?php $titleColor = get_option('ttr_title'); if (empty($titleColor)){ echo "#";}else{ echo $titleColor;} ?>" name="color_picker_color1" />
							<div id="color_picker_color1"></div>

                        </td>
                    </tr>
                    <tr>
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                $('#color_picker_color1').hide();
                                $('#color_picker_color1').farbtastic('#color1');
                                $('#color1').click(function() {
                                    $('#color_picker_color1').fadeIn();
                                });
                                $(document).mousedown(function() {
                                    $('#color_picker_color1').each(function() {
                                        var display = $(this).css('display');
                                        if ( display == 'block' )
                                            $(this).fadeOut();
                                    });
                                });
                            });
                        </script>
                        <td><h6><?php echo(__('Site Slogan Color',CURRENT_THEME)); ?></h6></td>
                        <td>
                            <!--<input type="text" id="color2" value="<?php /*echo get_option('ttr_slogan');  */?>" name="color_picker_color2" />-->

                            <input type="text" id="color2" value="<?php $sloganColor = get_option('ttr_slogan'); if (empty($sloganColor)){ echo "#";}else{ echo $sloganColor;} ?>" name="color_picker_color2" />
							<div id="color_picker_color2"></div>

                        </td>
                    </tr>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('#color_picker_color2').hide();
                            $('#color_picker_color2').farbtastic('#color2');
                            $('#color2').click(function() {
                                $('#color_picker_color2').fadeIn();
                            });
                            $(document).mousedown(function() {
                                $('#color_picker_color2').each(function() {
                                    var display = $(this).css('display');
                                    if ( display == 'block' )
                                        $(this).fadeOut();
                                });
                            });
                        });
                    </script>
                <?php endif; ?>
                <?php if (is_array($sidebaroptions)):?>
                    <tr>
                        <td><h6><?php echo(__('Block Heading Color',CURRENT_THEME));?></h6></td>
                        <td>
                            <!-- <input type="text" id="color3" value="<?php /*echo get_option('ttr_blockheading'); */?>" name="color_picker_color3" />-->
                            
							<input type="text" id="color3" value="<?php $blockheading = get_option('ttr_blockheading'); if (empty($blockheading)){ echo "#";}else{ echo $blockheading;} ?>" name="color_picker_color3" />
                            <div id="color_picker_color3"></div>

                        </td>
                    </tr>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('#color_picker_color3').hide();
                            $('#color_picker_color3').farbtastic('#color3');
                            $('#color3').click(function() {
                                $('#color_picker_color3').fadeIn();
                            });
                            $(document).mousedown(function() {
                                $('#color_picker_color3').each(function() {
                                    var display = $(this).css('display');
                                    if ( display == 'block' )
                                        $(this).fadeOut();
                                });
                            });
                        });
                    </script>
               <!-- --><?php /*if($sidebaroptions[2]['name']=='Use vertical menu on Sidebar-1'): */?>
                    <tr>
                        <td><h6><?php echo(__('Sidebar Menu Heading Color',CURRENT_THEME));?></h6></td>
                        <td>
                            <!--<input type="text" id="color4" value="<?php /*echo get_option('ttr_sidebarmenuheading'); */?>" name="color_picker_color4" />-->

							<input type="text" id="color4" value="<?php $sidebarmenuheading = get_option('ttr_sidebarmenuheading'); if (empty($sidebarmenuheading)){ echo "#";}else{ echo $sidebarmenuheading;} ?>" name="color_picker_color4" />
							<div id="color_picker_color4"></div>
                            
                        </td>
                    </tr>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('#color_picker_color4').hide();
                            $('#color_picker_color4').farbtastic('#color4');
                            $('#color4').click(function() {
                                $('#color_picker_color4').fadeIn();
                            });
                            $(document).mousedown(function() {
                                $('#color_picker_color4').each(function() {
                                    var display = $(this).css('display');
                                    if ( display == 'block' )
                                        $(this).fadeOut();
                                });
                            });
                        });
                    </script>
             <!--   --><?php /*endif; */?>
                <?php endif; ?>
                <?php if (is_array($footeroptions)):?>
                    <tr>
                        <td><h6><?php echo(__('Footer Copyright Color',CURRENT_THEME));?></h6></td>
                        <td>
                            <!--  <input type="text" id="color5" value="<?php /*echo get_option('ttr_copyright'); */?>" name="color_picker_color5" />-->
 <input type="text" id="color5" value="<?php $copyright = get_option('ttr_copyright'); if (empty($copyright)){ echo "#";}else{ echo $copyright;} ?>" name="color_picker_color5" />

                            <div id="color_picker_color5"></div>
                           </td>
                    </tr>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('#color_picker_color5').hide();
                            $('#color_picker_color5').farbtastic('#color5');
                            $('#color5').click(function() {
                                $('#color_picker_color5').fadeIn();
                            });
                            $(document).mousedown(function() {
                                $('#color_picker_color5').each(function() {
                                    var display = $(this).css('display');
                                    if ( display == 'block' )
                                        $(this).fadeOut();
                                });
                            });
                        });
                    </script>
                    <tr>
                        <td><h6><?php echo(__('Footer Designed By Color',CURRENT_THEME));?></h6></td>
                        <td>
                            <!-- <input type="text" id="color6" value="<?php /*echo get_option('ttr_designedby'); */?>" name="color_picker_color6" />-->

							<input type="text" id="color6" value="<?php $designedby = get_option('ttr_designedby'); if (empty($designedby)){ echo "#";}else{ echo $designedby;} ?>" name="color_picker_color6" />
							<div id="color_picker_color6"></div>
                            
                        </td>
                    </tr>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('#color_picker_color6').hide();
                            $('#color_picker_color6').farbtastic('#color6');
                            $('#color6').click(function() {
                                $('#color_picker_color6').fadeIn();
                            });
                            $(document).mousedown(function() {
                                $('#color_picker_color6').each(function() {
                                    var display = $(this).css('display');
                                    if ( display == 'block' )
                                        $(this).fadeOut();
                                });
                            });
                        });
                    </script>


                    <tr>
                        <td><h6><?php echo(__('Footer Designed By Link Color',CURRENT_THEME));?></h6></td>
                        <td>
                            <!-- <input type="text" id="color7" value="<?php /*echo get_option('ttr_designedbylink'); */?>" name="color_picker_color7" />-->

							<input type="text" id="color7" value="<?php $designedbylink = get_option('ttr_designedbylink'); if (empty($designedbylink)){ echo "#";}else{ echo $designedbylink;} ?>" name="color_picker_color7" />
							<div id="color_picker_color7"></div>
                            
                        </td>
                    </tr>
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('#color_picker_color7').hide();
                            $('#color_picker_color7').farbtastic('#color7');
                            $('#color7').click(function() {
                                $('#color_picker_color7').fadeIn();
                            });
                            $(document).mousedown(function() {
                                $('#color_picker_color7').each(function() {
                                    var display = $(this).css('display');
                                    if ( display == 'block' )
                                        $(this).fadeOut();
                                });
                            });
                        });
                    </script>
                <?php endif; ?>

                <tr>
                    <td><h6><?php echo(__('Page/Post Title Normal Color',CURRENT_THEME));?></h6></td>
                    <td>
                        <!-- <input type="text" id="color8" value="<?php /*echo get_option('ttr_post_title_color'); */?>" name="color_picker_color8" />-->

                        <input type="text" id="color8" value="<?php $posttitleColor = get_option('ttr_post_title_color'); if (empty($posttitleColor)){ echo "#";}else{ echo $posttitleColor;} ?>" name="color_picker_color8" />
                        <div id="color_picker_color8"></div>

                    </td>
                </tr>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $('#color_picker_color8').hide();
                        $('#color_picker_color8').farbtastic('#color8');
                        $('#color8').click(function() {
                            $('#color_picker_color8').fadeIn();
                        });
                        $(document).mousedown(function() {
                            $('#color_picker_color8').each(function() {
                                var display = $(this).css('display');
                                if ( display == 'block' )
                                    $(this).fadeOut();
                            });
                        });
                    });
                </script>

                <tr>
                    <td><h6><?php echo(__('Post Title Hover Color',CURRENT_THEME));?></h6></td>
                    <td>
                        <!--<input type="text" id="color9" value="<?php /*echo get_option('ttr_post_title_hover_color'); */?>" name="color_picker_color9" />
-->
                        <input type="text" id="color9" value="<?php $posttitlehoverColor = get_option('ttr_post_title_hover_color'); if (empty($posttitlehoverColor)){ echo "#";}else{ echo $posttitlehoverColor;} ?>" name="color_picker_color9" />
						<div id="color_picker_color9"></div>

                    </td>
                </tr>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $('#color_picker_color9').hide();
                        $('#color_picker_color9').farbtastic('#color9');
                        $('#color9').click(function() {
                            $('#color_picker_color9').fadeIn();
                        });
                        $(document).mousedown(function() {
                            $('#color_picker_color9').each(function() {
                                var display = $(this).css('display');
                                if ( display == 'block' )
                                    $(this).fadeOut();
                            });
                        });
                    });
                </script>


                </tbody>
                </table>

                <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                <input type="hidden" name="update_options" value="Update Options"/>

                </form>
                </div>

            <?php endif; ?>



            <?php 		break;

        case "shortcodes":?>

            <div id="content">
            <table class="table table-hover table-bordered">
            <tbody>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Google Docs Viewer',CURRENT_THEME)); ?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [pdf href="http://manuals.info.apple.com/en_US/Enterprise_Deployment_Guide.pdf"]Link text.[/pdf]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Displaying Related Posts',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [related_posts]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Google AdSense',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [adsense client="ca-pub-1234567890" slot="1234567" width=728 height=90]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Google Chart',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [chart data="41.52,37.79,20.67,0.03" bg="F7F9FA" labels="Reffering+sites|Search+Engines|Direct+traffic|Other" colors="058DC7,50B432,ED561B,EDEF00" size="488x200" title="Traffic Sources" type="pie"]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Tweet Me Button',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [tweet]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Google Map',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [googlemap]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('YouTube',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [youtube value="http://www.youtube.com/watch?v=1aBSPn2P9bg"]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Private Content',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [member]This text will be only displayed to registered users.[/member]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('PayPal',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [donate account="paypal account" type="text" text="Donation"]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Contact Us Form',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [contact_us_form]
                    </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>
                        <?php echo(__('Login Form',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="login_form" style='block' loginbutton="Log In" logoutbutton="Log Out"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Custom Menu',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="Custom_Menu" title="Menu" style='block' menustyle='hmenu' nav_menu='All Pages' alignment='nostyle' color1='#d80e0e' color2='#120ed8' color='#ecdd74']
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Archives',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Archives"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Calendar',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Calendar"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Categories',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Categories"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Links',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Links"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Meta',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Meta"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Pages',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Pages"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Recent Comments',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Recent_Comments"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Recent Posts',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Recent_Posts"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('RSS',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_RSS"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Search',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Search"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Tag Cloud',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Tag_Cloud"]
                    </h6>
                </td>
            </tr>

            <tr>
                <td>
                    <h6>
                        <?php echo(__('Text',CURRENT_THEME));?>
                    </h6>
                </td>
                <td>
                    <h6>
                        [widget type="WP_Widget_Text"]
                    </h6>
                </td>
            </tr>
            </tbody>
            </table>
            </div>
            <?php break;
        case "contactform":
            ?>
            <div id="content">
                <?php 	if ( isset($_POST['update_options'])) { contact_form_option_update(); }
                $value_contact = get_option('contact_form');

                ?>

                <form method="POST">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <td colspan="3"><?php echo(__("To use CONTACT FORM, apply shortcode [contact_us_form]",CURRENT_THEME));?></td>

                        </tr>
                        <tr>
                            <td><?php echo(__('Admin Email Address',CURRENT_THEME));?></td>
                            <td colspan="2">
                                <input type="email" id="ttr_email" <?php if($value_contact[0]['ttr_email']){ ?> value="<?php print_r($value_contact[0]['ttr_email']); ?>" <?php } else {?> value="<?php print_r(get_option('admin_email')); ?>"<?php } ?> name="ttr_email" />

                            </td>

                        </tr>

                        <!-- Google Captcha -->
                        <tr>
                            <td><?php echo(__('Public Key For Google Captcha',CURRENT_THEME));?></td>
                            <td colspan="2">
                                <input type="text" id="ttr_captcha_public_key" <?php if($value_contact[1]['ttr_captcha_public_key']){ ?> value="<?php print_r($value_contact[1]['ttr_captcha_public_key']); ?>" <?php }  ?>  name="ttr_captcha_public_key" />

                            </td>

                        </tr>

                        <tr>
                            <td><?php echo(__('Private Key For Google Captcha',CURRENT_THEME));?></td>
                            <td colspan="2">
                                <input type="text" id="ttr_captcha_private_key" <?php if($value_contact[2]['ttr_captcha_private_key']){ ?> value="<?php print_r($value_contact[2]['ttr_captcha_private_key']); ?>" <?php }  ?>  name="ttr_captcha_private_key" />

                            </td>

                        </tr>

                        <!-- Contact Us Error Message -->
                        <tr>
                            <td><?php echo(__('Error Message',CURRENT_THEME));?></td>
                            <td colspan="2">
                                <input type="textarea" id="ttr_contact_us_error_message" <?php if($value_contact[3]['ttr_contact_us_error_message']){ ?> value="<?php print_r($value_contact[3]['ttr_contact_us_error_message']); ?>" <?php } else {?> value="<?php echo(__("Message was not sent. Try Again.",CURRENT_THEME));?>"<?php } ?> name="ttr_contact_us_error_message" />

                            </td>

                        </tr>

                        <tr>
                            <td><?php echo(__('Success Message',CURRENT_THEME));?></td>
                            <td colspan="2">
                                <input type="textarea" id="ttr_contact_us_success_message" <?php if($value_contact[4]['ttr_contact_us_success_message']){ ?> value="<?php print_r($value_contact[4]['ttr_contact_us_success_message']); ?>" <?php } else {?> value="<?php echo(__("Thanks! Your message has been sent.",CURRENT_THEME)); ?>"<?php } ?>  name="ttr_contact_us_success_message" />

                            </td>

                        </tr>
                        <tr>
                            <td><?php echo(__('Field Name:',CURRENT_THEME));?></td>
                            <td><?php echo(__('Required',CURRENT_THEME));?></td>
                            <td><?php echo(__('Remove',CURRENT_THEME));?></td>
                        </tr>


                        <?php if (is_array($value_contact)): ?>

                            <?php foreach($value_contact as $key=>$i)
                            {
                                foreach($value_contact[$key] as $newkey=>$j)
                                {
                                    if($newkey == 'ttr_email' || $newkey == 'ttr_emailreq' || $newkey == 'ttr_captcha_public_key' || $newkey == 'ttr_captcha_public_keyreq' || $newkey == 'ttr_captcha_private_key' || $newkey == 'ttr_captcha_private_keyreq' || $newkey == 'ttr_contact_us_error_message' || $newkey == 'ttr_contact_us_error_messagereq' || $newkey == 'ttr_contact_us_success_message' || $newkey == 'ttr_contact_us_success_messagereq')
                                        continue;
                                    ?>

                                    <?php 	if(strpos($newkey,'req')==false) { ?>

                                    <td><input name="<?php echo $newkey; ?>" id="<?php echo $newkey; ?>" type="<?php echo 'text'; ?>" value="<?php if ( $value_contact[$key][$newkey] != "") { print_r($value_contact[$key][$newkey]); } ?>" /></td>
                                <?php }?>

                                    <?php 	if(strpos($newkey,'req')!==false) { ?>
                                    <td>
                                        <?php if(isset($value_contact[$key][$newkey]) && $value_contact[$key][$newkey] == 'on') { $checked = "checked=\"checked\""; } else { $checked = ""; } ?>

                                        <div class="normal-toggle-button">
                                            <input type="checkbox" id="<?php echo $newkey; ?>"  name="<?php echo $newkey; ?>" <?php echo $checked; ?> />
                                        </div></td>
                                    <?php $url = get_template_directory_uri();?>
                                    <td><input type="image" src="<?php echo($url).'/images/cross.png'; ?>" class="removefield" /></td>
                                    </tr>
                                <?php } ?>

                                <?php }
                            }

                        endif;
                        ?>

                        <tr>
                            <td colspan="3"><input type="button" value="<?php echo(__('Add New Field',CURRENT_THEME));?>" class="newfield" /></td>
                        </tr>

                        </tbody>
                    </table>
                    <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                    <input type="hidden" name="update_options" value="Update Options"/>
                </form>

            </div>


            <?php break;
        case "generaloptions": ?>
            <div id="content">
                <form method="post">
                    <?php
                    foreach ($generaloptions as $value) {
                        options_code($value);
                    }
                    ?>


                    <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                    <input type="hidden" name="action" value="ttrsave"></input>
                </form>
            </div>
            <?php break;
        case "mmoptions": ?>
            <div id="content">
                <form method="post">
                    <?php
                    foreach ($mmoptions as $value) {
                        options_code($value);
                    }
                    ?>


                    <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                    <input type="hidden" name="action" value="ttrsave"></input>
                </form>
            </div>
            <?php break;

        case "error": ?>
            <div id="content">
                <form method="post">
                    <?php
                    foreach ($error as $value) {
                        options_code($value);
                    }
                    ?>


                    <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                    <input type="hidden" name="action" value="ttrsave"></input>
                </form>
            </div>


            <?php break;
        case "gmap": ?>
            <div id="content">
                <form method="post">
                    <?php
                    foreach ($gmapoptions as $value) {
                        options_code($value);
                    }
                    ?>


                    <button name="ttrsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
                    <input type="hidden" name="action" value="ttrsave"></input>
                </form>
            </div>
            <?php break;

         case "seooptions":  
			$seomode=get_option('ttr_seo_enable');
            if($seomode=="on"){
				function ilc_admin_tabs( $current = 'homepage' ) {
                $tabs = array( 'homepage' => 'SEO Mode', 'home' => 'Home', 'general' => 'General', 'web' => 'Web/Social','sitemap' => 'Sitemap','advanced'=>'Advanced' );
                echo '<h2 class="nav-tab-wrapper">';
                foreach( $tabs as $tab => $name ){
                    $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                    echo "<a class='nav-tab$class' href='?page=functions.php&tab=seooptions&subtab=$tab'>$name</a>";
                }
                echo '</h2>';
            }
		}				
				
		else{
				
				function ilc_admin_tabs( $current = 'homepage' ) {
                $tabs = array( 'homepage' => 'SEO Mode');
                echo '<h2 class="nav-tab-wrapper">';
                foreach( $tabs as $tab => $name ){
                    $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                    echo "<a class='nav-tab$class' href='?page=functions.php&tab=seooptions&subtab=$tab'>$name</a>";
                }
                echo '</h2>';
            }
			
		}
		            ?>
            <div id="content">
            <?php if ( isset ( $_GET['subtab'] ) ) ilc_admin_tabs($_GET['subtab']); else ilc_admin_tabs("homepage");
            if ( isset ( $_GET['subtab'] ) ) $tab = $_GET['subtab'];
            else $tab = 'homepage'; ?>
            <?php switch($tab)
        {
			 case "homepage":?>
                <form method="post">
                    <?php
                    foreach ($seoenable as $value) {
                        options_code($value);//Calling Function For Displaying Options
                    }
                    ?>
                    <button name="action" value="ttrsubsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>

                </form>
                <?php break;
            case "home":?>
                <form method="post">
                    <?php
                    foreach ($seooptions as $value) {
                        options_code($value);//Calling Function For Displaying Options
                    }
                    ?>
                    <script type="text/javascript">

                        var page_title = jQuery("#ttr_seo_page_title").parent().parent();
                        var post_title = jQuery("#ttr_seo_post_title").parent().parent();
                        var category_title = jQuery("#ttr_seo_category_title").parent().parent();
                        var date_archive_title = jQuery("#ttr_seo_date_archive_title").parent().parent();
                        var anchor_archive_title = jQuery("#ttr_seo_anchor_archive_title").parent().parent();
                        var tag_title = jQuery("#ttr_seo_tag_title").parent().parent();
                        var search_title = jQuery("#ttr_seo_search_title").parent().parent();
                        var seo_404_title = jQuery("#ttr_seo_404_title").parent().parent();


                        if(!jQuery("#ttr_seo_rewrite_titles").is(':checked')){
                            page_title.css("display","none");
                            post_title.css("display","none");
                            category_title.css("display","none");
                            date_archive_title.css("display","none");
                            anchor_archive_title.css("display","none");
                            tag_title.css("display","none");
                            search_title.css("display","none");
                            seo_404_title.css("display","none");
                        }
                        jQuery("#ttr_seo_rewrite_titles").change(function(){
                            if(!jQuery(this).is(':checked')){
                                page_title.css("display","none");
                                post_title.css("display","none");
                                category_title.css("display","none");
                                date_archive_title.css("display","none");
                                anchor_archive_title.css("display","none");
                                tag_title.css("display","none");
                                search_title.css("display","none");
                                seo_404_title.css("display","none");

                            }
                            else{
                                page_title.css("display","");
                                post_title.css("display","");
                                category_title.css("display","");
                                date_archive_title.css("display","");
                                anchor_archive_title.css("display","");
                                tag_title.css("display","");
                                search_title.css("display","");
                                seo_404_title.css("display","");
                            }
                        });
                    </script>
                    <button name="action" value="ttrsubsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>

                </form>
                <?php break;

            case "general":?>
                <form method="post">
                    <?php
                    foreach ($genoptions as $value) {
                        options_code($value);//Calling Function For Displaying Options
                    }
                    ?>
                    <script type="text/javascript">

                        var categories_meta_keywords = jQuery("#ttr_seo_categories_meta_keywords").parents('tr');
                        var tags_meta_keywords = jQuery("#ttr_seo_tags_meta_keywords").parents('tr');
                        var default_keywords = jQuery("#ttr_seo_default_keywords").parents('tr');

                        if(!jQuery("#ttr_seo_use_keywords").is(':checked')){
                            categories_meta_keywords.css("display","none");
                            tags_meta_keywords.css("display","none");
                            default_keywords.css("display","none");
                        }

                        jQuery("#ttr_seo_use_keywords").change(function(){
                            if(!jQuery(this).is(':checked')){
                                categories_meta_keywords.css("display","none");
                                tags_meta_keywords.css("display","none");
                                default_keywords.css("display","none");
                            }
                            else{
                                categories_meta_keywords.css("display","");
                                tags_meta_keywords.css("display","");
                                default_keywords.css("display","");
                            }
                        });
                    </script>
                    <button name="action" value="ttrsubsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>

                </form>
                <?php break;

            case "web":?>
                <form method="post">
                    <?php
                    foreach ($weboptions as $value) {
                        options_code($value);
                    }
                    ?>
                    <button name="action" value="ttrsubsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>

                </form>
                <?php break;

            case "sitemap":?>
                <form method="post">
                    <?php
                    foreach ($sitemapoptions as $value) {
                        options_code($value);
                    }
                    ?>
                    <button name="action" value="ttrsitemap" type="submit" class="btn"><?php echo(__('Generate/Update Sitemap',CURRENT_THEME));?></button>
                    <button name="action" value="ttrsubsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>

                </form>
                <?php break;

            case "advanced":?>
                <form method="post">
                    <?php
                    foreach ($advancedoptions as $value) {
                        options_code($value);
                    }
                    ?>
                    <button name="action" value="ttrsubsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>

                </form>
                <?php break;?>
                </div>
            <?php }
            break;

        case "backuprecovery":
            function ilc_admin_tabs( $current = 'homepage' ) {
                $tabs = array( 'homepage' => 'Dashboard', 'backup' => 'Backup', 'recovery' => 'Recovery' );
                echo '<h2 class="nav-tab-wrapper">';
                foreach( $tabs as $tab => $name ){
                    $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                    echo "<a class='nav-tab$class' href='?page=functions.php&tab=backuprecovery&subtab=$tab'>$name</a>";
                }
                echo '</h2>';
            }?>
            <div id="content">
            <?php if ( isset ( $_GET['subtab'] ) ) ilc_admin_tabs($_GET['subtab']); else ilc_admin_tabs("homepage");
            if ( isset ( $_GET['subtab'] ) ) $tab = $_GET['subtab'];
            else $tab = 'homepage';
            $dir=ABSPATH . '/wp-admin/';
            $files = glob($dir.'*.zip');
            array_multisort(array_map( 'filemtime', $files ),SORT_NUMERIC,SORT_DESC,$files);
            $lastrun=date('d-m-Y H:i:s',filemtime($files[0]));
            update_option('ttr_last_backup',$lastrun);
            $next_timestamp = date("d-m-Y H:i:s",wp_next_scheduled('prefix_hourly_event'));
            update_option('ttr_next_scheduled_backup',$next_timestamp);?>

            <?php switch($tab)
        {
             case "homepage":
                ?>
                <form method="post">
                    <?php
                    foreach ($dashboardoptions as $value) {
                        options_code($value);//Calling Function For Displaying Options
                    }
                    ?>
					<button name="action" value="ttrsubsave" type="submit" class="btn"><?php echo(__('Save Changes',CURRENT_THEME));?></button>
					
					<button name="action" value="ttrtest" type="submit" class="btn"><?php echo(__('Test FTP Connection',CURRENT_THEME));?></button>
										
			<?php
				if ( 'ttrtest' == $_REQUEST['action'] ) {
										
				$ftp_host = get_option('ttr_ftp_server_address');
				$ftp_user = get_option('ttr_ftp_user_name');
				$ftp_password = get_option('ttr_ftp_user_password');
				if(empty($ftp_host) || empty($ftp_user) || empty($ftp_password)) {
					echo "<br /><br/><p><font color='red'>FTP Settings are not set(Field value Missing)</p><br/>";
				}
				else{
					echo "<br /><br/><b>Connecting to $ftp_host via FTP...<b> <br/>";
					$conn = ftp_connect($ftp_host);
					$login = ftp_login($conn, $ftp_user, $ftp_password);

					//Enable PASV ( Note: must be done after ftp_login() )
					$mode = ftp_pasv($conn, TRUE);

					//Login OK ?
					if ((!$conn) || (!$login) || (!$mode)) {
					  die("<p><font color='red'>FTP connection has failed !</p>");
					}
					 echo "<div><p><b>Status :</b><font color='green'> Connected</p><br/>";
		            }
			}
			
			?>
            </form>
                <?php break;

            case "backup":?>
                <form method="post">
                    <?php
                    foreach ($backupoptions as $value) {
                        options_code($value);//Calling Function For Displaying Options
                    }?>
                    <script type="text/javascript">
                        var automatic_interval = jQuery("#ttr_automatic_backup_interval").parents('tr');
						if(!jQuery("#ttr_automatic_backup_recovery_enable").is(':checked')){
                            automatic_interval.css("display","none");
							jQuery("#ttrauto").css("display","");
                        }
						
                        jQuery("#ttr_automatic_backup_recovery_enable").change(function(){
                            if(!jQuery(this).is(':checked')){

                                automatic_interval.css("display","none");
								jQuery("#ttrauto").css("display","none");
                            }
                            else{

                                automatic_interval.css("display","");
								jQuery("#ttrauto").css("display","");
                            }
                        });
                    </script>
                        <button name="action" value="ttrbackup" type="submit" class="btn"><?php echo(__('Backup Now',CURRENT_THEME));?></button>
                        <button name="action" id="ttrauto" value="ttrautobackup" type="submit" class="btn"  style="display:none;"><?php echo(__('Start/Stop Auto Backup',CURRENT_THEME));?></button>
                				   
                </form>
                <?php break;

            case "recovery":?>
                <form enctype="multipart/form-data" method="post">
                    <?php
                    foreach ($recoveryoptions as $value) {
                        options_code($value);//Calling Function For Displaying Options
                    }
                    ?>
					<button type="submit" value="ttrrestore" name="action" class="btn"><?php echo(__('Restore Backup',CURRENT_THEME));?></button>  
					
</form>
					             </div>
            <?php } break;


    }?>
    <div class="clear"></div>
    </div>
    </div>
<?php }


function contact_form_option_update()
{

    $post_val=array();
    foreach($_POST as $key=>$i)
    {

        if($key=='ttrsave' || $key=='update_options')
            continue;
        if(strpos($key,'req') == false)
        {

            $post_val_new=array();
            $post_val_new[$key] = $_POST[$key];

            if (isset($_POST[$key.'req']))
            {
                $post_val_new[$key.'req'] = $_POST[$key.'req'];

            }
            else
                $post_val_new[$key.'req']='off';

            array_push($post_val,$post_val_new);
        }
    }
    update_option('contact_form', $post_val);

}


function admin_tabs( $current = 'postcontent' ) {
    if (  function_exists( 'header_options_array' ) )
        $headeroptions=header_options_array();
    else
        $headeroptions="";

    if (  function_exists( 'footer_options_array' ) )
        $footeroptions=footer_options_array();
    else
        $footeroptions="";

    if (  function_exists( 'sidebar_options_array' ) )
        $sidebaroptions= sidebar_options_array();
    else
        $sidebaroptions="";

    $tabs = array( 'header' => __('Header',CURRENT_THEME), 'postcontent' => __('Post / Content',CURRENT_THEME), 'sidebar' => __('Sidebar',CURRENT_THEME), 'footer' => __('Footer',CURRENT_THEME), 'colors' => __('Colors',CURRENT_THEME), 'shortcodes' => __('Shortcodes',CURRENT_THEME), 'contactform' => __('Contact Us Form ',CURRENT_THEME),'generaloptions' => __('General',CURRENT_THEME),'gmap' => __('Google Map',CURRENT_THEME),'error' => __('Error Page',CURRENT_THEME),'seooptions' => __('SEO Mode',CURRENT_THEME),'mmoptions' => __('Maintenance Mode',CURRENT_THEME),'backuprecovery' => __('Backup/Recovery Mode',CURRENT_THEME));
    if (!is_array($headeroptions))
    {
        if (($key = array_search('Header', $tabs)) !== false) {
            unset($tabs[$key]);
        }
    }
    if (!is_array($sidebaroptions))
    {
        if (($key = array_search('Sidebar', $tabs)) !== false) {
            unset($tabs[$key]);
        }
    }
    if (!is_array($footeroptions))
    {
        if (($key = array_search('Footer', $tabs)) !== false) {
            unset($tabs[$key]);
        }
    }
    if (!is_array($headeroptions) && !is_array($sidebaroptions) && !is_array($footeroptions))
    {
        if (($key = array_search('Colors', $tabs)) !== false) {
            unset($tabs[$key]);
        }
    }
    $links = array();
    echo '<div id="aq-nav">';
    echo '<ul>';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? 'current' : '';
        echo "<li class='$class'><a href='?page=functions.php&tab=$tab'>$name</a></li>";

    }
    echo '</ul>';
    echo '</div>';
}

function color_picker_option_update()
{
    if (  function_exists( 'header_options_array' ) )
        $headeroptions=header_options_array();
    else
        $headeroptions="";

    if (  function_exists( 'footer_options_array' ) )
        $footeroptions=footer_options_array();
    else
        $footeroptions="";

    if (  function_exists( 'sidebar_options_array' ) )
        $sidebaroptions= sidebar_options_array();
    else
        $sidebaroptions="";

    if (is_array($headeroptions))
    {
        $titleColor = get_option('ttr_title');
        if($titleColor == "#")
        {
            update_option('ttr_title', null);
        }
        else
        {
            update_option('ttr_title', esc_html($_POST['color_picker_color1']));
        }
        update_option('ttr_slogan', esc_html($_POST['color_picker_color2']));
    }
    if (is_array($sidebaroptions))
    {
        update_option('ttr_blockheading', esc_html($_POST['color_picker_color3']));
        /*if($sidebaroptions[2]['name']=='Use vertical menu on Sidebar-1')*/
            update_option('ttr_sidebarmenuheading', esc_html($_POST['color_picker_color4']));
    }
    if (is_array($footeroptions))
    {
        update_option('ttr_copyright', esc_html($_POST['color_picker_color5']));
        update_option('ttr_designedby', esc_html($_POST['color_picker_color6']));
        update_option('ttr_designedbylink', esc_html($_POST['color_picker_color7']));
    }

    $posttitleColor = get_option('ttr_post_title_color');
    if($posttitleColor == "#")
    {
        update_option('ttr_post_title_color', null);
    }
    else
    {
        update_option('ttr_post_title_color', esc_html($_POST['color_picker_color8']));
    }

    $posttitlehoverColor = get_option('ttr_post_title_hover_color');
    if($posttitlehoverColor == "#")
    {
        update_option('ttr_post_title_hover_color', null);
    }
    else
    {
        update_option('ttr_post_title_hover_color', esc_html($_POST['color_picker_color9']));
    }
}


function customAdmin() {
    $url = get_template_directory_uri();
    $screen = get_current_screen();
    if ($screen->id =='toplevel_page_functions')
    {
        /*wp_register_script( 'bootstrap', get_template_directory_uri() .'/js/bootstrap.min.js');
        wp_enqueue_script( 'bootstrap');*/
    }

    wp_register_script( 'togglebutton', get_template_directory_uri() .'/js/jquery.toggle.buttons.js');
    wp_enqueue_script( 'togglebutton', get_template_directory_uri() .'/js/jquery.toggle.buttons.js' );

    echo '<link href="'.$url.'/css/bootstrap.css" rel="stylesheet">';
    echo '<link href="'.$url.'/css/bootstrap-toggle-buttons.css" rel="stylesheet">';
    echo '<link href="'.$url.'/admin-style.css" rel="stylesheet">';
    echo '<script type="text/javascript" src="'.$url.'/js/expand.js"></script>';
    echo '<script type="text/javascript">jQuery(document).ready(function($){$(\'\.normal-toggle-button\').toggleButtons();});</script>';
}

add_action('admin_head', 'customAdmin');

function pdflink($attr, $content) {
    if ($attr['href']) {
        return '<a class="pdf" href="http://docs.google.com/viewer?url=' . $attr['href'] . '">'.$content.'</a>';
    } else {
        $src = str_replace("=", "", $attr[0]);
        return '<a class="pdf" href="http://docs.google.com/viewer?url=' . $src . '">'.$content.'</a>';
    }
}
add_shortcode('pdf', 'pdflink');

function related_posts_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'limit' => '5',
    ), $atts));

    global $wpdb, $post, $table_prefix;

    if ($post->ID) {
        $retval = '<ul>';
        // Get tags
        $tags = wp_get_post_tags($post->ID);
        $tagsarray = array();
        foreach ($tags as $tag) {
            $tagsarray[] = $tag->term_id;
        }
        $tagslist = implode(',', $tagsarray);
        if ($tagslist != null)
        {
            // Do the query
            $q = "SELECT p.*, count(tr.object_id) as count
		FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE
		tt.taxonomy ='post_tag' AND
		tt.term_taxonomy_id = tr.term_taxonomy_id AND
		tr.object_id  = p.ID AND
		tt.term_id IN ($tagslist) AND
		p.ID != $post->ID AND
		p.post_status = 'publish' AND
		p.post_date_gmt < NOW()
		GROUP BY tr.object_id
		ORDER BY count DESC, p.post_date_gmt DESC
		LIMIT $limit;";


            $related = $wpdb->get_results($q);
            if ( $related ) {
                foreach($related as $r) {
                    $retval .= '<li><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></li>';
                }
            }
        } else {
            $retval .= '
		<li>No related posts found</li>';
        }
        $retval .= '</ul>';
        return $retval;
    }
    return;
}
add_shortcode('related_posts', 'related_posts_shortcode');

function showads($atts) {
    extract(shortcode_atts(array(
        'client' => '',
        'slot' => '',
        'width' => '250',
        'height' => '250',
    ), $atts));
    return '<script type="text/javascript"><!--
	google_ad_client = "'.$client.'";
	google_ad_slot = "'.$slot.'";
	google_ad_width = '.$width.';
	google_ad_height = '.$height.';
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	';
}
add_shortcode('adsense', 'showads');

function chart_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'data' => '',
        'colors' => '',
        'size' => '400x200',
        'bg' => 'ffffff',
        'title' => '',
        'labels' => '',
        'advanced' => '',
        'type' => 'pie'
    ), $atts));

    switch ($type) {
        case 'line' :
            $charttype = 'lc'; break;
        case 'xyline' :
            $charttype = 'lxy'; break;
        case 'sparkline' :
            $charttype = 'ls'; break;
        case 'meter' :
            $charttype = 'gom'; break;
        case 'scatter' :
            $charttype = 's'; break;
        case 'venn' :
            $charttype = 'v'; break;
        case 'pie' :
            $charttype = 'p3'; break;
        case 'pie2d' :
            $charttype = 'p'; break;
        default :
            $charttype = $type;
            break;
    }

    $string = '';
    if ($title) $string .= '&chtt='.$title.'';
    if ($labels) $string .= '&chl='.$labels.'';
    if ($colors) $string .= '&chco='.$colors.'';
    $string .= '&chs='.$size.'';
    $string .= '&chd=t:'.$data.'';
    $string .= '&chf='.$bg.'';

    return '<img title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$charttype.''.$string.$advanced.'" alt="'.$title.'" />';
}
add_shortcode('chart', 'chart_shortcode');

function tweetmeme(){
    return '    <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>

    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
}
add_shortcode('tweet', 'tweetmeme');

function googleMapShortcode($atts, $content = null)
{
    extract(shortcode_atts(array("id" => 'myMap', "type" => 'road', "latitude" => '36.394757', "longitude" => '-105.600586', "zoom" => '9', "message" => 'This is the message...', "width" => '300', "height" => '300'), $atts));

    $mapType = get_option('ttr_googlemap_type');
    $latitude =  get_option('ttr_map_latitude');
    $longitude = get_option('ttr_map_longitude');
    $width = get_option('ttr_map_width');
    $height = get_option('ttr_map_height');



    echo '<!-- Google Map -->
        <script type="text/javascript">
        jQuery(document).ready(function() {
          function initializeGoogleMap() {

              var myLatlng = new google.maps.LatLng('.$latitude.','.$longitude.');
              var myOptions = {
                center: myLatlng,
                zoom: '.$zoom.',
                mapTypeId: google.maps.MapTypeId.'.$mapType.'
              };
              var map = new google.maps.Map(document.getElementById("'.$id.'"), myOptions);

              var contentString = "'.$message.'";
              var infowindow = new google.maps.InfoWindow({
                  content: contentString
              });';
    if(get_option('ttr_marker_enable',true)):
        echo'
              var marker = new google.maps.Marker({
              position: myLatlng
              });

              google.maps.event.addListener(marker, "click", function() {
                  infowindow.open(map,marker);
              });

              marker.setMap(map);';
    endif;

    echo '}
          initializeGoogleMap();

        });
        </script>';


    return '<div id="'.$id.'" style="width:'.$width.'px; height:'.$height.'px;  class="googleMap"></div>';
}


add_shortcode("googlemap", "googleMapShortcode");


function enqueue_custom_scripts() {
   
    wp_register_script('googlemaps',get_template_directory_uri() .'/js/map.js', false, null, true);
    wp_enqueue_script('googlemaps');
    wp_register_script('bootstrapfront',get_template_directory_uri() .'/js/bootstrap.min.js', false, null, true);
    wp_enqueue_script('bootstrapfront');
    wp_register_script('html5shiv',get_template_directory_uri() .'/js/html5shiv.js', false, null, true);
    wp_enqueue_script('html5shiv');
 
    wp_register_style( 'bootstrap', get_template_directory_uri() .'/bootstrap.css', array());
    wp_enqueue_style( 'bootstrap' );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function cwc_youtube($atts) {
    extract(shortcode_atts(array(
        "value" => 'http://',
        "width" => '475',
        "height" => '350',
        "name"=> 'movie',
        "allowFullScreen" => 'true',
        "allowScriptAccess"=>'always',
    ), $atts));
    $pos = strpos($value, "watch?v=");
    return '<object style="height: '.$height.'px; width: '.$width.'px"><param name="'.$name.'" value=http://youtube.com/v/'.substr($value, $pos+8).'"><param name="allowFullScreen" value="'.$allowFullScreen.'"></param><param name="allowScriptAccess" value="'.$allowScriptAccess.'"></param><embed src="http://youtube.com/v/'.substr($value, $pos+8).'" type="application/x-shockwave-flash" allowfullscreen="'.$allowFullScreen.'" allowScriptAccess="'.$allowScriptAccess.'" width="'.$width.'" height="'.$height.'"></embed></object>';
}
add_shortcode("youtube", "cwc_youtube");

function cwc_member_check_shortcode( $atts, $content = null ) {
    if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
        return $content;
    return '';
}

add_shortcode( 'member', 'cwc_member_check_shortcode' );

function donate_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'text' => 'Make a donation',
        'account' => 'REPLACE ME',
        'for' => '',
    ), $atts));

    global $post;

    if (!$for) $for = str_replace(" ","+",$post->post_title);

    return '<a class="donateLink" href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business='.$account.'&item_name=Donation+for+'.$for.'">'.$text.'</a>';
}
add_shortcode('donate', 'donate_shortcode');

function contact_form()
{
    ob_start();
    $value_contact=get_option('contact_form');
    ?>
    <form method="post">
        <table style="width:100%; height:auto; border:0;">



            <?php  if (is_array($value_contact))
            {?>
                <?php foreach($value_contact as $key=>$i)
            {

                foreach($value_contact[$key] as $newkey=>$j)
                {

                    if($newkey == 'ttr_email' || $newkey == 'ttr_emailreq' || $newkey == 'ttr_captcha_public_key' || $newkey == 'ttr_captcha_public_keyreq' || $newkey == 'ttr_captcha_private_key' || $newkey == 'ttr_captcha_private_keyreq' || $newkey == 'ttr_contact_us_error_message' || $newkey == 'ttr_contact_us_error_messagereq' || $newkey == 'ttr_contact_us_success_message' || $newkey == 'ttr_contact_us_success_messagereq')

                        continue;

                    if(strpos($newkey,'req')==false ) {
                        if($value_contact[$key][$newkey]){?>

                            <tr style="border: 0;">


                                <td style="border: 0;"><?php print_r($value_contact[$key][$newkey]); ?>:</td>

                                <td style="border: 0;"><input type="text" name="<?php print_r($value_contact[$key][$newkey]); ?>" style="width:300px; height:30px;" placeholder="<?php print_r($value_contact[$key][$newkey]); ?>" <?php 	if(isset($value_contact[$key][$newkey.'req']) && $value_contact[$key][$newkey.'req'] == 'on'){ ?> required<?php }  ?> /></td>
                            </tr>
                        <?php
                        }
                    }
                }
            }
            }
            ?>
            <tr style="border: 0;">
                <td style="border: 0;"><?php echo(__('E-Mail Address:',CURRENT_THEME));?></td>
                <td style="border: 0;"><input type="email" name="message_email"  style="width:300px; height:30px;"  placeholder='<?php echo(__("Your E-Mail Address:",CURRENT_THEME));?>'  required  /></td>
            </tr>
            <tr style="border: 0;">
                <td style="border: 0;"><?php echo(__('Message:',CURRENT_THEME));?></td>
                <td style="border: 0;"><textarea rows="8" cols="40" name="message_text"   placeholder='<?php echo(__("Enter Your Message Here&hellip;",CURRENT_THEME));?>' required ></textarea></td>
            </tr>

            <?php if(($value_contact[1]['ttr_captcha_public_key']) && ($value_contact[2]['ttr_captcha_private_key'])):?>
                <tr style="border: 0;">
                    <td colspan=2 style="border: 0;">
                        <?php
                        //Include reCaptcha liberary
                        require_once('recaptchalib.php');

                        // Get a key from https://www.google.com/recaptcha/admin/create
                        $publickey = $value_contact[1]['ttr_captcha_public_key'];
                        $privatekey = $value_contact[2]['ttr_captcha_private_key'];

                        # The response from reCAPTCHA
                        $resp = null;
                        # The error code from reCAPTCHA, if any
                        $error = null;

                        # Was there a reCAPTCHA response?
                        if (isset($_POST["recaptcha_response_field"])) {
                            $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

                            if ($resp->is_valid) {
                                echo "You got it!";
                            } else {
                                # Set the error code so that we can display it
                                $error = $resp->error;
                            }
                        }
                        echo recaptcha_get_html($publickey, $error);
                        ?>
                    </td>
                    <div style="clear:both;"></div>
                </tr>
            <?php endif; ?>



            <tr style="border: 0;">
                <td colspan="2" style="border: 0;" ><button class="btn btn-default" type="submit" value="Submit" name="submit_values" ><?php echo(__('Send Message',CURRENT_THEME));?></button></td>
            </tr>
        </table>
    </form>

    <?php

    function my_contact_form_generate_response($type, $message){

        if($type == "success")
            echo "<div class='success'>{$message}</div>";
        else
            echo "<div class='error'>{$message}</div>";
    }
    //response messages
    $message_unsent  = $value_contact[3]['ttr_contact_us_error_message'];
    $message_sent    = $value_contact[4]['ttr_contact_us_success_message'];

    //user posted variables
    if(isset($_POST['submit_values']))
    {

        $email = $_POST['message_email'];
        $message='';

        $check_mail=$value_contact[0]['ttr_email'];
        if($check_mail)
        {
            $to = $check_mail;
        }
        else
        {
            $to = get_option('admin_email');
        }
        if(isset($_POST['Subject']) && $_POST['Subject'])
        {
            $subject = $_POST['Subject'];
        }
        else
        {
            $subject = get_bloginfo().'-contact-form';
        }

        $headers = __('From: ',CURRENT_THEME). $email . "</br>" .
            __('Reply-To: ',CURRENT_THEME) . $email . "\r\n";


        foreach($value_contact as $key=>$i)
        {

            foreach($value_contact[$key] as $newkey=>$j)
            {
                if($newkey == 'ttr_email' || $newkey == 'ttr_emailreq' || $newkey == 'ttr_captcha_public_key' || $newkey == 'ttr_captcha_public_keyreq' || $newkey == 'ttr_captcha_private_key' || $newkey == 'ttr_captcha_private_keyreq' || $newkey == 'ttr_contact_us_error_message' || $newkey == 'ttr_contact_us_error_messagereq' || $newkey == 'ttr_contact_us_success_message' || $newkey == 'ttr_contact_us_success_messagereq')
                    continue;
                if(strpos($newkey,'req')==false) {

                    $first_var=$value_contact[$key][$newkey];
                    $replace_var=str_replace(' ','_',$first_var);

                    if(isset($_POST[$replace_var]) && !empty($_POST[$replace_var]))
                    {
                        $message .=$first_var.":".$_POST[$replace_var].' ';
                    }
                }
            }
        }
        $message .= __('Message:   ',CURRENT_THEME).$_POST['message_text'];

        $sent = wp_mail($to, $subject, $message,$headers);

        if($sent)
        {
            my_contact_form_generate_response("success", $message_sent); //message sent!
        }
        else
        {
            my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
    }
    return ob_get_clean();
}

add_shortcode('contact_us_form', 'contact_form');

function myactivationfunction($oldname, $oldtheme=false) {

    global $no_slides;
    if (  function_exists( 'color_array' ) )
        $colors=color_array();
    if (  function_exists( 'page_options_array' ) )
        $pageoptions=page_options_array();
    if (  function_exists( 'post_options_array' ) )
        $postoptions=post_options_array();

    if (  function_exists( 'header_options_array' ) )
        $headeroptions=header_options_array();
    else
        $headeroptions="";


    if (  function_exists( 'postcontent_array' ) )
        $postcontentoptions=postcontent_array();
    if (  function_exists( 'footer_options_array' ) )
        $footeroptions=footer_options_array();
    else
        $footeroptions="";


    if (  function_exists( 'sidebar_options_array' ) )
        $sidebaroptions= sidebar_options_array();
    else
        $sidebaroptions="";


    if (  function_exists( 'general_options_array' ) )
        $generaloptions = general_options_array();

    if (  function_exists( 'mm_options_array' ) )
        $mmoptions = mm_options_array();

    if (  function_exists( 'googlemap_options_array' ) )
        $gmapoptions = googlemap_options_array();

    if (  function_exists( 'error_options_array' ) )
        $error = error_options_array();

	if (  function_exists( 'seo_enable_array' ) )
        $seoenable = seo_enable_array();

    if (  function_exists( 'home_settings_array' ) )
        $seooptions = home_settings_array();

    if (  function_exists( 'general_settings_array' ) )
        $genoptions = general_settings_array();

    if (  function_exists( 'web_social_array' ) )
        $weboptions = web_social_array();

    if (  function_exists( 'sitemap_array' ) )
        $sitemapoptions = sitemap_array();

    if (  function_exists( 'advanced_array' ) )
        $advancedoptions = advanced_array();

    if (  function_exists( 'dashboard_array' ) )
        $dashboardoptions = dashboard_array();

    if (  function_exists( 'backup_array' ) )
        $backupoptions =backup_array();

    if (  function_exists( 'recovery_array' ) )
        $recoveryoptions = recovery_array();

    if (is_array($headeroptions)){
        foreach( $headeroptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $headervar = get_option( $option_data['id'], "ttr_test" );
                $url = get_template_directory_uri();
                if($option_data['id'] == 'ttr_logo')
                {
                    if( $headervar == "ttr_test" ) {
                        update_option( $option_data['id'], $url.'/logo.png' );
                    }
                }
                elseif ($option_data['id'] == 'ttr_favicon_image')
                {
                    update_option( $option_data['id'], $url.'/favicon.ico' );
                }

                else {
                    if( $headervar == "ttr_test" ) {
                        update_option( $option_data['id'], $option_data['std'] );
                    }
                }
            }
        }
    }

    foreach( $postcontentoptions as $option_data ) {
        if (isset($option_data['id']))
        {
            $postcontentvar = get_option( $option_data['id'], "ttr_test" );
            if( $postcontentvar == "ttr_test" ) {
                update_option( $option_data['id'], $option_data['std'] );
            }
        }
    }
    if (is_array($sidebaroptions)){
        foreach( $sidebaroptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $sidebarvar = get_option( $option_data['id'], "ttr_test" );
                if( $sidebarvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }
    if (is_array($footeroptions)){
        foreach( $footeroptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $footervar = get_option( $option_data['id'], "ttr_test" );
                if($option_data['id'] == 'ttr_facebook'||
                    $option_data['id'] == 'ttr_twitter'||
                    $option_data['id'] == 'ttr_linkedin'||
                    $option_data['id'] == 'ttr_rss' ||
                    $option_data['id'] == 'ttr_googleplus')
                {
                    $url = get_template_directory_uri();
                    if( $footervar == "ttr_test" ) {
                        update_option( $option_data['id'], $url.'/images/'.$option_data['std'] );
                    }
                }
                else {
                    if( $footervar == "ttr_test" ) {
                        update_option( $option_data['id'], $option_data['std'] );
                    }
                }
            }
        }
    }
    if (is_array($colors)){
        foreach( $colors as $option_data ) {
            if (isset($option_data['id']))
            {
                $colorvar = get_option( $option_data['id'], "ttr_test" );
                if( $colorvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }
    $contactvar=get_option('contact_form',"ttr_test");
    if( $contactvar == "ttr_test" ) {
        $adminmail=get_option('admin_email');
        $default=array(0=>array('ttr_email'=>$adminmail),1=>array('ttr_captcha_public_key'=>''),2=>array('ttr_captcha_private_key'=>''),3=>array('ttr_contact_us_error_message'=>'Message was not sent. Try Again.'),4=>array('ttr_contact_us_success_message'=>'Thanks! Your message has been sent.'),5=>array('ttr_name'=>__('Name',CURRENT_THEME) ,'ttr_namereq' => 'on' ), 6=>array('ttr_subject' => __('Subject',CURRENT_THEME) , 'ttr_subjectreq' => 'on'));
        update_option( 'contact_form', $default );
    }

    foreach( $gmapoptions as $option_data ) {
        if (isset($option_data['id']))
        {
            $extravar = get_option( $option_data['id'], "ttr_test" );

            if( $extravar == "ttr_test" ) {
                update_option( $option_data['id'], $option_data['std'] );

            }
        }
    }

    foreach( $generaloptions as $option_data ) {
        if (isset($option_data['id']))
        {
            $extravar = get_option( $option_data['id'], "ttr_test" );
            if($option_data['id'] == 'ttr_icon_back_to_top')
            {
                $url = get_template_directory_uri();
                if( $extravar == "ttr_test" ) {
                    update_option( $option_data['id'], $url.'/images/gototop.png' );
                }
            }
            else
            {
                if( $extravar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );

                }
            }

        }

    }
    if (is_array($error)){
        foreach( $error as $option_data ) {
            if (isset($option_data['id']))
            {
                $errorvar = get_option( $option_data['id'], "ttr_test" );
                if( $errorvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }

    if (is_array($mmoptions)){
        foreach( $mmoptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $extravar = get_option( $option_data['id'], "ttr_test" );

                if( $extravar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }

        }
    }

	if (is_array($seoenable)){ 
        foreach( $seoenable as $option_data ) {
            if (isset($option_data['id']))
            {
                $seoenablevar = get_option( $option_data['id'], "ttr_test" );
                if( $seoenablevar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }

    if (is_array($seooptions)){
        foreach( $seooptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $seovar = get_option( $option_data['id'], "ttr_test" );
                if( $seovar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }

    if (is_array($genoptions)){
        foreach( $genoptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $genvar = get_option( $option_data['id'], "ttr_test" );
                if( $genvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }


    if (is_array($weboptions)){
        foreach( $weboptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $webvar = get_option( $option_data['id'], "ttr_test" );
                if( $webvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }

    if (is_array($advancedoptions)){
        foreach( $advancedoptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $advancedvar = get_option( $option_data['id'], "ttr_test" );
                if( $advancedvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }


    if (is_array($dashboardoptions)){
      
        foreach( $dashboardoptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $dashboardvar = get_option( $option_data['id'], "ttr_test" );            
                if( $dashboardvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );

                }
            }
        }
    }

    if (is_array($backupoptions)){
        foreach( $backupoptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $backupvar = get_option( $option_data['id'], "ttr_test" );
                if( $backupvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }

    if (is_array($recoveryoptions)){
        foreach( $recoveryoptions as $option_data ) {
            if (isset($option_data['id']))
            {
                $recoveryvar = get_option( $option_data['id'], "ttr_test" );
                if( $recoveryvar == "ttr_test" ) {
                    update_option( $option_data['id'], $option_data['std'] );
                }
            }
        }
    }

}

add_action("after_switch_theme", "myactivationfunction");

function mydeactivationfunction($newname, $newtheme) {

    if (  function_exists( 'color_array' ) )
        $colors=color_array();
    if (  function_exists( 'header_options_array' ) )
        $headeroptions=header_options_array();
    else
        $headeroptions="";
    if (  function_exists( 'postcontent_array' ) )
        $postcontentoptions=postcontent_array();
    if (  function_exists( 'footer_options_array' ) )
        $footeroptions=footer_options_array();
    else
        $footeroptions="";
    if (  function_exists( 'sidebar_options_array' ) )
        $sidebaroptions= sidebar_options_array();
    else
        $sidebaroptions="";
    if (  function_exists( 'general_options_array' ) )
        $generaloptions = general_options_array();

    if (  function_exists( 'googlemap_options_array' ) )
        $gmapoptions = googlemap_options_array();

    if (  function_exists( 'error_options_array' ) )
        $error = error_options_array();

	if (  function_exists( 'seo_enable_array' ) )
        $seoenable = seo_enable_array();

    if (  function_exists( 'home_settings_array' ) )
        $seooptions = home_settings_array();

    if (  function_exists( 'general_settings_array' ) )
        $genoptions = general_settings_array();

    if (  function_exists( 'web_social_array' ) )
        $weboptions = web_social_array();

    if (  function_exists( 'sitemap_array' ) )
        $sitemapoptions = sitemap_array();

    if (  function_exists( 'advanced_array' ) )
        $advancedoptions = advanced_array();

    if (  function_exists( 'dashboard_array' ) )
        $dashboardoptions = dashboard_array();

    if (  function_exists( 'backup_array' ) )
        $backupoptions = backup_array();

    if (  function_exists( 'recovery_array' ) )
        $recoveryoptions = recovery_array();

    if (is_array($headeroptions)){
        foreach( $headeroptions as $option_data ) {
            $headervar = get_option( $option_data['id'], "ttr_test" );
            if($option_data['id']=='blogname' || $option_data['id']=='blogdescription' )
            {
                continue;
            }
            if( $headervar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }
    foreach( $postcontentoptions as $option_data ) {
        $postcontentvar = get_option( $option_data['id'], "ttr_test" );
        if( $postcontentvar != "ttr_test" ) {
            delete_option( $option_data['id']);
        }
    }

    if (is_array($sidebaroptions)){
        foreach( $sidebaroptions as $option_data ) {
            $sidebarvar = get_option( $option_data['id'], "ttr_test" );
            if( $sidebarvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    if (is_array($footeroptions)){
        foreach( $footeroptions as $option_data ) {
            $footervar = get_option( $option_data['id'], "ttr_test" );
            if( $footervar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }
    if (is_array($colors)){
        foreach( $colors as $option_data ) {
            $colorvar = get_option( $option_data['id'], "ttr_test" );
            if( $colorvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }
    $contactform_var=get_option('contact_form',"ttr_test");
    if( $contactform_var != "ttr_test" ) {
        delete_option( 'contact_form');
    }

    if (  function_exists( 'mm_options_array' ) )
        $mmoptions = mm_options_array();

    foreach( $generaloptions as $option_data ) {
        $extravar = get_option( $option_data['id'], "ttr_test" );
        if( $extravar != "ttr_test" ) {
            delete_option( $option_data['id']);
        }
    }
    if (is_array($error)){
        foreach( $error as $option_data ) {
            $errorvar = get_option( $option_data['id'], "ttr_test" );
            if( $errorvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    foreach( $gmapoptions as $option_data ) {
        $gmapvar = get_option( $option_data['id'], "ttr_test" );
        if( $gmapvar != "ttr_test" ) {
            delete_option( $option_data['id']);
        }
    }


    if (is_array($mmoptions)){
        foreach( $mmoptions as $option_data ) {
            $mmvar = get_option( $option_data['id'], "ttr_test" );
            if( $mmvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

	 if (is_array($seoenable)){
        foreach( $seoenable as $option_data ) {
            $seoenablevar = get_option( $option_data['id'], "ttr_test" );
            if( $seoenablevar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    if (is_array($seooptions)){
        foreach( $seooptions as $option_data ) {
            $seovar = get_option( $option_data['id'], "ttr_test" );
            if( $seovar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    if (is_array($genoptions)){
        foreach( $genoptions as $option_data ) {
            $genvar = get_option( $option_data['id'], "ttr_test" );
            if( $genvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    if (is_array($weboptions)){
        foreach( $weboptions as $option_data ) {
            $webvar = get_option( $option_data['id'], "ttr_test" );
            if( $webvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    if (is_array($advancedoptions)){
        foreach( $advancedoptions as $option_data ) {
            $advancedvar = get_option( $option_data['id'], "ttr_test" );
            if( $advancedvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }
    if (is_array($dashboardoptions)){
        foreach( $dashboardoptions as $option_data ) {
            $dashboardvar = get_option( $option_data['id'], "ttr_test" );
            if( $dashboardvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    if (is_array($backupoptions)){
        foreach( $backupoptions as $option_data ) {
            $backupvar = get_option( $option_data['id'], "ttr_test" );
            if( $backupvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }

    if (is_array($recoveryoptions)){
        foreach( $recoveryoptions as $option_data ) {
            $recoveryvar = get_option( $option_data['id'], "ttr_test" );
            if( $recoveryvar != "ttr_test" ) {
                delete_option( $option_data['id']);
            }
        }
    }
}

add_action("switch_theme", "mydeactivationfunction");

function wordpress_breadcrumbs() {

    $delimiter = get_option('ttr_breadcrumb_text_separator');
    $name = __('Home',CURRENT_THEME); //text for the 'Home' link
    $currentBefore = '<span class="current">';
    $currentAfter = '</span>';

    if ( !is_home() && !is_front_page() || is_paged() ) {

        echo '<div class="breadcrumb">';

        global $post;
        $home = home_url();
        echo get_option("ttr_breadcrumb_text");
        echo '<a href="' . $home . '">' . $name . '</a> ' .'<span class="separator">'. $delimiter . '</span>  ';

        if ( is_category() ) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, '<span class="separator"> ' . $delimiter . '</span> '));
            echo $currentBefore . __('Archive by category &#39;',CURRENT_THEME);
            single_cat_title();
            echo '&#39;' . $currentAfter;

        } elseif ( is_day() ) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> <span class="separator">' . $delimiter . '</span> ';
            echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> <span class="separator">' . $delimiter . '</span> ';
            echo $currentBefore . get_the_time('d') . $currentAfter;

        } elseif ( is_month() ) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> <span class="separator">' . $delimiter . '</span> ';
            echo $currentBefore . get_the_time('F') . $currentAfter;

        } elseif ( is_year() ) {
            echo $currentBefore . get_the_time('Y') . $currentAfter;

        } elseif ( is_single() ) {
            $cat = get_the_category();
            if (isset($cat) && !empty($cat))
            {
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' <span class="separator">' . $delimiter . '</span> ');
                echo $currentBefore;
                the_title();
                echo $currentAfter;
            }

        } elseif ( is_page() && !$post->post_parent ) {
            echo $currentBefore;
            the_title();
            echo $currentAfter;

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . '<span class="separator"> ' . $delimiter . '</span> ';
            echo $currentBefore;
            the_title();
            echo $currentAfter;

        } elseif ( is_search() ) {
            echo $currentBefore . __('Search results for &#39;',CURRENT_THEME) . get_search_query() . '&#39;' . $currentAfter;

        } elseif ( is_tag() ) {
            echo $currentBefore . __('Posts tagged &#39;',CURRENT_THEME);
            single_tag_title();
            echo '&#39;' . $currentAfter;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $currentBefore . __('Articles posted by',CURRENT_THEME) . $userdata->display_name . $currentAfter;

        } elseif ( is_404() ) {
            echo $currentBefore . __('Error 404',CURRENT_THEME) . $currentAfter;
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page',CURRENT_THEME) . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</div>';

    }
}

add_filter('sidebars_widgets', 'sidebars_widgets');
//Add input fields(priority 5, 3 parameters)
add_action('in_widget_form', 'kk_in_widget_form', 5, 3);
//Callback function for options update (priority 5, 3 parameters)
add_filter('widget_update_callback', 'kk_in_widget_form_update', 5 , 3);
function sidebars_widgets($sidebars) {
    if ( is_admin() ) {
        return $sidebars;
    }

    global $wp_registered_widgets;

    foreach ( $sidebars as $s => $sidebar ) {
        if ( $s == 'wp_inactive_widgets' || strpos($s, 'orphaned_widgets') === 0 || empty($sidebar) ) {
            continue;
        }

        foreach ( $sidebar as $w => $widget ) {
            // $widget is the id of the widget
            if ( !isset($wp_registered_widgets[$widget]) ) {
                continue;
            }

            $opts = $wp_registered_widgets[$widget];
            $id_base = is_array($opts['callback']) ? $opts['callback'][0]->id_base : $opts['callback'];

            if ( !$id_base ) {
                continue;
            }

            $instance = get_option('widget_' . $id_base);

            if ( !$instance || !is_array($instance) ) {
                continue;
            }

            if ( isset($instance['_multiwidget']) && $instance['_multiwidget'] ) {
                $number = $opts['params'][0]['number'];
                if ( !isset($instance[$number]) ) {
                    continue;
                }

                $instance = $instance[$number];
                unset($number);
            }

            unset($opts);

            $show = show_widget($instance);



            if ( !$show ) {
                unset($sidebars[$s][$w]);
            }

            unset($widget);
        }
        unset($sidebar);
    }

    return $sidebars;
}
function show_widget($instance){
    global $wp_query;
    $post_id = $wp_query->get_queried_object_id();

    if (is_home()){
        $show = isset($instance['page-home']) ? ($instance['page-home']) : false;
    }else if (is_front_page()){
        $show = isset($instance['page-front']) ? ($instance['page-front']) : false;
    }else if (is_archive()){
        $show = isset($instance['page-archive']) ? ($instance['page-archive']) : false;
    }else if (is_single()){
        if(function_exists('get_post_type')){
            $type = get_post_type();
            if($type != 'page' and $type != 'post')
                $show = isset($instance['page-'.$type]) ? ($instance['page-'.$type]) : false;
        }

        if(!isset($show))
            $show = isset($instance['page-single']) ? ($instance['page-single']) : false;
    }else if (is_404()){
        $show = isset($instance['page-404']) ? ($instance['page-404']) : false;
    }else if($post_id){
        $show = isset($instance['page-'.$post_id]) ? ($instance['page-'.$post_id]) : false;
    }

    if(!isset($show))
        $show = false;

    if($show)
        return false;

    return $instance;
}

function kk_in_widget_form($t,$return,$instance){


    $instance = wp_parse_args( (array) $instance, array( 'style' => 'default') );
    $pages = get_posts( array(
        'post_type' => 'page', 'post_status' => 'publish',
        'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC'
    ));
    $wp_page_types = array(
        'front' => __('Front', CURRENT_THEME),
        'home' => __('Blog', CURRENT_THEME),
        'archive' => __('Archives', CURRENT_THEME),
        'single' => __('Single Post', CURRENT_THEME),
        '404' => __('404', CURRENT_THEME)
    );

    ?>
    <label><?php echo(__('Hide widget on:',CURRENT_THEME));?></label>
    <div class=<?php echo $t->get_field_id(''); ?> style="height:150px; overflow:auto; border:1px solid #dfdfdf;">
	<button onclick="select_widget(this);" style="margin:5px 0 0 5px;" type="button" class="check-all">Select All</button>
	<button onclick="unselect_widget(this);" style="margin:5px 0 0 5px;" type="button" class="uncheck-all">UnSelect All</button>

	<?php foreach ($pages as $page)
    {
        $instance['page-'.$page->ID] = isset($instance['page-'.$page->ID]) ? $instance['page-'.$page->ID] : false;
        ?>
        <div style="padding:5px;">
            <input style="margin:1px 5px 0 5px;" class=<?php echo $t->get_field_id(''); ?> type="checkbox" <?php checked($instance['page-'.$page->ID], true) ?> id="<?php echo $t->get_field_id('page-'.$page->ID); ?>" name="<?php echo $t->get_field_name('page-'.$page->ID); ?>" />
            <label style="display:inline;margin:0;" for="<?php echo $t->get_field_id('page-'.$page->ID); ?>"><?php echo $page->post_title ?></label>
        </div>
    <?php } ?>
	 <?php foreach ($wp_page_types as $key => $label){
        $instance['page-'.$key] = isset($instance['page-'.$key]) ? $instance['page-'.$key] : false;
        ?>
        <div style="padding:5px;">
            <input style="margin:1px 5px 0 5px;" class=<?php echo $t->get_field_id(''); ?> type="checkbox" <?php checked($instance['page-'.$key], true) ?> id="<?php echo $t->get_field_id('page-'.$key); ?>" name="<?php echo $t->get_field_name('page-'.$key); ?>" />
            <label style="display:inline;margin:0;" for="<?php echo $t->get_field_id('page-'.$key); ?>"><?php echo $label .' '. __('Page', CURRENT_THEME) ?></label>
        </div>
    <?php } ?>

	</div>

	<script type="text/javascript">

        function select_widget(obj) {

            ( function() {

                var parent = jQuery(obj).parent();
                var name = parent.attr('class');
                jQuery('.' + name).attr('checked', 'checked');

            } )();
        }

        function unselect_widget(obj) {

            ( function() {

                var parent = jQuery(obj).parent();
                var name = parent.attr('class');
                jQuery('.' + name).removeAttr('checked');

            } )();
        }
    </script>

	<?php if ( !isset($instance['style']) )
        $instance['style'] = null;
	?>

        <label for="<?php echo $t->get_field_id('style'); ?>"><?php echo(__('Block Style:',CURRENT_THEME));?></label>
        <select id="<?php echo $t->get_field_id('style'); ?>" name="<?php echo $t->get_field_name('style'); ?>">
            <option <?php selected($instance['style'], 'default');?>value="default"><?php echo(__('Default',CURRENT_THEME));?></option>
            <option <?php selected($instance['style'], 'none');?> value="none"><?php echo(__('None',CURRENT_THEME));?></option>
            <option <?php selected($instance['style'], 'block');?>value="block"><?php echo(__('Block',CURRENT_THEME));?></option>
        </select>
    <?php
    $retrun = null;
    return array($t,$return,$instance);
}

function kk_in_widget_form_update($instance, $new_instance, $old_instance){
    $pages = get_posts( array(
        'post_type' => 'page', 'post_status' => 'publish',
        'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC'
    ));
    if($pages){

        foreach ($pages as $page){

            if(isset($new_instance['page-'.$page->ID]))
            {
                $instance['page-'.$page->ID] = 1;

            }
            else if(isset($instance['page-'.$page->ID]))
                unset($instance['page-'.$page->ID]);
            unset($page);
        }
    }

    foreach(array('front', 'home', 'archive', 'single', '404') as $page){
        if(isset($new_instance['page-'. $page]))
        {
            $instance['page-'. $page] = 1;

        }
        else if(isset($instance['page-'. $page]))
            unset($instance['page-'. $page]);
    }
    $instance['style'] = $new_instance['style'];
    return $instance;
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */

function tt_add_custom_box() {

    $screens = array( 'post', 'page' );

    foreach($screens as $screen)
    {
        add_meta_box(
            'post_page_options',
            __( 'Theme Options',CURRENT_THEME ),
            'tt_custombox_in_publish',
            $screen,
            'side',
            'high'
        );}

}
add_action( 'add_meta_boxes', 'tt_add_custom_box' );
add_action( 'save_post', 'tt_save_postdata' );

function tt_custombox_in_publish() {
    global $post;
    if (  function_exists( 'page_options_array' ) )
        $pageoptions = page_options_array();
    if (  function_exists( 'post_options_array' ) )
        $postoptions = post_options_array();
    if ('page' != get_post_type($post) && 'post' != get_post_type($post)) return;

    if ('page' == get_post_type($post)):
        foreach ($pageoptions as $value) {
            switch ($value['type']) {

                case "open":
                    ?>
                    <table class="table table-hover table-bordered">
                    <?php 	break;

                case "close":
                    ?>
                    </table>
                    <?php   break;

                case "select":
                    ?><table class="table table-hover table-bordered">
                    <tr>
                        <td><h6><?php echo $value['name']; ?></h6></td>
                        <td ><select style="width:100px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_post_meta($post->ID, $value['id'], true) == $option) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
                    </tr>

                    <?php   break;

                case "checkbox":
                    ?>
                    <tr>
                        <td ><h6><?php echo $value['name']; ?></h6></td>

                        <td>
                            <?php
                            $var = get_post_meta($post->ID, $value['id'],true);?>
                            <?php if ((isset($var) && $var == 'true') || $var == '')
                            {
                                $checked = 'checked="yes"';
                            }
                            else
                            {
                                $checked = '';
                            }?>
                            <div class="normal-toggle-button">
                                <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" <?php echo $checked; ?> />
                            </div>
                        </td>
                    </tr>
                    <?php 	break;

                case 'media': ?>

                    <tr>
                        <td><h6><?php echo $value['name']; ?></h6></td>
                        <td>
                            <div class="uploader">

                                <input type="text" class="upload" style="width:100px;" id="<?php echo $value['id']; ?>" name="<?php  echo $value['id']; ?>" value="<?php if ( get_post_meta($post->ID, $value['id'], true) != "") { echo get_post_meta($post->ID, $value['id'], true); }?>" />


                                <input type= "button" style="margin-top:5px;" class="button" name="<?php echo $value['id']; ?>_button" id="<?php echo $value['id']; ?>_button" value="Upload" />
                            </div>
                            <script type="text/javascript">
                                jQuery(document).ready(function()
                                {
                                    var _custom_media = true,
                                        _orig_send_attachment = wp.media.editor.send.attachment;

                                    // ADJUST THIS to match the correct button
                                    jQuery('.uploader .button').click(function(e)
                                    {
                                        var send_attachment_bkp = wp.media.editor.send.attachment;
                                        var button = jQuery(this);
                                        var id = button.attr('id').replace('_button', '');
                                        _custom_media = true;
                                        wp.media.editor.send.attachment = function(props, attachment)
                                        {
                                            if ( _custom_media )
                                            {
                                                jQuery("#"+id).val(attachment.url);
                                            } else {
                                                return _orig_send_attachment.apply( this, [props, attachment] );
                                            };
                                        }

                                        wp.media.editor.open(button);
                                        return false;
                                    });

                                    jQuery('.add_media').on('click', function()
                                    {
                                        _custom_media = false;
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    </table>
                    <?php break;
            }
        }
        ?>
    <?php

    endif;
    if ('post' == get_post_type($post)):
        foreach ($postoptions as $value) {
            switch ($value['type']) {

                case "open":
                    ?>
                    <table class="table table-hover table-bordered">
                    <?php 	break;

                case "close":
                    ?>
                    </table>
                    <?php   break;

                case "select":
                    ?>
                    <tr>
                        <td><h6><?php echo $value['name']; ?></h6></td>
                        <td ><select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_post_meta($post->ID, $value['id'], true) == $option) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
                    </tr>

                    <?php   break;

                case "checkbox":
                    ?>
                    <tr>
                        <td ><h6><?php echo $value['name']; ?></h6></td>

                        <td>
                            <?php
                            $var = get_post_meta($post->ID, $value['id'],true);?>
                            <?php if ((isset($var) && $var == 'true') || $var == '')
                            {
                                $checked = 'checked="yes"';
                            }
                            else
                            {
                                $checked = '';
                            }?>
                            <div class="normal-toggle-button">
                                <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" <?php echo $checked; ?> />
                            </div>
                        </td>
                    </tr>
                    <?php 	break;


            }
        }
        ?>
    <?php
    endif;
}

function tt_save_postdata( $post_id ) {

    if (  function_exists( 'page_options_array' ) )
        $pageoptions = page_options_array();
    if (  function_exists( 'post_options_array' ) )
        $postoptions = post_options_array();
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
        return;

    if ( isset($_POST['post_type']) &&'page' != $_POST['post_type'] && 'post' != $_POST['post_type'] )
        return;

    if (isset($_POST['post_type']) && 'post' == $_POST['post_type']):
        foreach ($postoptions as $value) {
            $mydata = $_POST[$value['id']];

            if (strpos($value['id'], "checkbox") !== false)
            {

                if (isset($mydata))
                {
                    $mydata = 'true';
                }
                else
                {
                    $mydata = 'false';
                }

                update_post_meta($post_id, $value['id'], $mydata);
            }
            elseif(strpos($value['id'], "text") !== false)
            {
                update_post_meta($post_id, $value['id'], $mydata);
            }
        }
    endif;

    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']):
        foreach ($pageoptions as $value) {
            $mydata = $_POST[$value['id']];
            if (strpos($value['id'], "checkbox") !== false)
            {
                if (isset($mydata))
                {
                    $mydata = 'true';
                }
                else
                {
                    $mydata = 'false';
                }

                update_post_meta($post_id, $value['id'], $mydata);
            }
            elseif(strpos($value['id'], "text") !== false)
            {
                update_post_meta($post_id, $value['id'], $mydata);
            }
            elseif(strpos($value['id'], "select") !== false)
            {
                update_post_meta($post_id, $value['id'], $mydata);

            }
        }
    endif;
}



function my_slide_show() {
    global $no_slides,$slide_show_visible,$cssprefix,$post;
    if (  function_exists( 'header_options_array' ) )
        $headeroptions = header_options_array();
    else
        $headeroptions="";
    if($slide_show_visible):
        if (is_array($headeroptions)){
            foreach( $headeroptions as $option_data ) {
                if($option_data['type']=='media')
                {
                    for($i=0;$i<$no_slides;$i++)
                    {
                        if($option_data['id']=='ttr_slide_show_image'.$i)
                        {
						$slideimage = get_option('ttr_slide_show_image'.$i);
							if(!empty($slideimage)) 
							{
                            if(get_option('ttr_slide_show_image'.$i) && get_option('ttr_horizontal_align'.$i) && get_option('ttr_vertical_align'.$i) && get_option('ttr_stretch'.$i))
                            {
                                $stretch_option = get_option('ttr_stretch'.$i);

                                if($stretch_option == "Uniform"){
                                    $stretch = "/ contain";
                                }
                                else if($stretch_option == "Uniform to fill"){
                                    $stretch = "/ cover";
                                }
                                else  {
                                    $stretch = "/ 100% 100%";
                                }
                                echo '<style>#Slide'.$i.'{background:url('.get_option('ttr_slide_show_image'.$i).') no-repeat '.get_option('ttr_horizontal_align'.$i).' '.get_option('ttr_vertical_align'.$i).''.$stretch.' !important;}</style>';

                            }
                            else if(get_option('ttr_slide_show_image'.$i))
                            {
                                echo '<style>#Slide'.$i.'{background:url('.get_option('ttr_slide_show_image'.$i).') no-repeat scroll center center / 100% 100% !important;}</style>';
                            }
                            else{
                                echo '<style>#Slide'.$i.'{background:url('.get_option('ttr_slide_show_image'.$i).') no-repeat scroll center center / 100% 100% ;}</style>';
                            }
							}

                        }
                    }
                }
            }
        }
    endif;

    if (get_option('ttr_post_title_color'))
     {
         echo '<style>.'.$cssprefix.'post_title,.'.$cssprefix.'post_title a,.'.$cssprefix.'post_title a:visited{color:'. get_option('ttr_post_title_color').' !important}</style>';
     }

     if (get_option('ttr_post_title_hover_color'))
     {
         echo '<style>.'.$cssprefix.'post_title a:hover{color:'. get_option('ttr_post_title_hover_color').' !important}</style>';
     }

    if(get_post_meta($post->ID,"ttr_background_size_select",true)):
        $a=get_post_meta($post->ID,"ttr_background_size_select",true);
        switch($a)
        {
            case "Fill":

                if(get_post_meta($post->ID,"ttr_custom_style_text",true)):
                    echo '<style>';
                    echo 'body {';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_custom_style_text', true).')';
                    if(get_post_meta($post->ID, 'ttr_header_repeat_enable_checkbox', true)=="true")
                        echo 'no-repeat';
                    else
                        echo "repeat";
                    echo ' !important;';
                    echo 'background-size:100% 100% !important;';

                    echo ' }</style>';
                endif;
                break;

            case "Horizontal Fill":
                if(get_post_meta($post->ID,"ttr_custom_style_text",true)):
                    echo '<style>';
                    echo 'body {';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_custom_style_text', true).')!important;';
                    echo 'background-size:auto 100% !important;';
                    if(get_post_meta($post->ID, 'ttr_header_repeat_enable_checkbox', true)=="true")
                        echo 'background-repeat:no-repeat !important;';
                    echo '}</style>';
                endif;
                break;

            case "Vertical Fill":
                if(get_post_meta($post->ID,"ttr_custom_style_text",true)):
                    echo '<style>';
                    echo 'body {';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_custom_style_text', true).')!important;';
                    echo 'background-size:100% auto !important;';
                    if(get_post_meta($post->ID, 'ttr_header_repeat_enable_checkbox', true)=="true")
                        echo 'background-repeat:no-repeat !important;';
                    echo '}</style>';
                endif;
                break;

            default:
                if(get_post_meta($post->ID,"ttr_custom_style_text",true)):
                    echo '<style>';
                    echo 'body {';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_custom_style_text', true).')!important;';
                    if(get_post_meta($post->ID, 'ttr_header_repeat_enable_checkbox', true)=="true")
                        echo 'background-repeat:no-repeat !important;';
                    echo '}</style>';
                endif;

        }
    endif;
    if(get_post_meta($post->ID,"ttr_header_size_select",true)):
        $a=get_post_meta($post->ID,"ttr_header_size_select",true);
        switch($a)
        {
            case "Fill":
                if(get_post_meta($post->ID,"ttr_change_header_image_text",true)):
                    echo '<style>';
                    echo 'header{';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_change_header_image_text', true).')!important;';
                    echo 'background-size:100% 100% !important;';
                    if(get_post_meta($post->ID, 'ttr_background_repeat_enable_checkbox', true)=="true")
                        echo 'background-repeat:no-repeat !important;';
                    echo '}</style>';
                endif;
                break;

            case "Horizontal Fill":
                if(get_post_meta($post->ID,"ttr_change_header_image_text",true)):
                    echo '<style>';
                    echo 'header{';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_change_header_image_text', true).')!important;';
                    echo 'background-size:auto 100% !important;';
                    if(get_post_meta($post->ID, 'ttr_background_repeat_enable_checkbox', true)=="true")
                        echo 'background-repeat:no-repeat !important;';
                    echo '}</style>';
                endif;
                break;

            case "Vertical Fill":
                if(get_post_meta($post->ID,"ttr_change_header_image_text",true)):
                    echo '<style>';
                    echo 'header{';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_change_header_image_text', true).')!important;';
                    echo 'background-size:100% auto !important;';
                    if(get_post_meta($post->ID, 'ttr_background_repeat_enable_checkbox', true)=="true")
                        echo 'background-repeat:no-repeat !important;';
                    echo '}</style>';
                endif;
                break;

            default:
                if(get_post_meta($post->ID,"ttr_change_header_image_text",true)):
                    echo '<style>';
                    echo 'header{';
                    echo 'background:url('.get_post_meta($post->ID, 'ttr_change_header_image_text', true).')!important;';
                    if(get_post_meta($post->ID, 'ttr_background_repeat_enable_checkbox', true)=="true")
                        echo 'background-repeat:no-repeat !important;';
                    echo '}</style>';
                endif;
                break;
        }
    endif;

    if(get_option('ttr_logo_image_width'))
    {
        echo '<style>.'.$cssprefix.'header_logo {width:'.get_option('ttr_logo_image_width').'px !important}</style>';
    }
    if(get_option('ttr_logo_image_height'))
    {
        echo '<style>.'.$cssprefix.'header_logo {height:'.get_option('ttr_logo_image_height').'px !important}</style>';
    }

}

add_action( 'wp_head', 'my_slide_show' );

if(get_option('ttr_google_analytics_enable')):

    add_action('wp_footer', 'add_googleanalytics');
endif;
function add_googleanalytics() {

    $ga= get_option('ttr_google_analytics');

    echo $ga;
}

function m_mode() {

    if(!is_admin())
    {
        if ( !is_user_logged_in())
        {
            $file = get_template_directory().'/maintenance-mode.php';
            include($file);
            exit();

        }
    }
}

if(get_option('ttr_mm_enable'))
{
    add_action('template_redirect','m_mode');
}

function ttr_theme_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', CURRENT_THEME ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ttr_theme_title', 10, 2);
?>