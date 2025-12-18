<?php
session_start();
require_once "cart_functions.php";
ensure_cart();
$tot = cart_totals();

if (!isset($_SESSION["formFields"])) {
  $_SESSION["formFields"] = [
    "Billing" => ["name"=>"", "email"=>""],
    "Shipping" => ["address"=>""],
    "Payment" => ["card_last4"=>""]
  ];
}
$f = $_SESSION["formFields"];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Checkout</title>
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
      <div class="badge"><?php echo $tot["count"]; ?> item(s) • €<?php echo number_format($tot["total"],2); ?></div>
      <a class="btn secondary" href="merch.php">Back to Merch</a>
    </div>
  </div>
</div>

<div class="container">
  <div class="grid">
    <div class="col-8">
      <div class="panel">
        <h2 style="margin:0;">Checkout</h2>
        <p class="small">Form fields are saved into <b>$_SESSION</b> </p>

        <div class="hr"></div>

        <form id="checkoutForm" onsubmit="return placeOrder();">
          <div class="panel" style="margin-bottom:12px;">
            <h3 style="margin:0 0 8px 0;">Billing</h3>

            <label>Name</label>
            <input id="Billing_name" name="billing_name" value="<?php echo htmlspecialchars($f["Billing"]["name"]); ?>"
              onchange="setFormValue('Billing','name')">

            <label>Email</label>
            <input id="Billing_email" name="billing_email" value="<?php echo htmlspecialchars($f["Billing"]["email"]); ?>"
              onchange="setFormValue('Billing','email')">
          </div>

          <div class="panel" style="margin-bottom:12px;">
            <h3 style="margin:0 0 8px 0;">Shipping</h3>

            <label>Address</label>
            <input id="Shipping_address" name="shipping_address" value="<?php echo htmlspecialchars($f["Shipping"]["address"]); ?>"
              onchange="setFormValue('Shipping','address')">
          </div>

          <div class="panel">
            <h3 style="margin:0 0 8px 0;">Payment</h3>

            <label>Card Last 4 Digits</label>
            <input id="Payment_card_last4" name="payment_last4" maxlength="4"
              value="<?php echo htmlspecialchars($f["Payment"]["card_last4"]); ?>"
              onchange="setFormValue('Payment','card_last4')">
          </div>

          <div style="margin-top:12px;" class="row">
            <button class="btn" type="submit">Place Order</button>
            <div id="orderMsg"></div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-4">
      <div class="panel">
        <h3 style="margin:0;">Basket Summary</h3>
        <div class="hr"></div>
        <?php
          
          require_once "cart_functions.php";
          echo render_cart_html();
        ?>
      </div>
    </div>
  </div>
</div>

<script src="javascript/checkout.js"></script>
</body>
</html>
