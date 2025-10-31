
<!-- Set Countries and Months if saved -->
<script>
var selectedCountryBilling = "<?php echo htmlspecialchars($billing['country'] ?? '') ?>";
document.getElementById("country").value = selectedCountryBilling;

var selectedCountryShipping = "<?php echo htmlspecialchars($shipping['scountry'] ?? '') ?>";
document.getElementById("scountry").value = selectedCountryShipping;

var monthChosen = "<?php echo htmlspecialchars($payment['expmonth'] ?? '') ?>";
document.getElementById("expmonth").value = monthChosen;

var yearChosen = "<?php echo htmlspecialchars($payment['expyear'] ?? '') ?>";
document.getElementById("expyear").value = yearChosen;
</script>