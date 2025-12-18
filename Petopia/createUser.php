<?php
session_start();
require_once "db_connect.php";
require_once "validation.php";

$username = isset($_POST["username"]) ? clean_input($_POST["username"]) : "";
$email = isset($_POST["email"]) ? clean_input($_POST["email"]) : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

$errU = required_text($username, 3, "Username");
$errE = valid_email($email);
$errP = required_text($password, 6, "Password");

$errors = [];
if ($errU !== "") $errors[] = $errU;
if ($errE !== "") $errors[] = $errE;
if ($errP !== "") $errors[] = $errP;

if (count($errors) > 0) {
  echo "<span class='err'>" . implode("<br>", $errors) . "</span>";
  exit;
}

$check = 0;

$stmt = $conn->prepare("SELECT user_id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 1) $check = 1;
$stmt->close();


$stmt = $conn->prepare("SELECT user_id FROM users WHERE email=? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 1) $check = 1;
$stmt->close();

if ($check === 1) {
  echo "<span class='err'>Username or email already exists.</span>";
  exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?,?,?)");
$stmt->bind_param("sss", $username, $email, $hash);

if ($stmt->execute()) {
  echo "<span class='ok'>User created successfully. You can now login.</span>";
} else {
  echo "<span class='err'>Database error creating user.</span>";
}
$stmt->close();
?>
