<?php


function ensure_cart() {
  if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = []; 
  }
}

function add_or_update_cart_item($merch_id, $deltaQty, $name, $price) {
  ensure_cart();

  $merch_id = strval($merch_id);

  if (!isset($_SESSION["cart"][$merch_id])) {
    $_SESSION["cart"][$merch_id] = [
      "qty" => 0,
      "name" => $name,
      "price" => floatval($price)
    ];
  }

  $_SESSION["cart"][$merch_id]["qty"] += intval($deltaQty);

  if ($_SESSION["cart"][$merch_id]["qty"] <= 0) {
    unset($_SESSION["cart"][$merch_id]);
  }
}

function cart_totals() {
  ensure_cart();

  $count = 0;
  $total = 0;

  foreach ($_SESSION["cart"] as $id => $item) {
    $count += intval($item["qty"]);
    $total += floatval($item["price"]) * intval($item["qty"]);
  }

  return ["count" => $count, "total" => $total];
}

function render_cart_html() {
  ensure_cart();
  $t = cart_totals();

  $html = "";
  $html .= "<div class='row space'>";
  $html .= "<div><b>Basket</b></div>";
  $html .= "<div class='badge'>" . $t["count"] . " item(s)</div>";
  $html .= "</div>";
  $html .= "<div class='hr'></div>";

  if (count($_SESSION["cart"]) === 0) {
    $html .= "<p class='small'>Your basket is empty.</p>";
    return $html;
  }

  foreach ($_SESSION["cart"] as $id => $item) {
    $name = htmlspecialchars($item["name"]);
    $qty = intval($item["qty"]);
    $price = number_format(floatval($item["price"]), 2);
    $line = number_format(floatval($item["price"]) * $qty, 2);

    $html .= "<div class='cartItem'>";
    $html .= "<div class='name'>" . $name . "</div>";
    $html .= "<div class='muted'>€" . $price . " each</div>";
    $html .= "<div class='row space' style='margin-top:10px;'>";
    $html .= "<div class='row'>";
    $html .= "<button class='btn secondary' onclick='changeQty(".$id.", -1)'>-</button>";
    $html .= "<div class='badge'>".$qty."</div>";
    $html .= "<button class='btn secondary' onclick='changeQty(".$id.", 1)'>+</button>";
    $html .= "</div>";
    $html .= "<div><b>€".$line."</b></div>";
    $html .= "</div>";
    $html .= "<div style='margin-top:10px;'>";
    $html .= "<button class='btn danger' onclick='removeItem(".$id.")'>Remove</button>";
    $html .= "</div>";
    $html .= "</div>";
  }

  $html .= "<div class='hr'></div>";
  $html .= "<div class='row space'>";
  $html .= "<div class='small'>Total</div>";
  $html .= "<div><b>€".number_format($t["total"],2)."</b></div>";
  $html .= "</div>";
  $html .= "<div style='margin-top:12px;'>";
  $html .= "<a class='btn' href='checkout.php'>Checkout</a>";
  $html .= "</div>";

  return $html;
}
?>
