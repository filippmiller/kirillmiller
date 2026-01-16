<?php
$social = $settings['social'] ?? [];
$footerText = $settings['footer_text'] ?? 'All rights reserved.';
?>
<div class="container">
    <div class="row">
        <div class="col footer text-center">
            <div>
                <?php if (!empty($social['vk'])) { ?><a href="<?php echo h($social['vk']); ?>"><img src="/assets/images/v.png" alt="VK" class="logo"></a><?php } ?>
                <?php if (!empty($social['facebook'])) { ?><a href="<?php echo h($social['facebook']); ?>"><img src="/assets/images/f.png" alt="Facebook" class="logo"></a><?php } ?>
                <?php if (!empty($social['instagram'])) { ?><a href="<?php echo h($social['instagram']); ?>"><img src="/assets/images/i.png" alt="Instagram" class="logo"></a><?php } ?>
                <?php if (!empty($social['youtube'])) { ?><a href="<?php echo h($social['youtube']); ?>"><img src="/assets/images/y.png" alt="YouTube" class="logo"></a><?php } ?>
            </div>
            <div class="pt-2"><small><?php echo h($footerText); ?> <?php echo date('Y'); ?></small></div>
        </div>
    </div>
</div>
<script src="/assets/js/magicimages-gallery.js"></script>
<script src="/assets/js/slick.min.js"></script>
<script src="/assets/js/site.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
</body>
</html>
