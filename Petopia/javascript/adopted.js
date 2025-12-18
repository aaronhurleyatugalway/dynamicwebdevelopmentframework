function openAdopted(){
  const box = document.getElementById("adopted_modal");
  box.style.display = "block";

  fetch("adopted_list.php")
    .then(r => r.text())
    .then(html => {
      document.getElementById("adoptedBody").innerHTML = html;
    })
    .catch(err => {
      document.getElementById("adoptedBody").innerHTML = "<p class='err'>Could not load adopted aliens.</p>";
      console.log(err);
    });
}

function closeAdopted(){
  document.getElementById("adopted_modal").style.display = "none";
}
