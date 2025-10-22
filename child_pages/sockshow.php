<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Loaded Content</title>
</head>

<body>

    <?php

    $status = "available";
    $sock_colour = isset($_POST['sock_colours']) ? htmlspecialchars($_POST['sock_colours']) : '';
    $sock_pattern = isset($_POST['sock_patterns']) ? htmlspecialchars($_POST['sock_patterns']) : '';

    $sizes_out = json_encode(isset($_POST['sizes']) ? $_POST['sizes'] : []);

    $sizes = str_replace(array('[', ']'), '', $sizes_out);

    include '../db_connect.php';

    $opening_part = "Select m.sock_id, s.status, s.sock_color, s.image_url, s.sock_pattern, s.size, 
m.merchandise_id, m.price, m.stock_quantity 
FROM Merchandise m 
JOIN Socks s ON m.sock_id = s.sock_id";

    $status_clause = "";
    $colour_clause = "";
    $pattern_clause = "";
    $size_clause = "";
    $extra = " WHERE";

    if ($status) {
        $status_clause = "$extra s.status='$status'";
        $extra = " AND";
    }

    if ($sock_colour) {
        $colour_clause = "$extra s.sock_color='$sock_colour'";
        $extra = " AND";
    }

    if ($sock_pattern) {
        $pattern_clause = "$extra LOWER(s.sock_pattern) LIKE '%$sock_pattern%'";
        $extra = " AND";
    }

    if ($sizes) {
        $size_clause = "$extra s.size in ($sizes)";
    }

    $sql_statement = "$opening_part $status_clause$colour_clause$pattern_clause$size_clause";
    $result = $conn->query($sql_statement);
    $conn->close();


    $num_results = mysqli_num_rows($result);

    if ($num_results > 1) {
        echo "<b><h3>There are " . mysqli_num_rows($result) . " Results</h3></b><br>";
    } else {
        echo "<br>";
    }

    echo "<div class='sock-container div-border'>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<div style='border: 1px solid #ccc; border-radius: 8px; padding: 16px; width: 150px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color: white'>";
        echo "<img src='images/" . $row['image_url'] . "' alt='" . $row['sock_color'] . " sock' style='width: 75%; height: auto; border-radius: 8px;'>";
        echo "<h3 style='color: #333;'>" . $row['sock_color'] . " - " . $row['sock_pattern'] . "</h3>";
        echo "<p style='margin: 8px 0; color: black;'>Size: " . $row['size'] . "</p>";
        echo "<p style='margin: 8px 0; font-weight: bold; color: black;'>Price: €" . $row['price'] . "</p>";
        echo "<button onclick='addtoCart(" . $row['sock_id'] . ")' style='padding: 10px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;'>
    Add to Cart</button>";
        echo "</div>";
    }

    echo "</div>";


    ?>

</body>

</html>