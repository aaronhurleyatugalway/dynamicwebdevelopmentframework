function updateSockList() {
  const status = document.getElementById("status").value;
  const sock_colour = document.getElementById("sock_colours").value;
  const sock_pattern = document.getElementById("sock_patterns").value;

  // Collect checked checkbox values
  const sizes = Array.from(
    document.querySelectorAll('input[name="sizes"]:checked'),
    checkbox => checkbox.value
  );

  // Build the FormData
  const formData = new FormData();
  formData.append("status", status);
  formData.append("sock_colour", sock_colour);
  formData.append("sock_pattern", sock_pattern);
  formData.append("sizes", sizes.join(","));


  fetch("sockshow.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById("sock_response").innerHTML = data;
  })
  .catch(error => console.error("Error:", error));
}


