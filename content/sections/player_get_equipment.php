<?php
// Comprobamos el equipo del personaje para obtener sus datos y enlaces.
	$equipmentQuery = "SELECT * FROM ".$dydTablePlayerEquip." WHERE player_url LIKE '".$playerURL."' LIMIT 1;"; // Elegimos el Equipamiento en la Base de Datos.
	$equipmentOrder = mysql_query($equipmentQuery, $link);
	$equipmentRows 	= mysql_num_rows($equipmentOrder);
// Preparamos el ARRAY de contenidos para los slots del equipo.
	$equipmentSlotArray = [
   2 => "WEAPON",		// Arma principal
		"SECONDARY",	// Arma secundaria (en cinto, etc.)
		"OFFHAND",		// Objeto en mano torpe (escudo, flechas, arma secundaria)
		"IMPLEMENT",	// Utensilio
		"HEAD",			// Casco / Sombrero
		"BODY",			// Armadura
		"BACK",			// Capa
		"WAIST",		// CinturÃ³n
		"ARMS",			// Brazales
		"HAND",			// Guantes
		"FEET",			// Calzado
		"TATOO",		// Tatuaje
		"NECK",			// Amuleto
		"RING1",		// Anillo 1
		"RING2",		// Anillo 2
		"REWARD"		// Recompensa de aventura (TÃ©cnica secreta, conjuro familiar, etc.)
	];
	$equipSlots = count($equipmentSlotArray)+2; // Le sumamos 2 mÃ¡s para dejar fuera del array el ID del inventario y la URL del personaje.
// Vamos mostrando los datos.
	if ($equipmentRows != "") {
		$playerInventory = TRUE;
		// ------------------------------------------------------------------------------ >
		$equipmentDataFetch = mysql_fetch_array($equipmentOrder);						// Empezamos a recolectar los datos.
		$playerBank			= str_replace("\r\n", "", $equipmentDataFetch["bank"]);		// Banco del Personaje (mochila).
		$playerRituals		= str_replace("\r\n", "", $equipmentDataFetch["rituals"]);	// Rituales del Personaje.
		// ------------------------------------------------------------------------------ >
		// EQUIPO PRINCIPAL DEL PERSONAJE
		// ------------------------------------------------------------------------------ >
		for($equipCT=2;$equipCT<$equipSlots;$equipCT++) {
			$equipSlotName 	= $equipmentSlotArray[$equipCT];	// Preparamos el nombre de la ranura de equipo (Arma, Cabeza, etc.)
			$equipSlotCheck = $equipmentDataFetch[$equipCT];	// Preparamos la localizaciÃ³n de la pieza de equipo.
			$equipSlotCheck = explode(":", $equipSlotCheck);	// Rompemos la variable en 2: tipo de Objeto (M, I o ninguno) y la ID del objeto.
			// Comprobamos si estamos buscando un objeto comÃºn (I) o un objeto mÃ¡gico (M).
			switch($equipSlotCheck[0]) {
				// ================== //
				// Objeto mÃ¡gico	  //
				// ================== //
				case "M": 
					$retrieveFrom 	= "magic";					// Indicamos que vamos a buscar un Objeto mÃ¡gico.
					$dataListMagic 	= $equipSlotCheck[1];		// Preparamos la variable con la ID.
					include ("retrieve_origin.php");			// Llamamos a esta pieza de cÃ³digo.
					$equipName[$equipSlotName] 	= $magicName;	// Preparamos el nombre de la pieza de equipo.
					$equipBonus[$equipSlotName]	= $magicBonus;	// Y su bonificador.
					$equipLink[$equipSlotName] 	= $pageRoot.$dydSectionMagicItems[0]."/".$equipSlotCheck[1]."/";
				break;
				// ================== //
				// Objeto comÃºn		  //
				// ================== //
				case "I":
					$retrieveFrom 	= "thing";					// Indicamos que vamos a buscar un Objeto comÃºn.
					$dataListThing 	= $equipSlotCheck[1];		// Preparamos la variable con la ID.
					include ("retrieve_origin.php");			// Llamamos a esta pieza de cÃ³digo.
					$equipName[$equipSlotName] 	= $thingName;	// Preparamos el nombre de la pieza de equipo.
					$equipBonus[$equipSlotName] = "";			// Y su bonificador.
					$equipLink[$equipSlotName] 	= $pageRoot.$dydSectionItems[0]."/".$equipSlotCheck[1]."/";
				break;
				// ================== //
				// Texto			  //
				// ================== //
				default:
					$equipName[$equipSlotName] 	= $equipSlotCheck[0];	// Preparamos el nombre de la pieza de equipo (solo texto).
					$equipBonus[$equipSlotName] = "";					// Y su bonificador.
					$equipLink[$equipSlotName] 	= "";					
				break;
			}
			// Si estamos con objetos de Cuerpo o Mano torpe, guardamos el tipo.
			switch($equipSlotName) {
				case "BODY":
				case "OFFHAND":
					$equipArmor[$equipSlotName] = $armorType;
				break;
			}
			// Finalizamos la comprobaciÃ³n.
		}
		// ------------------------------------------------------------------------------ >
		// EQUIPO PRINCIPAL DEL PERSONAJE
		// ------------------------------------------------------------------------------ >
	}
?>