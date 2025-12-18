<?php


function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
  return $data;
}

function required_text($value, $minLen, $fieldName) {
  $value = clean_input($value);

  if ($value === "") {
    return $fieldName . " is required.";
  }
  if (strlen($value) < $minLen) {
    return $fieldName . " must be at least " . $minLen . " characters.";
  }
  return "";
}

function valid_email($value) {
  $value = clean_input($value);

  if ($value === "") {
    return "Email is required.";
  }
  if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
    return "Email is not valid.";
  }
  return "";
}

function valid_rating($value) {
  $value = intval($value);
  if ($value < 1 || $value > 5) {
    return "Rating must be between 1 and 5.";
  }
  return "";
}
?>
