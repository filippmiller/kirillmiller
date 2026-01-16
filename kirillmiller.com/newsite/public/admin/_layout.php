<?php
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo h($adminTitle); ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f6f6f6; margin: 0; }
        header { background: #222; color: #fff; padding: 16px 24px; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        main { padding: 24px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .card { background: #fff; padding: 16px; margin-bottom: 16px; border-radius: 6px; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 6px; box-sizing: border-box; }
        button { padding: 8px 14px; }
        .row { display: flex; gap: 16px; }
        .row > div { flex: 1; }
        .muted { color: #666; }
        .thumb { max-width: 140px; height: auto; border: 1px solid #ddd; }
        .actions form { display: inline; }
    </style>
</head>
<body>
<header>
    <strong>Admin</strong>
    <nav>
        <a href="/admin/pages.php">Pages</a>
        <a href="/admin/media.php">Media</a>
        <a href="/admin/galleries.php">Galleries</a>
        <a href="/admin/slider.php">Slider</a>
        <a href="/admin/menu.php">Menu</a>
        <a href="/admin/settings.php">Settings</a>
        <a href="/admin/logout.php">Logout</a>
    </nav>
</header>
<main>
    <h1><?php echo h($adminTitle); ?></h1>
    <?php echo $content; ?>
</main>
</body>
</html>
