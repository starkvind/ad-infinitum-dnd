<?php
	// Preparamos el atributo y le damos nombre y título.
	switch ($checkAttribute) {
		case "FUE":
			$attStat = 0;
			$attName = "Fuerza";
		break;
		case "CON":
			$attStat = 1;
			$attName = "Constitución";
		break;
		case "DES":
			$attStat = 2;
			$attName = "Destreza";
		break;
		case "INT":
			$attStat = 3;
			$attName = "Inteligencia";
		break;
		case "SAB":
			$attStat = 4;
			$attName = "Sabiduría";
		break;
		case "CAR":
			$attStat = 5;
			$attName = "Carisma";
		break;
	}
?>