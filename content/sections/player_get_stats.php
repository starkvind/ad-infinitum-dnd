<?php
// Cálculo de atributos del personaje.
	if ($playerAttr != "") {
	echo "<div class='playerStatsLeft' style='padding-left:30px;'>";
		echo "<b>Características</b>";
		echo "<ul>";
		// ----------------------------------
		// Nombres de los Atributos
		// ----------------------------------
			$playerCharan[0] = "Fuerza";
			$playerCharan[1] = "Constitución";
			$playerCharan[2] = "Destreza";
			$playerCharan[3] = "Inteligencia";
			$playerCharan[4] = "Sabiduría";
			$playerCharan[5] = "Carisma";
		// ----------------------------------
		// Comprobamos modificadores raciales
		// ----------------------------------
		// Humano
		// ----------------------------------
		if ($humanBonus != "") {
			$checkAttribute = $humanBonus;
			include("player_attr.php");
			$humanStat = $attStat;
			$humanStatTitle = $attName;
		}
		// ----------------------------------
		// Otras razas
		// ----------------------------------
		if ($raceAbilities != "" AND $raceAbilities != "1HUMANO") { 
			$raceAbBonus1 = explode("/", $raceAbilities);
		// ----------------------------------
		// ATRIBUTO PRIMARIO
		// ----------------------------------
			$checkAttribute = $raceAbBonus1[0];
			include("player_attr.php");
			$raceStat1 = $attStat;
			$raceStatTitle1 = $attName;
		// ----------------------------------
		// ATRIBUTO SECUNDARIO
		// ----------------------------------
			$checkAttribute = $raceAbBonus1[$racialBonus];
			include("player_attr.php");
			$raceStat2= $attStat;
			$raceStatTitle2 = $attName;
		}
		// ----------------------------------
		// Bonificadores por Nivel
		// ----------------------------------
		// Nivel 4
		// ----------------------------------
		if ($lvl4Bonus != "") {
			$levelBonus = explode("/", $lvl4Bonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$level4A = $attStat;
			// Segundo Bonus
			$checkAttribute = $levelBonus[1];
			include("player_attr.php");
			$level4B = $attStat;
		}
		// ----------------------------------
		// Nivel 8
		// ----------------------------------
		if ($lvl8Bonus != "") {
			$levelBonus = explode("/", $lvl8Bonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$level8A = $attStat;
			// Segundo Bonus
			$checkAttribute = $levelBonus[1];
			include("player_attr.php");
			$level8B = $attStat;
		}
		// ----------------------------------
		// Nivel 14
		// ----------------------------------
		if ($lvl14Bonus != "") {
			$levelBonus = explode("/", $lvl14Bonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$level14A = $attStat;
			// Segundo Bonus
			$checkAttribute = $levelBonus[1];
			include("player_attr.php");
			$level14B = $attStat;
		}
		// ----------------------------------
		// Nivel 18
		// ----------------------------------
		if ($lvl18Bonus != "") {
			$levelBonus = explode("/", $lvl18Bonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$level18A = $attStat;
			// Segundo Bonus
			$checkAttribute = $levelBonus[1];
			include("player_attr.php");
			$level18B = $attStat;
		}
		// ----------------------------------
		// Nivel 24
		// ----------------------------------
		if ($lvl24Bonus != "") {
			$levelBonus = explode("/", $lvl24Bonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$level24A = $attStat;
			// Segundo Bonus
			$checkAttribute = $levelBonus[1];
			include("player_attr.php");
			$level24B = $attStat;
		}
		// ----------------------------------
		// Nivel 28
		// ----------------------------------
		if ($lvl28Bonus != "") {
			$levelBonus = explode("/", $lvl28Bonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$level28A = $attStat;
			// Segundo Bonus
			$checkAttribute = $levelBonus[1];
			include("player_attr.php");
			$level28B = $attStat;
		}
		// ----------------------------------
		// Destino épico
		// ----------------------------------
		if ($epicBonus != "") {
			$levelBonus = explode("/", $epicBonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$epicA = $attStat;
			// Segundo Bonus
			if ($levelBonus[1] != "") {
				$checkAttribute = $levelBonus[1];
				include("player_attr.php");
				$epicB = $attStat;
			}
		}		
		// ----------------------------------
		// Equipo [Guarrada manual]
		// ----------------------------------
		if ($statEquipBonus != "") {
			$levelBonus = explode("/", $statEquipBonus);
			// Primer Bonus
			$checkAttribute = $levelBonus[0];
			include("player_attr.php");
			$statEquipA = $attStat;
			// Segundo Bonus
			if ($levelBonus[1] != "") {
				$checkAttribute = $levelBonus[1];
				include("player_attr.php");
				$statEquipB = $attStat;
			}
		}
	// ----------------------------------		
	// Atributos principales
	// ----------------------------------
		$playerSTRo = $playerCharac[0];	
		$playerCONo = $playerCharac[1];
		$playerDEXo = $playerCharac[2];
		$playerINTo = $playerCharac[3];
		$playerWISo = $playerCharac[4];
		$playerCHAo = $playerCharac[5];
	// ----------------------------------
	// Sumamos los atributos de bonificación
	// ----------------------------------
		if ($humanStat >= 0 or $humanStat < 5) { $playerCharac[$humanStat] = $playerCharac[$humanStat] +2; }
		if ($raceStat1 >= 0 or $raceStat1 < 5) { $playerCharac[$raceStat1] = $playerCharac[$raceStat1] +2; }
		if ($raceStat2 >= 0 or $raceStat2 < 5) { $playerCharac[$raceStat2] = $playerCharac[$raceStat2] +2; }
	// ----------------------------------
	// Sumamos los atributos de nivel
	// ----------------------------------
		if ($lvl4Bonus != "") { $playerCharac[$level4A] = $playerCharac[$level4A] +1; $playerCharac[$level4B] = $playerCharac[$level4B] +1;	}
		if ($lvl8Bonus != "") { $playerCharac[$level8A] = $playerCharac[$level8A] +1; $playerCharac[$level8B] = $playerCharac[$level8B] +1;	}
		if ($lvl14Bonus != "") { $playerCharac[$level14A] = $playerCharac[$level14A] +1; $playerCharac[$level14B] = $playerCharac[$level14B] +1; }
		if ($lvl18Bonus != "") { $playerCharac[$level18A] = $playerCharac[$level18A] +1; $playerCharac[$level18B] = $playerCharac[$level18B] +1; }
		if ($lvl24Bonus != "") { $playerCharac[$level24A] = $playerCharac[$level24A] +1; $playerCharac[$level24B] = $playerCharac[$level24B] +1; }
		if ($lvl28Bonus != "") { $playerCharac[$level28A] = $playerCharac[$level28A] +1; $playerCharac[$level28B] = $playerCharac[$level28B] +1; }
	// ----------------------------------
	// Sumamos los bonos por cambio de rango
	// ----------------------------------
		// Parangón
		// ----------------------------------
		if ($playerLevel >= 11) {
			for($bp=0;$bp<6;$bp++) { $playerCharac[$bp] = $playerCharac[$bp] +1; }
		}
		// ----------------------------------
		// Épico
		// ----------------------------------
		if ($playerLevel >= 21) {
			for($be=0;$be<6;$be++) { $playerCharac[$be] = $playerCharac[$be] +1; }
		}
	// ----------------------------------
	// Sumamos atributos si el Destino épico los da
	// ----------------------------------
		if ($epicBonus != "") { $playerCharac[$epicA] = $playerCharac[$epicA] +2; $playerCharac[$epicB] = $playerCharac[$epicB] +2; }
	// ----------------------------------
	// Sumamos atributos si el Equipo los da [Guarrada Manual]
	// ----------------------------------		
		if ($statEquipBonus != "") { $playerCharac[$statEquipA] = $playerCharac[$statEquipA] +1; $playerCharac[$statEquipB] = $playerCharac[$statEquipB] +1; }
	// ----------------------------------
	// Atributos del Personaje
	// ----------------------------------
			for($ps=0;$ps<6;$ps++) {
			// ----------------------------------
			// Comprobamos el modificador de característica
			// ----------------------------------
				$checkStat = $playerCharac[$ps];
				include ("stat_calc.php");
				$playerCharam[$ps] = $statMod;
				if ($playerCharam[$ps] >= 0) { $modSign[$ps] = "+"; } else { $modSign[$ps] = ""; }
				echo "<li><b>".$playerCharan[$ps].":</b>";
					echo "<span class='playerStat'>".$playerCharac[$ps];
					echo "<span class='playerMod'>(".$modSign[$ps].$playerCharam[$ps].")</span>";
					echo "</span>";
				echo "</li>";
			}
		echo "</ul>";
	echo "</div>"; // <-- Cerramos DIV de Stats
	}
	// ----------------------------------
	// Preparamos datos de armadura equipada
	// ----------------------------------
	$equipArmorType = $equipArmor["BODY"];
	if ($equipArmorType != "") {
		$armorSearch = "armor";
		include("player_armor.php");
		//echo "<br/> $equipArmorType - CA: $armorAC / Penalizad hab: $armorSkill / Penalizad vel: $armorSpeed / Tipo: $armorKind <br/>";
		// Preparamos el bonificador básico a la CA
		// ----------------------------------
		switch($armorKind) {
			// ----------------------------------
			// Ligera: bonus armadura + bonus de MOD
			// ----------------------------------
			case "Ligera":
				$acArmorBonus = max($playerCharam[2], $playerCharam[3]) + $armorAC;
			break;
			// ----------------------------------
			// Pesada: bonus armadura
			// ----------------------------------
			case "Pesada":
				$acArmorBonus = $armorAC;
			break;
		}
		$armorSkillMalus = $armorSkill;
		$armorSpeedMalus = $armorSpeed;
	}
	// ----------------------------------
	// Preparamos los datos del escudo equipado
	// ----------------------------------
	$shieldType = $equipArmor["OFFHAND"];
	if ($shieldType != ""){
		$armorSearch = "shield";
		include("player_armor.php");
		//echo "<br/> $shieldType - CA: $armorAC / Penalizad hab: $armorSkill / Penalizad vel: $armorSpeed / Tipo: $armorKind <br/>";
		$shieldArmorBonus = $armorAC;
		$shieldSkillMalus = $armorSkill;
	}
	// ----------------------------------
	// Preparamos datos de las habilidades
	// ----------------------------------
		include_once("player_get_skills.php");
	// ----------------------------------
	// Preparamos los datos de las defensas de clase
	// ----------------------------------
	$classDefenses = explode(";", $classDefense);
	$defenseCount = count($classDefenses);
	for($cd=0;$cd<$defenseCount;$cd++) {
		$classDefenseText = explode (":", $classDefenses[$cd]);
		switch ($classDefenseText[0]) {
			case "FOR":
				$classDefenseName[0] = "Fortaleza";
				$classDefenseVal[0] = $classDefenseText[1];
			break;
			case "REF":
				$classDefenseName[1] = "Reflejos";
				$classDefenseVal[1] = $classDefenseText[1];
			break;
			case "VOL":
				$classDefenseName[2] = "Voluntad";
				$classDefenseVal[2] = $classDefenseText[1];
			break;
		}
	}
	// ----------------------------------
	// Defensas del Personaje
	// ----------------------------------
		$playerCA 	= 10 + floor($playerLevel/2) + $acArmorBonus + $shieldArmorBonus;
		$playerFOR 	= 10 + floor($playerLevel/2) + max($playerCharam[0], $playerCharam[1]) + $classDefenseVal[0];
		$playerREF 	= 10 + floor($playerLevel/2) + max($playerCharam[2], $playerCharam[3]) + $shieldArmorBonus + $classDefenseVal[1];
		$playerWIL 	= 10 + floor($playerLevel/2) + max($playerCharam[4], $playerCharam[5]) + $classDefenseVal[2];
		// ----------------------------------
		// Iniciativa, velocidad y visión
		// ----------------------------------
		$playerINI  = $playerCharam[2] + floor($playerLevel/2);
		if ($playerINI >= 0) { $playerINIsymbol = "+"; } else { $playerINIsymbol = ""; }
		$playerSPE 	= $raceSpeed + $armorSpeedMalus;
		// ----------------------------------
		// Vitalidad, salud y esfuerzos curativos
		// ----------------------------------
		$playerLevelHP  = ($playerLevel -1) * $classHpLvl;
		$playerHP 		= $playerCharac[1] + $classHp1st + $playerLevelHP;
		$playerBloodied = floor($playerHP/2);
		$playerSurgeVal = floor($playerHP/4);
		$playerSurges	= $playerCharam[1] + $classSurges;
		// ----------------------------------
		// Sentidos
		// ---------------------------------- 
		$playerPasIns = 10+$playerSkillMod["Perspicacia"]; // Perspicacia pasiva
		$playerPasPer = 10+$playerSkillMod["Percepción"]; // Percepción pasiva
	// ----------------------------------
	// Mostramos todas las defensas ya subidas
	// ----------------------------------
	echo "<div class='playerStatsCenter' style='width:210px;padding-left:10px;'>"; // <-- Abrimos DIV de Defensas
		echo "<b>Defensas</b>";
		echo "<ul>";
			echo "<li><b>CA:</b> <span class='playerStat'>".$playerCA."</span></li>";
			echo "<li><b>Fortaleza:</b> <span class='playerStat'>".$playerFOR."</span></li>";
			echo "<li><b>Reflejos:</b> <span class='playerStat'>".$playerREF."</span></li>";
			echo "<li><b>Voluntad:</b> <span class='playerStat'>".$playerWIL."</span></li>";
		echo "</ul>";
	echo "</div>"; // <-- Cerramos DIV de Defensas
	echo "<div class='playerStatsCenter' style='width:210px;padding-left:10px;'>"; // <-- Abrimos DIV de Salud
		echo "<b>Combate</b>";
		echo "<ul>";
			echo "<li><b>Puntos de golpe:</b> <span class='playerStat'>$playerHP</span></li>";
			echo "<li><b>Maltrecho:</b> <span class='playerStat'>$playerBloodied</span></li>";
			echo "<li><b>Valor de esfuerzo:</b> <span class='playerStat'>$playerSurgeVal</span></li>";
			echo "<li><b>Esfuerzos diarios:</b> <span class='playerStat'>$playerSurges</span></li>";
			echo "<li><b>Iniciativa:</b> <span class='playerStat'>".$playerINIsymbol.$playerINI."</span></li>";
			echo "<li><b>Velocidad:</b> <span class='playerStat'>$playerSPE</span></li>";
		echo "</ul>";
	echo "</div>"; // <-- Cerramos DIV de Salud
	echo "<div class='playerStatsCenter' style='width:210px;padding-left:10px;'>"; // <-- Abrimos DIV de Sentidos
		echo "<b>Sentidos</b>";
		echo "<ul>";
			echo "<li><b>Visión:</b> ".$raceVision."</li>";
			echo "<li><b>Perspicacia pasiva:</b> <span class='playerStat'>".$playerPasIns."</span></li>";
			echo "<li><b>Percepción pasiva:</b> <span class='playerStat'>".$playerPasPer."</span></li>";
		echo "</ul>";
	echo "</div>"; // <-- Cerramos DIV de Sentidos
?>