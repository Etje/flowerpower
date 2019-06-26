<?php
require("header.php");
$pdo = ConnectToDatabase(); 
if(isset($_POST["toevoegen"]))
{

/*Wanneer er op een knop gedrukt word, gegevens ophalen en inserte in een datatable*/

	$productNaam 			= $_POST["productNaam"];
	$productCategorie 		= $_POST["productCategorie"];
	$productAfbeelding		= $_POST["productAfbeelding"];
	$productPrijsPerStuk	= $_POST["productPrijsPerStuk"];


	$addFlower = $pdo->prepare("INSERT INTO `producten`
											(productNaam,
					 						 productCategorie,
					 					 	 productAfbeelding,
					 					 	 productPrijsPerStuk
					 					 	 ) VALUES (	:productNaam,
						 								:productCategorie,
														:productAfbeelding,
														:productPrijsPerStuk)");
	$addFlower->execute(array(
		"productNaam" => $productNaam,
		"productCategorie" => $productCategorie,
		"productAfbeelding" => $productAfbeelding,
		"productPrijsPerStuk" => $productPrijsPerStuk
		));

/*Kijken of de insert goed gelukt is. zo ja, toon de waarde die tussen <p></p> staat*/

if($addFlower == true)
{
	echo "<p class='AddCart' style='color: #666666;'>De gegevens zijn succesvol aan de database toegevoegt</p>";
}
}

if(isset($_POST["productWijzigen"]))
{
	$id = $_POST["productWijzigen"];
	$aangepasteNaam = $_POST["aangepasteNaam"];
	$aangepasteCategorie = $_POST["aangepasteCategorie"];
	$aangepasteAfbeelding = $_POST["aangepasteAfbeelding"];
	$aangepastProductPrijsPerStuk = $_POST["aangepastProductPrijsPerStuk"];

	$update = $pdo->prepare("UPDATE `producten`
							 SET `productNaam` = :gebruikersnaam,
							 	 `productCategorie` = :productNaam,
							 	 `productAfbeelding` = :productAfbeelding,
							 	 `productPrijsPerStuk` = :prijs
							 WHERE `productID` = :id");

	$update->bindValue(":gebruikersnaam", $aangepasteNaam);
	$update->bindValue(":productNaam", $aangepasteCategorie);
	$update->bindValue(":productAfbeelding", $aangepasteAfbeelding);
	$update->bindValue(":prijs", $aangepastProductPrijsPerStuk);
	$update->bindValue(":id", $id);

	$medewerkerUpdate = $update->execute();

	if($medewerkerUpdate)
	{
		echo "<p class='AddCart' style='color: #666666;'>Product is succesvol geupdate</p>";
	}
}

if(isset($_POST["productVerwijderen"]))
{
	$id = $_POST["productVerwijderen"];

	$sql1 = $pdo->prepare("SELECT `productID` FROM `factuur_regel`");
	$sql1->execute();
	$sth4 = $sql1->fetch();

	$y = $sth4[0];

	if($id == $y)
	{
		echo "<p class='AddCart'>gegevens kunnen nog niet verwijderd worden</p>";
	}
	else {

		$sql = $pdo->prepare("DELETE FROM `producten` WHERE `productID` = '".$id."'");

	    $verwijderData = $sql->execute();

	    if($verwijderData)
	    {
	    	echo "<p class='AddCart' style='color: #666666;'>Gegegevens zijn succesvol verwijderd</p>";
	    }
	}
}

/*De aangepaste gegevens ophalen, en ik de datatable verwerken als 'n update querie*/

if(isset($_POST["klantWijzigen"]))
{
	$id = $_POST["klantWijzigen"];
	$aangepasteGebruikersNaam = $_POST["aangepasteGebruikersNaam"];
	$aangepasteGebruikersAdres = $_POST["aangepasteGebruikersAdres"];
	$aangepasteGebruikersPostcode = $_POST["aangepasteGebruikersPostcode"];
	$aangepasteGebruikersWoonplaats = $_POST["aangepasteGebruikersWoonplaats"];
	$aangepastgebruikersTelefoon = $_POST["aangepastgebruikersTelefoon"];
	$aangepastegebruikersGeboortedatum = $_POST["aangepastegebruikersGeboortedatum"];
	$aangepasteGebruikersEmail = $_POST["aangepasteGebruikersEmail"];
	$aangepastAccesslevel = $_POST["aangepastAccesslevel"];
	$gebruikersGebruikersnaam = $_POST["gebruikersGebruikersnaam"];
	$gebruikersWachtwoord = $_POST["gebruikersWachtwoord"];

	$update = $pdo->prepare("UPDATE `gebruikers`
							 SET `gebruikersNaam` = :gebruikersNaam,
							 	 `gebruikersAdres` = :gebruikersAdres,
							 	 `gebruikersPostcode` = :gebruikersPostcode,
							 	 `gebruikersWoonplaats` = :gebruikersWoonplaats,
							 	 `gebruikersTelefoon` = :gebruikersTelefoon,
							 	 `gebruikersGeboortedatum` = :gebruikersGeboortedatum,
							 	 `gebruikersEmail` = :gebruikersEmail,
							 	 `accesslevel` = :accesslevel,
							 	 `gebruikersGebruikersnaam` = :gebruikersGebruikersnaam,
							 	 `gebruikersWachtwoord` = :gebruikersWachtwoord
							 WHERE `gebruikersID` = :id");

	$update->bindValue(":gebruikersNaam", $aangepasteGebruikersNaam);
	$update->bindValue(":gebruikersAdres", $aangepasteGebruikersAdres);
	$update->bindValue(":gebruikersPostcode", $aangepasteGebruikersPostcode);
	$update->bindValue(":gebruikersWoonplaats", $aangepasteGebruikersWoonplaats);
	$update->bindValue(":gebruikersTelefoon", $aangepastgebruikersTelefoon);
	$update->bindValue(":gebruikersGeboortedatum", $aangepastegebruikersGeboortedatum);
	$update->bindValue(":gebruikersEmail", $aangepasteGebruikersEmail);
	$update->bindValue(":accesslevel", $aangepastAccesslevel);
	$update->bindValue(":gebruikersGebruikersnaam", $gebruikersGebruikersnaam);
	$update->bindValue(":gebruikersWachtwoord", $gebruikersWachtwoord);
	$update->bindValue(":id", $id);

	$klantUpdate = $update->execute();

	if($klantUpdate)
	{
		echo "<p class='AddCart' style='color: #666666; width: 19%;'>Klant is succesvol geupdate</p>";
	}
}

 /*Wanneer er op een knop gedrukt word, worden er gegevens uit de database verwijderd*/

if(isset($_POST["klantVerwijderen"]))
{
	$id = $_POST["klantVerwijderen"];
	$sql = $pdo->prepare("DELETE FROM `gebruikers` WHERE `gebruikersID` = '".$id."'");

    $verwijderKlant = $sql->execute();

    if($verwijderKlant)
    {
    	echo "<p class='AddCart' style='color: #666666; width: 19%;'>Klant is succesvol verwijderd</p>";
    }
}

if(isset($_POST["MedewerkerVerwijderen"]))
{
	$id = $_POST["MedewerkerVerwijderen"];
	$sql = $pdo->prepare("DELETE FROM `medewerker` WHERE `medewerkerID` = '".$id."'");

    $verwijderData = $sql->execute();

    if($verwijderData)
    {
    	echo "<p class='AddCart' style='color: #666666;'>Medewerker is succesvol verwijderd</p>";
    }
}

if(isset($_POST["AddMedewerker"]))
{
	$medewerkerNaam 			= $_POST["medewerkerNaam"];
	$medewerkerGebruikersnaam	= $_POST["medewerkerGebruikersnaam"];
	$medewerkerWachtwoord		= $_POST["medewerkerWachtwoord"];
	$medewerkerAccesslevel		= $_POST["accesslevel"];


	$sql = $pdo->prepare("INSERT INTO `medewerker`
											(medewerkerNaam,
					 						 medewerkerGebruikersnaam,
					 					 	 medewerkerWachtwoord,
					 					 	 accesslevel
					 					 	 ) VALUES (	:medewerkerNaam,
						 								:medewerkerGebruikersnaam,
														:medewerkerWachtwoord,
														:accesslevel)");
	$sql->execute(array(
		"medewerkerNaam" => $medewerkerNaam,
		"medewerkerGebruikersnaam" => $medewerkerGebruikersnaam,
		"medewerkerWachtwoord" => $medewerkerWachtwoord,
		"accesslevel" => $medewerkerAccesslevel
		));

if($sql == true)
{
	echo "<p class='AddCart' style='color: #666666;'>De gegevens zijn succesvol aan de database toegevoegdt</p>";
}
}
require("./form/bloemenToevoegForm.php");
if(isset($_SESSION['accesslevel']) && $_SESSION['accesslevel'] > 2){
require("./form/medewerkerToevoegForm.php");
}
require("./form/viewMedewerkers.php");
if(isset($_SESSION['accesslevel']) && $_SESSION['accesslevel'] > 2){
require("./form/editMedewerker.php");
}
require("./form/editCartForm.php");
require("./form/viewOrders.php");
require("footer.php");
?>