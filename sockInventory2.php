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
    <form id="sock_form" action="/submit">
<select name="status" id="status" onchange="updateSockList()">
            <option value="" disabled selected>Select a Status</option>
            <option value="">All</option>
            <option value="available">Available</option>
            <option value="stolen">Stolen</option>
</select>
    <select name="sock_colours" id="sock_colours" onchange="updateSockList()">
    <option value="" disabled selected>Select a Colour</option>
    <option value="">All</option>
    <?php while($row = $result1->fetch_assoc()) {
    echo "<option value=\"". $row["sock_color"] . "\">". $row["sock_color"] . "</option>";
  }
  ?>
</select>

<input type="text" id="sock_patterns" name="sock_patterns" 
placeholder="Enter Sock Pattern" onkeyup="updateSockList()">

<div class="inline-form">
<b>Select Size:</b>
<?php while($row = $result3->fetch_assoc()) {
    echo "<label>";
    echo "<input type=\"checkbox\" name=\"sizes[]\" value=\"" . $row["size"] . 
    "\" onclick=\"updateSockList()\">". $row["size"] ."</label><br>";
  }
  ?>
</div>
</form>

</div>

    <div id="sock_response"></div>
</body>
  <script src="js/sock2.js"></script>
</html>