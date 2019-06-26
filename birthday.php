<?php
require('header.php');
$pdo = ConnectToDatabase();

$sql4 = $pdo->prepare("	SELECT `gebruikersNaam`, DATE_FORMAT(`gebruikersGeboortedatum`, '%d-%m-%Y')
						FROM  `gebruikers`
						WHERE  DATE_ADD(`gebruikersGeboortedatum`, 
                			   INTERVAL YEAR(CURDATE())-YEAR(`gebruikersGeboortedatum`)
                         	   + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(`gebruikersGeboortedatum`),1,0)YEAR)  
            			BETWEEN CURDATE() 
            			AND DATE_ADD(CURDATE(), INTERVAL 2 DAY)");
$sql4->execute();
$qry4 = $sql4->fetchAll();

if(empty($qry4)){
	echo "<p class='AddCart' style='text-align: center;'>Op dit moment zijn er geen klanten binnen 2 dagen jarig!</p>";
}
else {
	require('./form/birthdayForm.php');	
}

?>