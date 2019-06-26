<div class="AddBeheer">
	<h2 style="width: 68%; margin: 0 auto; margin-top: 2%;">Artikelen wijzigen</h2>
			<?php

			$sql5 = $pdo->prepare("SELECT * FROM `producten`");
			$sql5->execute();
			$qry5 = $sql5->fetchAll();

			foreach($qry5 as $product)
			{
				?>
				<form method="post" action="">
					<table class="viewTable">
						<?php
						$id = $product[0];
						$productNaam = $product[1];
						$productCategorie = $product[2];
						$productAfbeelding = $product[3];
						$productPrijsPerStuk = $product[4];
					?>
						<tr>
							<td>Naam: </td>
							<td><?php echo $productNaam; ?></td>
						</tr>
						<tr>
							<td>Categorie: </td>
							<td><?php echo $productCategorie; ?></td>
						</tr>
						<tr>
							<td>Afbeelding: </td>
							<td><?php echo $productAfbeelding; ?></td>
						</tr>
						<tr>
							<td>Wachtwoord: </td>
							<td><?php echo $productPrijsPerStuk; ?></td>
						</tr>
						<tr>
							<td colspan="2" style="padding-top: 15px;"><?php echo "<button type='submit' name='productVerwijderen' value='$id'>Verwijderen</button>";?></td>
						</tr>
					</table>
				</form>
			<?php
			}
			?>
</div>