function loginUser() {
    const formData = new FormData(document.getElementById("login"));
    console.log(formData.get("username"));
  
    fetch("login.php", {
      // Change to your PHP script
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (response.ok) {
          return response.json();
        }
        throw new Error("Network response was not ok.");
      })
      .then((data) => {
        if (data.success) {
          document.getElementById("login_response").innerHTML = data.message;
          document.getElementById("user_name").innerHTML = formData.get("username");
          closeModal();
        } else {
          document.getElementById("login_response").innerHTML = data.message;
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  
      return false;
  }

  function createUser() {

    const formData = new FormData(document.getElementById("sock_userForm"));
  
    fetch("createUser.php", {
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
        document.getElementById("login_response2").innerHTML = data;
      })
      .catch((error) => {
        console.error("Error:", error);
      });

      return false;
  }


/*Show the login*/
let showLoginModal = () => {
    let modal = document.getElementById("login_modal");
    modal.style.display = "block";
    document.getElementById("backdrop").style.display = "block";

    modal_header = `
    <img src="images/catsock3.jpg" alt="Sock Thieves" width="70px">
    <span class="close cursor" onclick="closeModal()">&times;</span>
    <br>
    <div class="modal-content div-border">`;
  
    modal_content = `
            <form id="login" onsubmit="return loginUser()">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <div class="div-border" id="buttons">
                    <input type="submit" value="Login"><br>
                </div>
            </form>

            <div class="div-border" id="login_response"><br></div>

            <button class="button3" onclick="showCreateUserModal()">Create User</button>
            </div>
`;

    modal.innerHTML = modal_header + modal_content;
}

/*Show the create user*/
let showCreateUserModal = () => {
    let modal = document.getElementById("login_modal");
    modal.style.display = "block";
    document.getElementById("backdrop").style.display = "block";

    modal_header = 
    `<img src="images/catsock.jpg" alt="Sock Thieves" width="70px">
    <span class="close cursor" onclick="closeModal()">&times;</span>
    <br>
    <div class="modal-content div-border">`;
  
    modal_content = `
             <form id="sock_userForm" onsubmit="return createUser()">
                    <label for="create_username">Username:</label>
                    <input type="text" id="create_username" name="username" required><br>

                    <label for="create_email">Email:</label>
                    <input type="text" id="create_email" name="email" required><br>

                    <label for="create_password">Password:</label>
                    <input type="password" id="create_password" name="password" required><br>

                    <div class="div-border" id="buttons">
                        <label>&nbsp;</label>
                        <input type="submit" value="Create User"><br>
                    </div>

                </form>
        <div class="div-border" id="login_response2"><br></div>

            <button class="button3" onclick="showLoginModal()">Login</button>

`;

    modal.innerHTML = modal_header + modal_content;
}

/* Close the login/create user content */
let closeModal = () => {
    document.getElementById("login_modal").style.display = "none";
    document.getElementById("backdrop").style.display = "none";
}

let showShoppingBasket = () => {
    let modal = document.getElementById("basket_modal");
    modal.style.display = "block";
}

let closeBasketModal = () => {
    document.getElementById("basket_modal").style.display = "none";
}