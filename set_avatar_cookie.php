<?php
if (isset($_GET['avatar'])) {
    $avatarImage = $_GET['avatar']; 

    // Set a cookie for the avatar ID
    setcookie("selected_avatar", $avatarImage, time() + (86400 * 70), "/"); // Expires in 70 days

    echo "<img onclick='showModalImages()' title='Change Avatar' src='images/avatars/". $avatarImage . "' alt='Sock Thieves' width='110px'>";
    
} 
?>

