<?php
require("header.php");
$pdo = ConnectToDatabase(); 
?>
<div class="content">
<?php
	/*Tabel word aangemaakt, en er worden bepaalde gegevens uit de database gehaald. */
	?>
<table style="width: 70%; margin-left: 22%;">
	<tr>
	<th>Naam</th>
	<th>Aantal</th>
	<th>Prijs per stuk</th>
	<th>Bruto prijs</th>
	</tr>
	<?php

	$total = 0;

	$locatie 	= $_SESSION["locatie"];
	$klant	 	= $_SESSION["username"];
	$tijd 		= $_SESSION["tijd"];
	$date		= $_SESSION["date"]; 

	$sql8 = $pdo->prepare("SELECT `winkelID` FROM `winkel` WHERE `winkelPlaats` = '".$locatie."'");
	$sql8->execute();
	$sth8 = $sql8->fetch();

	$winkelID = $sth8[0];

	$sql9 = $pdo->prepare("SELECT `gebruikersID` FROM `gebruikers` WHERE `gebruikersGebruikersnaam` = '".$klant."'");
	$sql9->execute();
	$sth9 = $sql9->fetch();

	$gebruikersID = $sth9[0];

	/*Het factuurID word als een random getal gegenereerd. Deze word vervolgens in de factuur datatable gebruikt als FactuurID. 
	Gelijk word deze daarna weer opgehaald uit de database, en gebruikt als factuurID in de insert voor factuur_regel*/

	$factuurID = rand(100, 100000); 

	$insert1 = $pdo->prepare("INSERT INTO `factuur`
			 (factuurID, 
			 winkelID,
			 gebruikersID, 
			 medewerkerID,
			 afhaaltijd, 
			 afgehandeld, 
			 factuurDatum)
			 VALUES ( :factuurID,
			 		  :winkelID,
			 		  :gebruikersID,
			 		  :medewerkerID,
			 		  :afhaaltijd,
			 		  :afgehandeld,
			 		  :factuurDatum)");

	$insert1->execute(array(
		"factuurID" => $factuurID,
	    "winkelID" => $winkelID,
	    "gebruikersID" => $gebruikersID,
	    "medewerkerID" => "0",
	    "afhaaltijd" => $tijd,
	    "afgehandeld" => "0",
	    "factuurDatum" => $date
	));

	foreach($_SESSION["cart"] as $cart)
	{
		$id = $cart['id'];
		$hoeveelheid = $cart['hoeveelheid'];

		$qry7 = $pdo->prepare("SELECT * FROM `producten` WHERE `productID` = '".$id."'");
		$qry7->execute();
		$sth7 = $qry7->fetchAll();


		foreach($sth7 as $final)
		{
			$productID = $final[0];
			$productNaam = $final[1];
			$productCategorie = $final[2];
			$prijsPerStuk = $final[5];

			$totaalPrijs = $prijsPerStuk * $hoeveelheid;

			$btw = 1.21;
			$InclBTW = $totaalPrijs * $btw;

			$prijsInclBTW = number_format($InclBTW, 2);

			$total += $prijsInclBTW;

			$sql11 = $pdo->prepare("SELECT `factuurID` FROM `factuur` WHERE `afhaaltijd` = '".$tijd."'");
			$sql11->execute();
			$sth11 = $sql11->fetch();

			$_SESSION["factuurID"] = $sth11[0];

			$factuurNr = $_SESSION["factuurID"];

			$insert = $pdo->prepare("INSERT INTO `factuur_regel`
			 (factuurID, 
			 productID,
			 productAantal)
			 VALUES ( :factuurID,
			 		  :productID,
			 		  :productAantal)");

			$insert->execute(array(
			    "factuurID" => $factuurNr,
			    "productID" => $productID,
			    "productAantal" => $hoeveelheid
			));
		?>
			<tr>
				<td style="max-width: 10px;"><?php echo $productNaam;?></td>
				<td><?php echo $hoeveelheid;?></td>
				<td><?php echo "&#8364; ".$prijsPerStuk.",-";?></td>
				<td><?php echo "&#8364; ".$totaalPrijs.",-";?></td>
			</tr>
		<?php
		}
	}

		$grand_total = number_format($total, 2);
	?>
		<table style="width: 56%; margin-top: 15px;">
		<tr style="font-weight: bold; color: red;">
			<td style="width: 50%;">Totaal: </td>
			<td style="width: 3%; position: relative; right: 15px;"><?php echo "&#8364; ".$grand_total.",-";?></td>
		</tr>
	</table>
</table>
<div class="invoice">
<p style="margin-top: 10%;"><a href="invoice.php" name="genereerFactuur">Factuur bekijken</a></p>
</div>
</div>
