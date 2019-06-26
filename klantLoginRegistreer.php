<?php
require("header.php");
$pdo = ConnectToDatabase(); 
if(isset($_POST["registreer"])){

	/*gegevens die de klant heeft ingevuld worden opgehaald, en in de database verwerkt*/


	$naam 			= $_POST["naam"]; 
	$adres 			= $_POST["adres"]; 
	$postcode 		= $_POST["postcode"];
	$woonplaats		= $_POST["woonplaats"];  
	$telefoon		= $_POST["telefoon"];  
	$geboortedatum	= $_POST["geboortedatum"];  
	$email			= $_POST["email"];   
	$gebruikersnaam = $_POST["gebruikersnaam"]; 
	$wachtwoord 	= md5($_POST["wachtwoord"]); 

	$stmt = $pdo->prepare("SELECT `gebruikersNaam` FROM `gebruikers`");
	$stmt->execute();
	$sth1 = $stmt->fetch();

	$datebaseGebruikersnaam = $sth1[0];

	if($datebaseGebruikersnaam == $naam)
	{
		echo "<p class='succes'>de gebruiker bestaat al</p>";
	}
	else
	{

	$sql = $pdo->prepare("INSERT INTO `gebruikers`
											(gebruikersNaam,
											 gebruikersAdres,
					 						 gebruikersPostcode,
					 					 	 gebruikersWoonplaats,
					 					 	 gebruikersTelefoon,
					 					 	 gebruikersGeboortedatum,
					 					 	 gebruikersEmail,
					 					 	 gebruikersGebruikersnaam,
					 					 	 gebruikersWachtwoord
					 					 	 ) VALUES (	:gebruikersNaam,
					 					 	 			:gebruikersAdres,
						 								:gebruikersPostcode,
														:gebruikersWoonplaats,
														:gebruikersTelefoon,
														:gebruikersGeboortedatum,
														:gebruikersEmail,
														:gebruikersGebruikersnaam,
														:gebruikersWachtwoord)");
			$sql->execute(array(
				"gebruikersNaam" => $naam,
				"gebruikersAdres" => $adres,
				"gebruikersPostcode" => $postcode,
				"gebruikersWoonplaats" => $woonplaats,
				"gebruikersTelefoon" => $telefoon,
				"gebruikersGeboortedatum" => $geboortedatum,
				"gebruikersEmail" => $email,
				"gebruikersGebruikersnaam" => $gebruikersnaam,
				"gebruikersWachtwoord" => $wachtwoord
			));

		if($sql)
		{
			echo "<p class='succes'>Gegevens zijn succesvol toegevoegd</p>";
		}	
		else 
		{
			echo "er is iets mis gegaan tijdens het toevoegen van uw gegevens";
		}
	}
}

if(isset($_POST["login"]))
{
	/*Gegevens worden opgehaald, en ze word er gekeken op je bent ingelogd ofniet*/
	$gebruikersnaam = $_POST["naam"];
	$wachtwoord = $_POST["password"];
	if($gebruikersnaam&&$wachtwoord)
	{
		$password = md5($wachtwoord);
		$stmt = $pdo->prepare("SELECT `gebruikersGebruikersnaam`, `accesslevel`, `gebruikersWachtwoord` FROM `gebruikers` WHERE `gebruikersGebruikersnaam` = '".$gebruikersnaam."' && `gebruikersWachtwoord` = '".$password."'");
		$stmt->execute();
		$sth1 = $stmt->fetchAll();

		foreach($sth1 as $key)
		{
			$dbgebruikersnaam = $key[0];
			$accesslevel = $key[1];
			$dbwachtwoord = $key[2];

			if($dbgebruikersnaam = $gebruikersnaam && $dbwachtwoord == $password){
				$_SESSION["username"] = $gebruikersnaam; 
				$_SESSION["accesslevel"] = $accesslevel;
				echo "<p class='succes'>U bent succesvol ingelogd</p>";
				echo '<script>window.location="index.php"</script>';
			}
		}
	}
}
?>
<div class="content" style="padding-top: 3%;">
<?php 
require("./form/registerForm.php");
require("./form/loginForm.php");
?>
</div>
<?php
require("footer.php");
?>
