<script>
function myFunction() {
    window.print();
}
</script>
<style>
.invoice {
	padding-right: 50px;
}

</style>
<style media="screen">
  .noPrint{ display: block; }
  .yesPrint{ display: block !important; }
</style>

<style media="print">
  .noPrint{ display: none; }
  .yesPrint{ display: block !important; }
</style>
<?php
session_start();
require("functions.php");
$pdo = ConnectToDatabase();

/*Hieronder worden de gegevens uit de database gehaald, en getoond in het factuur*/

if(isset($_SESSION["cart"])){ 
?>
<div id="factuur">
<h2 style="margin-top: 4%;">FlowerPower</h2>
<table>
<tr><td>Af te halen:</td></tr>
<tr><td>Bloemenwinkel FlowerPower</td></tr>
<?php
$locatie = $_SESSION["locatie"];
$naam = $_SESSION["username"];
	
$sql4 = $pdo->prepare("SELECT `gebruikersID`
					  FROM `gebruikers` 
					  WHERE `gebruikersGebruikersnaam` = '".$naam."'");
$sql4->execute();
$sth4 = $sql4->fetch();

$id = $sth4[0]; 

$sql = $pdo->prepare("SELECT * 
					  FROM `winkel` 
					  WHERE `winkelplaats` = '".$locatie."'");
$sql->execute();
$sth1 = $sql->fetchAll();

$grand_total = 0; 
foreach($sth1 as $key)
{

$winkelID 	  	= $key[0];
$winkelplaats 	= $key[1];
$winkelAdres  	= $key[2];
$winkelPostcode = $key[3];
$winkelTelefoon	= $key[4];

echo "<tr>";
echo "<td>".$winkelAdres."</td></tr>";
echo "<td>".$winkelPostcode." ".$winkelplaats."</td></tr>";
echo "<td>".$winkelTelefoon."</td>";
echo "</tr>";
}
?>
</table>
<h2 style="font-size: 50px;">Factuur</h2>
<table>
<?php 
$sql2 = $pdo->prepare("SELECT `factuurID`, `factuurDatum` FROM `factuur` WHERE `gebruikersID` = '".$id."' LIMIT 1");
$sql2->execute();
$sth2 = $sql2->fetchAll();

foreach($sth2 as $factuur)
{
	$factuurID = $factuur[0];
	$datum 	   = $factuur[1];

	echo "<tr style='font-size: 20px;'>";
	echo "<td style='padding-right: 300px;'>FactuurNummer: ".$factuurID."</td>";
	echo "<td>".$datum."</td>";
	echo "</tr>";

}
?>
</table>
<table>
<?php
$sql1 = $pdo->prepare("SELECT `gebruikersNaam`, `gebruikersAdres`, `gebruikersPostcode`, `gebruikersWoonplaats` 
					   FROM `gebruikers` a
					   WHERE a.`gebruikersID` = '".$id."' LIMIT 1");
$sql1->execute();
$sth1 = $sql1->fetchAll();

foreach($sth1 as $gebruiker)
{
	$gebruikersNaam = $gebruiker[0];
	$gebruikersAdres = $gebruiker[1];
	$gebruikersPostcode = $gebruiker[2];
	$gebruikersWoonplaats = $gebruiker[3];

	echo "<tr>";
	echo "<td>".$gebruikersNaam."</td></tr>";
	echo "<td>".$gebruikersAdres."</td></tr>";
	echo "<td>".$gebruikersPostcode." ".$gebruikersWoonplaats."</td>";
	echo "</tr>";
}
?>
</table>
<h3>Artikelen</h3>
<table>
<tr>
<th class="invoice">Product naam</th>
<th class="invoice">Aantal</th>
<th class="invoice">Prijs</th>
<th class="invoice">Bruto Prijs</th>
</tr>
<?php 
foreach($_SESSION["cart"] as $product)
{
$productID = $product['id'];
$hoeveelheid = $product['hoeveelheid'];

$sql4 = $pdo->prepare("SELECT a.`productNaam`, a.`productPrijsPerStuk` FROM `producten` a, `factuur_regel` b WHERE a.`productID` = '".$productID."' LIMIT 1");
$sql4->execute();
$sth4 = $sql4->fetchAll();

		foreach($sth4 as $artikel)	
		{
			$productNaam	 = $artikel[0];
			$productPrijs    = $artikel[1];

			$bruto = $productPrijs * $hoeveelheid; 

			echo "<tr>";
			echo "<td>".$productNaam."</td>";
			echo "<td>".$hoeveelheid."</td>";
			echo "<td>&#8364; ".$productPrijs.",-</td>";
			echo "<td>&#8364; ".$bruto.",-</td>";
			echo "</tr>";

		$grand_total += $bruto;
		$percentage = 1.21; 
		$btwPrijs = $grand_total / $percentage;
		$y = $grand_total - $btwPrijs;
		$overblijfsel = round($y); 
		$netto = $grand_total - $overblijfsel; 
		}
	}
		?>
		<table style="margin-top: 3%;">
		<tr>
		<td style="padding-right: 287px; ">Totaal:</td>
		<td style="width: 50px;"><?php echo "&#8364; ".$grand_total.",-"; ?></td>
		</tr>
		<tr>
		<td>BTW:</td>
		<td><?php echo "&#8364; ".$overblijfsel.",-"; ?></td>
		</tr>
		<tr>
		<td>Netto:</td>
		<td><?php echo "&#8364; ".$netto.",-"; ?></td>
		</tr>		
		</table>
		<p class="noPrint">
		<button onclick="myFunction()">afdrukken</button>
		<a href="clearCart.php">Ga terug</a>
		</p>
		<?php
} else {
	echo "<p class='AddCart'>er is geen factuur beschikbaar</p>";
}
?>
</table>		
</div>
