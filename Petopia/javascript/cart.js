function openCart(){
    document.getElementById("basket_modal").style.display = "block";
    refreshCartHTML();
  }
  function closeCart(){
    document.getElementById("basket_modal").style.display = "none";
  }
  
  function addToCart(merchId){
    const fd = new FormData();
    fd.append("merch_id", merchId);
  
    fetch("cartcount.php", { method:"POST", body: fd })
      .then(r => r.text())
      .then(html => {
        document.getElementById("cart_response").innerHTML = html;
        refreshCartHTML();
      })
      .catch(err => console.log(err));
  }
  
  function refreshCartHTML(){
    fetch("updateCart.php?render_only=1")
      .then(r => r.text())
      .then(html => {
        document.getElementById("cartBody").innerHTML = html;
      })
      .catch(err => console.log(err));
  }
  
  function changeQty(merchId, delta){
    const fd = new FormData();
    fd.append("merch_id", merchId);
    fd.append("delta", delta);
  
    fetch("updateCart.php", { method:"POST", body: fd })
      .then(r => r.text())
      .then(html => {
        document.getElementById("cartBody").innerHTML = html;

        fetch("cartcount.php", { method:"POST", body: new FormData() })
          .then(rr => rr.text())
          .then(sum => document.getElementById("cart_response").innerHTML = sum);
      })
      .catch(err => console.log(err));
  }
  
  function removeItem(merchId){

    changeQty(merchId, -9999);
  }
