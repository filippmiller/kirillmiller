<?php
session_start();

$publicRoot = __DIR__;
$projectRoot = dirname($publicRoot);

define('DATA_PATH', $projectRoot . '/storage/data');
define('UPLOADS_PATH', $publicRoot . '/uploads');

// Use Supabase CDN for images in production, local path for development
$supabaseUrl = getenv('SUPABASE_STORAGE_URL');
if ($supabaseUrl) {
    define('UPLOADS_URL', rtrim($supabaseUrl, '/'));
} else {
    define('UPLOADS_URL', '/uploads');
}

$config = require __DIR__ . '/config.php';

function load_json($path, $default = [])
{
    if (!file_exists($path)) {
        return $default;
    }
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $default;
}

function save_json($path, $data)
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($path, $json . "\n");
}

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function get_pages()
{
    return load_json(DATA_PATH . '/pages.json', []);
}

function get_menu_items()
{
    return load_json(DATA_PATH . '/menu.json', []);
}

function get_media_items()
{
    return load_json(DATA_PATH . '/media.json', []);
}

function get_slider_items()
{
    return load_json(DATA_PATH . '/slider.json', []);
}

function get_galleries()
{
    return load_json(DATA_PATH . '/galleries.json', []);
}

function get_settings()
{
    return load_json(DATA_PATH . '/settings.json', []);
}

function get_users()
{
    return load_json(DATA_PATH . '/users.json', []);
}

function is_home_page($page)
{
    return isset($page['is_home']) && $page['is_home'];
}

function find_page_by_slug($pages, $slug)
{
    foreach ($pages as $page) {
        if (!empty($page['slug']) && $page['slug'] === $slug) {
            return $page;
        }
    }
    return null;
}

function find_home_page($pages)
{
    foreach ($pages as $page) {
        if (is_home_page($page)) {
            return $page;
        }
    }
    return null;
}

function get_home_slug()
{
    static $homeSlug = null;
    if ($homeSlug !== null) {
        return $homeSlug;
    }
    $pages = get_pages();
    $home = find_home_page($pages);
    $homeSlug = $home['slug'] ?? '';
    return $homeSlug;
}

function menu_url($slug)
{
    $homeSlug = get_home_slug();
    if ($slug === '' || $slug === 'home' || ($homeSlug !== '' && $slug === $homeSlug)) {
        return '/';
    }
    return '/' . rawurlencode($slug);
}

function sort_by_order($items)
{
    usort($items, function ($a, $b) {
        $orderA = isset($a['order']) ? (int)$a['order'] : 0;
        $orderB = isset($b['order']) ? (int)$b['order'] : 0;
        if ($orderA === $orderB) {
            return strcmp($a['title'] ?? '', $b['title'] ?? '');
        }
        return $orderA <=> $orderB;
    });
    return $items;
}

function get_menu_children($items, $parentId)
{
    $children = [];
    foreach ($items as $item) {
        if (($item['parent_id'] ?? null) === $parentId) {
            $children[] = $item;
        }
    }
    return sort_by_order($children);
}

function build_menu_html($items, $currentSlug)
{
    $items = sort_by_order($items);

    // Find current menu item and its parent
    $currentItem = find_menu_item_by_slug($items, $currentSlug);
    $currentParentId = $currentItem ? ($currentItem['parent_id'] ?? null) : null;

    $html = '';
    foreach ($items as $item) {
        if (!empty($item['parent_id'])) {
            continue;
        }
        $slug = $item['slug'] ?? '';
        $itemId = $item['id'] ?? null;

        // Check if this is the current item or the parent of current item
        $isCurrent = $slug === $currentSlug;
        $isParent = $currentParentId && $itemId === $currentParentId;

        $classes = [];
        if ($isCurrent) {
            $classes[] = 'current-menu-item';
        }
        if ($isParent) {
            $classes[] = 'current-menu-parent';
        }

        $classStr = implode(' ', $classes);
        $html .= '<li class="' . h($classStr) . '"><a href="' . h(menu_url($slug)) . '">' . h($item['title'] ?? '') . '</a></li>';
    }
    return $html;
}

