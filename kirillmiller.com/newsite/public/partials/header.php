<?php
$headerSent = headers_sent();
if (!$headerSent) {
    header('Content-Type: text/html; charset=utf-8');
}
$siteTitle = $settings['site_title'] ?? ($config['site']['title'] ?? 'Kirill Miller');
$logo = '/assets/images/logo.png';
$logoMobile = '/assets/images/mobile_logo.png';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($pageTitle); ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/wp-block-library.min.css">
    <?php if (file_exists(__DIR__ . '/../assets/css/wp-block-theme.min.css')) { ?>
        <link rel="stylesheet" href="/assets/css/wp-block-theme.min.css">
    <?php } ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col text-center header">
            <div class="miller">
                <div class="d-none d-sm-block">
                    <a href="/"><img src="<?php echo h($logo); ?>" alt="<?php echo h($siteTitle); ?>" class="logo"></a>
                </div>
                <div class="d-block d-sm-none my-3">
                    <a href="/"><img src="<?php echo h($logoMobile); ?>" alt="<?php echo h($siteTitle); ?>"></a>
                </div>
            </div>
            <div class="menu-block main-menu-block mb-2">
                <ul class="menu d-none d-sm-block">
                    <?php echo $mainMenuHtml; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <?php
        // Check if we have a parent menu item active
        $hasParentActive = !empty($subMenuHtml) && strpos($mainMenuHtml, 'current-menu-parent') !== false;
        $subMenuClass = 'col py-2 sub-menu-block d-none d-sm-block';
        if ($hasParentActive) {
            $subMenuClass .= ' has-parent-active';
        }
        ?>
        <div class="<?php echo $subMenuClass; ?>">
            <?php if (!empty($subMenuHtml)) { ?>
                <div class="menu-block">
                    <ul class="menu">
                        <?php echo $subMenuHtml; ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="col py-2 mobule-menu d-block d-sm-none">
            <div class="text-center">
                <a href="#" id="mobile-menu-button" class="text-uppercase">Menu</a>
            </div>
            <div id="mobile-menu-show" style="display: none" class="text-start">
                <ul class="menu">
                    <?php echo $mainMenuHtml; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
