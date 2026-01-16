<?php
require __DIR__ . '/_bootstrap.php';

$slider = get_slider_items();
$media = get_media_items();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'add';
    if ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        $slider = array_values(array_filter($slider, function ($item) use ($id) {
            return ($item['id'] ?? '') !== $id;
        }));
        save_json(DATA_PATH . '/slider.json', $slider);
        header('Location: /admin/slider.php');
        exit;
    }

    $mediaId = $_POST['media_id'] ?? '';
    $link = trim($_POST['link'] ?? '');
    if ($mediaId !== '') {
        $slider[] = [
            'id' => 'slide_' . uniqid(),
            'media_id' => $mediaId,
            'link' => $link
        ];
        save_json(DATA_PATH . '/slider.json', $slider);
    }
    header('Location: /admin/slider.php');
    exit;
}

$mediaById = [];
foreach ($media as $item) {
    $mediaById[$item['id']] = $item;
}

ob_start();
?>
<div class="card">
    <h2>Add slide</h2>
    <form method="post">
        <label>Image
            <select name="media_id" required>
                <option value="">Select image</option>
                <?php foreach ($media as $item) { ?>
                    <option value="<?php echo h($item['id']); ?>"><?php echo h($item['title'] ?? $item['filename']); ?></option>
                <?php } ?>
            </select>
        </label>
        <label>Link (optional)
            <input type="text" name="link">
        </label>
        <button type="submit">Add slide</button>
    </form>
</div>
<div class="card">
    <h2>Slides</h2>
    <table>
        <thead>
        <tr><th>Preview</th><th>Link</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($slider as $item) { ?>
            <?php $mediaItem = $mediaById[$item['media_id']] ?? null; ?>
            <tr>
                <td>
                    <?php if ($mediaItem) { ?>
                        <img class="thumb" src="<?php echo h(UPLOADS_URL . '/' . $mediaItem['filename']); ?>" alt="">
                    <?php } else { ?>
                        <span class="muted">Missing media</span>
                    <?php } ?>
                </td>
                <td><?php echo h($item['link'] ?? ''); ?></td>
                <td class="actions">
                    <form method="post" onsubmit="return confirm('Delete this slide?')">
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
$adminTitle = 'Slider';
require __DIR__ . '/_layout.php';
