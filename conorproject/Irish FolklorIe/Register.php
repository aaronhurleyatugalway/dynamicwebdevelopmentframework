<?php
include 'db_connect.php';
session_start();

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    echo "All fields are required.";
    exit;
}

if ($password !== $confirm_password) {
    echo "Passwords do not match.";
    exit;
}

// Check if username or email already exists
$stmt = $conn->prepare("SELECT * FROM Users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Username or email already exists.";
    exit;
}

// Hash the password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed);

if ($stmt->execute()) {
    // Automatically log in the user
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $username;

    echo "success";
} else {
    echo "Error: " . $conn->error;
}
?>



