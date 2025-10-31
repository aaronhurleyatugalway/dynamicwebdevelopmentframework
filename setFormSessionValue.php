<?php

session_start();

function test_input($data) {
    $data = trim($data);
    $data = str_replace(["\\", "/"], "", $data);
    $data = htmlspecialchars($data, ENT_NOQUOTES, 'UTF-8');
    return $data;
}

$inputKey = isset($_POST['inputKey']) ? htmlspecialchars($_POST['inputKey']) : '';
$inputValue = isset($_POST['inputValue']) ? test_input($_POST['inputValue']) : '';
$fieldset = isset($_POST['fieldset']) ? htmlspecialchars($_POST['fieldset']) : '';

$_SESSION['formFields'][$fieldset][$inputKey] = $inputValue;