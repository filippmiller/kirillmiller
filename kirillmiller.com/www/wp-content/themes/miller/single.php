<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col content py-3 px-4">
            <div class="breadcrumbs  d-none d-sm-block">
                <?php if(function_exists('bcn_display'))
                {
                    bcn_display();
                }?>
            </div>
            <h1 class="title text-uppercase mb-3"><?php the_title() ?></h1>
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                }
                the_content();
            }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>

