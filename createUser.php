<?php

include 'db_connect.php';

$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$emailExists = 0; // check for if email exists already;
$usernameExists = 0; // check for if username exists already;

// Check if username exists
$sql = "SELECT username FROM Users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);  // "s" indicates the parameter is a string
$stmt->execute();
$result_username = $stmt->get_result();

if ($result_username->num_rows > 0) {
    $usernameExists = 1;
}

// Check if email exists
$sql = "SELECT email FROM Users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);  // "s" indicates the parameter is a string
$stmt->execute();
$result_email = $stmt->get_result();

if ($result_email->num_rows > 0) {
    $emailExists = 1;
}


if ($usernameExists != 1 && $emailExists != 1) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully!<br>";
        echo "Username : {$username}<br>";
        echo "Email : {$email}<br>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
} else {
    if ($usernameExists == 1) {
        echo "The username already exists<br>";
    }
    if ($emailExists == 1) {
        echo "The email address has already been used<br>";
    }
}
$conn->close();

?>