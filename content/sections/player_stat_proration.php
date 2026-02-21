<?php
// Desglose de estadísticas y atributos del personaje.
	echo "<div class='playerStatsLeft' style='width:190px;'>";
	echo "<b>Características iniciales</b>";
	echo "<ul>";
		echo "<li><b>".$playerCharan[0].":</b> <span class='playerStat'>".$playerSTRo."</span></li>";
		echo "<li><b>".$playerCharan[1].":</b> <span class='playerStat'>".$playerCONo."</span></li>";
		echo "<li><b>".$playerCharan[2].":</b> <span class='playerStat'>".$playerDEXo."</span></li>";
		echo "<li><b>".$playerCharan[3].":</b> <span class='playerStat'>".$playerINTo."</span></li>";
		echo "<li><b>".$playerCharan[4].":</b> <span class='playerStat'>".$playerWISo."</span></li>";
		echo "<li><b>".$playerCharan[5].":</b> <span class='playerStat'>".$playerCHAo."</span></li>";
	echo "</ul>";
	echo "</div>";
	echo "<div class='playerStatsCenter' style='width:auto;padding-left:24px;'>";
	echo "<b>Mejoras</b>";
	echo "<ul>";
	echo "<li><b>".$className.":</b> ";
		for($classd=0;$classd<3;$classd++) {
			if ($classDefenseVal[$classd] != "") { 
				echo "+".$classDefenseVal[$classd]." a ".$classDefenseName[$classd];
				if ($classd < 2 and $defenseCount > 1) { echo ", "; }
			}			
		}
	echo ".</li>";
	if ($humanStatTitle != "") { echo "<li><b>".$raceName.":</b> +2 a ".$humanStatTitle.".</li>"; }
	if ($raceAbBonus1[0] != "") { 
		echo "<li><b>".$raceName.":</b> +2 a ".$raceStatTitle1." y ".$raceStatTitle2.".</li>";
	}
	if ($epicBonus != "") { 
		echo "<li><b>$epicName:</b> +2 a ".$playerCharan[$epicA];
		if ($epicB != "") { echo " y ".$playerCharan[$epicB]; }
		echo ".</li>"; 
	}
	if ($statEquipBonus != "") { 
		echo "<li><b>Equipo mágico:</b> +1 a ".$playerCharan[$statEquipA];
		if ($statEquipB != "") { echo " y ".$playerCharan[$statEquipB]; }
		echo ".</li>"; 
	}
	if ($lvl4Bonus != "") { 	echo "<li><b>Nivel 4:</b> +1 a ".$playerCharan[$level4A]." y ".$playerCharan[$level4B].".</li>"; }
	if ($lvl8Bonus != "") { 	echo "<li><b>Nivel 8:</b> +1 a ".$playerCharan[$level8A]." y ".$playerCharan[$level8B].".</li>"; }
	if ($playerLevel >= 11) { 	echo "<li><b>Nivel 11:</b> +1 a todas las características.</li>"; }
	if ($lvl14Bonus != "") { 	echo "<li><b>Nivel 14:</b> +1 a ".$playerCharan[$level14A]." y ".$playerCharan[$level14B].".</li>"; }
	if ($lvl18Bonus != "") { 	echo "<li><b>Nivel 18:</b> +1 a ".$playerCharan[$level18A]." y ".$playerCharan[$level18B].".</li>"; }
	if ($playerLevel >= 21) { 	echo "<li><b>Nivel 21:</b> +1 a todas las características.</li>"; }
	if ($lvl24Bonus != "") { 	echo "<li><b>Nivel 24:</b> +1 a ".$playerCharan[$level24A]." y ".$playerCharan[$level24B].".</li>"; }
	if ($lvl28Bonus != "") { 	echo "<li><b>Nivel 28:</b> +1 a ".$playerCharan[$level28A]." y ".$playerCharan[$level28B].".</li>"; }
	echo "</ul>";
	echo "</div>";
	echo "<div class='playerStatsCenter' style='width:auto;padding-left:20px;'>";
	echo "<b>Bonificaciones de equipo</b>";
	echo "<ul>";
		if ($shieldType != ""){ echo "<li><b>Escudo:</b> CA +$shieldArmorBonus".", Reflejos +$shieldArmorBonus</li>";}
		if ($equipName["BODY"] != "") { echo "<li><b>Armadura:</b> CA +$acArmorBonus</li>"; }
	echo "</ul>";
	echo "</div>";				
?>