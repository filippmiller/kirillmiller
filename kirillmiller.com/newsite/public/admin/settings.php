<?php
require __DIR__ . '/_bootstrap.php';

$settings = get_settings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings['site_title'] = trim($_POST['site_title'] ?? '');
    $settings['footer_text'] = trim($_POST['footer_text'] ?? '');
    $settings['social'] = [
        'vk' => trim($_POST['vk'] ?? ''),
        'facebook' => trim($_POST['facebook'] ?? ''),
        'instagram' => trim($_POST['instagram'] ?? ''),
        'youtube' => trim($_POST['youtube'] ?? '')
    ];
    save_json(DATA_PATH . '/settings.json', $settings);
    header('Location: /admin/settings.php');
    exit;
}

$social = $settings['social'] ?? [];

ob_start();
?>
<div class="card">
    <form method="post">
        <label>Site title
            <input type="text" name="site_title" value="<?php echo h($settings['site_title'] ?? ''); ?>">
        </label>
        <label>Footer text
            <input type="text" name="footer_text" value="<?php echo h($settings['footer_text'] ?? ''); ?>">
        </label>
        <h2>Social links</h2>
        <label>VK
            <input type="text" name="vk" value="<?php echo h($social['vk'] ?? ''); ?>">
        </label>
        <label>Facebook
            <input type="text" name="facebook" value="<?php echo h($social['facebook'] ?? ''); ?>">
        </label>
        <label>Instagram
            <input type="text" name="instagram" value="<?php echo h($social['instagram'] ?? ''); ?>">
        </label>
        <label>YouTube
            <input type="text" name="youtube" value="<?php echo h($social['youtube'] ?? ''); ?>">
        </label>
        <button type="submit">Save settings</button>
    </form>
</div>
<?php
$content = ob_get_clean();
$adminTitle = 'Settings';
require __DIR__ . '/_layout.php';
