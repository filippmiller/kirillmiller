<?php
/**
 * Template Name: Главная страница
 */
?>

<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col content py-3 px-4">
            <h1 class="title text-uppercase mb-0"><?php the_title() ?></h1>
        </div>
    </div>
</div>
<div class="container slick-main-block">
    <div class="row">
        <div class="col m-0 p-0">
            <div class="slick-main">
                <?php
                foreach (get_field('slider') as $slide) {
                    ?>
                    <div class="slide">
                        <?php
                        if ($slide['url'] != '') {
                            ?>
                            <a href="<?php echo $slide['url'] ?>">
                                <?php
                                echo wp_get_attachment_image($slide['image'], 'large');
                                ?>
                            </a>
                            <?php
                        } else {
                            echo wp_get_attachment_image($slide['image'], 'large');
                        }
                        ?>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col content-main py-3 px-4">
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
