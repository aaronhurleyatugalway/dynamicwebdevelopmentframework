<!-- =============================== -->
<!-- HEADER / NAVIGATION BAR -->
<!-- =============================== -->
<div class="div-border" style="display: flex; justify-content: left; align-items: center; gap: 20px;">



<a href="index.php">
    <img src="images/findyoursocks.jpg" width="245px" alt="Front Page with Shop">
</a>

  <!-- Avatar Section -->

  <span id="avatarimage">
    <img src="images/avatars/<?php echo $_COOKIE["selected_avatar"] ?? 'avatar0.jpg' ?>" title="Change Avatar"
      alt="Sock Thieves" width="110px">
  </span>

  <!-- Username Display -->
  <span id="user_name">
    <?php
    if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
      echo $_SESSION["username"];
    }
    ?>
  </span>&nbsp;&nbsp;



  <!-- Shopping Cart Info -->
  <div class="div-border" id="cart_response">
    <a href="#" onclick='showShoppingBasket()'><img src="images/cart.jpg" width="40"></a>
    <span style="display: inline-block; margin-left: 10px;">
      <span style="background-color: #c71585; color: white; padding: 2px 6px; border-radius: 4px;">
        <?php echo $cart_info['no_of_items']; ?>
      </span>
      <br>
      €<?php echo number_format($cart_info['total_price'], 2); ?>
    </span>
  </div>
</div>