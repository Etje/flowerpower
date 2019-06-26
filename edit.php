<?php
require("header.php");
$pdo = ConnectToDatabase(); 
?>
<div class="content">
<?php
if(isset($_POST["aanpassen"]))
{
	$productNummer = $_POST["aanpassen"];
	$hoeveelheid = $_POST["hoeveelheid"];

	if(isset($_POST["verwijderen"]))
	{
		unset($_SESSION["cart"][$productNummer]);
	}
		$sql1 = $pdo->prepare("SELECT * FROM `producten` WHERE `productID` = '".$productNummer."'");
		$sql1->execute();
		$sth3 = $sql1->fetchAll();

		$total = 0;
		foreach($sth3 as $product)
			{
				$productnaam = $product[1];
				$productCategorie = $product[2];
				$productPrijsPerStuk = $product[4];	

				$btw = 1.21;
				$prijsExclBTW = $hoeveelheid * $productPrijsPerStuk;
				$InclBTW = $prijsExclBTW * $btw;

				$prijsInclBTW = number_format($InclBTW, 2);

				$total += $prijsInclBTW;
				
?>
		<form method="post" action="winkelwagentje.php">
		<input type="hidden" name="pid" value="<?php echo $productNummer; ?>" />
			<table class="editTable">
				<tr>
					<td style="width:50%;">Naam: </td>
					<td><?php echo $productnaam;?></td>
				</tr>
				<tr>
					<td>categorie: </td>
					<td><?php echo $productCategorie;?></td>
				</tr>
				<tr>
					<td>hoeveelheid: </td>
					<td><?php echo "<input type='text' name='aangepasteHoeveelheid' value='$hoeveelheid'> exemplaren";?></td>
				</tr>
				<tr>
					<td>prijs per stuk: </td>
					<td><?php echo "&#8364; ".$productPrijsPerStuk.",-";?></td>
				</tr>		
				<tr>
					<td colspan="2" style="padding-top: 30px;"><button type="submit" name="edit">Aanpassen</button></td>
				</tr>
			</table>
		</form>
		<?php
	}
}
?>
</div>
<?php
require("footer.php");
?>