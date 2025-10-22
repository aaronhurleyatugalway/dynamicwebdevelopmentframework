<?php
// set_theme.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    $theme = preg_replace('/[^a-z0-9_]/i', '', $_POST['theme']); // sanitize input
    setcookie('theme', $theme, time() + 3600 * 24 * 70, '/'); // store for 70 days
}

?>