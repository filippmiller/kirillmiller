<?php
require __DIR__ . '/app.php';

$pages = get_pages();
$slug = isset($_GET['page']) ? trim($_GET['page']) : '';
if ($slug === '') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = trim((string)$path, '/');
    if ($path !== '') {
        $slug = $path;
    }
}
$slug = urldecode($slug);
$currentPage = null;

if ($slug === '' || $slug === 'home') {
    $currentPage = find_home_page($pages);
} else {
    $currentPage = find_page_by_slug($pages, $slug);
}

$currentSlug = $slug === '' ? ($currentPage['slug'] ?? 'home') : $slug;

if (!$currentPage) {
    http_response_code(404);
}

$menuItems = get_menu_items();
$mainMenuHtml = build_menu_html($menuItems, $currentSlug);
$subMenuHtml = build_submenu_html($menuItems, $currentSlug);
$settings = get_settings();
$pageTitle = $currentPage ? ($currentPage['title'] ?? 'Page') : 'Not found';
$showSlider = $currentPage && is_home_page($currentPage);
$pageContent = $currentPage ? render_content_with_galleries($currentPage['content'] ?? '') : '';

require __DIR__ . '/partials/header.php';
?>

<?php if ($showSlider) { ?>
    <div class="container">
        <div class="row">
            <div class="col content py-3 px-4">
                <h1 class="title text-uppercase mb-0"><?php echo h($pageTitle); ?></h1>
            </div>
        </div>
    </div>

    <?php require __DIR__ . '/partials/slider.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col content-main py-3 px-4">
                <?php echo $pageContent; ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col content py-3 px-4">
                <?php if ($currentPage) { ?>
                    <div class="breadcrumbs d-none d-sm-block">
                        <a href="/">Home</a> / <span class="current-item"><?php echo h($currentPage['title'] ?? ''); ?></span>
                    </div>
                    <h1 class="title text-uppercase mb-3"><?php echo h($pageTitle); ?></h1>
                    <?php echo $pageContent; ?>
                <?php } else { ?>
                    <h1 class="title text-uppercase mb-3">Not found</h1>
                    <p>Page not found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php
require __DIR__ . '/partials/footer.php';
