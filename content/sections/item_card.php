<?php
	// INICIO RECOLECCION DATOS
	// ================================================================== //
	$idGetData = $powerId; // Cogemos datos de la variable powerID
	$orderData ="SELECT * FROM ".$dydTableMagicItems." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Objeto en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Objeto
			$itemName 	 	 = $dataResult["name"]; 		// Nombre del Objeto.
			$itemLevel		 = $dataResult["level"];		// Nivel del Objeto.
			$itemFlavor		 = $dataResult["flavortext"];	// Descripción del Objeto.
			$itemClasses	 = $dataResult["classes"];		// Clases que pueden llevar el Objeto.
			$itemRequire	 = $dataResult["required"];		// Requisitos del Objeto.
			$itemType		 = $dataResult["type"];			// Tipo del Objeto.
			$itemBdType		 = $dataResult["bd_type"];		// Tipo del Objeto para la BDD.
			$itemValue		 = $dataResult["value"];		// Valor del Objeto en Piezas de oro.
			$itemPage		 = $dataResult["page"];			// Página de los Manuales donde aparece el Objeto.
			$itemBonus		 = $dataResult["bonus"];		// Bonificación del Objeto.
			$itemCritical	 = $dataResult["critical"];		// Critico del Objeto.
			$itemProperty 	 = $dataResult["property"];		// Propiedad que da el Objeto.
			$itemPower1		 = $dataResult["power1"];		// Poder 1 del Objeto.
			$itemPower2		 = $dataResult["power2"];		// Poder 2 del Objeto.
			$itemPower3		 = $dataResult["power3"];		// Poder 3 del Objeto.
			$itemSpecial	 = $dataResult["special"];		// Característica especial del Objeto.
			$itemPicture	 = $dataResult["picture"];		// Imagen del Objeto.
			$itemReward		 = $dataResult["reward"];		// Procedencia del objeto. Recompensa de aventura o bono vip.
		// ================================================================== //
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		if ($originCanon != 0) {
		// Color del titulo de la Tarjeta
		switch($itemBdType) {
			case 1:
			case 5:
			case 6:
				$titleBackground = "#CC3300";
			break;
			case 3:	
			case 2:
				$titleBackground = "#0000CC";
			break;
			/*case 3:
				// Si el objeto es un Accesorio, tomamos el numero "trinket" para saber que fondo le ponemos
				switch($itemTrinket) {
					case 1:
						$titleBackground = "#CC3300";
					break;
					case 2:
						$titleBackground = "#0000CC";
					break;				
				}
				break;*/
			case 4:
				$titleBackground = "#009966";
			break;
			default:
				$titleBackground = "#6600CC";
			break;
		}
		// Añadir . al precio
		$digitsItemValue = strlen($itemValue);
		//echo "El precio tiene $valueTest numeros.";
		switch($digitsItemValue) {
			default:
				$newItemValue = $itemValue;
			break;
			case 4:
				$newItemValue = substr($itemValue, 0, -3).".".substr($itemValue, 1);
			break;
			case 5:
				$newItemValue = substr($itemValue, 0, -3).".".substr($itemValue, 2);
			break;
			case 6:
				$newItemValue = substr($itemValue, 0, -3).".".substr($itemValue, 3);
			break;
		}
		if ($itemReward == 2) {
			$valueIcon = $pageRoot."media/icon/icon_topaz.png";
			$iconTitle = "Valor en topacios del infinito";
			$iconStyle = "width:14px;height:14px;";
		} else {
			$valueIcon = $pageRoot."media/icon/coin.png";
			$iconTitle = "Valor en piezas de oro";
			$iconStyle = "";
		}
	// ================================================================== //
	// FIN RECOLECCION DATOS
?>
<!-- INICIO DE TARJETA -->
	<div id="powerCard">
		<!-- Título del Objeto -->
		<div class="cardTitle" style="background:<?php echo $titleBackground; ?>;">
			<div class="cardTitleName"><?php echo $itemName; ?></div>
			<div class="cardTitleClass">Nivel <?php echo $itemLevel; ?></div> 
		</div>
		<!-- Texto decorativo del Objeto -->
		<div class="cardFlavor"><?php echo $itemFlavor; ?></div>
		<!-- Tipo y Precio  del Objeto -->
		<div class="cardTypes">
			<div class="cardTypesItem"><a title="<?php echo $itemPage; ?>"><?php echo $itemType; ?></a></div>
			<!-- Si tiene valor, se lo ponemos en PO -->
			<?php if ($itemValue != 0) { ?>
				<div class="cardTypesValue">
					<?php echo $newItemValue; ?> <img class="goldIcon" src="<?php echo $valueIcon; ?>" title="<?php echo $iconTitle; ?>" style="<?php echo $iconStyle; ?>" />
				</div>
			<!-- Requisito del objeto -->
			<?php } else if ($itemRequire != "") { ?>
				<div class="cardTypesValue"><b>Requisito:</b> <?php echo $itemRequire; ?></div>
			<?php } ?>
			<!-- Fin Valor del objeto -->
		</div>
		<!-- Objeto exclusivo para ciertas Clases -->
		<?php if ($itemClasses != "") { ?>
			<div class="cardTypes">
				<div class="cardItemBonus"><b>Clases:</b> <?php echo $itemClasses; ?></div>
			</div>
		<?php } ?>
		<!-- Bonificador del Objeto -->
		<?php if ($itemBonus != "") { ?>
			<div class="cardTypes">
				<div class="cardItemBonus"><b>Bonificador:</b> <?php echo $itemBonus; ?></div>
			</div>
		<?php } ?>
		<!-- Crítico del Objeto -->
		<?php if ($itemCritical != "") { ?>
			<div class="cardTypes">
				<div class="cardItemBonus"><b>Crítico:</b> <?php echo $itemCritical; ?></div>
			</div>
		<?php } ?>
		<!-- Propiedad del Objeto -->
		<?php if ($itemProperty != "") { ?>
			<div class="cardItemProperty"><b>Propiedad:</b> <?php echo $itemProperty; ?></div>
		<?php } ?>
		<!-- Poder 1 del Objeto -->
		<?php if ($itemPower1 != "") { ?>
			<div class="cardText"><b>Poder</b> <?php echo $itemPower1; ?></div>
		<?php } ?>
		<!-- Poder 2 del Objeto -->
		<?php if ($itemPower2 != "") { ?>
			<div class="cardText"><b>Poder</b> <?php echo $itemPower2; ?></div>
		<?php } ?>
		<!-- Poder 3 del Objeto -->
		<?php if ($itemPower3 != "") { ?>
			<div class="cardText"><b>Poder</b> <?php echo $itemPower3; ?></div>
		<?php } ?>
		<!-- Texto especial del Objeto -->
		<?php if ($itemSpecial != "") { ?>
			<div class="cardText"><?php echo $itemSpecial; ?></div>
		<?php } ?>
		<!-- Texto de la recompensa del objeto -->
		<?php if ($itemReward != 0) {
				switch ($itemReward) {
					case 1:
						$rewText1 = "<b>Recompensa de aventura:</b> ";
					break;
					case 2:
						$rewText1 = "<b>Reliquia del infinito:</b> ";
					break;
				}
				$rewText2 = "este objeto no se puede desencantar utilizando el ritual <i>Desencantar objeto mágico</i>.";
		?>
			<div class="cardText" style="border-top:1px solid #003366;"><?php echo $rewText1.$rewText2; ?></div>
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
