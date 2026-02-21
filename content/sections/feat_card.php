<?php
	$featId = $featId ?? ($page ?? "");
	$powerInPlayer = $powerInPlayer ?? FALSE;
	$featSlot = isset($featSlot) ? (int)$featSlot : 0;
	$featSpecific = $featSpecific ?? "";
	$featLevelLearned = $featLevelLearned ?? "";
	$playerFeatLink = $playerFeatLink ?? "";
	$idGetData = $featId; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableFeats." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Objeto en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Objeto
			$featName 	 	 = $dataResult["name"]; 		// Nombre de la Dote.
			$featType		 = $dataResult["type"];			// Tipo de la Dote.
			$featClass		 = $dataResult["class"];		// Clase/raza/etc de la Dote.
			$featTier		 = $dataResult["tier"];			// Grado de la Dote.
			$featFlavor		 = $dataResult["flavortext"];	// Texto decorativo de la Dote.
			$featRequired	 = $dataResult["required"];		// Requisitos de la Dote.
			$featBonus		 = $dataResult["bonus"];		// Bonificación de la Dote.
			$featBDBonus	 = $dataResult["bd_bonus"];		// Bonificación de BD de la Dote.
			$featSpecial	 = $dataResult["special"];		// Característica especial de la Dote.
			$featPower		 = $dataResult["power"];		// Bonificación de la Dote.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
			$returnData 	 = $featType;
			$featType 		 = strtolower($featType);
		//	$featTier 		 = strtolower($featTier);
		// ================================================================== //
		if ($originCanon != 0) {
			// Añadir los niveles a los requisitos
			if ($featRequired != "") {
				$featComma = ", ";
			} else {
				$featComma = "";
			}
			// Preparamos las dotes de Parangón y Épicos
			switch($featTier) {
				default:
					$featRequired = $featRequired;
				break;
				case "Parangón":
					$featRequired = "nivel 11".$featComma.$featRequired;
				break;
				case "Épico":
					$featRequired = "nivel 21".$featComma.$featRequired;
				break;
			}
			// Color del titulo de la Tarjeta
			switch(ucfirst($featType)) {
				case "General":
					$titleBackground = "#006633";
					break;
				case "Racial":
					$titleBackground = "#660000";
					break;
				case "Clásea":
					$titleBackground = "#303030";
					break;
				default:
					$titleBackground = "#003333";
					break;
			}
			// Separador
			$powerBullet = "&#8224;";
			// Título de la Dote
			if ($featClass != "") {
				$textClassFeat = "Dote de ".$featClass;
			} else {
				$textClassFeat = "Dote";
			}
			if ($featSpecific != "") {
				$featName = $featName." <span style='font-weight:normal;'>- ".$featSpecific."</span>";
			}
		}	
	}
?>
<!-- INICIO DE TARJETA -->
	<div id="powerCard" <?php if ($powerInPlayer == TRUE) { ?>class="playerPower" style="<?php if ($featSlot % 2 == 1) {?>margin-left:16px;<?php }?>"<?php } ?>>
		<!-- Cierre del poder si estamos en ficha jugador -->
		<?php if ($powerInPlayer == TRUE) { ?>
			<a href="#feat" onclick="show_power('feat<?php echo $featId;?>');">
		<?php } ?>
		<!-- Título de la Dote -->
		<div class="cardTitle" style="background:<?php echo $titleBackground; ?>;">
			<div class="cardTitleName"><?php echo $featName; ?></div>
			<div class="cardTitleClass"><?php echo $textClassFeat; ?></div> 
		</div>
		<!-- Cierre del poder si estamos en ficha jugador -->
		<?php if ($powerInPlayer == TRUE) { ?>
			</a>
		<?php } ?>
		<!-- Si estamos en la ficha del jugador, todo esto lo ocultamos -->
		<?php if ($powerInPlayer == TRUE) { ?>
			<div class="playerPowerContent" id="feat<?php echo $featId;?>">
		<?php } ?>
		<!-- Texto decorativo de la Dote -->
		<?php if ($featFlavor != "") { ?>
		<div class="cardFlavor"><?php echo $featFlavor; ?></div>
		<?php } ?>
		<!-- Rango y tipo de la Dote -->
		<div class="cardTypes">
			<!-- Tipo de Dote -->
			<div class="cardAction">
				<?php echo ucfirst($featType)." ".$powerBullet." <span style='font-weight:normal;'>Grado ".strtolower($featTier)."</span>"; ?> 
			</div>
		<!-- Aprendizaje de la Dote -->
		<?php if ($featLevelLearned != "") { ?>
			<div class="cardReach" style="font-weight:bold;width:auto;">
				<?php echo $featLevelLearned; ?>
			</div>
		<?php } ?>
		</div>
		<!-- Requisito de la Dote -->
		<?php if ($featRequired != "") { ?>
			<div class="cardText"><b>Requisitos:</b> <?php echo $featRequired; ?></div>
		<?php } ?>
		<!-- Bonificador de la Dote -->
		<?php if ($featBonus != "") { ?>
			<div class="cardText"><b>Beneficio:</b> <?php echo $featBonus; ?></div>
		<?php } ?>
		<!-- Especial de la Dote -->
		<?php if ($featSpecial != "") { ?>
			<div class="cardText"><b>Especial:</b> <?php echo $featSpecial; ?></div>
		<?php } ?>
		<!-- Enlace a la página del Poder si estamos en la ficha del jugador -->
		<?php if ($powerInPlayer == TRUE AND $playerFeatLink != "") { ?>
			<div class="cardText">
				<a id ="nameLink" href="<?php echo $playerFeatLink; ?>" target="_blank">
					<?php //echo $powerName; ?>
					<img class="powerLink" src="<?php echo $dydIconDirectory."icon_link".$dydIconExtension; ?>" />
				</a>
			</div>
		<?php } ?>
		<!-- DIV final para añadir el borde de abajo -->
			<div style="border-bottom: 1px solid #003366;"></div>
		<!-- Si estamos en la ficha del jugador, todo esto lo ocultamos -->
		<?php if ($powerInPlayer == TRUE) { ?>
			</div>
		<?php } ?>
	</div>
<!-- FIN DE TARJETA -->
