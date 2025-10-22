<?php

include 'db_connect.php';

// SQL query to get image data
$sql = "SELECT id, image_path FROM avatars";
$result = $conn->query($sql);

// Create an array to store the image data
$images = array();

if ($result->num_rows > 0) {
    // Fetch rows from the database
    while($row = $result->fetch_assoc()) {
        $images[] = $row; // Add each row as an element in the array
    }
}

// Return the image data as a JSON response
header('Content-Type: application/json');
echo json_encode($images);

// Close the database connection
$conn->close();
?>
