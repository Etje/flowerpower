<?php
require("header.php");
$pdo = ConnectToDatabase();
if(isset($_POST["claimen"]))
{
	$sth19 = $pdo->prepare("SELECT `medewerkerID` FROM `medewerker` WHERE `medewerkerGebruikersnaam` = '".$_SESSION["username"]."'");
	$sth19->execute();
	$qry19 = $sth19->fetch();

	$ID = $qry19[0];

	foreach($_POST["medewerker"] as $medewerker)
	{
		$sth18 = $pdo->prepare("UPDATE `factuur` 
								SET `MedewerkerID` = '".$ID."' 
								WHERE `factuurID` = '".$medewerker."'");
		$sth18->execute();
	}
}
if(isset($_POST["submit"]))
{
	foreach($_POST["afgehandeld"] as $id)
	{
		$sth18 = $pdo->prepare("UPDATE `factuur` 
								SET `afgehandeld` = 1
								WHERE `factuurID` = '".$id."'");
		$sth18->execute();

		$sth19 = $pdo->prepare("DELETE FROM `factuur_regel` 
								WHERE `factuurID` = '".$id."'");
		$sth19->execute();
	}
}
if(isset($_POST["gereedMaken"]))
{

	$_SESSION["id"] = $_POST["medewerker"];

	$id = $_SESSION["id"];

	$sth18 = $pdo->prepare("SELECT `medewerkerNaam`
							FROM `medewerker`
							WHERE `medewerkerID` = '".$id."'");
	$sth18->execute();
	$qry18 = $sth18->fetch();	

	$naam = $qry18[0];

	$sth17 = $pdo->prepare("SELECT b.`factuurID`, b.`winkelID`, b.`gebruikersID`, b.`medewerkerID`, b.`afhaaltijd`, b.`afgehandeld`, b.`factuurDatum` 
							FROM `medewerker` a, `factuur` b 
							WHERE a.`medewerkerID` = '".$id."'");
	$sth17->execute();
	$qry17 = $sth17->fetchAll();

	if(count($qry17) == 0)
	{
		?>
			<h2 class="AddCart" style="width: 44%; padding: 1% 0% 3% 0%;">Er zijn geen bestellingen die klaargezet dienen te worden door <?php echo $naam; ?></h2>
		<?php 
	}
	else 
	{
	?>
	<h2 class="AddCart" style="width: 44%; padding: 1% 0% 3% 0%;">Dit zijn de bestellingen die door <?php echo $naam; ?> afgehandeld dienen te worden!</h2>
<form method="post" action="">
	<table>
	<tr>
		<th style="visibility: hidden;">Afgehandeld</th>
		<th>FactuurID</th>
		<th>winkelID</th>
		<th>gebruikersID</th>
		<th>medewerkerID</th>
		<th>afhaaltijd</th>
		<th>afgehandeld</th>
		<th>Datum</th>
	</tr>
	<?php 
	foreach($qry17 as $factuur)
	{
		$factuurID		= $factuur[0];
		$winkelID		= $factuur[1];
		$gebruikersID	= $factuur[2];
		$medewerkerID	= $factuur[3];
		$afhaaltijd 	= $factuur[4];
		$afgehandeld	= $factuur[5];
		$factuurDatum	= $factuur[6];

		if($afgehandeld == 1){

		}else{
		
		echo "<tr><td><input type='checkbox' name='afgehandeld[]' value='$factuurID'></td>";
		echo "<td>".$factuurID."</td>";
		echo "<td>".$winkelID."</td>";
		echo "<td>".$gebruikersID."</td>";
		echo "<td>".$medewerkerID."</td>";
		echo "<td>".$afhaaltijd."</td>";
		echo "<td>".$afgehandeld."</td>";
		echo "<td>".$factuurDatum."</td></tr>";
	}}?>
	</table>
	<table>
		<tr>
			<td colspan="2">
				<input style="margin-left: 10%; margin-top: 3%;" type="submit" name="submit" value="afgehandeld">
			</td> 
		</tr>
	</table>
</form>

	<?php
}
}
else
{
?>
<div class="content">
<h2 class="AddCart" style="width: 65%; padding-top: 3%;">Kies de gebruiker waarvan de bestellingen weergegeven dienen te worden</h2>
<form method="post" action="overview.php">
<table>
<tr>
<td><p>Laat de bestellingen zien die 
<select name="gebruiker">
<?php 
$sth15 = $pdo->prepare("SELECT `gebruikersID`, `gebruikersNaam` FROM `gebruikers`");
$sth15->execute();
$qry15 = $sth15->fetchAll();

foreach ($qry15 as $gebruiker) 
{

$gebruikersID = $gebruiker[0];
$gebruikersNaam = $gebruiker[1];

echo "<option value='$gebruikersID'>$gebruikersNaam</option>";
}
?>
</select> geplaatst heeft</p>
</tr>
<tr>
<td><?php echo "<button style='width: 150px; margin-left: 43%; margin-top: 3%;' type='submit' name='bestellingen'>Bekijken</button>";?></td>
</tr>
</table>
</form>
<h2 class="AddCart" style="text-align: center; width: 945px; padding-top: 8%;">Bestellingen toekennen aan medewerker</h2>
<form method="post" action="">
<table style="text-align: center;">
<tr>
<th style="visibility: hidden;">hidden</th>
<th>FactuurID</th>
<th>WinkelID</th>
<th>GebruikersID</th>
<th>MedewerkerID</th>
<th>Afhaaltijd</th>
<th>Afgehandeld</th>
<th>factuurDatum</th>
</tr>
<?php
$sth18 = $pdo->prepare("SELECT * FROM `factuur` WHERE `medewerkerID` = 0");
$sth18->execute();
$qry18 = $sth18->fetchAll();

foreach($qry18 as $factuur)
{
	echo "<tr><td><input type='checkbox' name='medewerker[]' value='$factuur[0]'></td>";
	echo "<td>".$factuur[0]."</td>";
	echo "<td>".$factuur[1]."</td>";
	echo "<td>".$factuur[2]."</td>";
	echo "<td>".$factuur[3]."</td>";
	echo "<td>".$factuur[4]."</td>";
	echo "<td>".$factuur[5]."</td>";
	echo "<td>".$factuur[6]."</td></tr>";
}
?>
</table>
<table style="width: 400px; margin-top: 2%;">
<tr>
<td><input type="submit" name="claimen" value="claimen"></td>
</tr>
</table>
</form>
<h2 class="AddCart" style="text-align: center; width: 945px; padding-top: 8%;">Bestelling claimen</h2>
<form method="post" action="">
<table style="text-align: center;">
<tr>
	<td>Bekijk welke bestellingen 
	<select name="medewerker">
		<?php 
		$sth16 = $pdo->prepare("SELECT `medewerkerID`, `medewerkerNaam` FROM `medewerker`");
		$sth16->execute();
		$qry16 = $sth16->fetchAll();

		foreach ($qry16 as $medewerker) 
		{
			$medewerkerID = $medewerker[0];
			$medewerkerNaam = $medewerker[1];

		echo "<option value='$medewerkerID'>$medewerkerNaam</option>";
		}
		?>
	</select> klaar moet zetten</td>
	</tr>
	<tr>
	<td><?php echo "<button style='width: 150px; margin-top: 3%;' type='submit' name='gereedMaken'>Bekijken</button>";?></td>
	</tr>
</tr>
</table>
</form>

</div>
<?php
}
require("footer.php");
?>
