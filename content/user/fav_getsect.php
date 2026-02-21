<?php
	switch($checkSection) {
		case "news":
			$favSection = "Actualizaciones";
		break;
		case "actions":
			$favSection = "Acción";
		break;
		case "articles":
			$favSection = "Artículo";
		break;
		case "players":
			$favSection = "Personaje jugador";
		break;
		case "races":
			$favSection = "Raza";
		break;
		case "classes":
			$favSection = "Clase";
		break;
		case "builds":
			$favSection = "Diseño de clase";
		break;
		case "traits":
			$favSection = "Rasgos";
		break;
		case "backgrounds":
			$favSection = "Trasfondo";
		break;
		case "powers":
			$favSection = "Poder";
		break;
		case "feats":
			$favSection = "Dote";
		break;
		case "rituals":
			$favSection = "Ritual";
		break;
		case "instances":
			$favSection = "Aventura";
		break;
		case "items":
			$favSection = "Equipo";
		break;
		case "magic":
			$favSection = "Objeto mágico";
		break;
		case "vehicles":
			$favSection = "Vehículo";
		break;
		case "encounters":
			$favSection = "Encuentro";
		break;
		case "bestiary":
			$favSection = "Bestiario";
		break;
		case "creatures":
			$favSection = "Criatura";
		break;
		case "ailments":
			$favSection = "Aflicción";
		break;
		case "shops":
			$favSection = "Bazar";
		break;
		case "music":
			$favSection = "Banda sonora";
		break;
		case "locations":
			$favSection = "Lugar";
		break;
		case "timeline":
			$favSection = "Evento";
		break;
		default:
			$favSection = "Sección no definida";
		break;
	}
?>