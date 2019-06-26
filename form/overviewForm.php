<?php
$sth12 = $pdo->prepare("SELECT * FROM `factuur` a, `factuur_regel` b WHERE a.`factuurID` = b.`factuurID`");
$sth12->execute();
$qry12 = $sth12->fetchAll();
?>
<table>
	<tr>
		<th>Gebruiker: </th>
		<th>FactuurID</th>
		<th>Product Naam</th>
		<th>Aantal</th>
		<th>Prijs per stuk</th>
		<th>Totaal prijs (Incl. 21% BTW)</th>
	</tr>
			<?php
				foreach($qry12 as $order)
				{
				$factuurID 		= $order[0];
				$winkelID 		= $order[1];
				$gebruikersID	= $order[2];
				$medewerkerID	= $order[3];
				$afhaaltijd		= $order[4];
				$afgehandeld	= $order[6];
				$factuurDatum 	= $order[7];
				$productID 		= $order[8];
				$productAantal	= $order[9];

				$sth13 = $pdo->prepare("SELECT `productNaam`, productPrijsPerStuk FROM `producten` WHERE `productID` = '".$productID."'");
				$sth13->execute();
				$qry13 = $sth13->fetch();

				$productNaam  = $qry13[0];
				$productPrijs = $qry13[1];

				$sth14 = $pdo->prepare("SELECT `gebruikersNaam` FROM `gebruikers` WHERE `gebruikersID` = '".$gebruikersID."'");
				$sth14->execute();
				$qry14 = $sth14->fetch();

				$gebruikersNaam = $qry14[0];

				$totaal = $productPrijs * $productAantal;
				echo "<tr>";
				echo "<td>".$gebruikersNaam."</td>";
				echo "<td>".$factuurID."</td>";
				echo "<td>".$productNaam."</td>";
				echo "<td>".$productAantal."</td>";
				echo "<td>&#8364; ".$productPrijs.",-</td>";
				echo "<td>&#8364; ".$totaal.",-</td>";
				echo "</tr>";

				}
				?>
</table>
