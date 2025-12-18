<?php
session_start();
require_once "db_connect.php";
require_once "validation.php";
require_once "cart_functions.php";

header("Content-Type: application/json");

ensure_cart();
if (count($_SESSION["cart"]) === 0) {
  echo json_encode(["success"=>false, "message"=>"Your basket is empty."]);
  exit;
}


$billing_name = isset($_POST["billing_name"]) ? $_POST["billing_name"] : "";
$billing_email = isset($_POST["billing_email"]) ? $_POST["billing_email"] : "";
$shipping_address = isset($_POST["shipping_address"]) ? $_POST["shipping_address"] : "";
$payment_last4 = isset($_POST["payment_last4"]) ? $_POST["payment_last4"] : "";

$e1 = required_text($billing_name, 2, "Billing name");
$e2 = valid_email($billing_email);
$e3 = required_text($shipping_address, 6, "Shipping address");
$e4 = required_text($payment_last4, 4, "Card last 4");

if ($e1 || $e2 || $e3 || $e4) {
  $all = array_filter([$e1,$e2,$e3,$e4]);
  echo json_encode(["success"=>false, "message"=>implode(" ", $all)]);
  exit;
}

if (!preg_match("/^[0-9]{4}$/", $payment_last4)) {
  echo json_encode(["success"=>false, "message"=>"Card last 4 must be exactly 4 digits."]);
  exit;
}

$user_id = isset($_SESSION["user_id"]) ? intval($_SESSION["user_id"]) : null;


$conn->begin_transaction();

try {
    foreach ($_SESSION["cart"] as $merch_id => $item) {
    $merch_id_i = intval($merch_id);
    $qty = intval($item["qty"]);
    $total_price = floatval($item["price"]) * $qty;

    if ($user_id === null) {
      $stmt = $conn->prepare("INSERT INTO merch_orders (merch_id, quantity, total_price, billing_name, billing_email, shipping_address, payment_last4) VALUES (?,?,?,?,?,?,?)");
      $stmt->bind_param("iidssss",
        $merch_id_i,
        $qty,
        $total_price,
        $billing_name,
        $billing_email,
        $shipping_address,
        $payment_last4
      );
    } else {
      $stmt = $conn->prepare("INSERT INTO merch_orders (user_id, merch_id, quantity, total_price, billing_name, billing_email, shipping_address, payment_last4) VALUES (?,?,?,?,?,?,?,?)");
      $stmt->bind_param("iiidssss",
        $user_id,
        $merch_id_i,
        $qty,
        $total_price,
        $billing_name,
        $billing_email,
        $shipping_address,
        $payment_last4
      );
    }

    if (!$stmt->execute()) {
      throw new Exception("Insert failed.");
    }
    $stmt->close();
  }

  
  $_SESSION["cart"] = [];
  $conn->commit();

  echo json_encode(["success"=>true, "message"=>"Order placed! (Demo checkout completed)"]);
} catch (Exception $ex) {
  $conn->rollback();
  echo json_encode(["success"=>false, "message"=>"Order failed. Please try again."]);
}
?>
