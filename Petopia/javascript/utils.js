function openModal(id){
    document.getElementById(id).style.display = "block";
  }
  function closeModal(id){
    document.getElementById(id).style.display = "none";
  }
  
  function showLogin(){
    document.getElementById("loginView").style.display = "block";
    document.getElementById("createView").style.display = "none";
    document.getElementById("login_response").innerHTML = "";
  }
  function showCreate(){
    document.getElementById("loginView").style.display = "none";
    document.getElementById("createView").style.display = "block";
    document.getElementById("login_response2").innerHTML = "";
  }
  
  function loginUser(){
    const fd = new FormData(document.getElementById("loginForm"));
  
    fetch("login.php", { method:"POST", body: fd })
      .then(r => r.json())
      .then(data => {
        document.getElementById("login_response").innerHTML =
          data.success ? "<span class='ok'>"+data.message+"</span>" : "<span class='err'>"+data.message+"</span>";
  
        if(data.success){
          document.getElementById("navUser").innerText = data.username;
          closeModal("loginModalBack");
          
          if (window.refreshPets) refreshPets();
        }
      })
      .catch(err => {
        document.getElementById("login_response").innerHTML = "<span class='err'>Login fetch error.</span>";
        console.log(err);
      });
  
    return false; 
  }
  
  function createUser(){
    const fd = new FormData(document.getElementById("createForm"));
  
    fetch("createUser.php", { method:"POST", body: fd })
      .then(r => r.text())
      .then(msg => {
        document.getElementById("login_response2").innerHTML = msg;
      })
      .catch(err => {
        document.getElementById("login_response2").innerHTML = "<span class='err'>Create user fetch error.</span>";
        console.log(err);
      });
  
    return false;
  }
  
  function logoutUser(){
    fetch("logout.php")
      .then(r => r.json())
      .then(data => {
        document.getElementById("navUser").innerText = "Guest";
        if (window.refreshPets) refreshPets();
      })
      .catch(err => console.log(err));
  }
