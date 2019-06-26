<?php
require("header.php");
$pdo = ConnectToDatabase(); 
unset($_SESSION["cart"]);
unset($_SESSION["productID"]);
?>
<div class="content">
<?php
echo "<div class='AddCart' style='width: 25%;'>je winkelwagentje is leeg</div>";
unset($_SESSION["tijd"]);
unset($_SESSION["locatie"]);
?>
</div>
<?php
require("footer.php");
?>
