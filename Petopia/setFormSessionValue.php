<?php
session_start();
require_once "validation.php";

$fieldset = isset($_POST["fieldset"]) ? clean_input($_POST["fieldset"]) : "";
$key = isset($_POST["key"]) ? clean_input($_POST["key"]) : "";
$value = isset($_POST["value"]) ? clean_input($_POST["value"]) : "";

if (!isset($_SESSION["formFields"])) {
  $_SESSION["formFields"] = [];
}
if (!isset($_SESSION["formFields"][$fieldset])) {
  $_SESSION["formFields"][$fieldset] = [];
}

$_SESSION["formFields"][$fieldset][$key] = $value;

echo "ok";
?>
