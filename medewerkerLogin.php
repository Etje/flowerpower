<?php
require("header.php");
$pdo = ConnectToDatabase(); 
if(isset($_POST["medewerkerLogin"]))
{
	$gebruikersnaam = $_POST["naam"];
	$wachtwoord = $_POST["password"];
	if($gebruikersnaam&&$wachtwoord)
	{
		$stmt = $pdo->prepare("SELECT `medewerkerGebruikersnaam`, `accesslevel`, `medewerkerWachtwoord` FROM `medewerker` WHERE `medewerkerGebruikersnaam` = '".$gebruikersnaam."' && `medewerkerWachtwoord` = '".$wachtwoord."'");
		$stmt->execute();
		$sth1 = $stmt->fetchAll();

		foreach($sth1 as $key)
		{
			$dbgebruikersnaam = $key[0];
			$accesslevel = $key[1];
			$dbwachtwoord = $key[2];

			if($dbgebruikersnaam = $gebruikersnaam && $dbwachtwoord == $wachtwoord){
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
require("./form/medewerkerLoginForm.php");
?>
</div>
<?php
require("footer.php");
?>
