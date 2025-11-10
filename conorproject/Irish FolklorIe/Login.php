<?php
session_start();

// Database connection
$servername = "conorproject";
$username = "root";
$password = "";
$dbname = "irish_folklore_db";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// When the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = trim($_POST["username_or_email"]);
    $password_input = trim($_POST["password"]);

    // Check if the user exists by username OR email
    $sql = "SELECT * FROM Users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_input, $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user found
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password (assuming you hashed it with password_hash() during registration)
        if (password_verify($password_input, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            echo "<script>alert('Login successful!'); window.location.href='index.php';</script>";
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that username or email.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Irish Folklore</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fafafa; }
        .container { width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;
        }
        input[type=submit] {
            background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer;
        }
        input[type=submit]:hover { background-color: #45a049; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login to Irish Folklore</h2>
        <form method="POST" action="">
            <label>Username or Email:</label>
            <input type="text" name="username_or_email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>

        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
