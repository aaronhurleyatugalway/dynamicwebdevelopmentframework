<?php
session_start();
require_once "db_connect.php";

$alien_id = isset($_GET["alien_id"]) ? intval($_GET["alien_id"]) : 0;

header("Content-Type: application/json");

if ($alien_id <= 0) {
  echo json_encode(["status"=>"error", "oneHint"=>"", "html"=>"<p class='err'>Invalid pet id.</p>"]);
  exit;
}


$stmt = $conn->prepare("
  SELECT alien_id, name, species, planet, abilities, care_instructions, adopted_by, image_url
  FROM alien_pets
  WHERE alien_id = ?
  LIMIT 1
");
$stmt->bind_param("i", $alien_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
  echo json_encode(["status"=>"error", "oneHint"=>"", "html"=>"<p class='err'>Pet not found.</p>"]);
  exit;
}

$p = $res->fetch_assoc();
$stmt->close();

$name = htmlspecialchars($p["name"]);
$species = htmlspecialchars($p["species"]);
$planet = htmlspecialchars($p["planet"]);
$abilities = nl2br(htmlspecialchars($p["abilities"]));
$care = nl2br(htmlspecialchars($p["care_instructions"]));
$img = htmlspecialchars($p["image_url"]);
$adopted = $p["adopted_by"] !== NULL;

$html = "";
$html .= "<div class='grid'>";
$html .= "  <div class='col-4'><img src='".$img."' alt='pet' style='width:100%; border-radius:18px; border:1px solid var(--line);'></div>";
$html .= "  <div class='col-8'>";
$html .= "    <h2 style='margin:0 0 6px 0;'>".$name."</h2>";
$html .= "    <div class='row' style='margin-bottom:10px;'>";
$html .= "      <span class='badge'>".$species."</span>";
$html .= "      <span class='badge'>Planet: ".$planet."</span>";
$html .= ($adopted ? "<span class='badge'>Adopted</span>" : "<span class='badge'>Available</span>");
$html .= "    </div>";

if (!$adopted) {
  if (!isset($_SESSION["user_id"])) {
    $html .= "<button class='btn secondary' onclick=\"openModal('loginModalBack'); showLogin();\">Login to Adopt</button>";
  } else {
    $html .= "<button class='btn' onclick='adoptPet(".$alien_id.")'>Adopt this pet</button>";
  }
} else {
  $html .= "<p class='small'>This pet has already been adopted.</p>";
}

$html .= "    <div class='hr'></div>";
$html .= "    <h3 style='margin:0 0 6px 0;'>Abilities</h3>";
$html .= "    <p class='small'>".$abilities."</p>";
$html .= "    <h3 style='margin:10px 0 6px 0;'>Care Instructions</h3>";
$html .= "    <p class='small'>".$care."</p>";

$html .= "    <div class='hr'></div>";
$html .= "    <h3 style='margin:0 0 6px 0;'>Ratings</h3>";
$html .= "    <div id='ratingsBox'></div>";
$html .= "  </div>";
$html .= "</div>";

echo json_encode([
  "status" => "ok",
  "oneHint" => $p["planet"],   
  "html" => $html
]);
?>
