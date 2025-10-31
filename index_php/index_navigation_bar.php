<!-- =============================== -->
  <!-- HEADER / NAVIGATION BAR -->
  <!-- =============================== -->
  <div class="div-border" style="display: flex; justify-content: left; align-items: center; gap: 20px;">

    <!-- Main Image -->
    <img src="images/findyoursocks.jpg" width="245px">

    <!-- Avatar Section -->
    <span onclick="showModalImages()">
      <span id="avatarimage">
        <img src="images/avatars/<?php echo $_COOKIE["selected_avatar"] ?? 'avatar0.jpg' ?>" title="Change Avatar" alt="Sock Thieves"
          width="110px">
      </span>
      <img src="images/avatarchoosesign.jpg" width="75px">
    </span>

<!-- Colour Theme Settings -->
<span id="colourThemeSelect">
  <img 
    id="themeCatImg"
    onclick="showColourSettings()" 
    src="images/colour_theme_cats/<?php echo htmlspecialchars($_COOKIE['theme'] ?? 'purple'); ?>_cat.jpg" 
    title="Change Colour Settings" 
    alt="Sock Thieves"
    width="180px">
</span>

    <!-- Login Button -->
    <button class="button3" onclick="showLoginModal()">Login</button>

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