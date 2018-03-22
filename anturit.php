<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />
<title>Centria sää</title>
<link rel="stylesheet" type="text/css" href="style_2.css">

</head>

<body>



  <header class="auto-style1"><a href="index.html">
	  <img src="lumikuva.jpg" alt="yla_tunniste" height="228" width="1000" /></a></header>
  
<div id="wrap">

<nav>
  
  <ul>
	<li><img src="amk_paalogo_fi_saa.jpg" alt="yla_tunniste" height="42" width="178" /><li>
    	<li><a href="index.php">Etusivu</a></li>
    	<li><a href="saa_historia.php">Säähistoria</a></li>
    	<li><a href="anturit.php">Anturit</a></li>
	<li><a href="../sivut/index.html">Centrian infosivu</a></li>


<li></li>
    </ul>

    </nav> 
  
 <div id="ylapyoristys">
 <section id="kokosivu">
 <p >

<?php
	// lisätään yhteys -skripti
		include 'yhteys.php';
		
			// Haetaan kaikki tiedot SaaAsema -taulusta
		$vastaus = mysql_query("SELECT * FROM SaaAsema ORDER BY MittausID DESC LIMIT 1") or die(mysql_error());
		
		// Tulostetaan tiedot
		echo "<h1>Anturit</h1><br>";
		echo "<table border='1'>";
		echo "<tr><th>Päiväys</th><th>Paine</th><th>Lämpötila</th><th>Varjolämpö</th><th>Valoisuus</th><th>Kosteus</th><th>Sademäärä</th><th>Suunta</th><th>Nopeus</th><th>Puuska</th><th>Akku</th></tr>";

		// jatketaan seuraavaa, kunnes kaikki tiedot luettu tietokannasta
		while($rivi = mysql_fetch_array( $vastaus )) {
			// tulostetaan yhden rivin tiedot
			echo "<tr><td>";
			$date=new DateTime($rivi['Paivays']);
			echo $date->format('d.m.Y G:m');
			// echo $rivi['Paivays'];
			echo "</td><td>";
			// Paine tietokannassa mmHg -> muutetaan hPa
			echo floor(($rivi['Paine'])*1.3332239);
			echo " hPa</td><td>";
			echo $rivi['Lampotila'];
			echo " °C</td><td>";
			echo $rivi['Lampotila2'];
			echo " °C</td><td>";
			echo $rivi['Valoisuus'];
			echo " W/m<sup>2</sup></td><td>";
			echo $rivi['Kosteus'];
			echo " %</td><td>";
			echo $rivi['Sademaara'];
			echo " mm/vrk</td><td>";
			echo $rivi['Suunta'];
			echo "°</td><td>";
			// Nopeus tietokannassa km/h
			echo (floor($rivi['Nopeus']*10 / 3.6)) / 10;
			echo " m/s</td><td>";
			// Puuska tietokannassa km/h
			echo (floor($rivi['Puuska']*10 / 3.6)) / 10;
			echo " m/s</td><td>";
			echo $rivi['Akku'];
			echo " %</td></tr>";
		}
		echo "</table>";
			

?>

<br>
 </p>
	 </section>
	 
  </div>
	  
</div>
<div id="footer"></div>

</body>
</html>
