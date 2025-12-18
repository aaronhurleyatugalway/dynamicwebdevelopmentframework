<?php
session_start();
require_once "db_connect.php";
require_once "cart_functions.php";
ensure_cart();
$tot = cart_totals();
$navUser = isset($_SESSION["username"]) ? $_SESSION["username"] : "Guest";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Petopia Merch</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>

<div class="header">
  <div class="container row space">
    <div class="row">
      <img src="images/logo.png" alt="Petopia" style="height:40px;">
      <a class="navlink" href="index.php">Adopt</a>
      <a class="navlink" href="merch.php">Merch</a>
      <a class="navlink" href="checkout.php">Checkout</a>
    </div>

    <div class="row">
      <div id="cart_response" class="badge">
        <?php echo $tot["count"]; ?> item(s) • €<?php echo number_format($tot["total"],2); ?>
      </div>
      <button class="btn secondary" onclick="openCart()">Basket</button>
      <div class="badge">User: <span id="navUser"><?php echo htmlspecialchars($navUser); ?></span></div>
    </div>
  </div>
</div>

<div class="container">
  <div class="panel">
    <div class="row space">
      <h2 style="margin:0;">Merch Store</h2>
      <span class="badge">All items loaded from database</span>
    </div>
    <div class="hr"></div>

    <?php
      
      $stmt = $conn->prepare("SELECT merch_id, name, price, stock_quantity, description, image_url FROM merch ORDER BY merch_id DESC");
      $stmt->execute();
      $res = $stmt->get_result();
    ?>

    <div class="grid">
      <?php while($m = $res->fetch_assoc()){ ?>
        <div class="col-4">
          <div class="card">
            <img src="<?php echo htmlspecialchars($m["image_url"]); ?>" alt="Merch">
            <div class="body">
              <h3><?php echo htmlspecialchars($m["name"]); ?></h3>
              <p><?php echo htmlspecialchars($m["description"]); ?></p>
              <div class="row space" style="margin-top:10px;">
                <span class="badge">€<?php echo number_format($m["price"],2); ?></span>
                <span class="badge">Stock: <?php echo intval($m["stock_quantity"]); ?></span>
              </div>
              <div class="actions">
                <button class="btn" onclick="addToCart(<?php echo intval($m['merch_id']); ?>)">Add to Basket</button>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <?php $stmt->close(); ?>
  </div>
</div>


<div class="sideModal" id="basket_modal">
  <div class="row space">
    <b>Basket</b>
    <span class="closeX" onclick="closeCart()">X</span>
  </div>
  <div class="hr"></div>
  <div id="cartBody"></div>
</div>

<script src="javascript/cart.js"></script>
</body>
</html>