function find_menu_item_by_slug($items, $slug)
{
    foreach ($items as $item) {
        if (($item['slug'] ?? '') === $slug) {
            return $item;
        }
    }
    return null;
}

function build_submenu_html($items, $currentSlug)
{
    $current = find_menu_item_by_slug($items, $currentSlug);
    if (!$current) {
        return '';
    }

    $parentId = $current['parent_id'] ?? null;
    $submenuParentId = $parentId ?: ($current['id'] ?? null);
    $children = get_menu_children($items, $submenuParentId);
    if (empty($children)) {
        return '';
    }

    $html = '';
    foreach ($children as $child) {
        $slug = $child['slug'] ?? '';
        $class = $slug === $currentSlug ? 'current-menu-item' : '';
        $html .= '<li class="' . h($class) . '"><a href="' . h(menu_url($slug)) . '">' . h($child['title'] ?? '') . '</a></li>';
    }
    return $html;
}

function get_gallery_by_id($galleries, $id)
{
    foreach ($galleries as $gallery) {
        if (($gallery['id'] ?? '') === $id) {
            return $gallery;
        }
    }
    return null;
}

function get_media_dimensions($relativePath)
{
    $path = UPLOADS_PATH . '/' . ltrim($relativePath, '/');
    if (!file_exists($path)) {
        return [0, 0];
    }
    $info = @getimagesize($path);
    if (!$info) {
        return [0, 0];
    }
    return [$info[0], $info[1]];
}

function render_gallery_html($gallery, $mediaItems, $galleryIndex)
{
    if (empty($gallery['media_ids'])) {
        return '';
    }

    $mediaById = [];
    foreach ($mediaItems as $media) {
        $mediaById[$media['id']] = $media;
    }

    $html = "<div class='gallery nicegallery-block' id='nicegallery-block" . (int)$galleryIndex . "'>";
    foreach ($gallery['media_ids'] as $mediaId) {
        if (empty($mediaById[$mediaId])) {
            continue;
        }
        $media = $mediaById[$mediaId];
        $src = UPLOADS_URL . '/' . $media['filename'];
        $caption = $media['caption'] ?? '';
        $dims = get_media_dimensions($media['filename']);
        $html .= "<a href='" . h($src) . "' data-fancybox='gallery" . (int)$galleryIndex . "' data-caption='" . h($caption) . "'>";
        $html .= "<img data-width='" . (int)$dims[0] . "' data-height='" . (int)$dims[1] . "' src='" . h($src) . "' alt='" . h($media['alt'] ?? '') . "'>";
        $html .= "</a>";
    }
    $html .= "</div>";
    return $html;
}

function render_content_with_galleries($content)
{
    $galleries = get_galleries();
    $mediaItems = get_media_items();
    $galleryIndex = 1;

    $callback = function ($matches) use ($galleries, $mediaItems, &$galleryIndex) {
        $id = $matches[1] ?? '';
        $gallery = get_gallery_by_id($galleries, $id);
        if (!$gallery) {
            return '';
        }
        $html = render_gallery_html($gallery, $mediaItems, $galleryIndex);
        $galleryIndex++;
        return $html;
    };

    return preg_replace_callback('/\\{\\{\\s*gallery:([^\\}\\s]+)\\s*\\}\\}/', $callback, (string)$content);
}

function admin_is_logged_in()
{
    return !empty($_SESSION['admin_logged_in']);
}

function admin_require_login()
{
    if (!admin_is_logged_in()) {
        header('Location: /admin/index.php');
        exit;
    }
}

function admin_login($username, $password, $config)
{
    $users = get_users();
    foreach ($users as $user) {
        $email = $user['email'] ?? '';
        $hash = $user['password_hash'] ?? '';
        if ($email !== '' && $username === $email && $hash !== '' && password_verify($password, $hash)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_role'] = $user['role'] ?? 'editor';
            return true;
        }
    }

    $expectedUser = $config['admin']['username'] ?? '';
    $expectedPass = $config['admin']['password'] ?? '';
    if ($username === $expectedUser && $password === $expectedPass) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $expectedUser;
        $_SESSION['admin_role'] = 'admin';
        return true;
    }
    return false;
}
