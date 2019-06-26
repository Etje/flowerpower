<?php
require("header.php");
$pdo = ConnectToDatabase(); 
?>
<div class="content">
<?php
if(isset($_SESSION["username"]))
{
	echo "<p class='welcome'>Hallo ".$_SESSION["username"]."</p>";
}
echo "<img src='./images/bedrijf/flowerpower 2.png' alt='images' class='indexImage'/>";
echo "<img src='http://www.bloemenhetwesten.nl/wp-content/uploads/2012/11/tulpen.jpg' alt='images' class='indexImage'/>";
?>
</div>
<?php
require("footer.php");
?>
