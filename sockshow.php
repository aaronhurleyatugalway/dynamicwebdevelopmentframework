<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Loaded Content</title>
</head>
<body>
    
<?php

    $status = $_POST['status'];
    $sock_colour = $_POST['sock_colour'];
    $sock_pattern = $_POST['sock_pattern'];
    $sizes = $_POST['sizes'];

    include 'db_connect.php';

    $status_clause = "";
    $colour_clause = "";
    $pattern_clause = "";
    $size_clause = "";
    $extra = " WHERE";

    if ($status){
        $status_clause = "$extra status='$status'";
        $extra = " AND";
    }

    if ($sock_colour){
        $colour_clause = "$extra sock_color='$sock_colour'";
        $extra = " AND";
    }

    if ($sock_pattern){
        $pattern_clause = "$extra sock_pattern='$sock_pattern'";
        $extra = " AND";
    }

    if($sizes){
        $size_list_as_string = "'" . str_replace(",", "','", $sizes) . "'";
        $size_clause = "$extra size in ($size_list_as_string)";
    }

    $sql_statement = "SELECT * FROM Socks$status_clause$colour_clause$pattern_clause$size_clause";
    $result = $conn->query($sql_statement);
    $conn->close();
    

$num_results = mysqli_num_rows($result);

if ($num_results > 1){
echo "There are " . mysqli_num_rows($result) . " Results<br>";
}
else {
    echo "<br>";
}

echo $sql_statement;
echo "<br>";

echo "<div class='sock-container'>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='sock-item'>";
    echo "<img src='images/" . htmlspecialchars($row['image_url']) . 
    "' width='133' alt='Sock Image' class='sock-image'>";
    echo "<p><strong>Status:</strong> " . htmlspecialchars($row['status']) . "</p>";
    echo "<p><strong>Colour:</strong> " . htmlspecialchars($row['sock_color']) . "</p>";
    echo "<p><strong>Pattern:</strong> " . htmlspecialchars($row['sock_pattern']) . "</p>";
    echo "<p><strong>Size:</strong> " . htmlspecialchars($row['size']) . "</p>";
    echo "</div>";
}

echo "</div>";


?>

</body>
</html>


