<div class="AddBeheer">
	<h2 style="width: 68%; margin: 0 auto; text-align: center; margin-left: 3%;">Klanten wijzigen of verwijderen</h2>
			<?php

			$sql6 = $pdo->prepare("SELECT * FROM `gebruikers`");
			$sql6->execute();
			$qry6 = $sql6->fetchAll();

			foreach($qry6 as $gebruikers)
			{
				?>
				<form method="post" action="">
					<table class="viewTable">
						<?php
						$gebruikersID = $gebruikers[0];
						$gebruikersNaam = $gebruikers[1];
						$gebruikersAdres = $gebruikers[2];
						$gebruikersPostcode = $gebruikers[3];
						$gebruikersWoonplaats = $gebruikers[4];
						$gebruikersTelefoon = $gebruikers[5];
						$gebruikersGeboortedatum = $gebruikers[6];
						$gebruikersEmail = $gebruikers[7];
						$accesslevel = $gebruikers[8];
						$gebruikersGebruikersnaam = $gebruikers[9];
						$gebruikersWachtwoord = $gebruikers[10];
					?>
						<tr>
							<td>Naam: </td>
							<td><?php echo "<input type='' name='aangepasteGebruikersNaam' value='$gebruikersNaam'>"; ?></td>
						</tr>
						<tr>
							<td>Adres: </td>
							<td><?php echo "<input type='' name='aangepasteGebruikersAdres' value='$gebruikersAdres'>"; ?></td>
						</tr>
						<tr>
							<td>Postcode: </td>
							<td><?php echo "<input type='text' name='aangepasteGebruikersPostcode' value='$gebruikersPostcode'>"; ?></td>
						</tr>
						<tr>
							<td>Woonplaats: </td>
							<td><?php echo "<input type='text' name='aangepasteGebruikersWoonplaats' value='$gebruikersWoonplaats'>"; ?></td>
						</tr>
						<tr>
							<td>Telefoon: </td>
							<td><?php echo "<input type='text' name='aangepastgebruikersTelefoon' value='$gebruikersTelefoon'>"; ?></td>
						</tr>						
						<tr>
							<td>Geboortedatum: </td>
							<td><?php echo "<input type='' name='aangepastegebruikersGeboortedatum' value='$gebruikersGeboortedatum'>"; ?></td>
						</tr>
						<tr>
							<td>Email: </td>
							<td><?php echo "<input type='text' name='aangepasteGebruikersEmail' value='$gebruikersEmail'>"; ?></td>
						</tr>
						<tr>
							<td>Accesslevel: </td>
							<td><?php echo "<input type='text' name='aangepastAccesslevel' value='$accesslevel'>"; ?></td>
						</tr>
						<tr>
							<td>Gebruikersnaam: </td>
							<td><?php echo "<input type='text' name='gebruikersGebruikersnaam' value='$gebruikersGebruikersnaam'>"; ?></td>
						</tr>
						<tr>
							<td>Wachtwoord: </td>
							<td><?php echo "<input type='text' name='gebruikersWachtwoord' value='$gebruikersWachtwoord'>"; ?></td>
						</tr>
						<tr>
							<td style="padding-top: 15px;"><?php echo "<button type='submit' name='klantWijzigen' value='$gebruikersID'>wijzigen</button>";?></td>
							<td style="padding-top: 15px;"><?php echo "<button type='submit' name='klantVerwijderen' value='$gebruikersID' style='position: relative; left: 20px;'>Verwijderen</button>";?></td>
						</tr>
					</table>
				</form>
			<?php
			}
			?>
</div>