<div class="AddBeheer">
	<h2 style="width: 68%; margin: 0 auto; margin-top: 2%; text-align: center;">Gegevens medewerkers</h2>
			<?php

			$sql4 = $pdo->prepare("SELECT * FROM `medewerker` WHERE `accesslevel` < 3");
			$sql4->execute();
			$qry4 = $sql4->fetchAll();

			foreach($qry4 as $medewerker)
			{
				?>
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
					<td><?php echo $gebruikersnaam; ?></td>
				</tr>
				<tr>
					<td>Wachtwoord: </td>
					<td><?php echo $wachtwoord; ?></td>
				</tr>
				<tr>
					<td>AccessLevel: </td>
					<td><?php echo $accesslevel; ?></td>
				</tr>
			</table>
			<?php
			}
			?>
</div>