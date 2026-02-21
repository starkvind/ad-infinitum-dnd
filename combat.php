<?php 
	header('Content-Type: text/html; charset=UTF-8'); 
	// -------------------------------------------------------------------------------------- //
	session_start();
	ob_start();
	// -------------------------------------------------------------------------------------- //
	include_once("content/rosetta.php"); 	// Archivo de la base de datos y configuración
	mysql_select_db($bdd, $link); 			// Seleccionamos la base de datos
	include_once("script/functions.php");	// Archivo con las funciones PHP
	$adZone = "dnd";						// Variable que define la parte de la web que estamos viendo.
	// -------------------------------------------------------------------------------------- //
	// Configuración de la pantalla de combate.
	$showDeadInitiative = TRUE;  			// ¿Mostrar en la tabla de iniciativas a las unidades muertas?
	$showUnitAvatars	= TRUE;			    // ¿Mostrar avatares? 
	$unitArray = array('party' => array(), 'enemy' => array(), 'neutral' => array());
	$combatInitiatives = array();
	// Barras de Vida
	$showPartyHp		= TRUE;				// ¿Mostrar la salud de los jugadores?
	$showEnemyHp		= FALSE;			// ¿Mostrar la salud de los enemigos?
	$showNeutralHp		= FALSE;			// ¿Mostrar la salud de los personajes neutrales?
	// -------------------------------------------------------------------------------------- //
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- Icono de la Web -->
		<link href="/../hub/infinidice.ico" type="image/x-icon" rel="shortcut icon" />
	<!-- Datos jscript -->
		<?php include_once("script/style_css.php"); ?>
	<!-- Datos del orden de las tablas -->
		<script type="text/javascript" language="javascript" src="<?php echo $pageRoot; ?>script/s.pagetable.js"></script>
	<script type="text/javascript" language="javascript">
		var interval = 0;
		
		if (history.forward(1)) {
			history.replace(history.forward(1));
		}
		
		function actualizar() {
			interval = window.setInterval ("cargar()", 60000);
		}
		
		function cargar() {
			window.clearInterval (interval);
			window.open ("combat.php", "_self");
		} 
	</script>
	<!-- Título de la web -->
	<title>%TITLE%</title>
