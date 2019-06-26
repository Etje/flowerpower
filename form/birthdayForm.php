		<?php
		foreach($qry4 as $birth)
		{
			?>
			<h2 style="width: 26%; margin: 0 auto; padding-top: 3%;">Klanten die binnen 2 dagen jarig zijn!</h2>
				<table class="viewTable">
					<tr>
						<th style="width: 12%; text-align: center;">Naam</th>
						<th style="width: 14%; text-align: center;">Geboortedatum</th>
					</tr>
					<?php
					$naam = $birth[0];
					$datum = $birth[1];
				?>
					<tr>
						<td style="width: 12%; text-align: center;"><?php echo $naam; ?></td>
						<td style="width: 14%; text-align: center;"><?php echo $datum; ?></td>
					</tr>
				</table>
		<?php
		}
		?>