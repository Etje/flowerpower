									<?php
										$sql = $pdo->prepare("SELECT * FROM `producten`");
										$sql->execute();
										$sth1 = $sql->fetchAll();

									?>
									<p class="text">Maak een keuze, en klik op het bloemstuk wat u graag wilt bestellen!</p>
										<form method="post" action="order.php">
												<section id="services">
											        <div class="container">
											            <div class="row">
											            	<?php
																foreach($sth1 as $try)
																	{
																		$id = $try[0];
																		$productnaam = $try[1];
																		$productcategorie = $try[2];
																		$productafbeelding = $try[3];
																		$prijs = $try[4];?>

										                    <div class="col-sm-3 col-lg-3 col-md-3">
											                        <div class="thumbnail">
											                            <?php echo "<img src='./images/".$productafbeelding."' alt='images' class='images'><br />";?>
											                            <div class="caption">
											                                <h4 class="pull-right"><?php echo "Prijs: &#8364; ".$prijs.",-";?></h4>
											                                <input type="hidden" name="bloem[]"><?php echo $productnaam; ?>
											                            </div>
										                        	<input type="submit" name="submit" value="bestel">
											                    </div>
										                    </div>
										                    <?php
															}
															?>
											            </div>
											        </div>
										    	</section>
										</form>
