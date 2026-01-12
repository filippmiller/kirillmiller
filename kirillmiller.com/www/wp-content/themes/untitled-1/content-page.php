<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
<?php global $cssprefix;?>
<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
<div class="entry-thumbnail">
  <?php the_post_thumbnail(); ?>
</div>
<?php endif; ?>
<?php if(isset($_POST['action']) && $_POST['wp_customize']=='on'):?>
<h1 class="<?php echo $cssprefix.'post_title';?>">
  <?php the_title(); ?>
</h1>
<?php else: ?>
<?php

	
$var = get_post_meta ( $post->ID, 'ttr_page_title_checkbox', true );
	$var1 = get_option ( 'ttr_all_page_title', true );
	if ($var != 'false' && $var1) :
		?>
<h1 class="<?php echo $cssprefix.'post_title';?>">
  <?php the_title(); ?>
</h1>
<?php endif; ?>
<?php endif; ?>
<?php the_content(); ?>
<?php wp_link_pages( array( 'before' => '<span>' . __( 'Pages:', CURRENT_THEME ) . '</span>', 'after' => '' ) ); ?>
<?php
		
if ($post = get_post ( $id ) and $url = get_edit_post_link ( $post->ID )) {
			// if ( null ==='Edit' )
			$link = __ ( 'Edit This', CURRENT_THEME );
			$post_type_obj = get_post_type_object ( $post->post_type );
			$link = '<a href="' . $url . '" title="' . esc_attr ( $post_type_obj->labels->edit_item ) . '">' . $link . '</a>';
			echo '<span class="edit-link">' . apply_filters ( 'edit_post_link', $link, $post->ID ) . '</span>';
		}
		?>