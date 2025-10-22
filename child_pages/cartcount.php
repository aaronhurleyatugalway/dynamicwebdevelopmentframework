<?php
session_start();
include '../cart_functions.php';

$id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';

include '../db_connect.php';

// Prepare the SQL statement
$sql_statement = "SELECT m.merchandise_id, s.image_url, m.price, s.sock_id, 
                  s.sock_color, s.sock_pattern, s.size
                  FROM Merchandise m
                  JOIN Socks s on s.sock_id = m.sock_id
                  WHERE s.sock_id = ?";

// Prepare and execute the statement
$stmt = $conn->prepare($sql_statement);
$stmt->bind_param("i", $id);  // 'i' indicates that $id is an integer
$stmt->execute();
$result = $stmt->get_result();

// Initialize cart info
$no_of_items = 0;
$total_price = 0;

if ($row = $result->fetch_assoc()) {  // Fetch the single row directly

    PHPaddToCart(
        $id,
        $row['price'],
        $row['sock_color'],
        $row['size'],
        $row['sock_pattern'],
        $row['merchandise_id'],
        $row['image_url']    
    );

    $return_info = countItemsAndPrice();
    $no_of_items = $return_info['no_of_items'];
    $total_price = $return_info['total_price'];

} else {
    echo "No results found.";
}

$stmt->close();
$conn->close();

  $total_price = number_format($total_price, 2);

// Display cart info
echo "<a href=\"#\" onclick='showShoppingBasket()'><img src=\"images/cart.jpg\" width=\"40\"></a>";
echo "<span style='display:inline-block; margin-left:10px;'>";
echo "<span style='background-color: #c71585; color: white; padding: 2px 6px; border-radius: 4px;'>";
echo $no_of_items;
echo "</span>";
echo "<br>";
echo "€" . $total_price;
echo "</span>";
?>

