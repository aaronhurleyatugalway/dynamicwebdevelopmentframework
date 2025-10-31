<?php
// ===============================
// Include dependencies and start session
// ===============================
include 'db_connect.php';

session_start();

include 'cart_functions.php'; // methods for adding to $_SESSION['cart'] and finding price

include 'index_php/index_set_cookies.php'; // initialising colour theme and avatar cookies
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sock Stealing Socks</title>
  <link rel="icon" type="image/png" href="images/favicon.png">

  <!-- Base stylesheet -->
  <link rel="stylesheet" href="css/styles.css">

  <!-- Theme stylesheet (dynamic) -->
  <link id="theme-css" rel="stylesheet" href="css/styles_<?php echo $theme; ?>.css">
</head>

<body>

  <?php
  // ===============================
  // Initialize session/cart data
  // ===============================
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  if (!isset($_SESSION['formFields'])) {
    $_SESSION['formFields'] = [];
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 0;
}



  $cart_info = countItemsAndPrice();
  ?>

  <?php
  include 'index_php/index_modals.php'; // File with Modals

  include 'index_php/index_navigation_bar.php'; //File with Navigation Bar Elements
  
  include 'index_php/index_shop_section.php'; //File with Shop Section 
  ?>


</body>

<!-- =============================== -->
<!-- JAVASCRIPT FILES -->
<!-- =============================== -->
<script src="js/utils.js"></script>
<script src="js/sock.js"></script>

</html>