<?php
if ($_SESSION['level'] >= 3) {
	include_once("content/sections/contents_tabs.php");	
	// Preparamos los datos.
	$idGetData = 3; // Cogemos datos del GET "page"
	$orderData ="SELECT ".$dydBasicFields.", ".$dydPartiesFields." FROM ".$dydTableParties." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Grupo en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	
if ($rowsData != "") {
	$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
	$playerParty	= $dataResult["members"]; // Miembros del grupo.
	$playerParty = preg_replace("/[\\r\\n]+/", "", $playerParty); // Quitamos los saltos de línea cojoneros.
	// Preparamos la party fish
	$playerArray = explode(",", $playerParty);
	$playerArrayCount = 0;
	while ($playerArrayCount<count($playerArray)) {
		$playerArray2[$playerArrayCount] = "'".str_replace(" ", "", $playerArray[$playerArrayCount])."'";
		$playerArrayCount++;
	}
	// ------------------------------------------------------------------ //
	$orderData ="SELECT url, name, inventory FROM ".$dydTablePlayers." WHERE url IN (".implode(",",$playerArray2).") ORDER BY name"; // Elegimos la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	// ------------------------------------------------------------------ //
	// Localización para pestañas
	if ($rowsData != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
?>
	<div id="playerParty">
		<table>
			<thead>
			<th style="border-top:0px;">&nbsp;</th>
	<?php
		for($dt=0;$dt<$rowsData;$dt++) {
			$queryResult = mysql_fetch_array($queryData);
			echo "<th>".$queryResult["name"]."</th>";
			// --------------------------------------------->
			// Sacamos el nivel para que la nena esté contenta
			// --------------------------------------------->
			$playerURL = $queryResult["url"];
			include ("content/sections/player_get_exp.php");
			// ------------------------------------->
			// Nivel
			// ------------------------------------->
			$levelQuery = "SELECT level FROM ".$dydTableLevelChart." WHERE xp BETWEEN 0 AND ".$adventTotalXP.";"; // Pillamos la info de la XP
			$levelData = mysql_query ($levelQuery, $link);
			$levelRows = mysql_num_rows($levelData);
			if ($levelRows != 0) { $charEquip[$dt]["LEVEL"] = $levelRows; }
			// --------------------------------------------->
			$charInventory = $queryResult["inventory"];
			$playerInv  = explode("|", $charInventory);
			$playerQinv = count($playerInv);
			// Limpiamos las variables
				$equipName["WEAPON"] = "";
				$equipLink["WEAPON"] = "";
				// Cuerpo
				$equipName["BODY"] = "";
				$equipName["WEAPON"] = "";
				$equipName["NECK"] = "";
				$equipName["BACK"] = "";
				$equipName["WAIST"] = "";
				$equipName["ARMS"] = "";
				$equipName["HAND"] = "";
				$equipName["HEAD"] = "";
				$equipName["FEET"] = "";
				$equipName["OFFHAND"] = "";
				$equipName["SECONDARY"] = "";
				$equipName["RING1"] = "";
				$equipName["RING2"] = "";
				$equipName["TATOO"] = "";
				$equipName["REWARD"] = "";
				$equipName["IMPLEMENT"] = ""; 
				// ------------------------------------------------------------------------------------------------------------------------------------- //
				for($it=0;$it<$playerQinv;$it++) {
					include("content/sections/player_get_equipment.php");
				}
				// Arma
				if ($equipName["WEAPON"] != "") { $charEquip[$dt]["WEAPON"] = $equipName["WEAPON"]; } else { $charEquip[$dt]["WEAPON"] = ""; }
				if ($equipLink["WEAPON"] != "") { $charEquipLink[$dt]["WEAPON"] = $equipLink["WEAPON"]; } else { $charEquipLink[$dt]["WEAPON"] = ""; }
				// Cuerpo
				if ($equipName["BODY"] != "") { $charEquip[$dt]["BODY"] = $equipName["BODY"]; } else { $charEquip[$dt]["BODY"] = ""; }
				if ($equipLink["BODY"] != "") { $charEquipLink[$dt]["BODY"] = $equipLink["BODY"]; } else { $charEquipLink[$dt]["BODY"] = ""; }
				// Cabeza
				if ($equipName["HEAD"] != "") { $charEquip[$dt]["HEAD"] = $equipName["HEAD"]; } else { $charEquip[$dt]["HEAD"] = ""; }
				if ($equipLink["HEAD"] != "") { $charEquipLink[$dt]["HEAD"] = $equipLink["HEAD"]; } else { $charEquipLink[$dt]["HEAD"] = ""; }
				// Cuello
				if ($equipName["NECK"] != "") { $charEquip[$dt]["NECK"] = $equipName["NECK"]; } else { $charEquip[$dt]["NECK"] = ""; }
				if ($equipLink["NECK"] != "") { $charEquipLink[$dt]["NECK"] = $equipLink["NECK"]; } else { $charEquipLink[$dt]["NECK"] = ""; }
				// Espalda
				if ($equipName["BACK"] != "") { $charEquip[$dt]["BACK"] = $equipName["BACK"]; } else { $charEquip[$dt]["BACK"] = ""; }
				if ($equipLink["BACK"] != "") { $charEquipLink[$dt]["BACK"] = $equipLink["BACK"]; } else { $charEquipLink[$dt]["BACK"] = ""; }
				// Cintura
				if ($equipName["WAIST"] != "") { $charEquip[$dt]["WAIST"] = $equipName["WAIST"]; } else { $charEquip[$dt]["WAIST"] = ""; }
				if ($equipLink["WAIST"] != "") { $charEquipLink[$dt]["WAIST"] = $equipLink["WAIST"]; } else { $charEquipLink[$dt]["WAIST"] = ""; }
				// Brazos
				if ($equipName["ARMS"] != "") { $charEquip[$dt]["ARMS"] = $equipName["ARMS"]; } else { $charEquip[$dt]["ARMS"] = ""; }
				if ($equipLink["ARMS"] != "") { $charEquipLink[$dt]["ARMS"] = $equipLink["ARMS"]; } else { $charEquipLink[$dt]["ARMS"] = ""; }
				// Manos
				if ($equipName["HAND"] != "") { $charEquip[$dt]["HAND"] = $equipName["HAND"]; } else { $charEquip[$dt]["HAND"] = ""; }
				if ($equipLink["HAND"] != "") { $charEquipLink[$dt]["HAND"] = $equipLink["HAND"]; } else { $charEquipLink[$dt]["HAND"] = ""; }
				// Pies
				if ($equipName["FEET"] != "") { $charEquip[$dt]["FEET"] = $equipName["FEET"]; } else { $charEquip[$dt]["FEET"] = ""; }
				if ($equipLink["FEET"] != "") { $charEquipLink[$dt]["FEET"] = $equipLink["FEET"]; } else { $charEquipLink[$dt]["FEET"] = ""; }
				// Mano torpe
				if ($equipName["OFFHAND"] != "") { $charEquip[$dt]["OFFHAND"] = $equipName["OFFHAND"]; } else { $charEquip[$dt]["OFFHAND"] = ""; }
				if ($equipLink["OFFHAND"] != "") { $charEquipLink[$dt]["OFFHAND"] = $equipLink["OFFHAND"]; } else { $charEquipLink[$dt]["OFFHAND"] = ""; }
				// Arma secundaria
				if ($equipName["SECONDARY"] != "") { $charEquip[$dt]["SECONDARY"] = $equipName["SECONDARY"]; } else { $charEquip[$dt]["SECONDARY"] = ""; }
				if ($equipLink["SECONDARY"] != "") { $charEquipLink[$dt]["SECONDARY"] = $equipLink["SECONDARY"]; } else { $charEquipLink[$dt]["SECONDARY"] = ""; }
				// Anillo izquierdo
				if ($equipName["RING1"] != "") { $charEquip[$dt]["RING1"] = $equipName["RING1"]; } else { $charEquip[$dt]["RING1"] = ""; }
				if ($equipLink["RING1"] != "") { $charEquipLink[$dt]["RING1"] = $equipLink["RING1"]; } else { $charEquipLink[$dt]["RING1"] = ""; }
				// Anillo derecho
				if ($equipName["RING2"] != "") { $charEquip[$dt]["RING2"] = $equipName["RING2"]; } else { $charEquip[$dt]["RING2"] = ""; }
				if ($equipLink["RING2"] != "") { $charEquipLink[$dt]["RING2"] = $equipLink["RING2"]; } else { $charEquipLink[$dt]["RING2"] = ""; }
				// Tutuaje
				if ($equipName["TATOO"] != "") { $charEquip[$dt]["TATOO"] = $equipName["TATOO"]; } else { $charEquip[$dt]["TATOO"] = ""; }
				if ($equipLink["TATOO"] != "") { $charEquipLink[$dt]["TATOO"] = $equipLink["TATOO"]; } else { $charEquipLink[$dt]["TATOO"] = ""; }
				// Recompensa alternativa
				if ($equipName["REWARD"] != "") { $charEquip[$dt]["REWARD"] = $equipName["REWARD"]; } else { $charEquip[$dt]["REWARD"] = ""; }
				if ($equipLink["REWARD"] != "") { $charEquipLink[$dt]["REWARD"] = $equipLink["REWARD"]; } else { $charEquipLink[$dt]["REWARD"] = ""; }
				// Utensilio
				if ($equipName["IMPLEMENT"] != "") { $charEquip[$dt]["IMPLEMENT"] = $equipName["IMPLEMENT"]; } else { $charEquip[$dt]["IMPLEMENT"] = ""; }
				if ($equipLink["IMPLEMENT"] != "") { $charEquipLink[$dt]["IMPLEMENT"] = $equipLink["IMPLEMENT"]; } else { $charEquipLink[$dt]["IMPLEMENT"] = ""; }
				// ------------------------------------------------------------------------------------------------------------------------------------- //
		}
	?>
			</thead>
			<tbody>
			<!-- Cerora parte <?php //echo $charEquip[$wp]["LEVEL"]; ?> --> 
				<tr class="even">
					<td class="slotName">Nivel</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>".$charEquip[$wp]["LEVEL"]."</td>";
					}
					$wp = 0;
					?>
				</tr>
			<!-- Primera parte -->
				<tr class="odd">
					<td class="slotName">Arma</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["WEAPON"] !="") {
							echo "<a href='".$charEquipLink[$wp]["WEAPON"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["WEAPON"]."</a></td>";
					}
					$wp = 0;
					?>
				</tr>
				<tr class="even">
					<td class="slotName">Arma secundaria</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["SECONDARY"] !="") {
							echo "<a href='".$charEquipLink[$wp]["SECONDARY"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["SECONDARY"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="odd">
					<td class="slotName">Mano torpe</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["OFFHAND"] !="") {
							echo "<a href='".$charEquipLink[$wp]["OFFHAND"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["OFFHAND"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="even">
					<td class="slotName">Utensilio</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["IMPLEMENT"] !="") {
							echo "<a href='".$charEquipLink[$wp]["IMPLEMENT"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["IMPLEMENT"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
			<!-- Segunda parte -->
				<tr class="odd">
					<td class="slotName">Cabeza</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["HEAD"] !="") {
							echo "<a href='".$charEquipLink[$wp]["HEAD"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["HEAD"]."</a></td>";
					}
					$wp = 0;
					?>
				</tr>
				<tr class="even">
					<td class="slotName">Cuerpo</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["BODY"] !="") {
							echo "<a href='".$charEquipLink[$wp]["BODY"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["BODY"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="odd">
					<td class="slotName">Espalda</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["BACK"] !="") {
							echo "<a href='".$charEquipLink[$wp]["BACK"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["BACK"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="even">
					<td class="slotName">Cintura</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["WAIST"] !="") {
							echo "<a href='".$charEquipLink[$wp]["WAIST"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["WAIST"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
			<!-- Tercera parte -->
				<tr class="odd">
					<td class="slotName">Brazos</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["ARMS"] !="") {
							echo "<a href='".$charEquipLink[$wp]["ARMS"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["ARMS"]."</a></td>";
					}
					$wp = 0;
					?>
				</tr>
				<tr class="even">
					<td class="slotName">Manos</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["HAND"] !="") {
							echo "<a href='".$charEquipLink[$wp]["HAND"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["HAND"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="odd">
					<td class="slotName">Pies</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["FEET"] !="") {
							echo "<a href='".$charEquipLink[$wp]["FEET"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["FEET"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="even">
					<td class="slotName">Tatuaje</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["TATOO"] !="") {
							echo "<a href='".$charEquipLink[$wp]["TATOO"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["TATOO"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
			<!-- Cuarta parte -->
				<tr class="odd">
					<td class="slotName">Cuello</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["NECK"] !="") {
							echo "<a href='".$charEquipLink[$wp]["NECK"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["NECK"]."</a></td>";
					}
					$wp = 0;
					?>
				</tr>
				<tr class="even">
					<td class="slotName">Anillo izquierdo</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["RING1"] !="") {
							echo "<a href='".$charEquipLink[$wp]["RING1"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["RING1"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="odd">
					<td class="slotName">Anillo derecho</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["RING2"] !="") {
							echo "<a href='".$charEquipLink[$wp]["RING2"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["RING2"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
				<tr class="even">
					<td class="slotName">Recompensa</td>
					<?php
					for($wp=0;$wp<count($charEquip);$wp++) {
						echo "<td>";
						if ($charEquipLink[$wp]["REWARD"] !="") {
							echo "<a href='".$charEquipLink[$wp]["REWARD"]."' target='_blank'>";
						} else {
							echo "<a>";
						}
						echo $charEquip[$wp]["REWARD"]."</a></td>";
					}
					$wp = 0;
					?>					
				</tr>
			</tbody>
		</table>
	<br/>
	</div>
<?php 
	}
} else {
	echo "Elige party fish";
}
// Si no estamos registrados, no dejamos que nadie vea el contenido.
} else {
	echo $phraseNoAuth;
}
?>
