function setFormValue(fieldset, key){
    const inputId = fieldset + "_" + key;
    const inputValue = document.getElementById(inputId).value;
  
    const fd = new FormData();
    fd.append("fieldset", fieldset);
    fd.append("key", key);
    fd.append("value", inputValue);
  
    fetch("setFormSessionValue.php", { method:"POST", body: fd })
      .then(r => r.text())
      .then(() => {
        
      })
      .catch(err => console.log(err));
  }
  
  function placeOrder(){
    const fd = new FormData(document.getElementById("checkoutForm"));
  
    fetch("place_order.php", { method:"POST", body: fd })
      .then(r => r.json())
      .then(data => {
        document.getElementById("orderMsg").innerHTML =
          data.success ? "<span class='ok'>"+data.message+"</span>" : "<span class='err'>"+data.message+"</span>";
  
        if(data.success){
          setTimeout(() => { window.location = "merch.php"; }, 900);
        }
      })
      .catch(err => console.log(err));
  
    return false;
  }
