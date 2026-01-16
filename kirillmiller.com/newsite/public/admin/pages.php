<?php
require __DIR__ . '/_bootstrap.php';

$pages = get_pages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $pages = array_values(array_filter($pages, function ($page) use ($id) {
            return ($page['id'] ?? '') !== $id;
        }));
        save_json(DATA_PATH . '/pages.json', $pages);
        header('Location: /admin/pages.php');
        exit;
    }

    $id = $_POST['id'] ?? '';
    $slug = trim($_POST['slug'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $isHome = !empty($_POST['is_home']);

    if ($id === '') {
        $id = 'page_' . uniqid();
        $pages[] = [
            'id' => $id,
            'slug' => $slug,
            'title' => $title,
            'content' => $content,
            'is_home' => $isHome
        ];
    } else {
        foreach ($pages as &$page) {
            if (($page['id'] ?? '') === $id) {
                $page['slug'] = $slug;
                $page['title'] = $title;
                $page['content'] = $content;
                $page['is_home'] = $isHome;
            }
        }
        unset($page);
    }

    if ($isHome) {
        foreach ($pages as &$page) {
            if (($page['id'] ?? '') !== $id) {
                $page['is_home'] = false;
            }
        }
        unset($page);
    }

    save_json(DATA_PATH . '/pages.json', $pages);
    header('Location: /admin/pages.php');
    exit;
}

$editing = null;
$editId = $_GET['edit'] ?? '';
foreach ($pages as $page) {
    if (($page['id'] ?? '') === $editId) {
        $editing = $page;
        break;
    }
}

ob_start();
?>
<div class="row">
    <div>
        <div class="card">
            <h2><?php echo $editing ? 'Edit page' : 'New page'; ?></h2>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo h($editing['id'] ?? ''); ?>">
                <label>Title
                    <input type="text" name="title" value="<?php echo h($editing['title'] ?? ''); ?>" required>
                </label>
                <label>Slug
                    <input type="text" name="slug" value="<?php echo h($editing['slug'] ?? ''); ?>" required>
                </label>
                <label>Content (HTML)
                    <textarea name="content" rows="8"><?php echo h($editing['content'] ?? ''); ?></textarea>
                </label>
                <label>
                    <input type="checkbox" name="is_home" value="1" <?php echo !empty($editing['is_home']) ? 'checked' : ''; ?>> Set as home page
                </label>
                <button type="submit">Save page</button>
            </form>
        </div>
    </div>
    <div>
        <div class="card">
            <h2>Pages</h2>
            <table>
                <thead>
                <tr><th>Title</th><th>Slug</th><th>Home</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($pages as $page) { ?>
                    <tr>
                        <td><?php echo h($page['title'] ?? ''); ?></td>
                        <td class="muted"><?php echo h($page['slug'] ?? ''); ?></td>
                        <td><?php echo !empty($page['is_home']) ? 'Yes' : 'No'; ?></td>
                        <td class="actions">
                            <a href="/admin/pages.php?edit=<?php echo h($page['id']); ?>">Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this page?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo h($page['id']); ?>">
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
$adminTitle = 'Pages';
require __DIR__ . '/_layout.php';
