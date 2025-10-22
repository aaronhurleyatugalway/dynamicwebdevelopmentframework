<?php
// ===============================
// Handle theme (via cookie)
// ===============================
$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'purple';

// ===============================
// Default avatar cookie
// ===============================
if (!isset($_COOKIE["selected_avatar"])) {
  setcookie("selected_avatar", "avatar0.jpg", time() + (86400 * 30), "/");
}

?>