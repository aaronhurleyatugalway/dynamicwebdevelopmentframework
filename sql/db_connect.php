<?php

$servername = "aaronproject";
$username = "root";
$password = "";
$dbname = "sock_theft_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>