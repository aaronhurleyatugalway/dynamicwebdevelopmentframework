function getCountries() {
  const formData = new FormData(document.getElementById("country_form"));

  fetch("gethint.php", {
    // Change to your PHP script
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) {
        return response.text(); // or response.json() based on your response type
      }
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("txtHint").innerHTML = data; // Display the response
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function showCountryInfo(str) {
  const formData = new FormData();
  formData.append("country", str);

  fetch("getCountry.php", {
    // Change to your PHP script
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) {
        return response.text(); // or response.json() based on your response type
      }
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("txtHintInfo").innerHTML = data; // Display the response
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
