<?php
require("header.php");
$pdo = ConnectToDatabase(); 
if(!isset($_SESSION["username"])){echo '<script>window.location="loginWarning.php"</script>';}
else 
{
?>
<div class="content">
<?php
if(isset($_POST["view"]))
{
	/*Het productID, van het product dat je wilt bestellen, maar ook de hoeveelheid en de prijs worden in een sessie gezet.
	Deze worden daarna gebruikt om gegevens op te halen uit de datatable*/
	$_SESSION["productID"]	 = $_POST["productnr"]; 
	$_SESSION["hoeveelheid"] = $_POST["hoeveelheid"];
	$_SESSION["prijs"]		 = $_POST["prijs"];

	$sql = $pdo->prepare("SELECT * FROM `producten` WHERE `productID` = '".$_SESSION["productID"]."'");
	$sql->execute();
	$sth1 = $sql->fetchAll();

	foreach($sth1 as $product)
		{
			$productnr = $product[0];
			$productnaam = $product[1];
			$productCategorie = $product[2];
			$productVoorraad = $product[3];
			$productAfbeelding = $product[4];
			$productPrijsPerStuk = $product[5];
		}

	$stm = $pdo->prepare("SELECT `winkelID`, `winkelPlaats`, `winkelAdres` FROM `winkel`");
	$stm->execute();
	$sth2 = $stm->fetchAll();	

	$qry1 = $pdo->prepare("SELECT `medewerkerID`, `medewerkerNaam` FROM `medewerker`");
	$qry1->execute();
	$sth4 = $qry1->fetchAll();
}
$_SESSION["productnr"] = $_POST["productnr"];
$hoeveelheid = $_POST["hoeveelheid"];  
$productnr = $_POST["productnr"];

$totaalPrijs = $hoeveelheid * $productPrijsPerStuk;
?>
<form name="cartform" method="post" action="winkelwagentje.php">
<?php echo "<img src='".$productAfbeelding."' alt='images' class='cart_image'>";?>
<table class="cart" style="line-height: 25px;">
<tr>
<td>Naam:</td>
<td><?php echo $productnaam; ?></td>
</tr>
<tr>
<td>Categorie:</td>
<td><?php echo $productCategorie; ?></td>
</tr>
<tr>
<td>Hoeveelheid:</td>
<td><?php echo $hoeveelheid; ?></td>
</tr>
<tr>
<td>Product Prijs:</td>
<td><?php echo "&#8364; ".$productPrijsPerStuk.",-";?></td>
</tr>
<?php
if(isset($_SESSION["locatie"])){}
	else {
?>
<tr>
<td>Afhaal locatie:</td>
<td>
	<select name="locatie">
		<?php
		foreach($sth2 as $locatie)
		{
			$id 	= $locatie[0];
			$plaats = $locatie[1];
			$adres 	= $locatie[2];
				
		echo "<option value='$plaats'>$plaats</option>";

		}
		?>
	</select>
</td>
</tr>
<tr>
<td>Gewenste ophaal tijd:</td>
<td>
<select name="tijd">
<option value="Tussen 9:00 en 10:00 uur">Tussen 9:00 en 10:00 uur</option>
<option value="Tussen 10:00 en 11:00 uur">Tussen 10:00 en 11:00 uur</option>
<option value="Tussen 11:00 en 12:00 uur">Tussen 11:00 en 12:00 uur</option>
<option value="Tussen 12:00 en 13:00 uur">Tussen 12:00 en 13:00 uur</option>
<option value="Tussen 13:00 en 14:00 uur">Tussen 13:00 en 14:00 uur</option>
<option value="Tussen 14:00 en 15:00 uur">Tussen 14:00 en 15:00 uur</option>
<option value="Tussen 15:00 en 16:00 uur">Tussen 15:00 en 16:00 uur</option>
<option value="Tussen 16:00 en 17:00 uur">Tussen 16:00 en 17:00 uur</option>
</select>
</td>
</tr>
<?php
}
?>
<tr>
<td colspan="2"><input type="submit" name="add_to_cart" value="in winkelwagentje" style="background-color: #ccc; left: 25%;"></td>
</tr>
</table>
</form> 
</div>
<?php
require("footer.php");
}
?>