<?php
require("header.php");
$pdo = ConnectToDatabase(); 
?>
<div class="content">
<?php
unset($_SESSION["cart"]);
session_destroy();
echo '<script>window.location="index.php"</script>';
?>
</div>
<?php
require("footer.php");
?>