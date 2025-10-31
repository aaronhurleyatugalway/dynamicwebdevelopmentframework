// When changing field values in the form,
// the $_SESSION variable updates also with this function
function updateFormSessionValue(input, fieldset) {
  $inputValue = document.getElementById(input).value;

  const formData = new FormData();
  formData.append("inputKey", input);
  formData.append("inputValue", $inputValue);
  formData.append("fieldset", fieldset);

  fetch("setFormSessionValue.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) {
        return response.text();
      }
      throw new Error("Network response was not ok.");
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function repeatAddress() {
  let checkbox = document.getElementById("same-as-billing");

  if (checkbox.checked) {
    document.getElementById("sname").value = document.getElementById("nname").value;
    document.getElementById("semail").value = document.getElementById("email").value;
    document.getElementById("scity").value = document.getElementById("city").value;
    document.getElementById("saddress").value = document.getElementById("address").value;
    document.getElementById("szip").value = document.getElementById("zip").value;
    document.getElementById("scountry").value = document.getElementById("country").value;
  } else {
    document.getElementById("sname").value = "";
    document.getElementById("semail").value = "";
    document.getElementById("scity").value = "";
    document.getElementById("saddress").value = "";
    document.getElementById("szip").value = "";
    document.getElementById("scountry").value = "";
  }

  updateFormSessionValue("sname", "shipping");
  updateFormSessionValue("semail", "shipping");
  updateFormSessionValue("scity", "shipping");
  updateFormSessionValue("saddress", "shipping");
  updateFormSessionValue("szip", "shipping");
  updateFormSessionValue("scountry", "shipping");
}

function clearCheckoutForms() {
  fetch("clearCheckoutForms.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (response.ok) {
        let form = document.getElementById("checkout-order-form");

        form.reset();

        // Manually clear input values
        form.querySelectorAll("input, select").forEach((field) => {
          field.value = "";
        });

        return response.text();
      }
      throw new Error("Network response was not ok.");
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function sendCheckoutForms() {
  const formData = new FormData(document.getElementById("checkout-order-form"));

  fetch("setCheckoutForms.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      return response.json(); // Parse the response as JSON
    })
    .then((data) => {
      if (data.success === "failure") {
        // Handle errors: display error messages next to corresponding fields
        displayErrors(data.errors);
        console.log("Errors:", data.errors);
      } else {
        // If no errors, proceed with the success actions
        submitCheckoutForm();
        console.log("Form submitted successfully!");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function displayErrors(errors) {
  // Clear previous error messages
  const errorElements = document.querySelectorAll(".error");
  errorElements.forEach((el) => (el.textContent = ""));

  // Loop through each error and display it
  for (const section in errors) {
    for (const field in errors[section]) {
      const errorElement = document.querySelector(`#${section}-${field}-error`);
      if (errorElement) {
        errorElement.textContent = errors[section][field];
      }
    }
  }
}

function submitCheckoutForm() {
  fetch("place_order.php", {
    method: "POST",
  })
    .then((response) => {
      if (response.ok) {
        return response.json();
      }
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      if (data.status === "success") {
        document.getElementById("cart_change").innerHTML = data.html;
        clearCheckoutForms();
        showCheckoutSuccess();
      } else if (data.status === "no_login") {
        showLoginModal();
      } else if (data.status === "empty_cart") {
        document.getElementById("cart_change").innerHTML = "Your Cart is Empty";
        showCheckoutSuccess();
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

let showCheckoutSuccess = () => {
  document.getElementById("checkout_success_modal").style.display = "block";
  document.getElementById("backdrop").style.display = "block";
};

/* Close the login/create user content */
let closeCheckoutSuccessModal = () => {
  document.getElementById("checkout_success_modal").style.display = "none";
  document.getElementById("backdrop").style.display = "none";

  // Redirect after 500 milliseconds
  setTimeout(() => {
    window.location.href = "index.php";
  }, 500);
};
