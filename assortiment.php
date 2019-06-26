<?php
require("header.php");
$pdo = ConnectToDatabase(); 
	/*De onderstaande code genereerd de producten die in de database staan*/
?>
<div class="content">
<?php
if(isset($_POST["view"]))
{
	if(empty($_POST["hoeveelheid"]))
	{
		echo "je dient eerst een hoeveelheid in te vullen";
	}
}
$sql = $pdo->prepare("SELECT * FROM `producten`");
$sql->execute();
$sth1 = $sql->fetchAll();
?>
<p class="text">Maak een keuze, en klik op het bloemstuk wat u graag wilt bestellen!</p>
	<section id="services">
        <div class="container">
            <div class="row">
            	<?php
					foreach($sth1 as $try)
						{?>
						<form method="post" action="detail.php" style="margin: 0;">
						<?php
							$id = $try[0];
							$productnaam = $try[1];
							$productcategorie = $try[2];
                            $productVoorraad = $try[3];
							$productafbeelding = $try[4];
							$prijs = $try[5];?>

		                    <div class="col-sm-3 col-lg-3 col-md-3">
			                        <div class="thumbnail">
			                            <?php echo "<img src='".$productafbeelding."' alt='images' class='images'>";?>  
			                            <div class="amount" name="amount">Aantal: <input type="number" name="hoeveelheid" required></div>
			                            <div class="caption">
			                                <h4 class="pull-right"><?php echo "&#8364; ".$prijs.",-";?></h4>
			                                <?php echo $productnaam; 					
			                                	echo "<input type='hidden' name='bloem' value='$productnaam'>";
			                                	echo "<input type='hidden' name='productnr' value='$id'>";
			                                	echo "<input type='hidden' name='prijs' value='$prijs'>";
			                                ?>					                            
			                            </div>
		                        	<input type="submit" name="view" value="bekijk">
			                    </div>
		                    </div>
		               	</form>
                    <?php
					}
					?>
            </div>
        </div>
	</section>
</div>
<?php
require("footer.php");
?>
