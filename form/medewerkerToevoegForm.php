<div class="AddBeheer">
	<h2 style="width: 68%; margin: 0 auto; margin-top: 2%; text-align: center;">Medewerker toevoegen</h2>
		<form method="post" action=""> 
			<table style="width: 30%; margin: 0 auto;">
			<tr>
			<td>Naam:</td>
			<td><input type="text" name="medewerkerNaam"></td>
			</tr>
			<tr>
			<td>Gebruikersnaam:</td>
			<td><input type="text" name="medewerkerGebruikersnaam"></td>
			</tr>
			<tr>
			<td>Wachtwoord:</td>
			<td><input type="password" name="medewerkerWachtwoord"></td>
			</tr> 
			<tr style="display: none;">  
			<td>AccesLevel:</td>
			<td>
			<select name="accesslevel">
			<option value="1">1</option>
			<option value="2" selected>2</option>
			</select>
			</td>
			</tr>
			<tr>
			<td><input type="submit" name="AddMedewerker" value="toevoegen"></td>
			</tr>
			</table> 
		</form>   
</div>