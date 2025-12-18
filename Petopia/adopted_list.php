<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION["user_id"])) {
  echo "<p class='small'>Please login to see your adopted aliens.</p>";
  exit;
}

$user_id = intval($_SESSION["user_id"]);

$stmt = $conn->prepare("SELECT alien_id, name, species, planet, image_url, adoption_date FROM alien_pets WHERE adopted_by=? ORDER BY adoption_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
  echo "<p class='small'>You have not adopted any aliens yet.</p>";
  $stmt->close();
  exit;
}

echo "<div class='petGrid'>";

while($p = $res->fetch_assoc()){
  $id = intval($p["alien_id"]);
  $name = htmlspecialchars($p["name"]);
  $species = htmlspecialchars($p["species"]);
  $planet = htmlspecialchars($p["planet"]);
  $img = htmlspecialchars($p["image_url"]);
  $date = htmlspecialchars($p["adoption_date"]);

  echo "<div class='card' style='cursor:pointer;' onclick='openPetDetails(".$id.")'>";
  echo "  <img src='".$img."' alt='adopted'>";
  echo "  <div class='body'>";
  echo "    <h3>".$name."</h3>";
  echo "    <p>".$species." • ".$planet."</p>";
  echo "    <div class='actions'>";
  echo "      <span class='badge'>Adopted</span>";
  echo "      <span class='badge'>".$date."</span>";
  echo "    </div>";
  echo "  </div>";
  echo "</div>";
}

echo "</div>";

$stmt->close();
?>
