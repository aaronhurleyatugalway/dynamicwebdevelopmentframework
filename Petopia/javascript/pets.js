function setCookie(name, value, days){
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + d.toUTCString() + ";path=/";
  }
  function getCookie(name){
    const parts = document.cookie.split(";").map(p => p.trim());
    for(const p of parts){
      if(p.startsWith(name + "=")){
        return decodeURIComponent(p.substring((name+"=").length));
      }
    }
    return "";
  }
  
  function refreshPets(){
  const fd = new FormData();

  const f1 = document.getElementById("petFilterForm");
  const f2 = document.getElementById("petSearchForm");

  if(f1){
    const a = new FormData(f1);
    for(const pair of a.entries()){ fd.append(pair[0], pair[1]); }
  }
  if(f2){
    const b = new FormData(f2);
    for(const pair of b.entries()){ fd.append(pair[0], pair[1]); }
  }

    setCookie("last_planet", fd.get("planet") || "", 14);
  
    fetch("pets_filter.php", { method:"POST", body: fd })
      .then(r => r.text())
      .then(html => {
        document.getElementById("pets_response").innerHTML = html;
      })
      .catch(err => console.log(err));
}
  
  
  function openPetDetails(alienId){
    fetch("pet_details.php?alien_id=" + encodeURIComponent(alienId))
      .then(r => r.json())
      .then(data => {
        document.getElementById("petDetailsBody").innerHTML = data.html;
        openModal("petDetailsBack");
  
        
        loadRatings(alienId);
  
        
        if(data.oneHint){
          document.getElementById("petDetailsHint").innerHTML =
            "<span class='badge'>Featured: " + data.oneHint + "</span>";
        } else {
          document.getElementById("petDetailsHint").innerHTML = "";
        }
      })
      .catch(err => console.log(err));
}
  
  function adoptPet(alienId){
    const fd = new FormData();
    fd.append("alien_id", alienId);
  
    fetch("adopt.php", { method:"POST", body: fd })
      .then(r => r.json())
      .then(data => {
        if(!data.success){
          alert(data.message);
          return;
        }
        refreshPets();
        
        openPetDetails(alienId);
      })
      .catch(err => console.log(err));
}
  
  function loadRatings(alienId){
    fetch("get_ratings.php?alien_id=" + encodeURIComponent(alienId))
      .then(r => r.text())
      .then(html => {
        document.getElementById("ratingsBox").innerHTML = html;
      })
      .catch(err => console.log(err));
}
  
  function submitRating(){
    const fd = new FormData(document.getElementById("ratingForm"));
  
    fetch("ratings_submit.php", { method:"POST", body: fd })
      .then(r => r.json())
      .then(data => {
        document.getElementById("ratingMsg").innerHTML =
          data.success ? "<span class='ok'>"+data.message+"</span>" : "<span class='err'>"+data.message+"</span>";
        if(data.success){
          loadRatings(fd.get("alien_id"));
          document.getElementById("ratingForm").reset();
        }
      })
      .catch(err => console.log(err));
return false;
  }
  
  
  window.addEventListener("load", () => {
    const savedPlanet = getCookie("last_planet");
    if(savedPlanet && document.getElementById("planet")){
      document.getElementById("planet").value = savedPlanet;
    }
    refreshPets();
  });
  

  window.refreshPets = refreshPets;
