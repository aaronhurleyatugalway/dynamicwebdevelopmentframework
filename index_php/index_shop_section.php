  <?php
  // ===============================
  // Fetch distinct data from database
  // ===============================
  // Sock colours
  
  $sql = "SELECT DISTINCT sock_color FROM Socks ORDER BY sock_color";
  $result1 = $conn->query($sql);

  // Sock patterns
  $sql = "SELECT DISTINCT sock_pattern FROM Socks ORDER BY sock_pattern";
  $result2 = $conn->query($sql);

  // Sizes
  $sql = "SELECT DISTINCT size FROM Socks ORDER BY size";
  $result3 = $conn->query($sql);

  $conn->close();?> 
  
  
  <!-- =============================== -->
  <!-- MAIN SHOP SECTION -->
  <!-- =============================== -->
  <div class="div-border table-layout">
    <table id="shoppingtable">
      <tr class="shoptr">

        <!-- =============================== -->
        <!-- FILTER FORM COLUMN -->
        <!-- =============================== -->
        <td id="form-cell">
          <form id="sock_form" action="/submit">
            <!-- Colour Dropdown -->
            <select name="sock_colours" id="sock_colours" onchange="updateSockList()">
              <option value="" disabled selected>Select a Colour</option>
              <option value="">All</option>
              <?php while ($row = $result1->fetch_assoc()) {
                echo "<option value=\"" . $row["sock_color"] . "\">" . $row["sock_color"] . "</option>";
              } ?>
            </select>

            <!-- Pattern Text Field -->
            <input type="text" id="sock_patterns" name="sock_patterns" placeholder="Enter Sock Pattern"
              onkeyup="updateSockList()">

            <!-- Size Checkboxes -->
            <div class="div-border">
              <b>Select Size:</b>
              <?php while ($row = $result3->fetch_assoc()) {
                echo "<label>";
                echo "<input type=\"checkbox\" name=\"sizes[]\" value=\"" . $row["size"] .
                  "\" onclick=\"updateSockList()\">" . $row["size"] . "</label>";
              } ?>
            </div>
          </form>
        </td>

        <!-- =============================== -->
        <!-- SOCK LIST RESPONSE COLUMN -->
        <!-- =============================== -->
        <td id="response-cell">
          <div id="sock_response" class="div-border"></div>
        </td>
      </tr>
    </table>
  </div>