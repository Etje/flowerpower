<?php
session_start();
include 'functions.php';
?>
<html>
<head>
  <title>FlowerPower.nl</title>
  <link href="style.css" rel="stylesheet" type="text/css">
  <link href="bootstrap.css" rel="stylesheet" type="text/css">
  <link rel="icon" type="image/png" href="./images/favicon.ico" />
</head>
<body>
<div class="header">
<h1 class="title">FlowerPower</h1>
<?php if(isset($_SESSION['username'])){?><a href="logout.php" style="position: relative; bottom: 50%; right: 2%; float: right;"><p>Logout</p></a><?php } 
else {?>
<a href="medewerkerLogin.php" style="position: relative; bottom: 50%; right: 2%; float: right;"><p>Medewerker login</p></a><?php }?>
<?php if(isset($_SESSION['username'])){?><a href="logout.php" style="position: relative; bottom: 50%; right: 2%; float: right;"></a><?php } 
else {?>
<a href="klantLoginRegistreer.php" style="position: relative; bottom: 50%; left: 2%; float: left;"><p>Klant login</p></a><?php }?>
<ul class="menu" style="text-decoration: none; padding-left: 0;">
<ul class="menu" style="text-decoration: none; padding-left: 0;">
<li><a href="index.php">Home</a></li>
<li><a href="assortiment.php">Assortiment</a></li>
<?php if(isset($_SESSION['accesslevel']) && $_SESSION['accesslevel'] == 2){}else{?><li><a href="winkelwagentje.php">Mijn winkelwagentje</a></li><?php }?>
<li><a href="contact.php">Contact</a></li>
<?php if(isset($_SESSION['accesslevel']) && $_SESSION['accesslevel'] > 2){?><li><a href="beheer.php"><p>Beheer</p></a></li><?php } else {}?>
<?php if(isset($_SESSION['accesslevel']) && $_SESSION['accesslevel'] >= 2){?><li><a href="viewCustomer.php"><p>Overzicht</p></a></li><?php } else {} ?>
<?php if(isset($_SESSION['accesslevel']) && $_SESSION['accesslevel'] >= 1){?><li><a href="birthday.php"><p>Verjaardagen lijst</p></a></li><?php } else {} ?>
</ul>
</div>
<?php
if(!empty($_SESSION["cart"]) && !isset($_GET['deleteshoppingcart']))
{
	echo "<a href='clearCart.php?deleteshoppingcart=yes' style='text-align: center; display: block; margin: 1% 0% 1% 0%;'>Winkelwagentje legen</a>";
}
?>
<img src="./images/underline.png" alt="underline" height="25px" width="100%" class="underline">
