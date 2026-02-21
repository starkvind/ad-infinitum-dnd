<?php
	// INICIO RECOLECCION DATOS
	// ================================================================== //
	$idGetData = $enemyId; // Cogemos datos de la variable powerID
	$orderData ="SELECT * FROM ".$dydTableCreatures." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el Enemigo en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del enemigo
			$enemyUrl 	 	 	= $dataResult["url"]; 			// URL del enemigo.
			$enemyName 	 	 	= $dataResult["name"]; 			// Nombre del enemigo.
			$enemyLevel			= $dataResult["level"] ?? "";	// Nivel del enemigo.
			$enemyElite			= $dataResult["elite"];			// Si el enemigo es elite
			$enemyRole			= $dataResult["role"];			// Rol del enemigo.
			$enemyType			= $dataResult["type"];			// Tipo de enemigo (humanoide, animado, constructo, etc).
			$enemySubType		= $dataResult["subtype"];		// Subtipo de enemigo (no muerto, reptil, felino, magico, inmortal).
			$enemySize			= $dataResult["size"];			// Tamaño del enemigo.
			$enemyXp			= $dataResult["xp"];			// Experiencia que otorga enemigo.
			$enemyInitiative	= $dataResult["initiative"];	// Iniciativa del enemigo.
			$enemySenses		= $dataResult["senses"];		// Sentidos del enemigo.
			// --------------------------------------------------------------------------------- //
			$enemyHp			= $dataResult["hp"];			// PG del enemigo.
			$enemyAc			= $dataResult["ac"];			// CA del enemigo.
			$enemyFortitude		= $dataResult["fortitude"];		// Fortaleza del enemigo.
			$enemyReflex		= $dataResult["reflex"];		// Reflejos del enemigo.
			$enemyWill			= $dataResult["will"];			// Voluntad del enemigo.
			$enemySpeed			= $dataResult["speed"];			// Velocidad del enemigo.
			// --------------------------------------------------------------------------------- //
			$enemyRegen			= $dataResult["regen"];			// Regeneración del enemigo.
			$enemySaving		= $dataResult["saving"];		// Bonus a las salvaciones del enemigo.
			$enemyActionP		= $dataResult["action"];		// Puntos de acción del enemigo.
			$enemyInmune		= $dataResult["inmunities"];	// Regeneración de PG del enemigo.
			$enemyResist		= $dataResult["resistances"];	// Resistencias del enemigo.
			$enemyVulnerable	= $dataResult["vulnerabilities"];// Vulnerabilidades del enemigo.			
			// --------------------------------------------------------------------------------- //
			$enemyAlignment		= $dataResult["alignment"];		// Alineamiento del enemigo.
			$enemyLanguages		= $dataResult["languages"];		// Idiomas del enemigo.
			$enemySkills		= $dataResult["skills"];		// Habilidades del enemigo.
			$enemyLoot			= $dataResult["loot"];			// Botín del enemigo.
			// --------------------------------------------------------------------------------- //
			$enemyStrength		= $dataResult["strength"];		// Fuerza del enemigo.
			$enemyConstitution	= $dataResult["constitution"];	// Constitución del enemigo.
			$enemyDexterity		= $dataResult["dexterity"];		// Destreza del enemigo.
			$enemyIntelligence	= $dataResult["intelligence"];	// Inteligencia del enemigo.
			$enemyWisdom		= $dataResult["wisdom"];		// Sabiduría del enemigo.
			$enemyCharisma		= $dataResult["charisma"];		// Carisma del enemigo.
			// --------------------------------------------------------------------------------- //
			$enemyTraits		= $dataResult["traits"];		// Pasivas del enemigo.
			$enemyActions		= $dataResult["standard_actions"];// Acciones estándar del enemigo.
			$enemyMoves			= $dataResult["move_actions"];	// Acciones de movimiento.
			$enemyMinors		= $dataResult["minor_actions"];	// Acciones menores del enemigo.
			$enemyReactions		= $dataResult["reaction_actions"];// Acciones de reacción del enemigo.
			// --------------------------------------------------------------------------------- //
			$enemyHireling		= $dataResult["hireling"];		// Coste de mantenimiento del personaje contratado.
			$enemyLore			= $dataResult["lore"];			// Información y tácticas del enemigo.
			$enemyPicture		= $dataResult["picture"];		// Imagen del enemigo. 
			$enemySounds		= $dataResult["sounds"];		// Sonidos del enemigo.
			$enemyVisible		= $dataResult["visible"];		// Visibilidad del enemigo.
		// ================================================================== //
		// Conseguimos datos del Origen
			include_once(__DIR__ . "/content_origin.php");
		// Comprobar visibilidad del enemigo
			$userLevel = $_SESSION['level'] ?? 0;
			// Si no estamos logeados o estamos logeados con la cuenta de Invitado, ponemos el nivel a 0
			if ($userLevel == "" OR $userLevel == -1) { $userLevel = 0; }
		// ================================================================== //
	if ((isset($mainUserName) OR $originCanon != 0) AND $userLevel >= $enemyVisible) {
	// FIN RECOLECCION DATOS 
		// Calcular valores de PG Maltrecho y PG Esfuerzo
		$enemyBloodied = floor($enemyHp/2);
		$enemyHpSurge = floor($enemyHp/4);
		// Clasificar al enemigo
		switch ($enemyElite) {
			case 1:
				$eliteText = " solitario";
			break;
			case 2:
				$eliteText = " de élite";
			break;
			case 3:
				$eliteText = ", jefe";
			break;
			case 4:
				$eliteText = " aliado";
			break;
			case 7:
				$eliteText = " esbirro";
			break;
			case 9:
				$eliteText = " líder";
			break;
			default:
				$eliteText = "";
			break;
		}
		// Quitar la etiqueta de PX si es 0
		// Averiguar las puntuaciones de característica
		// Array de atributos
		$arrayStats = array(
			1 => $enemyStrength,
			2 => $enemyConstitution,
			3 => $enemyDexterity,
			4 => $enemyIntelligence,
			5 => $enemyWisdom,
			6 => $enemyCharisma
		);
		// Array de modificadores
		$arrayMods = array();
		// Operaciones
		for ($statC=1;$statC<7;$statC++) {
			$checkStat = $arrayStats[$statC];
			include ("stat_calc.php");
			// Sumamos medio nivel al modificador
			$statModFinal = $statMod + floor($enemyLevel/2);
			if ($statModFinal >= 0) { $modSign = "+"; } else { $modSign = ""; }
			// "<span title='Mod: ".$statMod." + &frac12; nv: ".floor($enemyHalfLevel)." = ".$modSign.$statModFinal."'>."</span>"".
			$arrayMods[$statC] = $modSign.$statModFinal;
		}
?>
<!-- INICIO DE TARJETA -->
	<div id="powerCard">
		<!-- Datos titulares del enemigo 252456 -->
		<?php 
			// Color del título de la Tarjeta
			switch($enemyElite) {
				// Aliado
				case 4:
					$enemyCardBG = "#012769";
				break;
				// Trampa
				case 6:
					$enemyCardBG = "#56242a";
				break;
			}
		?>
		<!-- Coloreamos el título según nos haga falta -->
		<div class="enemyTitle" style="<?php if ($enemyCardBG != "") { echo "background:$enemyCardBG;"; } ?>font-weight:bold;padding-bottom:10px;">
			<div class="cardTitleName"><?php echo $enemyName; ?></div>
			<div class="cardTitleClass">
				<?php
				// Si es un familiar, ponemos solo "Familiar"
				// En caso contrario, colocamos su rol y nivel
					if ($enemyElite != 5) {
						echo "$enemyRole$eliteText nivel $enemyLevel"; 
					} else {
						echo $enemyRole;
					}
				?>
			</div>
		</div>
		<?php 
		// ================================================================================================== //
		// ****************** 						BESTIARIO NORMAL 					   ******************
		// ================================================================================================== //
		switch($enemyElite) {
			default: 
		?>
		<div class="enemyTitle" style="<?php if ($enemyCardBG != "") { echo "background:".$enemyCardBG.";"; } ?>padding-top:0px;padding-bottom:10px;border-bottom: 1px solid #003366;">
			<div class="cardTitleName">
				<?php echo $enemyType." ".$enemySize.""; if ($enemySubType != "") { echo " (".$enemySubType.")"; } ?>
			</div>
			<?php if ($enemyXp !=0 AND $enemyElite != 4) { ?><div class="cardTitleClass"><?php echo $enemyXp; ?> PX</div><?php } ?>
		</div>
		<!-- Datos básicos del enemigo (PG, velocidad, visión, etc) -->
		<div class="enemyStats"> <!-- PG e Iniciativa -->
			<div class="cardTitleName">
				<b>PG:</b> <?php echo $enemyHp; ?>; 
					<?php
						// Si es un Esbirro, poner el texto del Esbirro
						if ($eliteText == " esbirro") { 
							echo "un ataque fallido nunca daña a un esbirro."; 
						// Si es un Objeto estático, poner que no puede estar maltrecho
						} else if ($enemyRole == "Objeto") {
							echo "no puede estar Maltrecho"; 
						} else {
							// Si es un Aliado, mostrar valor de Maltrecho y Esfuerzo
							if ($enemyElite ==  4) {
								echo "<b>Maltrecho:</b> ".$enemyBloodied.", <b>Esfuerzo:</b> ".$enemyHpSurge;
							// Si no, mostrar valor de Maltrecho
							} else {
								echo "<b>Maltrecho:</b> ".$enemyBloodied."";
							}
						}
						// Preparamos un salto de línea especial si es un enjambre
						if (strpos($enemySubType,"enjambre") !== false) {
							$jumpOnResistances = TRUE;
						}
	
					?>
			</div>
			<div class="cardTitleClass"><b>Iniciativa:</b> +<?php echo $enemyInitiative; ?></div>
		</div>
		<div class="enemyStats"> <!-- Defensas y Sentidos -->
			<div class="cardTitleName">
				<b>CA:</b> <?php echo $enemyAc; ?>,
				<b>Fortaleza:</b> <?php echo $enemyFortitude; ?>,
				<b>Reflejos:</b> <?php echo $enemyReflex; ?>,
				<b>Voluntad:</b> <?php echo $enemyWill; ?>
			</div>
			<?php $orderSenses = explode(";", $enemySenses);?>
			<div class="cardTitleClass"><b>Percepción:</b> <?php echo $orderSenses[0] ?? ""; ?></div>
		</div>
		 <!-- Velocidad, más visión -->
			<div class="enemyStats">
				<div class="cardTitleName"><b>Velocidad:</b> <?php echo $enemySpeed; ?></div>
				<div class="cardTitleClass"><i><?php echo $orderSenses[1] ?? ""; ?></i></div>
			</div>
		<!-- Regeneración -->
		<?php if ($enemyRegen != "") { ?>
			<div class="enemyStats">
				<div class="cardTitleName"><b>Regeneración:</b> <?php echo $enemyRegen; ?></div>
			</div>
		<?php } ?>
		<!-- Tiradas de Salvación y Puntos de Acción --> 
		<?php
			if ($enemySaving != "" OR $enemyActionP != 0) {
		?>
			<div class="enemyStats">
				<?php if ($enemySaving != "" AND $enemyActionP != 0) { $enemySavActSep = ";"; } else { $enemySavActSep = ""; } ?>
				<?php if ($enemySaving != "") {  echo "<b>Salvaciones:</b> ".trim($enemySaving).$enemySavActSep; } ?>
				<?php if ($enemyActionP != 0) {  echo "<b>Puntos de acción:</b> $enemyActionP"; } ?>
			</div>
		<?php
			}
		?>
		<!-- Inmunidades, resistencias, etc -->
		<?php
			$jumpOnResistances = FALSE;
			if ($enemyInmune != "" OR $enemyResist != "" OR $enemyVulnerable != "") {
		?>
		<div class="enemyStats" <?php if ($jumpOnResistances == TRUE) { ?> style="min-height:24px;" <?php }?>>
			<?php if ($enemyInmune != "") {  echo "<b>Inmune:</b> ".$enemyInmune; }?>
			<?php if ($enemyResist != "") {  echo "<b>Resiste:</b> ".$enemyResist; }?>
			<?php if ($jumpOnResistances == TRUE) { ?> <br/> <?php }?>
			<?php if ($enemyVulnerable != "") {  echo "<b>Vulnerable:</b> ".$enemyVulnerable; }?>
		</div>
		<?php } ?>
		<div style="background: #A3A392;padding-bottom:6px;border-bottom: 1px solid #003366;">
		</div>
		<!-- Poderes y demás usos -->
			<!-- Rasgos pasivos -->
		<?php if ($enemyTraits != "") { ?>
		<div class="enemySkillTitle" style="<?php if ($enemyCardBG != "") { echo "background:$enemyCardBG;"; } ?>">
			Rasgos
		</div>
		<?php
			$typeOfAttacks = $enemyTraits;
				include ("enemy_attacks.php");
			}
		?>
		<!-- Poderes a voluntad -->
		<?php if ($enemyActions != "") { ?>
		<div class="enemySkillTitle" style="<?php if ($enemyCardBG != "") { echo "background:$enemyCardBG;"; } ?>">
			Acciones estándar
		</div>
		<?php
			$typeOfAttacks = $enemyActions;
				include ("enemy_attacks.php");
			}
		?>
		<!-- Poderes de movimiento -->
		<?php if ($enemyMoves != "") { ?>
		<div class="enemySkillTitle" style="<?php if ($enemyCardBG != "") { echo "background:$enemyCardBG;"; } ?>">
			Acciones de movimiento
		</div>
		<?php
			$typeOfAttacks = $enemyMoves;
				include ("enemy_attacks.php");
			}
		?>
		<!-- Poderes menor -->
		<?php if ($enemyMinors != "") { ?>
		<div class="enemySkillTitle" style="<?php if ($enemyCardBG != "") { echo "background:$enemyCardBG;"; } ?>">
			Acciones menores
		</div>
		<?php
			$typeOfAttacks = $enemyMinors;
				include ("enemy_attacks.php");
			}
		?>
		<!-- Reacciones  -->
		<?php if ($enemyReactions != "") { ?>
		<div class="enemySkillTitle" style="<?php if ($enemyCardBG != "") { echo "background:$enemyCardBG;"; } ?>">
			Reacciones
		</div>
		<?php
			$typeOfAttacks = $enemyReactions;
				include ("enemy_attacks.php");
			}
		?>
		<!-- Habilidades  -->
		<?php if ($enemySkills != "") {	?>
		<div class="enemyStats" style="background:#707060;"> <!-- Habilidades -->
			<div class="cardTitleName"><b>Habilidades:</b> <?php echo $enemySkills; ?></div>
		</div>
		<?php } ?>
		<!-- Puntuaciones de característica del enemigo -->
		<div class="enemyStats" style="background:#707060;"> <!-- Caraceristicas arriba -->
			<span class="enemyAttrib"><b>Fuerza:</b> <?php echo "$enemyStrength ($arrayMods[1])"; ?></span>
			<span class="enemyAttrib"><b>Destreza:</b> <?php echo "$enemyDexterity ($arrayMods[3])"; ?></span>
			<span class="enemyAttrib"><b>Sabiduría:</b> <?php echo "$enemyWisdom ($arrayMods[5])"; ?></span>
		</div>
		<!-- Caraceristicas abajo -->
		<div class="enemyStats" style="background:#707060;padding-bottom:6px;border-bottom: 1px solid #003366;"> 
			<span class="enemyAttrib"><b>Constitución:</b> <?php echo "$enemyConstitution ($arrayMods[2])"; ?></span>
			<span class="enemyAttrib"><b>Inteligencia:</b> <?php echo "$enemyIntelligence ($arrayMods[4])"; ?></span>
			<span class="enemyAttrib"><b>Carisma:</b> <?php echo "$enemyCharisma ($arrayMods[6])"; ?></span>
		</div>
		<!-- Alineamientos, idiomas y botín -->
		<?php if ($enemyLoot != "") { $cardEndStyle = ""; } else { $cardEndStyle = "padding-bottom:6px;"; } ?>
		<div class="enemyStats" style="<?php echo $cardEndStyle; ?>"> <!-- Alineamiento e idiomas -->
			<div class="cardTitleName"><b>Alineamiento:</b> <?php echo $enemyAlignment; ?></div>
			<div class="cardTitleClass"><b>Idiomas:</b> <?php echo $enemyLanguages; ?></div>
		</div>
		<!-- Botín -->
		<?php if ($enemyLoot != "") { ?>
			<div class="enemyStats">
				<div class="cardTitleName"><b>Equipo:</b> <?php echo $enemyLoot; ?></div>
			</div>
				<?php if ($enemyHireling !="") { ?>
			<div class="enemyStats" style="padding-bottom:6px;">
				<div class="cardTitleName"><b>Mantenimiento:</b> <?php echo $enemyHireling; ?></div>
				<?php } else { ?>
			<div style="padding-bottom:6px;background:#A3A392;">
				<?php } ?>
			</div>
		<?php } ?>
	<?php
		// ================================================================================================== //
		// ****************** 						FAMILIARES		 					   ******************
		// ================================================================================================== //
		break;
		case 5:
	?>
		<!-- Datos del Familiar -->
		<?php if ($enemySkills != "") {	?>
		<div id="italic" class="enemyStats"> 
			<?php echo $enemySkills; ?>
		</div>
		<?php } ?>
		<!-- Sentidos del Familiar -->
		<?php if ($enemySenses != "") {	?>
		<div class="enemyStats"> 
			<b>Sentidos</b>: <?php echo $enemySenses; ?>
		</div>
		<?php } ?>
		<!-- Velocidad del Familiar -->
		<?php if ($enemySpeed != "") {	?>
		<div id="familiarData" class="enemyStats"> 
			<b>Velocidad</b>: <?php echo $enemySpeed; ?>
		</div>
		<?php } ?>
		<!-- Beneficios constantes -->
		<?php if ($enemyTraits != "") { ?>
		<div class="enemySkillTitle">
			Beneficios constantes
		</div>
		<div class="enemyAttackInfo">
			<?php echo $enemyTraits; ?>
		</div>
		<?php } ?>
		<!-- Beneficios constantes -->
		<?php if ($enemyActions != "") { ?>
		<div class="enemySkillTitle">
			Beneficios activos
		</div>
		<div class="enemyAttackInfo">
			<?php echo $enemyActions; ?>
		</div>
		<?php } ?>
		<!-- Peculiaridades del familiar -->
		<?php if ($enemyMoves != "") { ?>
		<div class="enemySkillTitle">
			Peculiaridades del familiar
		</div>
		<div class="enemyAttackInfo">
			<ul>
			<?php echo $enemyMoves; ?>
			</ul>
		</div>
		<!-- FIN DEL FAMILIAR -->
		<?php } ?>
	<?php 
		// ================================================================================================== //
		// ****************** 					TRAMPAS Y PELIGROS					   ******************
		// ================================================================================================== //
		break;
		case 6:
	?>
		<!-- Detalles de la Trampa -->
		<div class="enemyTitle" style="background:#56242a;padding-top:0px;padding-bottom:10px;border-bottom: 1px solid #003366;">
			<div class="cardTitleName"> <?php echo $enemyType; ?> </div>
			<div class="cardTitleClass"><?php echo $enemyXp; ?> PX</div>
		</div>
		<!-- Datos de la Trampa -->
		<?php if ($enemySkills != "") {	?>
		<div id="italic" class="enemyStats"> 
			<?php echo $enemySkills; ?>
		</div>
		<?php } ?>
		<!-- Descripción de la Trampa -->
		<div class="enemyStats" style="height:auto;padding-bottom:6px;"> 
			<b><?php echo $enemyType; ?>:</b> 
			<?php if ($enemyLoot != "") { echo $enemyLoot; } ?>	
		</div>
		<!-- Percepción de los PJs hacia la Trampa -->
		<?php if ($enemyTraits != "") { ?>
		<div class="enemyAttack" style="font-weight:bold;";>
			Percepción
		</div>
		<div class="enemyAttackInfo" style="padding-left:6px;">
			<ul><?php echo $enemyTraits; ?></ul>
			<?php if ($enemyHireling != "") { 
				// Dividimos la habilidad principal y las Clases de Dificultad
				$enemyTrapMoreSkill = explode("^", $enemyHireling);
				echo "<b>Habilidad adicional</b>: ".trim($enemyTrapMoreSkill[0]).".";
				echo "<ul>"; // Comenzamos listado para las Clases de Dificultad
				// Separamos las clases de dificultad
				$enemyTrapHelpSkill = explode("|", $enemyTrapMoreSkill[1]);
				$enemyTrapMoreSkillCount = count($enemyTrapHelpSkill);
				// Las mostramos
				//echo $enemyTrapMoreSkillCount;
				for($cd=0;$cd<$enemyTrapMoreSkillCount;$cd++) {
					echo "<li>".$enemyTrapHelpSkill[$cd]."</li>";
				}
				echo "</ul>"; // Cerramos listado
			?>
			<?php } ?>
			<?php if ($enemyInitiative != 0) { echo "<b>Iniciativa</b> +".$enemyInitiative; } ?>
			<?php if ($enemySpeed != "") { echo "<span style='padding-left:20px;'><b>Velocidad</b> ".$enemyInitiative."</span>"; } ?>
		</div>
		<?php } ?>
		<!-- Activación de la Trampa -->
		<?php if ($enemyActions != "") { ?>
		<div class="enemyAttack" style="font-weight:bold;";>
			Activación
		</div>
		<div class="enemyStats" style="height:auto;padding:6px 10px;">  
			<?php echo $enemyActions; ?>	
		</div>
		<?php } ?>
		<!-- Ataque de la Trampa -->
		<?php if ($enemyMoves != "") { ?>
		<div class="enemyAttack" style="font-weight:bold;";>
			Ataque
		</div>
		<div class="enemyStats" style="height:auto;padding-bottom:6px;padding-left:10px;">  
			<?php 
				// Preparamos los títulos primero
				$enemyTrapAttack = explode("^",$enemyMoves);
				$enemyTrapTitles = explode("-",$enemyTrapAttack[0]);
				// ^- los 0 y 1 de esta variable serán el tipo de acción y el alcance.
				$enemyTrapAttackCount = count($enemyTrapAttack);
				// Título del Ataque
				echo "<b>".$enemyTrapTitles[0]."</b>"."<span style='font-weight:bold;padding-left:50px;'>".$enemyTrapTitles[1]."</span><br/>";
				// Datos del Ataque
				for($ataks=1;$ataks<$enemyTrapAttackCount;$ataks++) {
					$enemyTrapAttackTopic = explode(":", $enemyTrapAttack[$ataks]); 
					echo "<b>".$enemyTrapAttackTopic[0].":</b>"." ".$enemyTrapAttackTopic[1]."<br/>";
				}
			?>	
		</div>
		<?php } ?>
		<!-- Contramedidas de la Trampa -->
		<?php if ($enemyMinors != "") { ?>
		<div class="enemyAttack" style="font-weight:bold;";>
			Contramedidas
		</div>
		<div class="enemyStats" style="height:auto;padding-bottom:6px;">  
			<ul style="padding-left:20px;margin-top:4px;margin-bottom:4px;"><?php echo $enemyMinors; ?></ul>
		</div>
		<?php } ?>
		<!-- Mejora a versión de élite de la Trampa -->
		<?php if ($enemyReactions != "") { ?>
		<?php 
			$enemyTrapXP = explode("^",$enemyReactions); 
		?>
		<div class="enemyAttack" style="font-weight:bold;";>
			Mejora a versión de élite (<?php echo $enemyTrapXP[0]; ?> PX)
		</div>
		<div class="enemyStats" style="height:auto;padding:6px 10px;">  
			<?php echo $enemyTrapXP[1]; ?>	
		</div>
		<?php } ?>
		<!-- FIN DE LAS TRAMPAS -->
	<?php break; } ?>
		<!-- DIV final para añadir el borde de abajo -->
		<div style="border-bottom: 1px solid #003366;"></div>
	</div>
<!-- FIN DE TARJETA -->
	<?php } else {
		echo "<div class='errorImg'>".$phraseNoAuth."</div>";
	} 
} ?>
