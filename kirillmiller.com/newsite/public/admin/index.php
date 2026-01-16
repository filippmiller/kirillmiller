<?php
require __DIR__ . '/../app.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (admin_login($username, $password, $config)) {
        header('Location: /admin/pages.php');
        exit;
    }
    $error = 'Invalid login.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 40px; }
        .login { max-width: 360px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 6px; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        label { display: block; margin-top: 12px; }
        input { width: 100%; padding: 8px; margin-top: 6px; }
        button { margin-top: 16px; padding: 10px 16px; }
        .error { color: #b00020; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="login">
        <h1>Admin login</h1>
        <form method="post">
            <label>Username
                <input type="text" name="username" required>
            </label>
            <label>Password
                <input type="password" name="password" required>
            </label>
            <button type="submit">Sign in</button>
            <?php if ($error) { ?><div class="error"><?php echo h($error); ?></div><?php } ?>
        </form>
    </div>
</body>
</html>
