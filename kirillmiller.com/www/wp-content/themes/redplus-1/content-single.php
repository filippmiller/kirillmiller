<?php global $classes_post;?>
<article <?php post_class( $classes_post ); ?>>
<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
<div class="entry-thumbnail">
<?php the_post_thumbnail(); ?>
</div>
<?php endif; ?>
<div class="ttr_post_content_inner">
<?php if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):?>
<div class="ttr_post_inner_box">
<h3 class="ttr_post_title">
<?php the_title(); ?></h3>
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
<?php the_title(); ?></h3>
</div>
<?php endif; ?>
<div class="ttr_article">
<?php if ( 'post' == get_post_type() ) : ?>
<?php endif; ?>
<?php endif; ?>
<div class="postcontent">
<?php the_content(); ?>
<div style="clear:both;"></div>
</div>
<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', CURRENT_THEME ) . '</span>', 'after' => '</div>' ) ); ?>
</div>
</div>
</article>
