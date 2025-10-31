<?php
session_start();

// Initialize response array
$response = [
    "success" => "success",
    "errors" => [],
    "formFields" => []
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Billing Information - Check that fields are filled in
    $billingFields = ["nname", "email", "city", "address", "zip", "country"];
    foreach ($billingFields as $field) {
        if (empty($_POST[$field]) || test_input($_POST[$field]) == "") {
            $response["errors"]["billing"][$field] = "*required";
        } else {
            $response["formFields"]["billing"][$field] = test_input($_POST[$field]);
        }
    }

    // Payment Information - Check that fields are filled in
    $paymentFields = ["cname", "ccnum", "expmonth", "expyear", "cvv"];
    foreach ($paymentFields as $field) {
        if (empty($_POST[$field]) || test_input($_POST[$field]) == "") {
            $response["errors"]["payment"][$field] = "*required";
        } else {
            $response["formFields"]["payment"][$field] = test_input($_POST[$field]);
        }
    }

    // Shipping Information - Check that fields are filled in
    $shippingFields = ["sname", "semail", "scity", "saddress", "szip", "scountry"];
    foreach ($shippingFields as $field) {
        if (empty($_POST[$field]) || test_input($_POST[$field]) == "") {
            $response["errors"]["shipping"][$field] = "*required";
        } else {
            $response["formFields"]["shipping"][$field] = test_input($_POST[$field]);
        }
    }

    // Validate Names
    validate_name("nname", "billing");
    validate_name("sname", "shipping");
    validate_name("cname", "payment");

    // Validate Emails
    validate_email("email", "billing");
    validate_email("semail", "shipping");

    // Validate address for billing, shipping
    validate_address("address", "billing");
    validate_address("saddress", "shipping");
    validate_address("city", "billing");
    validate_address("scity", "shipping");

    // Validate zip codes for billing, shipping
    validate_postcode("zip", "billing");
    validate_postcode("szip", "shipping");

    // Call the credit card validation function
    validate_credit_card("ccnum", "payment");

    // Call the cvv validation function
    validate_cvv("cvv", "payment");

    // If there are errors, set success to "failure"
    if (!empty($response["errors"])) {
        $response["success"] = "failure";
    } else {
        // Store validated data in session
        $_SESSION['formFields'] = $response["formFields"];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Generic function to validate form fields using a regular expression
function validate_field($field, $formType, $regex, $errorMessage = "*invalid") {
    global $response;

    // Check if the field exists and is not empty
    if (isset($response["formFields"][$formType][$field]) && !empty($response["formFields"][$formType][$field])) {
        $value = $response["formFields"][$formType][$field];

        // Validate the value against the provided regex
        if (!preg_match($regex, $value)) {
            $response["errors"][$formType][$field] = $errorMessage;
        }
    }
}


// Function to validate names (letters, spaces, hyphens, apostrophes allowed)
function validate_name($field, $formType) {
    validate_field($field, $formType, "/^[a-zA-Z]+(?:[-' ]?[a-zA-Z]+)*$/", "*invalid");
}

// Function to validate emails
function validate_email($field, $formType) {
    validate_field($field, $formType, "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", "*invalid");
}

// Function to validate address (letters, numbers, spaces, commas, periods, hyphens, apostrophes, quotes allowed)
function validate_address($field, $formType) {
    validate_field($field, $formType, "/^[a-zA-Z0-9\s,.'\"-]*$/", "*Invalid");
}

// Function to validate postcode (letters, numbers, hyphens, and spaces allowed)
function validate_postcode($field, $formType) {
    validate_field($field, $formType, "/^[A-Za-z0-9-\s]+$/", "*Invalid");
}

// Function to validate CVV (3 or 4 digits only)
function validate_cvv($field, $formType) {
    validate_field($field, $formType, "/^\d{3,4}$/", "*Invalid");
}


function validate_credit_card($field, $formType)
{
    global $response;

    if (isset($response["formFields"][$formType][$field]) 
    && !empty($response["formFields"][$formType][$field])) {
        $cardNumber = $response["formFields"][$formType][$field];

        // Remove spaces for flexibility in input
        $cardNumber = str_replace(" ", "", $cardNumber);

        // Check if the card number contains only digits
        if (!ctype_digit($cardNumber)) {
            $response["errors"][$formType][$field] = "*bad format";
        }

        // Check that the card number length is between 13 and 19 digits (inclusive)
        elseif (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            $response["errors"][$formType][$field] = "*invalid";
        }

        elseif (!is_valid_luhn($cardNumber)) {
            $response["errors"][$formType][$field] = "*not a card";
        }


    }
}


// Function to sanitize input
function test_input($data)
{
    $data = trim($data);
    $data = str_replace(["\\", "/"], "", $data); // Remove all backslashes and forward slashes
    $data = htmlspecialchars($data, ENT_NOQUOTES, 'UTF-8');
    return $data;
}

function is_valid_luhn($number) {
    settype($number, 'string');
    $sumTable = array(
      array(0,1,2,3,4,5,6,7,8,9),
      array(0,2,4,6,8,1,3,5,7,9));
    $sum = 0;
    $flip = 0;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
      $sum += $sumTable[$flip++ & 0x1][$number[$i]];
    }
    return $sum % 10 === 0;
}





?>