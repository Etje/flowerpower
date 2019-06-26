<div class="AddBeheer" style="min-height: 575px;">
	<h2 style="width: 68%; margin: 0 auto; margin-top: 2%;">Medewerker wijzigen of verwijderen</h2>
			<?php

			$sql4 = $pdo->prepare("SELECT * FROM `medewerker`");
			$sql4->execute();
			$qry4 = $sql4->fetchAll();

			foreach($qry4 as $medewerker)
			{
				?>
				<form method="post" action="">
					<table class="viewTable">
						<?php
						$id = $medewerker[0];
						$medewerkerNaam = $medewerker[1];
						$gebruikersnaam = $medewerker[2];
						$wachtwoord = $medewerker[3];
						$accesslevel = $medewerker[4];
					?>
						<tr>
							<td>ID: </td>
							<td><?php echo $id; ?></td>
						</tr>
						<tr>
							<td>Naam: </td>
							<td><?php echo $medewerkerNaam; ?></td>
						</tr>
						<tr>
							<td>Gebruikersnaam: </td>
							<td><?php echo "<input type='text' name='aangepasteGebruikersnaam' value='$gebruikersnaam'>"; ?></td>
						</tr>
						<tr>
							<td>Wachtwoord: </td>
							<td><?php echo "<input type='text' name='aangepastWachtwoord' value='$wachtwoord'>"; ?></td>
						</tr>
						<tr>
							<td>AccessLevel: </td>
							<td><?php echo "<input type='number' name='aangepastAccesslevel' value='$accesslevel'>"; ?></td>
						</tr>
						<tr>
							<td style="padding-top: 15px;"><?php echo "<button type='submit' name='wijzigen' value='$id'>wijzigen</button>";?></td>
							<td style="padding-top: 15px;"><?php echo "<button type='submit' style='position: relative; left: 20px;' name='MedewerkerVerwijderen' value='$id'>Verwijderen</button>";?></td>
						</tr>
					</table>
				</form>
			<?php
			}
			?>
</div>