<?php
	// INICIO RECOLECCION DATOS
	// ================================================================== //
	$idGetData = $ailmentId; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableAilments." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos la Aflicción en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Vehículo
			$ailmentName 	 	= $dataResult["name"]; 			// Nombre de la Aflicción.
			$ailmentLevel		= $dataResult["level"];			// Nivel de la Aflicción.
			$ailmentType		= $dataResult["type"];			// Tipo de la Aflicción.
			$ailmentCost		= $dataResult["cost"];			// Precio en PO de la Aflicción.
			$ailmentFlavor		= $dataResult["flavortext"];	// Texto decorativo de la Aflicción.
			// --------------------------------------------------------------------------------- //
			$ailmentDetails		= $dataResult["details"];		// Detalles de la Aflicción.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		// Colocar . al precio
		$digitsAilmentValue = strlen($ailmentCost);
		switch($digitsAilmentValue) {
			default:
				$newAilmentValue = $ailmentCost;
			break;
			case 4:
				$newAilmentValue = substr($ailmentCost, 0, -3).".".substr($ailmentCost, 1);
			break;
			case 5:
				$newAilmentValue = substr($ailmentCost, 0, -3).".".substr($ailmentCost, 2);
			break;
			case 6:
				$newAilmentValue = substr($ailmentCost, 0, -3).".".substr($ailmentCost, 3);
			break;
		}
		// ================================================================== //
		// Color del titulo de la Tarjeta
		switch($ailmentType) {
			case "Enfermedad":
				$titleBackground = "#006633";
				break;
			case "Veneno":
				$titleBackground = "#660000";
				break;
		}
		// FIN RECOLECCION DATOS 
		if ($originCanon != 0) {	
		// CONTENIDO DE LA TARJETA DE LA AFLICCIÓN
?>
	<!-- INICIO DE TARJETA -->
	<div id="powerCard">
		<!-- TITULO DE LA TARJETA -->
		<!-- Nombre y nivel de la Aflicción -->
		<div class="enemyTitle" style="background:<?php echo $titleBackground; ?>;font-weight:bold;padding-bottom:10px;border-bottom: 1px solid #003366;">
			<div class="cardTitleName"><?php echo $ailmentName; ?></div>
			<div class="cardTitleClass" style="font-weight:normal;"><?php echo $ailmentType." nivel ".$ailmentLevel; ?></div> 
		</div>
		<!-- Datos de la enfermedad o veneno -->
		<?php if ($ailmentFlavor != "") {	?>
		<div id="italic" class="enemyStats"> 
			<?php echo $ailmentFlavor; ?>
		</div>
		<?php } ?>
		<!-- Precio de la Aflicción -->
		<?php if ($ailmentCost > 0) { ?>
		<div class="enemyStats">
			<div class="cardTitleClass">
				<?php echo $newAilmentValue; ?>
				<img class="goldIcon" src="<?php echo $pageRoot; ?>media/icon/coin.png" title="Valor en piezas de oro"/>
			</div>
		</div>
		<!-- Línea intermedia -->
		<div style="background:#A3A392;padding-bottom:8px;border-bottom:1px solid #003366;"></div>
		<?php } ?>
		<!-- FIN TITULO DE LA TARJETA -->
		<!-- INICIO DETALLES DE LA ENFERMEDAD -->
<?php
	$ailmentInfoSections = explode("|", $ailmentDetails);
	$ailmentQtySections = count($ailmentInfoSections);
	for($ninja=0;$ninja<$ailmentQtySections;$ninja++) {
		// ------------------->
		// Ataque del veneno
		$ailmentDetail = explode("[ATK]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<b>Ataque:</b> <?php echo $ailmentDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Impacto del veneno
		$ailmentDetail = explode("[HIT]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<b>Impacto:</b> <?php echo $ailmentDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Primera salvación fallida
		$ailmentDetail = explode("[FFT]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<i>Primera salvación fallida:</i> <?php echo $ailmentDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Segunda salvación fallida
		$ailmentDetail = explode("[SFT]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<i>Segunda salvación fallida:</i> <?php echo $ailmentDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Efecto secundario
		$ailmentDetail = explode("[SEF]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<i>Efecto secundario:</i> <?php echo $ailmentDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Especial
		$ailmentDetail = explode("[SPE]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<b>Especial:</b> <?php echo $ailmentDetail[1]; ?>
		</div>
		<?php
		}
		// ------------------->
		// Nivel de la enfermedad
		$ailmentDetail = explode("[LVL]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<?php $diseaseLevels = explode("}", $ailmentDetail[1]); ?>
			<b>Fase 0:</b> El objetivo queda curado.<br />
			<?php for($dis=0;$dis<count($diseaseLevels);$dis++) { ?>
				<b>Fase <?php echo ($dis+1).":</b> ".$diseaseLevels[$dis];?><br />
			<?php } ?>
		</div>
		<?php
		}
		// ------------------->
		// Aguante de la enfermedad
		$ailmentDetail = explode("[CHK]", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
		?>
		<div class="alimentInfo">
			<?php $diseaseCheck = explode("}", $ailmentDetail[1]); ?>
			<b>Prueba:</b> <?php echo $diseaseCheck[0]; ?>
			<?php if ($diseaseCheck[1] != "") { ?>
				<ul class="diseaseDCS">
					<?php
						$diseaseDCS = explode("¡", $diseaseCheck[1]);
						for($dis=0;$dis<count($diseaseDCS);$dis++) {
							$diseaseDCgood = explode(":", $diseaseDCS[$dis]);
					?>
						<li><?php echo "<i>".$diseaseDCgood[0].":</i> ".$diseaseDCgood[1].""; ?></li>
					<?php }	?>
				</ul>
			<?php } ?>
		</div>
		<?php
		}
		// ------------------->
		// Otros detalles
		$ailmentDetail = explode("{", $ailmentInfoSections[$ninja]);
		if ($ailmentDetail[1] != "") {
			// Hemos encontrado un detalle aparte, usamos }
			$ailmentDetailText = explode("}", $ailmentDetail[1]);
		?>
		<div class="alimentInfo">
			<b><?php echo $ailmentDetailText[0].":</b> ".$ailmentDetailText[1]; // El valor 1 es el contenido ?>
		</div>
		<?php
		}
		// ------------------->
	}
?>
		<!-- Línea final -->
		<div style="background:#A3A392;padding-bottom:4px;"></div>
		<!-- FIN DETALLES DE LA AFLICCIÓN -->
	<!-- FIN DE TARJETA -->
	</div>
<?php
		} else {
			echo "<div class='errorImg'>".$phraseNoAuth."</div>";
		}
	}
?>
