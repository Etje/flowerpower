<?php	

/*Functie voor het verwijderen van items uit de shoppingcart*/

function removeElementWithValue($array, $key, $value){
     foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
               unset($array[$subKey]);
          }
     }
     return $array;
}

require("header.php");
$pdo = ConnectToDatabase();
if(!isset($_SESSION["username"])){echo '<script>window.location="loginWarning.php"</script>';}
else 
{
?>
<div class="AddCart">
<?php

/*Wanneer er op een knop gedrukt word, worden er sessies aangemaakt met waardes die opgehaald worden via een post*/

if(isset($_POST["add_to_cart"]))
{
	if(!isset($_SESSION["tijd"])){

	$_SESSION["date"] 	 	= date("d-m-Y");
	$_SESSION["tijd"] 	 	= $_POST["tijd"];
	$_SESSION["locatie"] 	= $_POST["locatie"]; 

	} else {}
}

/*Als bepaalde condities niet zo zijn word een string getoont, anders word de inhoud van het winkelwagentje getoont*/

if(!isset($_SESSION["productID"]) && empty($_SESSION["cart"]))
{
	echo "Op dit moment is je winkelwagentje leeg";
	unset($_SESSION["medewerker"]);
}
else
{
?>
<h1>Winkelwagentje</h1>
</div>
<?php
	if(isset($_SESSION['productnr'])){
		$productID 		= $_SESSION["productnr"];
		$_SESSION["cart"][] = array('id'=>$productID, 'hoeveelheid'=> $_SESSION["hoeveelheid"]);

		unset($_SESSION["productID"]);
		unset($_SESSION["productnr"]);
		unset($_SESSION["hoeveelheid"]);
	}

/*Als het winkelwagentje niet leeg is word een bepaalde string getoont*/

	if(!empty($_SESSION["cart"]))
	{
		echo "<a href='assortiment.php' style='font-weight: bold; text-align: center; display: block; margin-top: 1%;'>Verder winkelen</a>";
	}
	
	$total = 0;
	$i = -1;
	foreach($_SESSION["cart"] as $product)
	{
		$i++;

		$productID = $product['id'];
		$hoeveelheid = $product['hoeveelheid'];

		$shoppingCart = $_SESSION['cart'];

		
			if(isset($_POST["edit"]))
			{
				$hoeveelheid = $_POST["aangepasteHoeveelheid"];

				foreach($shoppingCart as $subKey => $subArray){
			          if($subArray['id'] == $_POST['pid']){
			               //unset($shoppingCart[$subKey]);
			          	$blah = $subKey;
			          }
			     }

				$shoppingCart[$blah]['hoeveelheid'] = $hoeveelheid;

				$_SESSION['cart'] = $shoppingCart;

				header('Refresh: 0;');
				exit;
			}
			else {
				//$hoeveelheid = $product['hoeveelheid'];
			}
		
		if(isset($_GET["productNummer"]))
			{
				$id = $_GET["productNummer"];
				$shoppingCart = removeElementWithValue($shoppingCart, "id", $id);

				$_SESSION['cart'] = $shoppingCart;

				header('Location: winkelwagentje.php');
				exit;

			}


		$sql = $pdo->prepare("SELECT * FROM `producten` WHERE `productID` = '".$productID."'");
		$sql->execute();
		$sth1 = $sql->fetchAll();

		foreach($sth1 as $producten)
			{
				$productNummer = $producten[0];
				$productnaam = $producten[1];
				$productCategorie = $producten[2];
				$productVoorraad = $producten[3];
				$productAfbeelding = $producten[4];
				$productPrijsPerStuk = $producten[5];

				$btw = 1.21;
				$prijsExclBTW = $hoeveelheid * $productPrijsPerStuk;
				$test = $prijsExclBTW / 121;
				$test1 = $test * 21;

				$btwBedrag = number_format($test1, 2);

				$total += $prijsExclBTW;

				/*Hieronder staan de formulieren die de klant dient in te vullen*/
				
				?>
<form method="post" action="edit.php">
	<table class="cartTable">
		<tr>
			<td style="width:50%;">Naam: </td>
			<td><?php echo $productnaam;?></td>
		</tr>
		<tr>
			<td>categorie: </td>
			<td><?php echo $productCategorie;?></td>
		</tr>
		<tr>
			<td>hoeveelheid: </td>
			<td><?php echo "<input type='hidden' name='hoeveelheid' value='$hoeveelheid'>".$hoeveelheid." exemplaren";?></td>
		</tr>
		<tr>
			<td>prijs per stuk: </td>
			<td><?php echo "&#8364; ".$productPrijsPerStuk.",-";?></td>
			<td>
				<div>
					<?php echo "<button type='submit' name='aanpassen' value='$productNummer'>Aanpassen</button><a style='position: relative; left: 40%;' href='winkelwagentje.php?productNummer=$productNummer'>verwijderen</a>"; ?>
				</div>
			</td>
		</tr>
	</table>
</form>
				<?php
			}
	}
	
	?>
	<table class="cartTable">
		<tr style="font-weight: bold; color: red;">
			<td style="width: 50%;">Totaal: </td>
			<td><?php echo "&#8364; ".$total.",-";?></td>
		</tr>
		<tr>
			<td style="width: 50%;">BTW: </td>
			<td><?php echo "&#8364; ".$btwBedrag.",-";?></td>
		</tr>
	</table>
	<table class="cartTable">
		<tr>
			<td style="width: 50%;">De locatie waar u dit wil ophalen is: </td>
			<td><?php echo $_SESSION["locatie"];?></td>
		</tr>
		<tr>
			<td style="width: 50%;">Tijd waarop: </td>
			<td><?php echo $_SESSION["tijd"];?></td>
		</tr>
		<tr>
			<td style="padding-top: 5%;"><a href="checkout.php" name="checkout" style="position: relative; left: 42%;">Uitchecken</a></td>
		</tr>
	</table>

			<?php
	}	
}
require("footer.php");
?>