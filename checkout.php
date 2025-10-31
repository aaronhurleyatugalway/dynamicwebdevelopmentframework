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

  <link rel="stylesheet" href="css/checkoutform.css">
</head>

<body class="checkout-page">

  <div id="login_modal" class="box3 div-border div-no-border form-container"></div>
  <div id="basket_modal" class="box3 div-border div-no-border form-container"></div>

  <div id="checkout_success_modal" class="box3 div-border div-no-border form-container">
    <span class="close cursor" onclick="closeCheckoutSuccessModal()">&times;</span>
    <div id="cart_change"></div>
  </div>

  <div id="backdrop"></div>

  <?php
  // ===============================
  // Initialize session/cart data
  // ===============================
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  // Fetch the form fields from the session
  $formFields = $_SESSION['formFields'];

  // Extract data for easier access
  $billing = $formFields['billing'] ?? [];
  $payment = $formFields['payment'] ?? [];
  $shipping = $formFields['shipping'] ?? [];

  if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 0;
  }



  $cart_info = countItemsAndPrice();
  ?>

  <?php

  include 'checkout_navigation_bar.php'; //File with Navigation Bar Elements
  ?>

  <div id="checkoutform_modal" class="box3 div-border div-no-border form-container">
    <?php include('checkoutform.php'); ?>
  </div>




</body>

<!-- =============================== -->
<!-- JAVASCRIPT FILES -->
<!-- =============================== -->
<script src="js/utils.js"></script>
<script src="js/sock.js"></script>

<!-- Add Countries and Months to Selections -->
<script src="js/formExtra.js"></script>
<script src="js/checkout.js"></script>

<?php include "set_dropdown_fields.php" ?>



</html>