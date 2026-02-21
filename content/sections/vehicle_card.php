<?php
	// INICIO RECOLECCION DATOS
	// ================================================================== //
	$idGetData = $vehicleId; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableVehicles." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Vehículo en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Vehículo
			$vehicleName 	 	= $dataResult["name"]; 			// Nombre del vehículo.
			$vehicleSize		= $dataResult["size"];			// Tamaño del vehículo.
			$vehicleHp			= $dataResult["hp"];			// PG del vehículo.
			$vehicleSquares		= $dataResult["squares"];		// Casillas que ocupa el vehículo.
			$vehicleValue		= $dataResult["price"];			// Precio en PO del vehículo.
			// --------------------------------------------------------------------------------- //
			$vehicleAc			= $dataResult["ac"];			// CA del vehículo.
			$vehicleFortitude	= $dataResult["fortitude"];		// Fortaleza del vehículo.
			$vehicleReflex		= $dataResult["reflex"];		// Reflejos del vehículo.
			$vehicleSpeed		= $dataResult["speed"];			// Velocidad del vehículo.
			// --------------------------------------------------------------------------------- //
			$vehicleDetails		= $dataResult["details"];		// Detalles del vehículo.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		// Colocar . al precio
		$digitsVehicleValue = strlen($vehicleValue);
		switch($digitsVehicleValue) {
			default:
				$newVehicleValue = $vehicleValue;
			break;
			case 4:
				$newVehicleValue = substr($vehicleValue, 0, -3).".".substr($vehicleValue, 1);
			break;
			case 5:
				$newVehicleValue = substr($vehicleValue, 0, -3).".".substr($vehicleValue, 2);
			break;
			case 6:
				$newVehicleValue = substr($vehicleValue, 0, -3).".".substr($vehicleValue, 3);
			break;
		}
		// FIN RECOLECCION DATOS 
		if ($originCanon != 0) {
		// str_replace(' ', '', $cadena)
		// CONTENIDO DE LA TARJETA DEL VEHICULO
?>
	<!-- INICIO DE TARJETA -->
	<div id="powerCard">
		<!-- TITULO DE LA TARJETA -->
		<!-- Nombre y tamaño del Vehículo -->
		<div class="enemyTitle" style="font-weight:bold;padding-bottom:10px;">
			<div class="cardTitleName"><?php echo $vehicleName; ?></div>
		</div>
		<div class="enemyTitle" style="padding-top:0px;padding-bottom:10px;border-bottom: 1px solid #003366;">
			<div class="cardTitleName" style="font-weight:normal;">Vehículo <?php echo $vehicleSize; ?></div>
		</div>
		<!-- PG, espacio y precio del Vehículo -->
		<div class="enemyStats"> <!-- PG e Iniciativa -->
			<div class="cardTitleName">
				<b>PG:</b> <?php echo $vehicleHp; ?>
				<span style="margin-left: 20px;"><b>Espacio:</b> <?php echo $vehicleSquares; ?> casillas</span>
			</div>
			<div class="cardTypesValue">
				<?php echo str_replace(" ", "", $newVehicleValue); ?>
				<img class="goldIcon" src="<?php echo $pageRoot; ?>media/icon/coin.png" title="Valor en piezas de oro" />
			</div>
		</div>
		<!-- Defensas del Vehículo -->
		<div class="enemyStats">
			<div class="cardTitleName">
				<b>CA:</b> <?php echo $vehicleAc; ?>,
				<b>Fortaleza:</b> <?php echo $vehicleFortitude; ?>,
				<b>Reflejos:</b> <?php echo $vehicleReflex; ?>
			</div>
		</div>
		<!-- Velocidad del Vehículo -->
		<div class="enemyStats">
			<div class="cardTitleName">
				<b>Velocidad:</b> <?php echo $vehicleSpeed; ?>
			</div>
		</div>
		<!-- Línea final -->
		<div style="background: #A3A392;padding-bottom:10px;border-bottom: 1px solid #003366;"></div>
		<!-- FIN TITULO DE LA TARJETA -->
		<div class="enemySkillTitle">
			Detalles
		</div>
		<!-- INICIO DETALLES DEL VEHICULO -->
<?php
	$vehicleInfoSections = explode("|", $vehicleDetails);
	$vehicleQtySections = count($vehicleInfoSections);
	for($ninja=0;$ninja<$vehicleQtySections;$ninja++) {
		// ------------------->
		// Piloto del vehiculo
		$vehicleDetail = explode("[PIL]", $vehicleInfoSections[$ninja]);
		if ($vehicleDetail[1] != "") {
		?>
		<div class="enemyAttack" style="font-weight: bold;">
			Piloto
		</div>
		<div class="enemyAttackInfo">
			<?php echo $vehicleDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Tirado por criaturas
		$vehicleDetail = explode("[TPA]", $vehicleInfoSections[$ninja]);
		if ($vehicleDetail[1] != "") {
		?>
		<div class="enemyAttack" style="font-weight: bold;">
			Tirado por criaturas
		</div>
		<div class="enemyAttackInfo">
			<?php echo $vehicleDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Conductor
		$vehicleDetail = explode("[CON]", $vehicleInfoSections[$ninja]);
		if ($vehicleDetail[1] != "") {
		?>
		<div class="enemyAttack" style="font-weight: bold;">
			Conductor
		</div>
		<div class="enemyAttackInfo">
			<?php echo $vehicleDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Tripulación del vehiculo
		$vehicleDetail = explode("[TRI]", $vehicleInfoSections[$ninja]);
		if ($vehicleDetail[1] != "") {
		?>
		<div class="enemyAttack" style="font-weight: bold;">
			Tripulación
		</div>
		<div class="enemyAttackInfo">
			<?php echo $vehicleDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Carga del vehiculo
		$vehicleDetail = explode("[CAR]", $vehicleInfoSections[$ninja]);
		if ($vehicleDetail[1] != "") {
		?>
		<div class="enemyAttack" style="font-weight: bold;">
			Carga
		</div>
		<div class="enemyAttackInfo">
			<?php echo $vehicleDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Vehiculo fuera de control
		$vehicleDetail = explode("[FDC]", $vehicleInfoSections[$ninja]);
		if ($vehicleDetail[1] != "") {
		?>
		<div class="enemyAttack" style="font-weight: bold;">
			Fuera de control
		</div>
		<div class="enemyAttackInfo">
			<?php echo $vehicleDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Otros detalles
		$vehicleDetail = explode("{", $vehicleInfoSections[$ninja]);
		if ($vehicleDetail[1] != "") {
			// Hemos encontrado un detalle aparte, usamos }
			$vehicleDetailText = explode("}", $vehicleDetail[1]);
			// Vamos a detectar si el detalle es un ataque
			$vehicleAttackText = explode("(", $vehicleDetailText[0]);
			if ($vehicleAttackText[1] != "") { 
				$vehicleAttName = $vehicleAttackText[0]; 
				$vehicleAttKeywords = substr($vehicleAttackText[1], 0, -1);
				// Iconos de ataque
				$attackIconFolder = $pageRoot."media/attack";
				$vehicleAttackIcon = explode("]", $vehicleAttName);
				if ($vehicleAttackIcon[1] != "") {
					// Hemos encontrado el CODIGO del icono, lo preparamos
					$vehicleAttIcon = substr($vehicleAttackIcon[0], 1);
					switch ($vehicleAttIcon) {
						case "F": // Cuerpo a cuerpo
							$attackIcon = $attackIconFolder."/icon_melee.png";
							$attackIconStyle = "margin: -4px 0 0 -6px;";
							$attackIconTitle = "Cuerpo a cuerpo";
						break;
						case "D": // A distancia
							$attackIcon = $attackIconFolder."/icon_ranged.png";
							$attackIconStyle = "margin: -4px 0 0 -2px;";
							$attackIconTitle = "A distancia";
						break;
					}
					$vehicleAttName = $vehicleAttackIcon[1];
				} 
			} else {
			// Si no tenemos nada, ponemos todas las variables a ""
				$vehicleAttName = ""; 
				$vehicleAttKeywords = "";
				$attackIcon = "";
			}
		?>
		<div class="enemyAttack" style="font-weight: bold;">
			<?php 
			// Comprobamos si el Detalle es un ataque y tiene iconos.
				if ($vehicleAttName != "" AND $vehicleAttKeywords != "") {
					if ($attackIcon != "") {
					// Icono y nombre del ataque, con sus categorías
						echo "<img src='".$attackIcon."' class='attackIcon' style='".$attackIconStyle."' title='".$attackIconTitle."'/>"; // Colocamos Icono
					}
					echo $vehicleAttName." <span style='font-weight: normal;'>(".$vehicleAttKeywords.")</span>";
			// Si no tenemos nada, mostramos el titulo simplemente
				} else { 
					echo $vehicleDetailText[0]; // El valor 0 es el titulo
				}
			?>
		</div>
		<div class="enemyAttackInfo">
			<?php echo $vehicleDetailText[1]; // El valor 1 es el contenido ?>
		</div>
		<?php
		}
		// ------------------->
	}
?>
		<!-- FIN DETALLES DEL VEHICULO -->
	<!-- FIN DE TARJETA -->
	</div>
<?php
		} else {
			echo "<div class='errorImg'>".$phraseNoAuth."</div>";
		}
	}
?>
