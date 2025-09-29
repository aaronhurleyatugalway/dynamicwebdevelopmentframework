<?php
// get the q parameter from URL
$hint = isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '';

$conn = new mysqli("aaronproject", "root", "", "myDB");

$sql2 = "SELECT country_name, continent, capital_name, population, flag_reference 
FROM Countries WHERE LOWER(country_name) LIKE '%$hint%'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
    echo "<span class='hover-pointer' onclick=\"showCountryInfo('" 
    . $row["country_name"] . "')\";>" . $row["country_name"] . "</span> | ";
    }
}

$conn->close();
?>