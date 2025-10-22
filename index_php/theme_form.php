<form id="themeForm" method="POST">
  <select name="theme" id="theme">
    <option value="red" <?php echo ($theme ?? '') == 'red' ? 'selected' : ''; ?>>Red and Pastel Rose</option>
    <option value="green" <?php echo ($theme ?? '') == 'green' ? 'selected' : ''; ?>>Green and Gold</option>
    <option value="blue" <?php echo ($theme ?? '') == 'blue' ? 'selected' : ''; ?>>Blue and Cyan</option>
    <option value="purple" <?php echo ($theme ?? '') == 'purple' ? 'selected' : ''; ?>>Pink and Purple</option>
    <option value="brown" <?php echo ($theme ?? '') == 'brown' ? 'selected' : ''; ?>>Brown and Orange</option>
    <option value="black" <?php echo ($theme ?? '') == 'black' ? 'selected' : ''; ?>>Black and White</option>
    <option value="silver" <?php echo ($theme ?? '') == 'silver' ? 'selected' : ''; ?>>Silver and Blue</option>
    <option value="space" <?php echo ($theme ?? '') == 'space' ? 'selected' : ''; ?>>Space Ship</option>
    <option value="bunny" <?php echo ($theme ?? '') == 'bunny' ? 'selected' : ''; ?>>Fluffy Bunny</option>
  </select>
</form>

<script>
document.getElementById('themeForm').addEventListener('change', function(e) {
    if(e.target.name === 'theme') {
        const selectedTheme = e.target.value;
        // Send AJAX request to update theme cookie
        fetch('set_theme.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'theme=' + encodeURIComponent(selectedTheme)
        }).then(() => {
            // Update the theme CSS dynamically
            const cssLink = document.getElementById('theme-css');
            cssLink.href = 'css/styles_' + selectedTheme + '.css';
            const themeImg = document.getElementById('themeCatImg');
            themeImg.src = `images/colour_theme_cats/${selectedTheme}_cat.jpg`
        });
    }
});
</script>
