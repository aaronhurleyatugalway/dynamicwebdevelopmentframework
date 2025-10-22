function updateSockList() {
  const formData = new FormData(document.getElementById("sock_form"));

  fetch("child_pages/sockshow.php", {
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

function addtoCart(id) {
  const formData = new FormData();
  formData.append("id", id);

  fetch("child_pages/cartcount.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) {
        return response.text();
      }
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("cart_response").innerHTML = data;
      updateCart();
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function changeCartValue(id, value) {
  const formData = new FormData();
  formData.append("id", id);
  formData.append("value", value);

  fetch("new_cart_item.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) {
        return response.text();
      }
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("cart_response").innerHTML = data;
      updateCart();
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function printCart(session_cart){
  console.log(session_cart);
}

function updateCart() {
  fetch("child_pages/updateCart.php", {
    method: "POST",
  })
    .then((response) => {
      if (response.ok) {
        return response.text();
      }
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("basket_modal").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

updateCart();

let showModalImages = () => {
  let modal = document.getElementById("image_modal");
  modal.style.display = "block";
  document.getElementById("backdrop").style.display = "block";

  let modal_header = `
        <span class="close cursor" onclick="closeImageModal()">&times;</span>
      <img src="images/avatars/chooseAvatar.jpg" alt="Sock Thieves" width="100px"><br>
      CHOOSE AVATAR
     
    <br>
  `;

  let modal_content = `
      <div class="image-grid div-border" id="imageGrid"></div>
      <br>
      <div class="modal-footer">
  <span class="bottom-close cursor" onclick="closeImageModal()">&times;</span>
</div>
  `;

  modal.innerHTML = modal_header + modal_content;

  const imageGrid = document.getElementById("imageGrid");

  // Fetch image data from the PHP script
  fetch("get_images.php")
    .then((response) => response.json())
    .then((data) => {
      data.forEach((image) => {
        const imageDiv = document.createElement("div");
        const img = document.createElement("img");
        img.src = "images/avatars/" + image.image_path;

        img.onclick = function () {
          fetch("set_avatar_cookie.php?avatar=" + image.image_path)
            .then((response) => response.text())
            .then((data) => {
              document.getElementById("avatarimage").innerHTML = data;
            })
            .catch((error) => console.error("Error:", error));
        };

        imageDiv.appendChild(img);
        imageGrid.appendChild(imageDiv);
      });
    })
    .catch((error) => console.error("Error fetching image data:", error));
};

/* Close the login/create user content */
let closeImageModal = () => {
  document.getElementById("image_modal").style.display = "none";
  document.getElementById("backdrop").style.display = "none";
};

let showColourSettings = () => {
  document.getElementById("colour_settings_modal").style.display = "block";
  document.getElementById("backdrop").style.display = "block";
};

let closeColourSettings = () => {
  document.getElementById("colour_settings_modal").style.display = "none";
  document.getElementById("backdrop").style.display = "none";
};
