<?php global $classes_post;?>
<article id="post-<?php the_ID(); ?>"<?php post_class( $classes_post ); ?>>
<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
<div class="entry-thumbnail">
<?php the_post_thumbnail(); ?>
</div>
<?php endif; ?>
<div class="ttr_post_content_inner">
<?php if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):?>
<div class="ttr_post_inner_box">
 <h3 class="ttr_post_title">
<?php if(has_post_format( array( 'link' ))):?>
<a href="<?php echo esc_url( mytheme_get_link_url() ); ?>"><?php the_title(); ?></a></h1>
<?php else: ?>
<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', CURRENT_THEME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<?php endif; ?>
</div>
<div class="ttr_article">
<?php if ( 'post' == get_post_type() ) : ?>
<?php endif; ?>
<?php else:?>
<?php $var = get_post_meta($post->ID, 'ttr_post_title_checkbox',true);
 $var_all=get_option('ttr_all_post_title',true);
if($var != 'false' && $var_all):?>
<div class="ttr_post_inner_box">
 <h3 class="ttr_post_title">
<?php if(has_post_format( array( 'link' ))):?>
<a href="<?php echo esc_url( mytheme_get_link_url() ); ?>"><?php the_title(); ?></a></h1>
<?php else: ?>
<?php if(get_post_meta($post->ID,'ttr_post_link_enable_checkbox',true)!= 'false'):?>
<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', CURRENT_THEME ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php endif; ?><?php the_title(); ?></a></h3>
<?php endif; ?>
</div>
<?php endif; ?>
<div class="ttr_article">
<?php if ( 'post' == get_post_type() ) : ?>
<?php endif; ?>
<?php endif; ?>
<?php if ( is_search() ) : ?>
<div class="entry-summary">
<?php the_excerpt(); ?>
</div>
<?php else : ?>
<?php if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):?>
<div class="postcontent">
<div class="entry-content">
<span class="audio-icon"></span>
<div class="audio-content">
<?php the_content( __( 'Continue reading <span>&rarr;</span>', CURRENT_THEME ) ); ?>
</div>
<div style="clear:both;"></div>
</div>
</div>
<?php else:?>
<div class="postcontent">
<div class="entry-content">
<span class="audio-icon"></span>
<div class="audio-content">
<?php if(get_option('ttr_read_more_button')):
the_content( '<span class="button">'.get_option('ttr_read_more').'</span>' );
else:
the_content( get_option('ttr_read_more') ); 
endif;?>
</div>
<div style="clear:both;"></div>
</div>
</div>
<?php endif;?>
<?php wp_link_pages( array( 'before' => '<span>' . __( 'Pages:', CURRENT_THEME ) . '</span>', 'after' => '' ) ); ?>
<?php endif; ?>
<?php $show_sep = false; ?>
</div>
</div>
</article>
