<?php
require __DIR__ . '/../app.php';
$_SESSION = [];
if (session_id() !== '') {
    session_destroy();
}
header('Location: /admin/index.php');
exit;
