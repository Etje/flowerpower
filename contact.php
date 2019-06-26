<?php
require("header.php");
$pdo = ConnectToDatabase(); 

$sql = $pdo->prepare("SELECT * FROM `winkel`");
$sql->execute();
$sth1 = $sql->fetchAll();
?>
<div class="content">
<p class="text">Hieronder vind je de adressengegevens van onze vestigingen</p>
			<table style="width: 100%; height: 600px;">
					<?php
						foreach($sth1 as $winkel)
							{
								$id = $winkel[0];
								$plaats = $winkel[1];
								$adres = $winkel[2];
								$postcode = $winkel[3];
								$openingstijden = $winkel[4];
								$telefoon = $winkel[5];
								$afbeelding = $winkel[6];

								echo "<tr class='winkel'><td style='padding-left: 2%;'><img src='./images/bedrijf/".$afbeelding."' alt='images' class='images' style='margin-left: 0%; padding-right: 2%;' />
								</td>";
								echo "<td style='width: 25%;'>Dit is onze vestiging in ".$plaats.", aan de ".$adres."</td>";
								echo "<td style='width: 25%;'>De openingstijden van deze vestiging zijn ".$openingstijden."</td>";
								echo "<td>De postcode van deze vestiging is ".$postcode.".</td>";
								echo "<td style='width: 20%;'>U kunt met deze vestiging contact opnemen via telefoonnummer: ".$telefoon."</td></tr>";
							}
					?>
			</table>
</div>
<?php
require("footer.php");
?>
