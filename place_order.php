<?php

$formatted_html = "";

session_start();

$user_id = $_SESSION["user_id"];
$total_price = 0;

include 'db_connect.php';


if (!empty($_SESSION['cart'])) {

    if ($user_id != 0) {

        // Insert the order into the orders table
        $stmt = $conn->prepare("INSERT INTO Orders (user_id, total_amount) VALUES (?,?)");
        $stmt->bind_param("id", $user_id, $total_price);
        // Execute the statement
        if ($stmt->execute()) {
            // Retrieve the last inserted order_id
            $order_id = $conn->insert_id;
        } else {
            $formatted_html .= "Error: " . $stmt->error;
        }
        $stmt->close();

        $formatted_html .= "<br><b style='color: #ffffff; margin: 20px 10px'>ORDER HAS BEEN MADE</b>
                            <table style=\"width: 90%\">
                            <tr>
                            <th class=\"custom-header-blue\">Sock Colour</th>
                            <th class=\"custom-header-blue\">Sock Pattern</th>
                            <th class=\"custom-header-blue\">Size</th>
                            <th class=\"custom-header-blue\">Quantity</th>
                            <th class=\"custom-header-blue\">Price</th>
                            <th class=\"custom-header-blue\">Subtotal</th>
                            </tr>";

        foreach ($_SESSION['cart'] as $cart_item) {

            // Insert the order into the orders table
            $stmt = $conn->prepare("INSERT INTO Order_Items (order_id, merchandise_id, quantity, subtotal) VALUES (?,?,?,?)");
            $sub_total = $cart_item["quantity"] * $cart_item["price"];
            $stmt->bind_param("iiid", $order_id, $cart_item["merchandise_id"], $cart_item["quantity"], $sub_total);
            // Execute the statement
            $stmt->execute();
            $stmt->close();

            $formatted_html .= "<tr><td>" . $cart_item['sock_colour'] . "</td>";
            $formatted_html .= "<td>" . $cart_item['sock_pattern'] . "</td>";
            $formatted_html .= "<td>" . $cart_item['size'] . "</td>";
            $formatted_html .= "<td>" . $cart_item["quantity"] . "</td>";
            $formatted_html .= "<td>" . $cart_item["price"] . "</td>";
            $formatted_html .= "<td>" . $sub_total . "</td>";
            $formatted_html .= "</tr>";
            $total_price += $cart_item["quantity"] * $cart_item["price"];
        }



        // Create the Total Price Row
        $formatted_html .= "<tr>";
        $formatted_html .= "<td> Total Price </td>";
        $formatted_html .= "<td></td><td></td><td></td><td></td>";
        $formatted_html .= "<td>" . $total_price . "</td>";
        $formatted_html .= "</tr>";
        $formatted_html .= "</table>";


        // Update total_amount in the Orders table
        $stmt = $conn->prepare("UPDATE Orders SET total_amount = ? WHERE order_id = ?");
        $stmt->bind_param("di", $total_price, $order_id);

        if ($stmt->execute()) {
            // Success
            $formatted_html .= "Your order has been made successfully.";
        } else {
            $formatted_html .= "Error updating total: " . $stmt->error;
        }

        $stmt->close();






        $conn->close();

        $_SESSION['cart'] = [];

        $formatted_html .= "</body></html>";

        $response = [
            "status" => "success",
            "html" => $formatted_html, // Preformatted HTML
        ];

        echo json_encode($response);

    } else {
        $response = [
            "status" => "no_login",
            "html" => $formatted_html, // Preformatted HTML
        ];

        echo json_encode($response);
    }
} else {
    $response = [
        "status" => "empty_cart",
        "html" => $formatted_html, // Preformatted HTML
    ];

    echo json_encode($response);
}



?>