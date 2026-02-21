<?php
	// Preparamos las variables para la Línea Temporal
	switch($typItem) {
		case "friendship":
			$eventType = "Amistad";
			$eventTitle = "Amistades en Ylat";
		break;
		case "love":
			$eventType = "Romance";
			$eventTitle = "Romances en Ylat";
		break;
		case "birth":
			$eventType = "Nacimiento";
			$eventTitle = "Nacimientos en Ylat";
		break;
		case "travel":
			$eventType = "Viaje";
			$eventTitle = "Viajes en Ylat";
		break;
		case "treasure":
			$eventType = "Tesoro";
			$eventTitle = "Tesoros en Ylat";
		break;
		case "foundation":
			$eventType = "Fundación";
			$eventTitle = "Fundaciones en Ylat";
		break;
		case "event":
			$eventType = "Evento";
			$eventTitle = "Eventos en Ylat";
		break;
		case "enmity":
			$eventType = "Enemistad";
			$eventTitle = "Enemistades en Ylat";
		break;
		case "battle":
			$eventType = "Batalla";
			$eventTitle = "Batallas en Ylat";
		break;
		case "death":
			$eventType = "Fallecimiento";
			$eventTitle = "Fallecimientos en Ylat";
		break;
		default:
			$eventType = "";
			$eventTitle = "Línea temporal de Ylat";
		break;
	}
?>