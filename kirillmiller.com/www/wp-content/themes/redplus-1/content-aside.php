<article id="post-<?php the_ID(); ?>"<?php post_class(); ?>>
<div class="ttr_post">
<div class="postcontent">
<div class="entry-content">
<?php if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'):?>
<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', CURRENT_THEME ) ); ?>
<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', CURRENT_THEME ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
<?php else: ?>
<?php if(get_option('ttr_read_more_button')):
the_content( '<span class="button">'.get_option('ttr_read_more').'</span>' );
else:
the_content( get_option('ttr_read_more') ); 
endif;?>
<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', CURRENT_THEME ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
<?php endif; ?>
</div><!-- .entry-content -->
</div>
<div class="entry-meta">
<?php if ( is_single() ) : ?>
<?php mytheme_entry_meta(); ?>
<?php edit_post_link( __( 'Edit This', CURRENT_THEME ), '<span class="edit-link">', '</span>' ); ?>
<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
<?php get_template_part( 'author-bio' ); ?>
<?php endif; ?>
<?php else : ?>
<?php mytheme_entry_meta(); ?>
<?php edit_post_link( __( 'Edit This', CURRENT_THEME ), '<span class="edit-link">', '</span>' ); ?>
<?php endif; // is_single() ?>
</div><!-- .entry-meta -->
</div>
</article><!-- #post -->
