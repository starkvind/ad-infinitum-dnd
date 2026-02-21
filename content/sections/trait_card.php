<?php
	$traitId = $traitId ?? ($page ?? "");
	$powerInPlayer = $powerInPlayer ?? FALSE;
	$traitSlot = isset($traitSlot) ? (int)$traitSlot : 0;
	if (!function_exists('dyd_safe_label')) {
		function dyd_safe_label($name, $url = "")
		{
			$name = trim((string) str_replace("\0", "", $name));
			$name = preg_replace('/[\x00-\x1F\x7F]/', '', $name);
			$nameLen = function_exists('mb_strlen') ? mb_strlen($name, 'UTF-8') : strlen($name);
			if ($nameLen > 1) {
				return $name;
			}
			$slug = trim((string) $url);
			if ($slug === '') {
				return $name;
			}
			$slug = preg_replace('/^[0-9]+[\/_-]*/', '', $slug);
			$slug = str_replace(array('-', '_', '+'), ' ', $slug);
			$slug = preg_replace('/\s+/', ' ', $slug);
			$slug = trim($slug);
			if ($slug === '') {
				return $name;
			}
			return ucfirst($slug);
		}
	}
	$idGetData = $traitId; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableTraits." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Objeto en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Objeto
			$traitName 	 	 = dyd_safe_label($dataResult["name"], $dataResult["url"] ?? ""); 		// Nombre del Rasgo.
			$traitType		 = $dataResult["type"];			// Tipo del Rasgo.
			$traitClass		 = $dataResult["class"];		// Clase/raza/etc del Rasgo.
			$traitInfo		 = $dataResult["infotext"];		// Información del Rasgo.
			$traitChoose	 = $dataResult["choosetext"];	// Selecciones del Rasgo.
			$traitFlavor	 = $dataResult["flavortext"];	// Texto decorativo del Rasgo.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// ================================================================== //
		// Detalles del Rasgo
		switch($traitType) {
			case "Aura":
				$traitTypeText = $traitType;
			break;	
			case "Clase":
				$traitTypeText = "Rasgo cláseo";
			break;	
			case "Defensa":
				$traitTypeText = "Defensas";
			break;			
			case "Pasiva":
				$traitTypeText = "Rasgo pasivo";
			break;			
			case "Poder":
				$traitTypeText = "Poder cláseo";
			break;
			case "Racial":
				$traitTypeText = "Rasgo racial";
			break;
			case "Origen":
				$traitTypeText = "Orígenes";
			break;
			case "Tema":
				$traitTypeText = "";
			break;	
			default:
				$traitTypeText = "Rasgo";
			break;
		}
		// Título del Rasgo
		if ($traitClass != "") {
			if ($traitTypeText != "") {
				$traitClassText = $traitTypeText." de ".$traitClass;
			} else {
				$traitClassText = $traitClass;
			}
		} else {
			$traitClassText = $traitTypeText;
		}
		// Color de fondo
		$titleBackground = "#003366";
	}
?>
<!-- INICIO DE TARJETA -->
<!--  <?php //if ($powerInPlayer == TRUE) { ?>class="playerPower" style="<?php //if ($traitSlot % 2 == 1) {?>margin-left:16px;<?php //}?>"<?php// } ?> -->
	<div id="powerCard" style="width:700px;margin-left:-100px;">
		<!-- Cierre del poder si estamos en ficha jugador -->
		<?php if ($powerInPlayer == TRUE) { ?>
			<a href="#trait" onclick="show_power('trait<?php echo $traitId;?>');">
		<?php } ?>
		<!-- Título del Rasgo -->
		<div class="cardTitle" style="background:<?php echo $titleBackground; ?>;">
			<div class="cardTitleName"><?php echo $traitName; ?></div>
			<div class="cardTitleClass"><?php echo $traitClassText; ?></div> 
		</div>
		<!-- Cierre del poder si estamos en ficha jugador -->
		<?php if ($powerInPlayer == TRUE) { ?>
			</a>
		<?php } ?>
		<!-- Si estamos en la ficha del jugador, todo esto lo ocultamos -->
		<?php if ($powerInPlayer == TRUE) { ?>
			<div class="playerPowerContent" id="trait<?php echo $traitId;?>">
		<?php } ?>
		<!-- Texto decorativo del Rasgo -->
		<?php if ($traitFlavor != "") { ?>
		<div class="cardFlavor" style="font-style:normal;"><?php echo $traitFlavor; ?></div>
		<?php } ?>
		<!-- Bonificador del Rasgo -->
		<?php if ($traitInfo != "") { ?>
			<div class="cardText" style="text-align:justify;">
			<?php if ($traitFlavor != "") { ?>
				<b>Beneficio:</b> 
			<?php } ?>
				<?php echo $traitInfo; ?>
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
		<!-- Elección del Rasgo -->
		<?php if ($traitChoose != "") { ?>
			<br />
			<div style="width:704px;margin-left:-102px;">
				<?php echo $traitChoose; ?>
			</div>
		<?php } ?>
