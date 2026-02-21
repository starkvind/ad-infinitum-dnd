<?php
	// INICIO RECOLECCION DATOS
	// ================================================================== //
	$idGetData = $powerId; // Cogemos datos de la variable powerID
	$orderData ="SELECT * FROM ".$dydTableItems." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Objeto en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Objeto
			$thingName 	 	 = $dataResult["name"]; 		// Nombre del Objeto.
			// ---------------------------- >
			$thingArmor		 = $dataResult["armor"];		// CA que da si es Armadura.
			$thingMinBonus	 = $dataResult["minbonus"];		// Bonificador mínimo de CA si es Armadura.
			$thingSkill		 = $dataResult["skill"];		// Penalizador a las pruebas de habilidad si es Armadura.
			$thingSpeed		 = $dataResult["speed"];		// Penalizador a la velocidad si es Armadura.
			// ---------------------------- >
			$thingComp		 = $dataResult["comp"];			// Bonificador de competencia si es Arma.
			$thingDice		 = $dataResult["dice"];			// Dado de daño si es Arma.
			$thingReach		 = $dataResult["reach"];		// Alcance si es Arma.
			// ---------------------------- >
			$thingHand		 = $dataResult["hand"];			// A una mano, dos manos o ambas si es Arma.
			$thingType		 = $dataResult["type"];			// Tipo del Objeto.
			$thingBdType	 = $dataResult["bd_type"];		// Tipo del Objeto para la BDD.
			$thingThingtype	 = $dataResult["thingtype"];	// Segunda clasificación del Objeto.
			// ---------------------------- >
			$thingProperties = $dataResult["properties"];	// Propiedades del objeto.
			$thingValue		 = $dataResult["price"];		// Valor del Objeto.
			$thingWeight	 = $dataResult["weight"];		// Peso del Objeto.
			$thingInfotext	 = $dataResult["infotext"];		// Información del Objeto.
			$thingIcon	 	 = $dataResult["icon"];			// Icono del Objeto.
			$thingPicture	 = $dataResult["picture"];		// Imagen del Objeto.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		if ($originCanon != 0) {
		// Preparacion de los datos de la Tarjeta
		// -------- >
		// Color del titulo de la Tarjeta
		$titleBackground = "#56242a";
		// Especificar tipo de manos
		if ($thingBdType == 1) {
			switch($thingHand) {
				case 1:
					$thingHands = "a una mano";
				break;
				case 2:
					$thingHands = "a dos manos";
				break;
				case 3:
					$thingHands = "doble";
				break;
			}
		} else {
			$thingHands = "";
		}
		// Especificar calidad del arma y tipo de arma
		$thingMelee = explode("Cuerpo a cuerpo", $thingThingtype);
		if ($thingMelee[1] != "") { 
			$thingMelRan = "Cuerpo a cuerpo";
			$thingQuality = $thingMelee[1]; 
		}
		$thingRanged = explode("A distancia", $thingThingtype);
		if ($thingRanged[1] != "") { 
			$thingMelRan = "A distancia";
			$thingQuality = $thingRanged[1]; 
		}
		// Denominar tipo de Tarjeta
		switch($thingBdType) {
			case 0:
				$thingTitle = "Objeto";
			break;
			case 1:
				$thingTitle = "Arma";
			break;
			case 2:
				$thingTitle = "Armadura";
				// Colocar tipo de Armadura (Ligera y Pesada)
				$thingQuality = strtolower($thingThingtype);
			break;
		}
		// Quitar el escudo del tema de Armadura
		if ($thingQuality == "escudo") { $thingQuality = ""; }
		// Añadir . al precio
		$digitsItemValue = strlen($thingValue);
		//echo "El precio tiene $valueTest numeros.";
		switch($digitsItemValue) {
			default:
				$newItemValue = $thingValue;
			break;
			case 4:
				$newItemValue = substr($thingValue, 0, -3).".".substr($thingValue, 1);
			break;
			case 5:
				$newItemValue = substr($thingValue, 0, -3).".".substr($thingValue, 2);
			break;
			case 6:
				$newItemValue = substr($thingValue, 0, -3).".".substr($thingValue, 3);
			break;
		}
		// Comprobar las monedas 
		$thingPriceTitle = "Valor en piezas de oro";
		if ($thingBdType == 0) {
			switch($thingHand) {
				case 3:
					$thingPriceCoin = "_silver";
					$thingPriceTitle = "Valor en piezas de plata";
				break;
				case 4:
					$thingPriceCoin = "_copper";
					$thingPriceTitle = "Valor en piezas de cobre";
				break;
			}
		}
		// Dar un tipo generico si no tiene nada.
		if ($thingType == "") { $thingType = "Equipo aventurero"; }
	// ================================================================== //
	// FIN RECOLECCION DATOS
