<?php
$sliderItems = get_slider_items();
$mediaItems = get_media_items();
$mediaById = [];
foreach ($mediaItems as $media) {
    $mediaById[$media['id']] = $media;
}
if (!empty($sliderItems)) {
?>
<div class="container slick-main-block">
    <div class="row">
        <div class="col m-0 p-0">
            <div class="slick-main">
                <?php foreach ($sliderItems as $item) { ?>
                    <?php $media = $mediaById[$item['media_id']] ?? null; ?>
                    <?php if ($media) { ?>
                        <div class="slide">
                            <?php if (!empty($item['link'])) { ?><a href="<?php echo h($item['link']); ?>"><?php } ?>
                                <img src="<?php echo h(UPLOADS_URL . '/' . $media['filename']); ?>" alt="<?php echo h($media['alt'] ?? ''); ?>">
                            <?php if (!empty($item['link'])) { ?></a><?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
