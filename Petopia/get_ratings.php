<?php
session_start();
require_once "db_connect.php";

$alien_id = isset($_GET["alien_id"]) ? intval($_GET["alien_id"]) : 0;

if ($alien_id <= 0) {
  echo "<p class='err'>Invalid pet id.</p>";
  exit;
}


$stmt = $conn->prepare("
  SELECT r.rating, r.review_text, r.created_at, u.username
  FROM pet_ratings r
  INNER JOIN users u ON u.user_id = r.user_id
  WHERE r.alien_id = ?
  ORDER BY r.created_at DESC
");
$stmt->bind_param("i", $alien_id);
$stmt->execute();
$res = $stmt->get_result();

echo "<div class='panel'>";
echo "<p class='small'>Leave a rating (1–5). Reviews are stored in MySQL.</p>";

if (isset($_SESSION["user_id"])) {
  echo "<form id='ratingForm' onsubmit='return submitRating();'>";
  echo "<input type='hidden' name='alien_id' value='".$alien_id."'>";
  echo "<label>Rating</label>";
  echo "<select name='rating'>";
  for($i=1;$i<=5;$i++){ echo "<option value='".$i."'>".$i."</option>"; }
  echo "</select>";
  echo "<label>Review (optional)</label>";
  echo "<textarea name='review_text' rows='3'></textarea>";
  echo "<div class='row' style='margin-top:10px;'>";
  echo "<button class='btn' type='submit'>Submit</button>";
  echo "<div id='ratingMsg'></div>";
  echo "</div>";
  echo "</form>";
} else {
  echo "<p class='small'>Login to submit a rating.</p>";
}

echo "<div class='hr'></div>";
echo "<b>Recent Reviews</b><br><br>";

if ($res->num_rows === 0) {
  echo "<p class='small'>No reviews yet.</p>";
} else {
  while($r = $res->fetch_assoc()){
    $u = htmlspecialchars($r["username"]);
    $rating = intval($r["rating"]);
    $txt = htmlspecialchars($r["review_text"] ?? "");
    $date = htmlspecialchars($r["created_at"]);

    echo "<div class='cartItem'>";
    echo "<div class='row space'>";
    echo "<div><b>".$u."</b> <span class='badge'>".$rating."/5</span></div>";
    echo "<div class='small'>".$date."</div>";
    echo "</div>";
    if ($txt !== "") {
      echo "<div class='small' style='margin-top:8px;'>".$txt."</div>";
    }
    echo "</div>";
  }
}

echo "</div>";

$stmt->close();
?>
