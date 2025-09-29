function updateSockList() {
  const formData = new FormData(document.getElementById("sock_form"));

  fetch("sockshow2.php", {
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
      document.getElementById("sock_response").innerHTML = data; // Display the response
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
