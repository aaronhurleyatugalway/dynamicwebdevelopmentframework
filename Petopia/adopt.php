<?php
session_start();
require_once "db_connect.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
  echo json_encode(["success"=>false, "message"=>"You must be logged in to adopt."]);
  exit;
}

$alien_id = isset($_POST["alien_id"]) ? intval($_POST["alien_id"]) : 0;
$user_id = intval($_SESSION["user_id"]);

if ($alien_id <= 0) {
  echo json_encode(["success"=>false, "message"=>"Invalid pet id."]);
  exit;
}


$stmt = $conn->prepare("UPDATE alien_pets SET adopted_by=?, adoption_date=NOW() WHERE alien_id=? AND adopted_by IS NULL");
$stmt->bind_param("ii", $user_id, $alien_id);
$stmt->execute();

if ($stmt->affected_rows === 1) {
  echo json_encode(["success"=>true, "message"=>"Adoption successful!"]);
} else {
  echo json_encode(["success"=>false, "message"=>"Sorry, that pet is already adopted."]);
}
$stmt->close();
?>
