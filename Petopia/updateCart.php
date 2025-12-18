<?php
session_start();
require_once "db_connect.php";
require_once "cart_functions.php";
ensure_cart();

if (isset($_GET["render_only"]) && $_GET["render_only"] == "1") {
  echo render_cart_html();
  exit;
}

$merch_id = isset($_POST["merch_id"]) ? intval($_POST["merch_id"]) : 0;
$delta = isset($_POST["delta"]) ? intval($_POST["delta"]) : 0;

if ($merch_id > 0 && $delta !== 0) {
  
  $stmt = $conn->prepare("SELECT name, price FROM merch WHERE merch_id=? LIMIT 1");
  $stmt->bind_param("i", $merch_id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows === 1) {
    $m = $res->fetch_assoc();
    add_or_update_cart_item($merch_id, $delta, $m["name"], $m["price"]);
  }
  $stmt->close();
}

echo render_cart_html();
?>
