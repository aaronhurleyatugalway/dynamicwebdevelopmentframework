<?php
session_start();
require_once "db_connect.php";
require_once "validation.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
  echo json_encode(["success"=>false, "message"=>"Login required."]);
  exit;
}

$user_id = intval($_SESSION["user_id"]);
$alien_id = isset($_POST["alien_id"]) ? intval($_POST["alien_id"]) : 0;
$rating = isset($_POST["rating"]) ? intval($_POST["rating"]) : 0;
$review_text = isset($_POST["review_text"]) ? clean_input($_POST["review_text"]) : "";

if ($alien_id <= 0) {
  echo json_encode(["success"=>false, "message"=>"Invalid pet id."]);
  exit;
}

$err = valid_rating($rating);
if ($err !== "") {
  echo json_encode(["success"=>false, "message"=>$err]);
  exit;
}


$stmt = $conn->prepare("INSERT INTO pet_ratings (alien_id, user_id, rating, review_text) VALUES (?,?,?,?)");
$stmt->bind_param("iiis", $alien_id, $user_id, $rating, $review_text);
$ok = $stmt->execute();
$stmt->close();

echo json_encode([
  "success" => $ok ? true : false,
  "message" => $ok ? "Review saved!" : "Database error while saving review."
]);
?>
