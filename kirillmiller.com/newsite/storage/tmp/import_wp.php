<?php
$exportPath = __DIR__ . '/wp_export.json';
$dataRoot = dirname(__DIR__) . '/data';

$pagesPath = $dataRoot . '/pages.json';
$menuPath = $dataRoot . '/menu.json';
$mediaPath = $dataRoot . '/media.json';
$sliderPath = $dataRoot . '/slider.json';
$galleriesPath = $dataRoot . '/galleries.json';

$export = json_decode(file_get_contents($exportPath), true);
if (!is_array($export)) {
    fwrite(STDERR, "Failed to load export data.\n");
    exit(1);
}

$media = json_decode(file_get_contents($mediaPath), true);
if (!is_array($media)) {
    $media = [];
}

$mediaByFilename = [];
$mediaById = [];
foreach ($media as &$item) {
    if (!isset($item['tags']) || !is_array($item['tags'])) {
        $item['tags'] = [];
    }
    if (!isset($item['used_in']) || !is_array($item['used_in'])) {
        $item['used_in'] = [];
    }
    $mediaByFilename[$item['filename']] = &$item;
    $mediaById[$item['id']] = &$item;
}
unset($item);

$attachmentFileById = [];
foreach ($export['attachments'] ?? [] as $att) {
    $attachmentFileById[(int)$att['id']] = $att['file'];
}

foreach ($export['attachments'] ?? [] as $att) {
    $file = $att['file'];
    if (isset($mediaByFilename[$file])) {
        $mediaByFilename[$file]['wp_id'] = (int)$att['id'];
        if (!empty($att['title']) && empty($mediaByFilename[$file]['title'])) {
            $mediaByFilename[$file]['title'] = $att['title'];
        }
    }
}

$pagesOut = [];
$pageBySlug = [];
$pageByTitle = [];
foreach ($export['pages'] ?? [] as $page) {
    $slug = urldecode($page['slug'] ?? '');
    $title = $page['title'] ?? '';
    $content = $page['content'] ?? '';
    $content = preg_replace('#https?://[^"\\\']*/wp-content/uploads/#', '/uploads/', $content);

    $row = [
        'id' => 'page_' . $page['id'],
        'slug' => $slug,
        'title' => $title,
        'content' => $content,
        'is_home' => !empty($page['is_home'])
    ];
    $pagesOut[] = $row;
    if ($slug !== '') {
        $pageBySlug[$slug] = $row;
    }
    if ($title !== '') {
        $pageByTitle[$title] = $row;
    }
}

$homeSlug = '';
foreach ($pagesOut as $page) {
    if (!empty($page['is_home'])) {
        $homeSlug = $page['slug'];
        break;
    }
}

$menuOut = [];
foreach ($export['menu_items'] ?? [] as $item) {
    $rawSlug = $item['slug'] ?? '';
    $slug = urldecode($rawSlug);
    $title = $item['title'] ?? '';

    if ($title === '' && $slug !== '' && isset($pageBySlug[$slug])) {
        $title = $pageBySlug[$slug]['title'];
    }
    if ($title !== '' && isset($pageByTitle[$title])) {
        $slug = $pageByTitle[$title]['slug'];
    }
    if ($rawSlug === 'menu-item-276' && $homeSlug !== '') {
        if ($title === '') {
            $title = 'Главная';
        }
        $slug = $homeSlug;
    }
    if ($title === '' && $homeSlug !== '' && stripos($rawSlug, 'menu-item') === 0) {
        $title = $homeSlug;
    }

    if ($slug === '' && $title === 'Главная' && $homeSlug !== '') {
        $slug = $homeSlug;
    }
    if ($title === '') {
        $title = $slug !== '' ? $slug : $rawSlug;
    }

    $menuOut[] = [
        'id' => (int)$item['id'],
        'title' => $title,
        'slug' => $slug,
        'parent_id' => !empty($item['parent_id']) ? (int)$item['parent_id'] : null,
        'order' => (int)$item['order']
    ];
}

