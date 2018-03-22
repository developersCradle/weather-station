<?php
	//tällä scriptillä luodaan yhteys haluttuun tietokantaan
	mysql_connect("localhost", "******", "********") or die(mysql_error());

	// Valitaan tietokanta
	mysql_select_db("tietokannnanNIMI") or die(mysql_error());
?>