</head>
<body onload="actualizar();"> 
	<div id="mainBody" style="width: 90%"> <!-- Abrimos DIV general [001] -->
		<!-- Zona central -->
		<div class="mainCombat">
			<?php
				// Cogemos la última batalla añadida.
				$battleQuery = "SELECT * FROM ".$dydTableCombats." ORDER BY date DESC LIMIT 1;"; // Elegimos el Equipamiento en la Base de Datos.
				$battleOrder = mysql_query($battleQuery, $link);
				$battleRows  = mysql_num_rows($battleOrder);
				// -------------------------------------------------------------------------------->
				if ($battleRows != 0) {
					$battleDataFetch = mysql_fetch_array($battleOrder);
					$battleID_2		= $battleDataFetch["id"];		// Preparamos el id del enfrentamiento.
					$battleName 	= $battleDataFetch["name"];		// Preparamos el nombre del enfrentamiento.
					$battleLocation = $battleDataFetch["location"];	// Preparamos el lugar del enfrentamiento.
					$battleTerrain	= $battleDataFetch["terrain"];	// Preparamos el terreno de fondo.
					// Colocamos el Título
					$finalTitle = $battleName." - Ad Infinitum";	// Título del Combate
					// Mostramos los datos, a ver qué pasa.
					echo "<div id='battleTitle'>".$battleName."</div>";
					// Elegimos los combatientes
					$battleUnitQuery = "SELECT * FROM ".$dydTableCombatUnits." WHERE combat_id LIKE ".$battleID_2.";"; // Elegimos los combatientes del combate.
					$battleUnitOrder = mysql_query($battleUnitQuery, $link);
					$battleUnitRows  = mysql_num_rows($battleUnitOrder);
					if ($battleUnitRows != 0) {
						for($unitC=0;$unitC<$battleUnitRows;$unitC++) {
							$battleUnitDataFetch = mysql_fetch_array($battleUnitOrder);	// Recolectamos la información de las unidades.
							// Preparamos las variables para su procesamiento.
							$unitURL 		= $battleUnitDataFetch["url"];			// URL o ID de la criatura (o jugador)
							$unitGivenName	= $battleUnitDataFetch["name"];			// Nombre dado a la unidad (útil para usar Orcos como Humanos mercenarios y tal)
							$unitGivenFace	= $battleUnitDataFetch["unit_avatar"];	// Avatar personalizado para la unidad.
							$unitFaction	= $battleUnitDataFetch["faction"];		// Facción de la unidad
							$unitCombatCode	= $battleUnitDataFetch["combat_code"];	// Código de la unidad (para pjs duplicados y tal)
							$unitType		= $battleUnitDataFetch["type"];			// Tipo de unidad
							$unitInitiative	= $battleUnitDataFetch["initiative"];	// Iniciativa de la unidad
							$unitStatus		= $battleUnitDataFetch["status"];		// Estado de la unidad
							$unitTurnActive	= $battleUnitDataFetch["turn_active"];	// ¿La unidad está activa en este turno?
							$unitHPplus		= $battleUnitDataFetch["hp_plus"];		// Bonificador adicional de salud (o como Adrián es un puto vago)
							// Vamos a ver de dónde sacamos los datos.
							switch($unitType) {
								// Jugadores
								case 0:
									$unitSearchTable 	= $dydTablePlayers; 		// Tabla de Jugadores
									$unitSearchFields 	= "name, surname, class";	// Campos a buscar
								break;
								// Cartas de criatura
								case 1:
									$unitSearchTable 	= $dydTableCreatures; 								// Tabla de Enemigos
									$unitSearchFields 	= "name, hp, role, ac, fortitude, reflex, will";	// Campos a buscar
								break;		
							}
							// Preparamos la orden de búsqueda, dependiendo si es numérico o nombre
							if(is_numeric($unitURL)) {
								$unitSearchCriteria = "id LIKE ".$unitURL."";
							} else {
								$unitSearchCriteria = "url LIKE '".$unitURL."'";
							}
							// Cogemos los datos de las tablas adecuadas.
							$dataUnitQuery	 = "SELECT ".$unitSearchFields." FROM ".$unitSearchTable." WHERE ".$unitSearchCriteria." LIMIT 1;"; // Elegimos la criatura de sus tablas.
							$dataUnitOrder	 = mysql_query($dataUnitQuery, $link);
							$dataUnitRows	 = mysql_num_rows($dataUnitOrder);
							if ($dataUnitRows != 0) {
								$dataUnitDataFetch = mysql_fetch_array($dataUnitOrder);	// Recolectamos la información de la unidad.
								// Preparamos la información.
								switch($unitType) {
									// Es un jugador.
									case 0:
										$unitName = $dataUnitDataFetch["name"]." ".$dataUnitDataFetch["surname"];	// Nombre de la unidad
										$unitRole = $dataUnitDataFetch["class"];
										$unitHP   = $unitHPplus;
										// Conseguimos su clase
										$retrieveFrom = "class";
										$dataListClass = $unitRole;
											include ("content/sections/retrieve_origin.php");
										$unitRole = $classRole;
									break;
									// Es una criatura
									case 1:
										if ($unitGivenName == "") { $unitName = $dataUnitDataFetch["name"]." ".$unitCombatCode; } else { $unitName = $unitGivenName." ".$unitCombatCode; }
										$unitRole = $dataUnitDataFetch["role"];
										$unitHP   = $dataUnitDataFetch["hp"] + $unitHPplus;
									break;
								}
								// Preparamos los efectos y el daño que hayan recibido.
								$turnUnitQuery 	= "SELECT * FROM ".$dydTableCombatTurns." WHERE defender LIKE '".$unitURL."' OR defender LIKE '".$unitCombatCode."';"; // Seleccionamos los turnos donde la criatura haya sido atacada.
								$turnUnitOrder	 = mysql_query($turnUnitQuery, $link);
								$turnUnitRows	 = mysql_num_rows($turnUnitOrder);
								$unitDamage = 0;
								if ($turnUnitRows != 0) {
									// Preparamos el HP
									for($unitHPC=0;$unitHPC<$turnUnitRows;$unitHPC++) {
										$turnUnitDataFetch = mysql_fetch_array($turnUnitOrder);	// Recolectamos la información de la salud.
										$unitDamage = $unitDamage+$turnUnitDataFetch["damage"];
									}
									// Hemos encontrado daño, asi que se lo hacemos.
									$unitHPremaining = $unitHP-$unitDamage;
								} else { 
									// La criatura está sin tocar.
									$unitHPremaining = $unitHP;
								}// Fin comprobación turnUnitRows
								// Preparamos el avatar y los estados.
								if ($unitGivenFace == "") {
									$unitAvatar = "media/avatar/".$unitURL.".png";
								} else {
									$unitAvatar = "media/avatar/".$unitGivenFace.".png";
								}
								// Comprobamos si existe el Avatar
								if (!file_exists($unitAvatar)) {
									//echo "El fichero $unitAvatar no existe";
									$unitAvatar = "media/user/noavatar.png";
								}
								// Si la longitud del nombre es más que 16 Caracteres, los cortamos.
								if (strlen($unitName) > 16) { $charactersToCut = strlen($unitName)-16; $unitName = substr($unitName, 0, -$charactersToCut); }
								// Comprobamos que estamos vivos.
								if ($unitHPremaining<=0) { $unitDeath = TRUE; } else { $unitDeath = FALSE; }
								// Definimos el color del rol de la unidad
								switch($unitRole) {
									case "Defensor":
									case "Soldado":
										$unitRoleColor = "blueRole";
									break;
									case "Líder":
									case "Artillero":
										$unitRoleColor = "greenRole";
									break;
									case "Pegador":
									case "Bruto":
										$unitRoleColor = "redRole";
									break;
									case "Controlador":
										$unitRoleColor = "purpleRole";
									break;
									case "Acechador":
									case "Hostigador":
										$unitRoleColor = "yellowRole";
									break;
								}
								// Unimos los datos al array de Facciones.
								$unitArray[$unitFaction][$unitC] = [
									"NAME" 			=> $unitName,
									"AVATAR"		=> $unitAvatar,
									"ROLE"			=> $unitRole,
									"ROLE_COLOR"	=> $unitRoleColor,
									"HP"			=> $unitHPremaining,
									"MAXHP"			=> $unitHP,
									"STATUS"		=> $unitStatus,
									"ALIVE"			=> $unitDeath
								];
								// Preparamos el array de Iniciativas
								$combatInitiatives[$unitInitiative] = $unitFaction."|".$unitName."|".$unitTurnActive."|".$unitDeath;
							} // Fin comprobación dataUnitRows
						}
				// Mostramos el fondo
				echo "<div id='battleBackground' style='background-image: url(media/terrain/".$battleTerrain.".jpg);'>";
					// Preparamos el estilo para las Cartas muertas.
					$deathUnitStyle = "opacity: 0.2";
					// Mostramos los datos según las diferentes facciones
					echo "<div id='battleUnitCardMat'>"; // Tablero de Cartas
						// -------------------------------------------------------------------------------->
						// Sección "Grupo de Jugadores"
						$unitArray["party"] = array_values($unitArray["party"]);  // Limpiamos valores
						if (count($unitArray["party"]) > 0) {
							echo "<fieldset>";
							for($unitPartyC=0;$unitPartyC<count($unitArray["party"]);$unitPartyC++) {
								// Comprobamos que la unidad no esté muerta para mostrar los datos.
								if ($unitArray["party"][$unitPartyC]["ALIVE"] == TRUE) { $unitBlockStyle = $deathUnitStyle; } else {  $unitBlockStyle = ""; }
								echo "<div id='unitBlock' class='party' style='".$unitBlockStyle."'>";
									echo "<div id='unitName' class='party'>".$unitArray["party"][$unitPartyC]["NAME"]."</div>";
									if ($showUnitAvatars == TRUE) {
										echo "<img src='".$pageRoot.$unitArray["party"][$unitPartyC]["AVATAR"]."' title='".$unitArray["party"][$unitPartyC]["NAME"]."' style='z-index:8;' />";
										$changeMarginNumericHealth = "";
									} else {
										$changeMarginNumericHealth = "noAvatar";
									}
									echo "<div id='unitHealth'>".hpbar($unitArray["party"][$unitPartyC]["HP"],$unitArray["party"][$unitPartyC]["MAXHP"])."</div>";
									if ($showPartyHp == TRUE) { echo "<div id='unitNumericHealth' class='".$changeMarginNumericHealth."'>".$unitArray["party"][$unitPartyC]["HP"]."/".$unitArray["party"][$unitPartyC]["MAXHP"]."</div>"; }
									echo "<div id='unitRole' class='".$unitArray["party"][$unitPartyC]["ROLE_COLOR"]."'>".$unitArray["party"][$unitPartyC]["ROLE"]."</div>";
								echo "</div>";
							}
							echo "</fieldset>";
						} // Fin Sección "Grupo de Jugadores"
						// -------------------------------------------------------------------------------->
						// Sección "Enemigos"
						$unitArray["enemy"] = array_values($unitArray["enemy"]); // Limpiamos valores
						if (count($unitArray["enemy"]) > 0) {
							echo "<fieldset>";
							for($unitEnemyC=0;$unitEnemyC<count($unitArray["enemy"]);$unitEnemyC++) {
								// Comprobamos que la unidad no esté muerta para mostrar los datos.
								if ($unitArray["enemy"][$unitEnemyC]["ALIVE"] == TRUE) { $unitBlockStyle = $deathUnitStyle; } else {  $unitBlockStyle = ""; }
								echo "<div id='unitBlock' class='enemy' style='".$unitBlockStyle."'>";
									echo "<div id='unitName' class='enemy'>".$unitArray["enemy"][$unitEnemyC]["NAME"]."</div>";
									if ($showUnitAvatars == TRUE) {
										echo "<img src='".$pageRoot.$unitArray["enemy"][$unitEnemyC]["AVATAR"]."' title='".$unitArray["enemy"][$unitEnemyC]["NAME"]."' style='z-index:8;' />";
										$changeMarginNumericHealth = "";
									} else {
										$changeMarginNumericHealth = "noAvatar";
									}
									echo "<div id='unitHealth'>".hpbar($unitArray["enemy"][$unitEnemyC]["HP"],$unitArray["enemy"][$unitEnemyC]["MAXHP"])."</div>";
									if ($showEnemyHp == TRUE) { echo "<div id='unitNumericHealth' class='".$changeMarginNumericHealth."'>".$unitArray["enemy"][$unitEnemyC]["HP"]."/".$unitArray["enemy"][$unitEnemyC]["MAXHP"]."</div>"; }
									echo "<div id='unitRole' class='".$unitArray["enemy"][$unitEnemyC]["ROLE_COLOR"]."'>".$unitArray["enemy"][$unitEnemyC]["ROLE"]."</div>";
								echo "</div>";
							}
							echo "</fieldset>";
						} // Fin Sección "Enemigos"
						// -------------------------------------------------------------------------------->
						// Sección "Neutrales"
						$unitArray["neutral"] = array_values($unitArray["neutral"]); // Limpiamos valores
						if (count($unitArray["neutral"]) > 0) {
							echo "<fieldset>";
							for($unitNeutralC=0;$unitNeutralC<count($unitArray["neutral"]);$unitNeutralC++) {
								// Comprobamos que la unidad no esté muerta para mostrar los datos.
								if ($unitArray["neutral"][$unitNeutralC]["ALIVE"] == TRUE) { $unitBlockStyle = $deathUnitStyle; } else {  $unitBlockStyle = ""; }
								echo "<div id='unitBlock' class='neutral' style='".$unitBlockStyle."'>";
									echo "<div id='unitName' class='neutral'>".$unitArray["neutral"][$unitNeutralC]["NAME"]."</div>";
									// Mostramos o no el avatar según configuración.
									if ($showUnitAvatars == TRUE) {
										echo "<img src='".$pageRoot.$unitArray["neutral"][$unitNeutralC]["AVATAR"]."' title='".$unitArray["neutral"][$unitNeutralC]["NAME"]."' style='z-index:8;' />";
										$changeMarginNumericHealth = "";			// Estilo para los PS numéricos.
									} else {
										$changeMarginNumericHealth = "noAvatar";	// Estilo para los PS numéricos.
									}
									echo "<div id='unitHealth'>".hpbar($unitArray["neutral"][$unitNeutralC]["HP"],$unitArray["neutral"][$unitNeutralC]["MAXHP"])."</div>";
									if ($showNeutralHp == TRUE) { echo "<div id='unitNumericHealth' class='".$changeMarginNumericHealth."'>".$unitArray["neutral"][$unitNeutralC]["HP"]."/".$unitArray["neutral"][$unitNeutralC]["MAXHP"]."</div>"; }
									echo "<div id='unitRole' class='".$unitArray["neutral"][$unitNeutralC]["ROLE_COLOR"]."'>".$unitArray["neutral"][$unitNeutralC]["ROLE"]."</div>";
								echo "</div>";
							}
							echo "</fieldset>";
						} // Fin Sección "Enemigos"
					} // Fin comprobación battleUnitRows
				echo "</div>"; // Tablero de Cartas
					// --------------------------------------------------------->
					// Preparamos iniciativas
					ksort($combatInitiatives);
					$newCombatInitiatives = array_reverse($combatInitiatives, true);
					$combatInitiatives = $newCombatInitiatives;
					// Mostramos los datos.
					echo "<div id='initiativeBlock'>"; // Tabla de Iniciativas
					echo "<h5>Iniciativas</h5>";
						echo "<table>";
							echo "<thead>";
								echo "<th style='text-align:right;'>Unidad</th>";
								echo "<th>Valor</th>";
							echo "</thead>";
							echo "<tbody>";
					// Preparamos las iniciativas.
					for($initiativeCount=999;$initiativeCount>0;$initiativeCount--) {
							if ($combatInitiatives[$initiativeCount] != "") {
								// Asignamos una variable más fácil de usar, y coleccionamos todos los datos del array.
								$initiativeUnitName = $combatInitiatives[$initiativeCount];
								$initiativeUnitName = explode("|", $initiativeUnitName);
								// Si está activa, rodeamos el jugador con un halo.
								switch($initiativeUnitName[2]) {
									case 1:
										if ($initiativeUnitName[3] == TRUE) { $initiativeUnitActive = "dead"; } else { $initiativeUnitActive = "active"; }
									break;
									default:
										if ($initiativeUnitName[3] == TRUE) { $initiativeUnitActive = "dead"; } else { $initiativeUnitActive = ""; }
									break;
								}
								// Dividimos la iniciativa actual entre 10.
								//$initiativeOfTheUnit = number_format($initiativeCount/10,0);
								$initiativeOfTheUnit = $initiativeCount;
								// Mostramos la iniciativa si la unidad está muerta y hemos puesto que se muestre.
								switch($initiativeUnitName[3]) {
									case TRUE:	// Está muerta.
										if ($showDeadInitiative == TRUE) {
											$showThisUnit = TRUE; 	// Mostramos
										} else {
											$showThisUnit = FALSE; 	// No mostramos
										}
									break;
									case FALSE:	// Está viva
										$showThisUnit = TRUE;		// Mostramos
									break;
								} // Fin comprobación si está muerta o viva.
								if ($showThisUnit == TRUE) {
									echo "<tr>";
										echo "<td id='".$initiativeUnitName[0]."' class='".$initiativeUnitActive."' style='text-align:right;'>".$initiativeUnitName[1]."</td>";
										echo "<td id='".$initiativeUnitName[0]."' class='".$initiativeUnitActive."'>".$initiativeOfTheUnit."</td>";
									echo "</tr>";
								}
						}
					}
							echo "</tbody>";
						echo "</table>";
					echo "</div>"; // Tabla de Iniciativas
					// --------------------------------------------------------->
				echo "</div>"; // Fondo
				} // Fin comprobación battleRows
				// -------------------------------------------------------------------------------->
			?>
		</div>
	</div>	<!-- Cerramos DIV general [001] -->
</body>
</html>	
<?php
	$pageContents = ob_get_contents(); // Get all the page's HTML into a string
	ob_end_clean(); // Wipe the buffer
	// Replace %TITLE% with $finalTitle variable contents, and print the HTML
	echo str_replace("%TITLE%", $finalTitle, $pageContents);
?>
