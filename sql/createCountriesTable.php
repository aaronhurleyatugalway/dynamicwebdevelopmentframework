<!DOCTYPE html>
<html>

<head>
    <title>Creating Database Table</title>
</head>

<body>

<?php
// include the connection file
include 'db_connect2.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE countries (
    id INT PRIMARY KEY AUTO_INCREMENT,
    country_name VARCHAR(100),
    continent VARCHAR(35),
    capital_name VARCHAR(100),
    flag_reference VARCHAR(20),
    population INT
);";

if ($conn->query($sql) === TRUE) {
  echo "Table Countries created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

</body>
</html>