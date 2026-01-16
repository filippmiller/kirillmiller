<?php
require __DIR__ . '/_bootstrap.php';

$galleries = get_galleries();
$media = get_media_items();
$error = '';
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
    if ($search !== '' && stripos($filename, $search) === false) {
        return false;
    }
    return true;
});

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $galleries = array_values(array_filter($galleries, function ($gallery) use ($id) {
            return ($gallery['id'] ?? '') !== $id;
        }));
        save_json(DATA_PATH . '/galleries.json', $galleries);
        header('Location: /admin/galleries.php');
        exit;
    }

    $id = trim($_POST['gallery_id'] ?? '');
    $existingId = $_POST['id'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $include = $_POST['include'] ?? [];
    $orderInput = $_POST['order'] ?? [];

    if ($id === '' && $existingId !== '') {
        $id = $existingId;
    }

    if ($id === '') {
        $error = 'Gallery ID is required.';
    } else {
        $isNew = $existingId === '';
        if ($isNew) {
            foreach ($galleries as $gallery) {
                if (($gallery['id'] ?? '') === $id) {
                    $error = 'Gallery ID already exists.';
                    break;
                }
            }
        }
    }

    if ($error === '') {
        $selected = [];
        foreach ($include as $mediaId) {
            $orderValue = isset($orderInput[$mediaId]) ? (int)$orderInput[$mediaId] : 0;
            $selected[] = ['id' => $mediaId, 'order' => $orderValue];
        }

        usort($selected, function ($a, $b) {
            if ($a['order'] === $b['order']) {
                return strcmp($a['id'], $b['id']);
            }
            return $a['order'] <=> $b['order'];
        });

        $mediaIds = array_map(function ($item) {
            return $item['id'];
        }, $selected);

        if ($existingId === '') {
            $galleries[] = [
                'id' => $id,
                'title' => $title,
                'media_ids' => $mediaIds
            ];
        } else {
            foreach ($galleries as &$gallery) {
                if (($gallery['id'] ?? '') === $existingId) {
                    $gallery['id'] = $id;
                    $gallery['title'] = $title;
                    $gallery['media_ids'] = $mediaIds;
                }
            }
            unset($gallery);
        }

        save_json(DATA_PATH . '/galleries.json', $galleries);
        header('Location: /admin/galleries.php');
        exit;
    }
}

$editing = null;
$editId = $_GET['edit'] ?? '';
foreach ($galleries as $gallery) {
    if (($gallery['id'] ?? '') === $editId) {
        $editing = $gallery;
        break;
    }
}

$selectedIds = $editing['media_ids'] ?? [];
$selectedLookup = array_flip($selectedIds);

ob_start();
?>
<div class="row">
    <div>
        <div class="card">
            <h2><?php echo $editing ? 'Edit gallery' : 'New gallery'; ?></h2>
            <?php if ($error) { ?><p class="muted"><?php echo h($error); ?></p><?php } ?>
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
                <?php if ($editing) { ?>
                    <input type="hidden" name="edit" value="<?php echo h($editing['id']); ?>">
                <?php } ?>
                <button type="submit">Filter</button>
            </form>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo h($editing['id'] ?? ''); ?>">
                <label>Gallery ID (use in content as {{gallery:ID}})
                    <input type="text" name="gallery_id" value="<?php echo h($editing['id'] ?? ''); ?>" <?php echo $editing ? 'readonly' : ''; ?> required>
                </label>
                <label>Title
                    <input type="text" name="title" value="<?php echo h($editing['title'] ?? ''); ?>" required>
                </label>
                <h3>Images</h3>
                <table>
                    <thead>
                    <tr><th>Use</th><th>Order</th><th>Preview</th><th>Filename</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($filteredMedia as $item) { ?>
                        <?php $isSelected = isset($selectedLookup[$item['id']]); ?>
                        <?php $orderValue = $isSelected ? (array_search($item['id'], $selectedIds, true) + 1) : ''; ?>
                        <tr>
                            <td><input type="checkbox" name="include[]" value="<?php echo h($item['id']); ?>" <?php echo $isSelected ? 'checked' : ''; ?>></td>
                            <td><input type="number" name="order[<?php echo h($item['id']); ?>]" value="<?php echo h($orderValue); ?>" min="0"></td>
                            <td><img class="thumb" src="<?php echo h(UPLOADS_URL . '/' . $item['filename']); ?>" alt=""></td>
                            <td class="muted"><?php echo h($item['filename']); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <button type="submit">Save gallery</button>
            </form>
        </div>
    </div>
    <div>
        <div class="card">
            <h2>Galleries</h2>
            <table>
                <thead>
                <tr><th>Title</th><th>ID</th><th>Images</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($galleries as $gallery) { ?>
                    <tr>
                        <td><?php echo h($gallery['title'] ?? ''); ?></td>
                        <td class="muted"><?php echo h($gallery['id'] ?? ''); ?></td>
                        <td><?php echo count($gallery['media_ids'] ?? []); ?></td>
                        <td class="actions">
                            <a href="/admin/galleries.php?edit=<?php echo h($gallery['id']); ?>">Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this gallery?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo h($gallery['id']); ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$adminTitle = 'Galleries';
require __DIR__ . '/_layout.php';
