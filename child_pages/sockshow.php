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
    $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];

    include '../db_connect.php';

    // ----- Build SQL -----
    $sql = "SELECT 
                m.sock_id, s.status, s.sock_color, s.image_url, 
                s.sock_pattern, s.size, 
                m.merchandise_id, m.price, m.stock_quantity
            FROM Merchandise m
            JOIN Socks s ON m.sock_id = s.sock_id";

    $where_conditions = [];
    $params = [];
    $types = "";

    // Status
    $where_conditions[] = "s.status = ?";
    $params[] = $status;
    $types .= "s";

    // Colour
    if (!empty($sock_colour)) {
        $where_conditions[] = "s.sock_color = ?";
        $params[] = $sock_colour;
        $types .= "s";
    }

    // Pattern
    if (!empty($sock_pattern)) {
        $where_conditions[] = "LOWER(s.sock_pattern) LIKE ?";
        $params[] = "%" . strtolower($sock_pattern) . "%";
        $types .= "s";
    }

    // Sizes
    if (!empty($sizes)) {
        $placeholders = implode(",", array_fill(0, count($sizes), "?"));
        $where_conditions[] = "s.size IN ($placeholders)";
        foreach ($sizes as $sz) {
            $params[] = $sz;
            $types .= "s";
        }
    }

    if (!empty($where_conditions)) {
        $sql .= " WHERE " . implode(" AND ", $where_conditions);
    }

    // ----- Prepare, bind, execute -----
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $num_results = $result->num_rows;

    if ($num_results > 1) {
        echo "<b><h3>There are $num_results Results</h3></b><br>";
    } else {
        echo "<br>";
    }

    echo "<div class='sock-container div-border'>";

    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; border-radius: 8px; padding: 16px; width: 150px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color: white'>";
        echo "<img src='images/" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['sock_color']) . " sock' style='width: 75%; height: auto; border-radius: 8px;'>";
        echo "<h3 style='color: #333;'>" . htmlspecialchars($row['sock_color']) . " - " . htmlspecialchars($row['sock_pattern']) . "</h3>";
        echo "<p style='margin: 8px 0; color: black;'>Size: " . htmlspecialchars($row['size']) . "</p>";
        echo "<p style='margin: 8px 0; font-weight: bold; color: black;'>Price: €" . htmlspecialchars($row['price']) . "</p>";
        echo "<button onclick='addtoCart(" . htmlspecialchars($row['sock_id']) . ")' style='padding: 10px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;'>Add to Cart</button>";
        echo "</div>";
    }

    echo "</div>";

    $stmt->close();
    $conn->close();

    ?>

</body>

</html>
