<?php
require __DIR__ . '/_bootstrap.php';

$media = get_media_items();
$folder = trim($_GET['folder'] ?? '');
$search = trim($_GET['search'] ?? '');

$folders = [];
foreach ($media as $item) {
    $filename = $item['filename'] ?? '';
    $parts = explode('/', $filename);
    if (count($parts) > 1) {
        $folders[$parts[0]] = true;
    }
}
$folders = array_keys($folders);
sort($folders);

$filteredMedia = array_filter($media, function ($item) use ($folder, $search) {
    $filename = $item['filename'] ?? '';
    if ($folder !== '' && strpos($filename, $folder . '/') !== 0) {
        return false;
    }
    if ($search !== '') {
        $tags = $item['tags'] ?? [];
        $tagMatch = false;
        foreach ($tags as $tag) {
            if (stripos($tag, $search) !== false) {
                $tagMatch = true;
                break;
            }
        }
        if (!$tagMatch && stripos($filename, $search) === false) {
            return false;
        }
    }
    return true;
});

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'upload';
    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        foreach ($media as $index => $item) {
            if (($item['id'] ?? '') === $id) {
                $filePath = UPLOADS_PATH . '/' . $item['filename'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                unset($media[$index]);
            }
        }
        $media = array_values($media);
        save_json(DATA_PATH . '/media.json', $media);
        header('Location: /admin/media.php');
        exit;
    }

    if ($action === 'update') {
        $id = $_POST['id'] ?? '';
        foreach ($media as &$item) {
            if (($item['id'] ?? '') === $id) {
                $item['alt'] = trim($_POST['alt'] ?? '');
                $item['caption'] = trim($_POST['caption'] ?? '');
                $tagsRaw = trim($_POST['tags'] ?? '');
                if ($tagsRaw === '') {
                    $item['tags'] = [];
                } else {
                    $tags = array_filter(array_map('trim', explode(',', $tagsRaw)));
                    $item['tags'] = array_values(array_unique($tags));
                }
            }
        }
        unset($item);
        save_json(DATA_PATH . '/media.json', $media);
        header('Location: /admin/media.php');
        exit;
    }

    if (!empty($_FILES['upload']['name'])) {
        $file = $_FILES['upload'];
        if (is_uploaded_file($file['tmp_name'])) {
            $info = getimagesize($file['tmp_name']);
            if ($info) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $filename = uniqid('img_', true) . '.' . $ext;
                $target = UPLOADS_PATH . '/' . $filename;
                if (move_uploaded_file($file['tmp_name'], $target)) {
                    $media[] = [
                        'id' => 'media_' . uniqid(),
                        'filename' => $filename,
                        'title' => $file['name'],
                        'alt' => '',
                        'caption' => '',
                        'tags' => [],
                        'used_in' => []
                    ];
                    save_json(DATA_PATH . '/media.json', $media);
                }
            }
        }
    }

    header('Location: /admin/media.php');
    exit;
}

ob_start();
?>
<div class="card">
    <h2>Upload image</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="upload" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
</div>
<div class="card">
    <h2>Media library</h2>
    <form method="get">
        <div class="row">
            <div>
                <label>Folder
                    <select name="folder">
                        <option value="">All</option>
                        <?php foreach ($folders as $item) { ?>
                            <option value="<?php echo h($item); ?>" <?php echo $folder === $item ? 'selected' : ''; ?>><?php echo h($item); ?></option>
                        <?php } ?>
                    </select>
                </label>
            </div>
            <div>
                <label>Search
                    <input type="text" name="search" value="<?php echo h($search); ?>">
                </label>
            </div>
        </div>
        <button type="submit">Filter</button>
    </form>
    <table>
        <thead>
        <tr><th>Preview</th><th>Details</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($filteredMedia as $item) { ?>
            <tr>
                <td><img class="thumb" src="<?php echo h(UPLOADS_URL . '/' . $item['filename']); ?>" alt=""></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?php echo h($item['id']); ?>">
                        <label>Alt text
                            <input type="text" name="alt" value="<?php echo h($item['alt'] ?? ''); ?>">
                        </label>
                        <label>Caption
                            <input type="text" name="caption" value="<?php echo h($item['caption'] ?? ''); ?>">
                        </label>
                        <label>Tags (comma separated)
                            <input type="text" name="tags" value="<?php echo h(implode(', ', $item['tags'] ?? [])); ?>">
                        </label>
                        <p class="muted">Used in: <?php echo h(implode(', ', $item['used_in'] ?? [])); ?></p>
                        <button type="submit">Save</button>
                    </form>
                </td>
                <td class="actions">
                    <form method="post" onsubmit="return confirm('Delete this image?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo h($item['id']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
$adminTitle = 'Media';
require __DIR__ . '/_layout.php';
