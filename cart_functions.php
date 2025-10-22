<?php

// Function to add an item to the cart
function PHPaddToCart($itemId, $price, $colour, $size, $pattern, $merchandiseId, $image) {
    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the item already exists in the cart
    if (isset($_SESSION['cart'][$itemId])) {
        // Item exists — increment quantity
        $_SESSION['cart'][$itemId]['quantity'] += 1;
    } else {
        // Item does not exist — add as new entry
        $_SESSION['cart'][$itemId] = [
            'id' => $itemId,
            'price' => $price,
            'quantity' => 1,
            'sock_colour' => $colour,
            'sock_pattern' => $pattern,
            'size' => $size,
            'merchandise_id' => $merchandiseId,
            'image' => $image
        ];
    }
}


function countItemsAndPrice(): array {
    
    $no_of_items = 0;
    $total_price = 0.00;

    foreach ($_SESSION['cart'] as &$item) {
            // Update the quantity if the item already exists
            $no_of_items += $item['quantity'];
            $total_price += $item['quantity']*$item['price'];
    }
    
    return [
        'no_of_items' => $no_of_items,
        'total_price' => $total_price
    ];
}