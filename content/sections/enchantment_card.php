<?php
	// INICIO RECOLECCION DATOS
	// ================================================================== //
	$idGetData = $enchantId; // Cogemos datos de la variable powerID
	$orderData ="SELECT * FROM ".$dydTableEnchants." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Encantamiento en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Encantamiento
			$enchantName  	 = $dataResult["name"]; 		// Nombre del Encantamiento.
			$enchantLevel	 = $dataResult["levels"];		// Nivel del Encantamiento.
			$enchantFlavor	 = $dataResult["flavortext"];	// Descripción del Encantamiento.
			$enchantType	 = $dataResult["type"];			// Tipo del Encantamiento.
			$enchantBdType	 = $dataResult["bd_type"];		// Tipo del Encantamiento para la BDD.
			$enchantPage	 = $dataResult["page"];			// Página de los Manuales donde aparece el Encantamiento.
			$enchantBonus	 = $dataResult["bonus"];		// Bonificación del Encantamiento.
			$enchantCritical = $dataResult["critical"];		// Critico del Encantamiento.
			$enchantProperty = $dataResult["property"];		// Propiedad que da el Encantamiento.
			$enchantPower1	 = $dataResult["power1"];		// Poder 1 del Encantamiento.
			$enchantPower2	 = $dataResult["power2"];		// Poder 2 del Encantamiento.
			$enchantPower3	 = $dataResult["power3"];		// Poder 3 del Encantamiento.
			$enchantSpecial  = $dataResult["special"];		// Especial del Encantamiento.
		// ================================================================== //
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		if ($originCanon != 0) {
		// Color del titulo de la Tarjeta
		switch($enchantBdType) {
			case "Arma":
			case "Utensilio":
				$titleBackground = "#CC3300";
				break;
			case "Armadura":
			case "Accesorio":
				$titleBackground = "#0000CC";
				break;
		/*case 4:
		 WEPON: CC3300
		 ARMOR: 0000CC
				$titleBackground = "#009966";
				break;*/
			default:
				$titleBackground = "#6600CC";
				break;
		}
		// Texto de bonificador de la Tarjeta:
		switch($enchantBdType) {
			case "Accesorio":
				$typeText = "Espacio de objeto";
			break;
			default:
				$typeText = $enchantBdType;
			break;
		}
		// Preparar niveles
			// Comprobamos el nivel mínimo
			$arrayLevels = explode("|", $enchantLevel);
			// Contamos y quitamos valores en blanco del array
			$cleanArrayLevels = array_values(array_diff($arrayLevels, array("")));
			if ($cleanArrayLevels[0] != "") {
				$checkArrayLevel = explode("+", $cleanArrayLevels[0]);
				$levelsEnchant = str_replace("Niv. ", "", $checkArrayLevel[0]);
				$levelsEnchant = str_replace(" ", "", $levelsEnchant);
				if (count($cleanArrayLevels) > 1) { $levelSign = "+"; } else { $levelSign = ""; }
			}
	// ================================================================== //
	// FIN RECOLECCION DATOS
?>
<!-- INICIO DE TARJETA -->
	<div id="powerCard">
		<!-- Título del Encantamiento -->
		<div class="cardTitle" style="background:<?php echo $titleBackground; ?>;">
			<div class="cardTitleName"><?php echo $enchantName; ?></div>
			<div class="cardTitleClass">Nivel <?php echo $levelsEnchant.$levelSign; ?></div> 
		</div>
		<!-- Texto decorativo del Encantamiento -->
		<div class="cardFlavor"><?php echo $enchantFlavor; ?></div>
		<!-- Niveles del Encantamiento -->
		<div class="enchantFlavor">
			<?php 
				// Preparamos los niveles de la armadura.
				for ($encLvl=0;$encLvl<count($cleanArrayLevels);$encLvl++) {
					echo "<div class='enchantLevel'>";
						$enchantLvl = explode("+", $cleanArrayLevels[$encLvl]);
						echo "<div style='float:left;width:42px;'>".$enchantLvl[0]."</div>";
						$enchantBns = explode(" ", $enchantLvl[1]);
						if ($enchantBns[0] != 0) { echo "<div style='float:left;margin-left:14px;text-align:right;'>+".$enchantBns[0]."</div>"; }
						echo "<div style='float:right;margin-right:24px;'>".$enchantBns[1]." po</div>";
					echo "</div>";
				}
			?>
		</div>
		<!-- Tipo de Encantamiento -->
		<?php if ($typeText != "") { ?>
			<div class="cardTypes">
				<div class="cardTypesItem" style="font-weight:normal;width:auto;"><b><?php echo $typeText; ?>:</b> <?php echo $enchantType; ?></div>
			</div>
		<?php } ?>
		<!-- Bonificador del Encantamiento -->
		<?php if ($enchantBonus != "") { ?>
			<div class="cardTypes">
				<div class="cardItemBonus"><b>Mejora:</b> <?php echo $enchantBonus; ?></div>
			</div>
		<?php } ?>
		<!-- Crítico del Encantamiento -->
		<?php if ($enchantCritical != "") { ?>
			<div class="cardTypes">
				<div class="cardItemBonus"><b>Crítico:</b> <?php echo $enchantCritical; ?></div>
			</div>
		<?php } ?>
		<!-- Propiedad del Encantamiento -->
		<?php if ($enchantProperty != "") { ?>
			<div class="cardItemProperty"><b>Propiedad:</b> <?php echo $enchantProperty; ?></div>
		<?php } ?>
		<!-- Poder 1 del Encantamiento -->
		<?php if ($enchantPower1 != "") { ?>
			<div class="cardText"><b>Poder</b> <?php echo $enchantPower1; ?></div>
		<?php } ?>
		<!-- Poder 2 del Encantamiento -->
		<?php if ($enchantPower2 != "") { ?>
			<div class="cardText"><b>Poder</b> <?php echo $enchantPower2; ?></div>
		<?php } ?>
		<!-- Poder 3 del Encantamiento -->
		<?php if ($enchantPower3 != "") { ?>
			<div class="cardText"><b>Poder</b> <?php echo $enchantPower3; ?></div>
		<?php } ?>
		<!-- Texto especial del Encantamiento -->
		<?php if ($enchantSpecial != "") { ?>
			<div class="cardText"><?php echo $enchantSpecial; ?></div>
		<?php } ?>
		<!-- Fin secciones -->
		<!-- DIV final para añadir el borde de abajo -->
		<div style="border-bottom: 1px solid #003366;"></div>
	</div>
<!-- FIN DE TARJETA -->
<?php } else {
		echo "<div class='errorImg'>".$phraseNoAuth."</div>";
	}
}
?>
