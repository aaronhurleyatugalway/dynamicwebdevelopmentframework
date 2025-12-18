<?php
session_start();
require_once "db_connect.php";
require_once "cart_functions.php";
ensure_cart();

if (isset($_POST["merch_id"]) && $_POST["merch_id"] !== "") {
  $merch_id = intval($_POST["merch_id"]);

  
  $stmt = $conn->prepare("SELECT name, price FROM merch WHERE merch_id=? LIMIT 1");
  $stmt->bind_param("i", $merch_id);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($res->num_rows === 1) {
    $m = $res->fetch_assoc();
    add_or_update_cart_item($merch_id, 1, $m["name"], $m["price"]);
  }
  $stmt->close();
}


$t = cart_totals();
echo $t["count"] . " item(s) • €" . number_format($t["total"],2);
?>
