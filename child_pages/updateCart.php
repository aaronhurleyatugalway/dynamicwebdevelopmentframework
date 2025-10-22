<?php
session_start();

echo '<span class="close cursor" onclick="closeBasketModal()">&times;</span>';

if (!empty($_SESSION['cart'])) {

    echo '<table id="cart_table" class="cart-table">';
    echo '<thead>
            <tr>
                <th>Image</th>
                <th>Size</th>
                <th>Colour</th>
                <th>Pattern</th>
                <th>Quantity</th>
                <th>Price (Each)</th>
                <th>Total</th>
            </tr>
          </thead>';
    echo '<tbody>';

    $grandTotal = 0; // Initialize total

    foreach ($_SESSION['cart'] as $item) {
        $size = htmlspecialchars($item['size']);
        $colour = htmlspecialchars($item['sock_colour']);
        $pattern = htmlspecialchars($item['sock_pattern']);
        $quantity = htmlspecialchars($item['quantity']);
        $price = number_format((float) $item['price'], 2);
        $total = number_format((float) $item['price'] * $item['quantity'], 2);

        $grandTotal += (float) $item['price'] * $item['quantity']; // Add to grand total

        // Image path
        $image = !empty($item['image']) ? 'images/' . $item['image'] : 'images/catsock.jpg';

        echo "<tr>
                <td><img src='$image' alt='$pattern $colour' style='width:60px; height:auto;'></td>
                <td>$size</td>
                <td>$colour</td>
                <td>$pattern</td>";


     echo "<td>
        <button class='plusminus' onclick='changeCartValue(" . $item['id'] . ",-1)'>−</button>
        <span class='quantity-display'>" . $quantity . "</span>
        <button class='plusminus' onclick='changeCartValue(" . $item['id'] . ",1)'>+</button>
      </td>";


        echo "
                <td>€$price</td>
                <td>€$total</td>
              </tr>";
    }

    // Add grand total row
    $grandTotalFormatted = number_format($grandTotal, 2);
    echo "<tr>
            <td colspan='6' style='text-align:right; font-weight:bold;'>Total:</td>
            <td style='font-weight:bold;'>€$grandTotalFormatted</td>
          </tr>";

    echo '</tbody>';
    echo '</table>';

} else {
    echo '<p style="color: #fff; background-color: #333; padding: 10px;">Your cart is empty.</p>';
}
?>