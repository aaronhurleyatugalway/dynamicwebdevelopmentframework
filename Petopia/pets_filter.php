<?php
session_start();
require_once "db_connect.php";


$planet = isset($_POST["planet"]) ? trim($_POST["planet"]) : "";
$category_id = isset($_POST["category_id"]) ? trim($_POST["category_id"]) : "";
$name_like = isset($_POST["name_like"]) ? trim($_POST["name_like"]) : "";


$sql = "
SELECT p.alien_id, p.name, p.species, p.planet, p.image_url, p.adopted_by
FROM alien_pets p
";

$params = [];
$types = "";

if ($category_id !== "") {
  $sql .= " INNER JOIN alien_category_link l ON l.alien_id = p.alien_id ";
}

$sql .= " WHERE 1=1 ";

if ($planet !== "") {
  $sql .= " AND p.planet = ? ";
  $types .= "s";
  $params[] = $planet;
}
if ($category_id !== "") {
  $sql .= " AND l.category_id = ? ";
  $types .= "i";
  $params[] = intval($category_id);
}
if ($name_like !== "") {
  $sql .= " AND LOWER(p.name) LIKE ? ";
  $types .= "s";
  $params[] = "%" . strtolower($name_like) . "%";
}

$sql .= " ORDER BY p.alien_id DESC ";

$stmt = $conn->prepare($sql);

if ($types !== "") {
  $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();

echo "<div class='petGrid'>";
while($row = $res->fetch_assoc()){
  $id = intval($row["alien_id"]);
  $name = htmlspecialchars($row["name"]);
  $species = htmlspecialchars($row["species"]);
  $planetOut = htmlspecialchars($row["planet"]);
  $img = htmlspecialchars($row["image_url"]);
  $adopted = $row["adopted_by"] !== NULL;

  echo "<div>";
  echo "  <div class='card' onclick='openPetDetails(".$id.")' style='cursor:pointer;'>";
  echo "    <img src='".$img."' alt='pet'>";
  echo "    <div class='body'>";
  echo "      <h3>".$name."</h3>";
  echo "      <p>".$species." • ".$planetOut."</p>";
  echo "      <div class='actions' onclick='event.stopPropagation();'>";

  if ($adopted) {
    echo "        <span class='badge'>Adopted</span>";
  } else {
    if (!isset($_SESSION["user_id"])) {
      echo "      <button class='btn secondary' onclick=\"openModal('loginModalBack'); showLogin();\">Login to Adopt</button>";
    } else {
      echo "      <button class='btn' onclick='adoptPet(".$id.")'>Adopt</button>";
    }
  }

  echo "        <button class='btn secondary' onclick='openPetDetails(".$id.")'>Details</button>";
  echo "      </div>";
  echo "    </div>";
  echo "  </div>";
  echo "</div>";
}
echo "</div>";

$stmt->close();
?>
