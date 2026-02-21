<?php
	// Archivo para definir los iconos de los objetos en la mochila del PJ.
switch ($getRitualIcon) {
	default:
if ($bankObjectIcon[$bankSlot2] == "") {
	switch ($bankObjectType[$bankSlot2]) {
		// Objetos varios
		case "Libro":				$bankItemIcon = "icon_canon"; break;
		case "Viaje":				$bankItemIcon = "icon_bank_travel"; break;
		case "Utensilio":			$bankItemIcon = "icon_bank_implement"; break;
		// Consumibles
		case "Poción":				$bankItemIcon = "icon_potion"; break;
		case "Elixir":				$bankItemIcon = "icon_bank_elixir"; break;
		case "Alquimia":			$bankItemIcon = "icon_bank_alchemy"; break;
		// Armamento
		// Hojas pesadas
		case "Hoja pesada":
		case "Espada larga":		
			$bankItemIcon = "icon_bank_heavyblade"; 
		break;
		// Hojas ligeras
		case "Hoja ligera":
		case "Daga":		
			$bankItemIcon = "icon_bank_lightblade"; 
		break;
		// Martillos
		case "Martillo":	
		case "Martillo de guerra":		
			$bankItemIcon = "icon_bank_warhammer"; 
		break;
		// Mangual
		case "Mangual":		
			$bankItemIcon = "icon_bank_flail"; 
		break;
		// Arcos
		case "Arco":		
			$bankItemIcon = "icon_bank_bow"; 
		break;
		// Armaduras ligeras
		case "Tela": 
		case "Armadura de tela": 
			$bankItemIcon = "icon_bank_armor_cloth"; 
		break;
		case "Cuero":				$bankItemIcon = "icon_armor"; break;
		case "Pieles":				$bankItemIcon = "icon_bank_armor_hide"; break;
		// Armaduras pesadas
		case "Mallas": 
		case "Cota de mallas": 
			$bankItemIcon = "icon_bank_armor_mail"; 
		break;
		case "Escamas":				$bankItemIcon = "icon_bank_armor_scale"; break;
		case "Completa":			$bankItemIcon = "icon_bank_armor_plate"; break;
		// Escudos
		case "Escudo":				$bankItemIcon = "icon_bank_shield"; break;
		// Utensilios
		case "Cetro": 				$bankItemIcon = "icon_bank_scepter"; break;
		case "Orbe": 				$bankItemIcon = "icon_bank_orb"; break;
		case "Varita": 				$bankItemIcon = "icon_bank_wand"; break;
		case "Símbolo sagrado":		$bankItemIcon = "icon_deity"; break;
		// Accesorios
		case "Amuleto": 			$bankItemIcon = "icon_bank_amulet"; break;
		// Objetos maravillosos
		case "Objeto maravilloso":	$bankItemIcon = "icon_wonder"; break;
		// Por defecto [!]
		default: 					$bankItemIcon = "icon_item"; break;
	}
} else {
	$bankItemIcon = $bankObjectIcon[$bankSlot2];
}
	break;
	case TRUE:
		switch($ritualCategory) {
			default: 					$ritualCategoryIcon = "icon_alchemy"; 	 break;
			case "Adivinación":			$ritualCategoryIcon = "icon_ritual_adi"; break;
			case "Creación":	 		$ritualCategoryIcon = "icon_ritual_cre"; break;
			case "Exploración": 		$ritualCategoryIcon = "icon_ritual_exp"; break;
			case "Engaño": 				$ritualCategoryIcon = "icon_ritual_dec"; break;
			case "Protección":			$ritualCategoryIcon = "icon_ritual_war"; break;
			case "Viaje":				$ritualCategoryIcon = "icon_ritual_tra"; break;
			case "Restablecimiento":	$ritualCategoryIcon = "icon_ritual_res"; break;
		}
	break;
}
?>