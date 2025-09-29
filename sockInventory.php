<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sock Stealing Socks Socks</title>
  <link rel="icon" type="image/png" href="images/favicon.png">
  <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

  <?php

  include 'db_connect.php';

  //Find distinct sock colours from sock table
  $sql = "SELECT DISTINCT sock_color FROM Socks ORDER BY sock_color";
  $result1 = $conn->query($sql);

  //Find distinct sock_patterns from sock table
  $sql = "SELECT DISTINCT sock_pattern FROM Socks ORDER BY sock_pattern";
  $result2 = $conn->query($sql);

  //Find distinct sizes from size table
  $sql = "SELECT DISTINCT size FROM Socks ORDER BY size";
  $result3 = $conn->query($sql);

  $conn->close();
  ?>

  <center><img src="images/findyoursocks.jpg" width="350px">
    <h3> Show Items </h3>
  </center>
  <div>
    <select name="status" id="status" onchange="updateSockList()">
      <option value="" disabled selected>Select a Status</option>
      <option value="">All</option>
      <option value="Available">Available</option>
      <option value="Stolen">Stolen</option>
    </select>

    <select name="sock_colours" id="sock_colours" onchange="updateSockList()">
      <option value="" disabled selected>Select a Colour</option>
      <option value="">All</option>
      <?php while ($row = $result1->fetch_assoc()) {
        echo "<option value=\"" . $row["sock_color"] . "\">" . $row["sock_color"] . "</option>";
      }
      ?>
    </select>

    <select name="sock_patterns" id="sock_patterns" onchange="updateSockList()">
      <option value="" disabled selected>Select a Pattern</option>
      <option value="">All</option>
      <?php while ($row = $result2->fetch_assoc()) {
        echo "<option value=\"" . $row["sock_pattern"] . "\">" . $row["sock_pattern"] . "</option>";
      }
      ?>
    </select>

    <div id="sizes" class="inline-form">
      <b>Select Size:</b>
      <?php while ($row = $result3->fetch_assoc()) {
        echo "<label>";
        echo "<input type=\"checkbox\" name=\"sizes\" value=\"" . $row["size"] .
          "\" onclick=\"updateSockList()\">" . $row["size"] . "</label><br>";
      }
      ?>
    </div>

  </div>

  <div id="sock_response"></div>
</body>
  <script src="js/sock.js"></script>
</html>