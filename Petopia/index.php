<?php
session_start();
require_once "db_connect.php";
require_once "cart_functions.php";
ensure_cart();


$tot = cart_totals();

$planets = [];
$stmt = $conn->prepare("SELECT DISTINCT planet FROM alien_pets ORDER BY planet");
$stmt->execute();
$res = $stmt->get_result();
while($row = $res->fetch_assoc()){
  $planets[] = $row["planet"];
}
$stmt->close();

$categories = [];
$stmt2 = $conn->prepare("SELECT category_id, name FROM alien_categories ORDER BY name");
$stmt2->execute();
$res2 = $stmt2->get_result();
while($row = $res2->fetch_assoc()){
  $categories[] = $row;
}
$stmt2->close();


$navUser = isset($_SESSION["username"]) ? $_SESSION["username"] : "Guest";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Petopia</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="icon" type="image/png" href="images/favicon.png"> 
</head>
<body>

<div class="header">
  <div class="container row space">
    <div class="row">
      <img src="images/logo.png" alt="Petopia" style="height:40px;">
      <a class="navlink" href="index.php">Adopt</a>
      <a class="navlink" href="merch.php">Merch</a>
      <a class="navlink" href="checkout.php">Checkout</a>
    </div>

    <div class="row">
      <div id="cart_response" class="badge">
        <?php echo $tot["count"]; ?> item(s) • €<?php echo number_format($tot["total"],2); ?>
      </div>
      <button class="btn secondary" onclick="openCart()">Basket</button>
      <button class="btn secondary" onclick="openAdopted()">My Adoptions</button>

      <div class="badge">User: <span id="navUser"><?php echo htmlspecialchars($navUser); ?></span></div>
      <?php if(!isset($_SESSION["user_id"])) { ?>
        <button class="btn" onclick="openModal('loginModalBack'); showLogin();">Login</button>
      <?php } else { ?>
        <button class="btn secondary" onclick="logoutUser()">Logout</button>
      <?php } ?>
    </div>
  </div>
</div>

<div class="container">
  <div class="hero">
    <img src="images/hero.png" alt="Hero">
    <div class="heroText">
      <div class="row space">
        <div>
          <h1 class="brandTitle">Petopia</h1>
          <p class="brandSubtitle">Alien Pet Adoption Agency</p>
          <div style="height:10px;"></div>
          <h2 style="margin:10px 0 6px 0;">Find your next cosmic companion</h2>
          <p class="small">Filter by planet / category, open details, adopt, and leave ratings.</p>
        </div>
        
      </div>
    </div>
  </div>

  <div class="grid" style="margin-top:14px;">
    <div class="col-4">
      <div class="panel">
        <h3 style="margin:0 0 8px 0;">Filters</h3>

        <form id="petFilterForm" onsubmit="return false;">
          <label>Planet</label>
          <select id="planet" name="planet" onchange="refreshPets()">
            <option value="">Any</option>
            <?php foreach($planets as $p){ ?>
              <option value="<?php echo htmlspecialchars($p); ?>"><?php echo htmlspecialchars($p); ?></option>
            <?php } ?>
          </select>

          <label>Category</label>
          <select name="category_id" onchange="refreshPets()">
            <option value="">Any</option>
            <?php foreach($categories as $c){ ?>
              <option value="<?php echo intval($c["category_id"]); ?>"><?php echo htmlspecialchars($c["name"]); ?></option>
            <?php } ?>
          </select>
        </form>

        <div class="hr"></div>

        <form id="petSearchForm" onsubmit="return false;">
          <label>Search by name</label>
          <input type="text" name="name_like" placeholder="e.g. Zorp" onkeyup="refreshPets()">
          <p class="small" style="margin-top:10px;">Search is separate from planet/category filters.</p>
        </form>

        <div class="hr"></div>
        <p class="small"
        </p>
      </div>
    </div>

    <div class="col-8">
      <div class="panel">
        <div class="row space">
          <h3 style="margin:0;">Available Pets</h3>
          <span class="badge">Click a card for details</span>
        </div>
        <div class="hr"></div>

        <div id="pets_response" class="petGrid"><div class="badge">Loading pets...</div></div>
      </div>
    </div>
  </div>
</div>


<div class="modalBack" id="loginModalBack">
  <div class="modal">
    <div class="modalHeader">
      <b>Account</b>
      <span class="closeX" onclick="closeModal('loginModalBack')">X</span>
    </div>

    <div id="loginView">
      <form id="loginForm" onsubmit="return loginUser();">
        <label>Username</label>
        <input name="username" type="text">
        <label>Password</label>
        <input name="password" type="password">
        <div style="margin-top:10px;" class="row">
          <button class="btn" type="submit">Login</button>
          <button class="btn secondary" type="button" onclick="showCreate()">Create User</button>
        </div>
        <div id="login_response" style="margin-top:10px;"></div>
      </form>
    </div>

    <div id="createView" style="display:none;">
      <form id="createForm" onsubmit="return createUser();">
        <label>Username</label>
        <input name="username" type="text">
        <label>Email</label>
        <input name="email" type="text">
        <label>Password</label>
        <input name="password" type="password">
        <div style="margin-top:10px;" class="row">
          <button class="btn" type="submit">Create</button>
          <button class="btn secondary" type="button" onclick="showLogin()">Back to Login</button>
        </div>
        <div id="login_response2" style="margin-top:10px;"></div>
      </form>
    </div>
  </div>
</div>


<div class="modalBack" id="petDetailsBack">
  <div class="modal" style="max-width:760px;">
    <div class="modalHeader">
      <b>Pet Details</b>
      <span class="closeX" onclick="closeModal('petDetailsBack')">X</span>
    </div>
    <div id="petDetailsHint" style="margin:10px 0;"></div>
    <div id="petDetailsBody"></div>
  </div>
</div>


<div class="modalBack" id="adopted_modal">
  <div class="modal" style="max-width:860px;">
    <div class="modalHeader">
      <b>My Adopted Aliens</b>
      <span class="closeX" onclick="closeAdopted()">X</span>
    </div>
    <div class="hr"></div>
    <div id="adoptedBody"><span class="badge">Loading...</span></div>
  </div>
</div>


<div class="sideModal" id="basket_modal">
  <div class="row space">
    <b>Basket</b>
    <span class="closeX" onclick="closeCart()">X</span>
  </div>
  <div class="hr"></div>
  <div id="cartBody"></div>
</div>

<script src="javascript/utils.js"></script>
<script src="javascript/pets.js"></script>
<script src="javascript/cart.js"></script>
<script src="javascript/adopted.js"></script>
</body>
</html>