$galleriesOut = [];
foreach ($export['galleries'] ?? [] as $gallery) {
    $mediaIds = [];
    foreach ($gallery['media_ids_wp'] ?? [] as $wpId) {
        $file = $attachmentFileById[(int)$wpId] ?? null;
        if ($file && isset($mediaByFilename[$file])) {
            $mediaIds[] = $mediaByFilename[$file]['id'];
        }
    }
    if (!empty($mediaIds)) {
        $galleriesOut[] = [
            'id' => $gallery['id'],
            'title' => $gallery['title'],
            'media_ids' => $mediaIds
        ];
    }
}

$sliderOut = [];
foreach ($export['slider'] ?? [] as $slide) {
    $file = $attachmentFileById[(int)$slide['image_id']] ?? null;
    if ($file && isset($mediaByFilename[$file])) {
        $sliderOut[] = [
            'id' => 'slide_' . bin2hex(random_bytes(8)),
            'media_id' => $mediaByFilename[$file]['id'],
            'link' => $slide['url'] ?? ''
        ];
    }
}

function add_tag(&$mediaItem, $tag)
{
    if ($tag === '') {
        return;
    }
    if (!in_array($tag, $mediaItem['tags'], true)) {
        $mediaItem['tags'][] = $tag;
    }
}

function add_usage(&$mediaItem, $slug)
{
    if ($slug === '') {
        return;
    }
    if (!in_array($slug, $mediaItem['used_in'], true)) {
        $mediaItem['used_in'][] = $slug;
    }
}

$menuBySlug = [];
$menuById = [];
foreach ($menuOut as $item) {
    if ($item['slug'] !== '') {
        $menuBySlug[$item['slug']] = $item;
    }
    $menuById[$item['id']] = $item;
}

foreach ($pagesOut as $page) {
    $slug = $page['slug'];
    if ($slug === '') {
        continue;
    }

    $menuItem = $menuBySlug[$slug] ?? null;
    $parentSlug = '';
    if ($menuItem && !empty($menuItem['parent_id'])) {
        $parentItem = $menuById[(int)$menuItem['parent_id']] ?? null;
        if ($parentItem) {
            $parentSlug = $parentItem['slug'];
        }
    }

    $encodedSlug = rawurlencode($slug);
    foreach ($galleriesOut as $gallery) {
        if (strpos($gallery['id'], 'gallery-' . $slug . '-') === 0 || strpos($gallery['id'], 'gallery-' . $encodedSlug . '-') === 0) {
            foreach ($gallery['media_ids'] as $mediaId) {
                if (isset($mediaById[$mediaId])) {
                    add_tag($mediaById[$mediaId], $slug);
                    add_usage($mediaById[$mediaId], $slug);
                    if ($parentSlug !== '') {
                        add_tag($mediaById[$mediaId], $parentSlug);
                    }
                }
            }
        }
    }

    if (preg_match_all("#/uploads/([^\"'\\s>]+)#", $page['content'], $matches)) {
        foreach ($matches[1] as $path) {
            if (isset($mediaByFilename[$path])) {
                add_tag($mediaByFilename[$path], $slug);
                add_usage($mediaByFilename[$path], $slug);
                if ($parentSlug !== '') {
                    add_tag($mediaByFilename[$path], $parentSlug);
                }
            }
        }
    }
}

foreach ($sliderOut as $slide) {
    $mediaId = $slide['media_id'];
    if (isset($mediaById[$mediaId])) {
        add_tag($mediaById[$mediaId], $homeSlug);
        add_usage($mediaById[$mediaId], $homeSlug);
    }
}

file_put_contents($pagesPath, json_encode($pagesOut, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
file_put_contents($menuPath, json_encode($menuOut, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
file_put_contents($galleriesPath, json_encode($galleriesOut, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
file_put_contents($sliderPath, json_encode($sliderOut, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
file_put_contents($mediaPath, json_encode($media, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");

echo "Imported WordPress data into newsite storage.\n";
