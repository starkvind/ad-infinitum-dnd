<?php
	$powerInPlayer = $powerInPlayer ?? FALSE;
	$powerSlot = $powerSlot ?? 0;
	$powerId = $powerId ?? ($page ?? "");
	// INICIO RECOLECCION DATOS
	// ================================================================== //
	$idGetData = $powerId; // Cogemos datos de la variable powerID
	$orderData ="SELECT * FROM ".$dydTablePowers." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Power en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del personaje
			$powerName 	 	 	= $dataResult["name"]; 			// Nombre del Poder.
			$powerType1		 	= $dataResult["powertype"];		// Una línea que describe la Raza.
			$powerClass	 	 	= $dataResult["class"]; 		// Altura de la Raza.
			$powerClassOption	= $dataResult["class_option"];	// Peso de la Raza.
			$powerLevel			= $dataResult["level"];			// Bonus.
			$powerFlavor		= $dataResult["flavortext"];	// Tipo de personaje. Si es Protagonista o pertenece al grupo de PNJs.
			$powerType2		 	= $dataResult["type"];	 		// Cumpleaños del personaje.
			$powerKeywords		= $dataResult["keywords"];	 	// Concepto del personaje.
			$powerAction		= $dataResult["action"]; 		// Naturaleza del personaje, como es en realidad.
			$powerTargetType	= $dataResult["target_type"]; 	// Conducta del personaje, como se comporta.
			$powerTarget		= $dataResult["target"];	 	// Texto escrito que habla sobre el personaje.
			$powerAttack		= $dataResult["attack"];	 	// Canción del personaje.
			$powerModAttack		= $dataResult["modattack"];	 	// Modificador del poder
			$powerDefense		= $dataResult["defense"]; 		// Dirección de la canción del personaje.
			$powerModDefense	= $dataResult["moddefense"];	// Modificador de la defensa
			$powerDamage		= $dataResult["damage"];	 	// Conducta del personaje, como se comporta.
			$powerTrigger		= $dataResult["trigger"];
			$powerEffect		= $dataResult["effect"];	 	// Texto escrito que habla sobre el personaje.
			$powerFailure	 	= $dataResult["failure"];	 	// Canción del personaje.
			$powerSpecial	 	= $dataResult["special"]; 		// Dirección de la canción del personaje.
			$powerMiscellaneus	= $dataResult["miscellaneus"];
			$powerCombotext		= $dataResult["combotext"];
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
	if ($powerLevel == 0) { $powerLevel = ""; }
	if ($originCanon != 0) {
		// Texto de tipo de poder de la Tarjeta
		switch($powerType1) {
			case 0:
				$powerTitleRight = "Poder racial de ".$powerClass;
				break;
			case 10:
				$powerTitleRight = $powerClass." ".$powerClassOption." ataque ".$powerLevel;
				break;
			case 1:
			case 11:
				$powerTitleRight = $powerClass." ".$powerClassOption." utilidad ".$powerLevel;
				break;
			case 12:
				$powerTitleRight = "Rasgo de ".$powerClass;
				break;			
			case 21:
				$powerTitleRight = "Poder de dote";
				break;
			case 30:
				$powerTitleRight = "Combinación de ".$powerClassOption." ".$powerLevel;
				break;
			case 31:
				$powerTitleRight = "Poder básico";
				break;
			case 32:
				$powerTitleRight = "Truco de ".$powerClass;
				break;	
			case 33:
				$powerTitleRight = "Pacto de ".$powerClass." ".$powerClassOption;
				break;					
		}
		// ================================================================== //
		// Color del titulo de la Tarjeta
		switch($powerType2) {
			case "A voluntad":
				$titleBackground = "#006633";
				break;
			case "Encuentro":
				$titleBackground = "#660000";
				break;
			case "Diario":
				$titleBackground = "#303030";
				break;
			default:
				$titleBackground = "orange";
				break;
		}
		// Separador entre Tipo de Acción y Palabras Clave
		$powerBullet = "&#8224;";//"<img src='".$pageRoot."media/icon/bullet.png' class='bullet' />";
	// ================================================================== //
	// FIN RECOLECCION DATOS
?>
<!-- INICIO DE TARJETA -->
	<div id="powerCard" <?php if ($powerInPlayer == TRUE) { ?>class="playerPower" style="<?php if ($powerSlot % 2 == 1) {?>margin-left:16px;<?php }?>"<?php } ?>>
		<!-- Cierre del poder si estamos en ficha jugador -->
		<?php if ($powerInPlayer == TRUE) { ?>
			<a href="#power" onclick="show_power('power<?php echo $powerId;?>');">
		<?php } ?>
		<!-- Título del Poder -->
		<div class="cardTitle" style="background:<?php echo $titleBackground; ?>;">
			<div class="cardTitleName"><?php echo $powerName; ?></div>
			<div class="cardTitleClass"><?php echo $powerTitleRight; ?></div> 
		</div>
		<!-- Cierre del poder si estamos en ficha jugador -->
		<?php if ($powerInPlayer == TRUE) { ?>
			</a>
		<?php } ?>
		<!-- Si estamos en la ficha del jugador, todo esto lo ocultamos -->
		<?php if ($powerInPlayer == TRUE) { ?>
			<div class="playerPowerContent" id="power<?php echo $powerId;?>">
		<?php } ?>
		<!-- Texto decorativo del Poder -->
		<div class="cardFlavor"><?php echo $powerFlavor; ?></div>
		<!-- Tipo y Palabras clave del Poder -->
		<div class="cardTypes">
			<div class="cardTypesLeft"><?php echo $powerType2; ?></div>
			<!-- Si tiene palabras clave, colocamos el símbolo y las palabras -->
			<?php if ($powerKeywords != "") { ?>
				<div style="float:left;text-align:center;width:20px;">
					<?php echo $powerBullet; ?>
				</div>
				<div class="cardTypesRight" <?php if ($powerInPlayer == TRUE) { ?>style="width:360px;"<?php } ?>>
					<?php echo $powerKeywords; ?>
				</div>
			<?php } ?>
			<!-- Fin Palabras Clave-->
		</div>
		<!-- Acción y alcance del Poder -->
		<div class="cardTypes">
			<!-- Tipo de Acción -->
			<div class="cardAction">
				<?php echo $powerAction; ?>
			</div>
			<!-- Alcance del Poder -->
			<div class="cardReach" <?php if ($powerInPlayer == TRUE) { ?>style="width:205px;"<?php } ?>>
				<?php echo $powerTargetType; ?>
			</div>
		</div>
		<!-- Texto de la tarjeta si es una Combinación -->
		<?php if ($powerCombotext != "") { ?>
			<div class="cardText"><?php echo $powerCombotext; ?></div>
		<?php } ?>
		<!-- Desencadenante del Poder -->
		<?php if ($powerTrigger != "") { ?>
			<div class="cardText"><b>Desencadenante:</b> <?php echo $powerTrigger; ?></div>
		<?php } ?>
		<!-- Objetivo del Poder -->
		<?php if ($powerTarget != "") { ?>
			<div class="cardText"><b>Objetivo:</b> <?php echo $powerTarget; ?></div>
		<?php } ?>
		<!-- Ataque vs. Defensa del Poder -->
		<?php if ($powerAttack != "" OR $powerDefense != "") { ?>
			<div class="cardText"><b>Ataque:</b> <?php echo $powerAttack." ".$powerModAttack." contra ".$powerDefense.$powerModDefense; ?></div>
		<?php } ?>
		<!-- Impacto del Poder -->
		<?php if ($powerDamage != "") { ?>
			<div class="cardText"><b>Impacto:</b> <?php echo $powerDamage; ?></div>
		<?php } ?>
		<!-- Fallo del Poder -->
		<?php if ($powerFailure != "") { ?>
			<div class="cardText"><b>Fallo:</b> <?php echo $powerFailure; ?></div>
		<?php } ?>
		<!-- Efecto del Poder -->
		<?php if ($powerEffect != "") { ?>
			<div class="cardText"><b>Efecto:</b> <?php echo $powerEffect; ?></div>
		<?php } ?>
		<!-- Rasgo especial del Poder -->
		<?php if ($powerSpecial != "") { ?>
			<div class="cardText"><b>Especial:</b> <?php echo $powerSpecial; ?></div>
		<?php } ?>
		<!-- Texto misceláneo del Poder -->
		<?php if ($powerMiscellaneus != "") { ?>
			<div class="cardText"><?php echo $powerMiscellaneus; ?></div>
		<?php } ?>
		<!-- Enlace a la página del Poder si estamos en la ficha del jugador -->
		<?php if ($powerInPlayer == TRUE AND $playerPowerLink != "") { ?>
			<div class="cardText">
				<a id ="nameLink" href="<?php echo $playerPowerLink; ?>" target="_blank">
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
	<?php } else {
		echo "<div class='errorImg'>".$phraseNoAuth."</div>";
	}
} ?>

