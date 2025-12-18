<?php
session_start();
header("Content-Type: application/json");

unset($_SESSION["user_id"]);
unset($_SESSION["username"]);

echo json_encode(["success"=>true, "message"=>"Logged out."]);
?>
