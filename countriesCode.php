<html>
<head>
<style>
        .hover-pointer {
            cursor: pointer; /* Changes cursor to pointer */
            color: black;
        }
        .hover-pointer:hover {
            color: blue; /* Change color on hover */
        }
    </style>


</head>

<body>

<center><img src="images/flagsworld.png" width="500px"><p></p></center>
<p><b>Start typing a country in the input field below:</b></p>

<form id="country_form" action="/submit">
  <label for="fname">Country:</label>
  <input type="text" id="fname" name="fname" onkeyup="getCountries()">
</form>

<p><span id="txtHintInfo"><?php echo "<br>Country: " . " " . "<br>Continent: 
" . " ". "<br>Capital: " . " " . "<br>Population: " . " " ."<br>";?></span></p>
<p>Suggestions: <span id="txtHint"></span></p>


</body>
<script src="js/countries.js"></script>
</html>