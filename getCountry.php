<?php
// get the q parameter from URL
$country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '';

$conn = new mysqli("aaronproject", "root", "", "myDB");

$sql2 = "SELECT country_name, continent, capital_name, population, flag_reference FROM Countries 
WHERE country_name='$country'";

$result2 = $conn->query($sql2);

if ($result2->num_rows >  0) {
    // output data of each row
    while($row = $result2->fetch_assoc()) {
      echo "<img src='flags\\" . $row["flag_reference"] . "' width='40px'><br>Country: " . $row["country_name"]. 
      "<br>Continent: " . $row["continent"]. "<br>Capital: " . $row["capital_name"]. "<br>Population: " 
      . $row["population"]."<br>";
    }
  }

$conn->close();
?>