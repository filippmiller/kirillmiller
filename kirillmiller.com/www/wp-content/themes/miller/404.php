<?php
    //global $myPostData;

    $post = get_posts( array( 'post_type' => 'page', 'include' => array(3829)) )[0];

    setup_postdata($post);

    get_header();
?>
    <h1><?php the_title()?></h1>
<?php
    echo apply_filters( 'the_content', get_post_field('post_content', 3829)); 

    get_footer(); 
?>