?>
<!-- INICIO DE TARJETA -->
	<div id="powerCard">
		<!-- Título del Objeto -->
		<div class="cardTitle" style="background:<?php echo $titleBackground; ?>;">
			<div class="cardTitleName">
				<?php
					if ($thingIcon != "") {
					//	echo "<img src='".$dydIconDirectory.$thingIcon.$dydIconExtension."' class='equipmentIcon' />";
					}
				?>
				<?php echo $thingName; ?>
			</div>
			<div class="cardTitleClass" style="font-weight: normal;">
				<?php echo $thingTitle." ".$thingHands." ".$thingQuality; ?>
			</div> 
		</div>
		<!-- Tipo y Precio  del Objeto -->
		<div class="cardTypes">
			<div class="cardTypesItem" style="margin-top: 2px;">
				<?php if ($thingMelRan != "") { ?> <span title="<?php echo $thingMelRan; ?>"> <?php } ?>
				<?php echo $thingType; ?>
				<?php if ($thingMelRan != "") { ?> </span> <?php } ?>
			</div>
			<!-- Si tiene valor, se lo ponemos en PO -->
			<?php if ($thingValue != 0) { ?>
				<div class="cardTypesValue" style="margin-top: 2px;">
					<?php echo $newItemValue; ?> 
					<img class="goldIcon" src="<?php echo $pageRoot; ?>media/icon/coin<?php echo $thingPriceCoin; ?>.png" title="<?php echo $thingPriceTitle; ?>"/>
				</div>
			<?php } ?>
			<!-- Fin Valor del objeto -->
		</div>
		<!-- Detalles de Armadura del Objeto -->
		<div class="cardTypes">
			<div class="cardTypesItem" style="font-weight:normal; width:400px;">
			<?php 
				switch($thingBdType) {
					// Armas
					case 1:
			?>
				<b>Competencia:</b> +<?php echo $thingComp; ?>
				<span style="margin-left: 8px;"><b>Dado de daño:</b> <?php echo $thingDice; ?></span>
				<?php if ($thingReach != "-") { ?><span style="margin-left: 8px;"><b>Alcance:</b> <?php echo $thingReach; ?></span><?php } ?>
			<?php
					break;
					// Armaduras
					case 2:
			?>
				<b>CA:</b> +<?php echo $thingArmor; ?>
				<span style="margin-left: 8px;"><b>Mejora mínima:</b> +<?php echo $thingMinBonus; ?></span>
				<?php if ($thingSkill != 0) { ?><span style="margin-left: 8px;"><b>Pruebas:</b> <?php echo $thingSkill; ?></span><?php } ?>
				<?php if ($thingSpeed != 0) { ?><span style="margin-left: 8px;"><b>Velocidad:</b> <?php echo $thingSpeed; ?></span><?php } ?>			
			<?php
					break;
					// Resto de objetos
					default:
			?>
				<b>Objeto mundano</b>
			<?php break; } ?>
			</div>
		<!-- Peso del objeto --->
			<div class="cardTypesValue" style="width:60px;">
				<?php echo $thingWeight; ?> 
				<img class="goldIcon" src="<?php echo $pageRoot; ?>media/icon/weight.png" title="Peso en lb."/>
			</div>
		</div>
		<!-- Propiedades del Objeto -->
		<?php if ($thingProperties != "") { ?>
			<div class="cardItemProperty" style="background-color: #000055"><b>Propiedades:</b> <?php echo $thingProperties; ?></div>
		<?php } ?>
		<!-- Texto especial del Objeto -->
		<?php if ($thingInfotext != "") { ?>
			<div class="cardText"><b>Detalles:</b> <?php echo $thingInfotext; ?></div>
		<?php } ?>
		<!-- Fin secciones -->
		<!-- DIV final para añadir el borde de abajo -->
		<div style="border-bottom: 1px solid #003366;"></div>
	</div>
<!-- FIN DE TARJETA -->
	<?php } else {
		echo "<div class='errorImg'>".$phraseNoAuth."</div>";
	}
} ?>
