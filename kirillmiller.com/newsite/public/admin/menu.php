<?php
require __DIR__ . '/_bootstrap.php';

$menuItems = get_menu_items();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $menuItems = array_values(array_filter($menuItems, function ($item) use ($id) {
            return ($item['id'] ?? '') !== $id;
        }));
        save_json(DATA_PATH . '/menu.json', $menuItems);
        header('Location: /admin/menu.php');
        exit;
    }

    $id = $_POST['id'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $parent = $_POST['parent_id'] ?? '';
    $order = (int)($_POST['order'] ?? 0);
    $parentId = $parent !== '' ? $parent : null;

    if ($id === '') {
        $menuItems[] = [
            'id' => 'menu_' . uniqid(),
            'title' => $title,
            'slug' => $slug,
            'parent_id' => $parentId,
            'order' => $order
        ];
    } else {
        foreach ($menuItems as &$item) {
            if (($item['id'] ?? '') === $id) {
                $item['title'] = $title;
                $item['slug'] = $slug;
                $item['parent_id'] = $parentId;
                $item['order'] = $order;
            }
        }
        unset($item);
    }

    save_json(DATA_PATH . '/menu.json', $menuItems);
    header('Location: /admin/menu.php');
    exit;
}

$editing = null;
$editId = $_GET['edit'] ?? '';
foreach ($menuItems as $item) {
    if (($item['id'] ?? '') === $editId) {
        $editing = $item;
        break;
    }
}

ob_start();
?>
<div class="row">
    <div>
        <div class="card">
            <h2><?php echo $editing ? 'Edit menu item' : 'New menu item'; ?></h2>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo h($editing['id'] ?? ''); ?>">
                <label>Title
                    <input type="text" name="title" value="<?php echo h($editing['title'] ?? ''); ?>" required>
                </label>
                <label>Slug
                    <input type="text" name="slug" value="<?php echo h($editing['slug'] ?? ''); ?>" required>
                </label>
                <label>Parent
                    <select name="parent_id">
                        <option value="">None</option>
                        <?php foreach ($menuItems as $item) { ?>
                            <option value="<?php echo h($item['id']); ?>" <?php echo (!empty($editing['parent_id']) && $editing['parent_id'] === $item['id']) ? 'selected' : ''; ?>><?php echo h($item['title']); ?></option>
                        <?php } ?>
                    </select>
                </label>
                <label>Order
                    <input type="number" name="order" value="<?php echo h($editing['order'] ?? 0); ?>">
                </label>
                <button type="submit">Save menu item</button>
            </form>
        </div>
    </div>
    <div>
        <div class="card">
            <h2>Menu items</h2>
            <table>
                <thead>
                <tr><th>Title</th><th>Slug</th><th>Parent</th><th>Order</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($menuItems as $item) { ?>
                    <tr>
                        <td><?php echo h($item['title'] ?? ''); ?></td>
                        <td class="muted"><?php echo h($item['slug'] ?? ''); ?></td>
                        <td class="muted"><?php echo h($item['parent_id'] ?? ''); ?></td>
                        <td><?php echo h($item['order'] ?? 0); ?></td>
                        <td class="actions">
                            <a href="/admin/menu.php?edit=<?php echo h($item['id']); ?>">Edit</a>
                            <form method="post" onsubmit="return confirm('Delete this menu item?')">
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
    </div>
</div>
<?php
$content = ob_get_clean();
$adminTitle = 'Menu';
require __DIR__ . '/_layout.php';
