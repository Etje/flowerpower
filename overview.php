<?php
require("header.php");
$pdo = ConnectToDatabase(); 
?>
<div class="content">
<?php
if(isset($_POST["bestellingen"]))
{
$gebruikerID = $_POST["gebruiker"];
$sth17 = $pdo->prepare("SELECT * FROM `factuur` a, `factuur_regel` b WHERE a.`factuurID` = b.`factuurID` AND `gebruikersID` = '".$gebruikerID."'");
$sth17->execute();
$qry17 = $sth17->fetchAll();


$_SESSION['gebruiker'] = $gebruikerID;

?>

<table style="margin-right: 7%;">
	<tr>
		<th>FactuurID</th>
		<th>Product Naam</th>
		<th>Aantal</th>
		<th>Prijs per stuk</th>
		<th>Totaal prijs (Incl. 21% BTW)</th>
	</tr>
<?php
foreach($qry17 as $product)
{
	$factuurID 		= $product[0];
	$winkelID 		= $product[1];
	$gebruikersID	= $product[2];
	$medewerkerID	= $product[3];
	$afhaaltijd		= $product[4];
	$afgehandeld	= $product[5];
	$factuurDatum 	= $product[6];
	$productID 		= $product[8];
	$productAantal	= $product[9];

	$sth13 = $pdo->prepare("SELECT `productNaam`, productPrijsPerStuk FROM `producten` WHERE `productID` = '".$productID."'");
	$sth13->execute();
	$qry13 = $sth13->fetch();

	$productNaam  = $qry13[0];
	$productPrijs = $qry13[1];

	$sth14 = $pdo->prepare("SELECT `gebruikersNaam` FROM `gebruikers` WHERE `gebruikersID` = '".$gebruikersID."'");
	$sth14->execute();
	$qry14 = $sth14->fetch();

	$gebruikersNaam = $qry14[0];

	$totaal = $productPrijs * $productAantal * 1.21;

	echo "<tr>";
	echo "<td>".$factuurID."</td>";
	echo "<td>".$productNaam."</td>";
	echo "<td>".$productAantal."</td>";
	echo "<td>&#8364; ".$productPrijs.",-</td>";
	echo "<td>&#8364; ".$totaal.",-</td>";
	echo "</tr>";
}
?>
</table>
</div>
<?php
}
?>
</div>
<?php
require("footer.php");
?>