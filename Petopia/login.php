<?php
session_start();
require_once "db_connect.php";
require_once "validation.php";

header("Content-Type: application/json");

$username = isset($_POST["username"]) ? clean_input($_POST["username"]) : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

if ($username === "" || $password === "") {
  echo json_encode(["success"=>false, "message"=>"Username and password are required."]);
  exit;
}


$stmt = $conn->prepare("SELECT user_id, username, password_hash FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
  $row = $res->fetch_assoc();
  if (password_verify($password, $row["password_hash"])) {
    $_SESSION["user_id"] = intval($row["user_id"]);
    $_SESSION["username"] = $row["username"];

    echo json_encode(["success"=>true, "message"=>"Login successful.", "username"=>$row["username"]]);
  } else {
    echo json_encode(["success"=>false, "message"=>"Password is incorrect."]);
  }
} else {
  echo json_encode(["success"=>false, "message"=>"Username not found."]);
}

$stmt->close();
?>
