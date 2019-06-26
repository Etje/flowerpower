<?php
require("header.php");
$pdo = ConnectToDatabase(); 
?>
<div class="content">
<?php
echo "<p class='warning'>U moet eerst inloggen voordat u deze pagina kunt bezichtigen</p>";
echo "<p>U word na 5 seconden doorgestuurd naar de login pagina</p>";
header("refresh:5;url=klantLoginRegistreer.php" );
?>
</div>
<?php
require("footer.php");
?>