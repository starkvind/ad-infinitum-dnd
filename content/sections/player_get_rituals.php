<?php
// Desglose e identificacion de los rituales
	$playerCheckRites = explode("-", $playerRituals);
	// Ya hemos localizado todos los objetos en la base de datos. Procedemos a mostrarlos
	if (count($playerCheckRites) > 0) {
		echo "<div class='playerBankList'>";
			echo "<ul class='playerBankList'>";
				for($ritualSlot=0;$ritualSlot<count($playerCheckRites);$ritualSlot++) {
					// Recogemos los datos del Ritual
					$retrieveFrom = "rituals";
					$dataListRitual = $playerCheckRites[$ritualSlot];
					include ("retrieve_origin.php");
					$ritualLink = $pageRoot."rituals/".$dataListRitual."/";
					$getRitualIcon = TRUE;
					include ("player_get_bank_icons.php");
					$ritualIcon = $dydIconDirectory.$ritualCategoryIcon.$dydIconExtension;
					// Lo mostramos
					echo "<a href='".$ritualLink."' title='".$ritualCategory."' target='_blank'>";
						echo "<li><div class='divBank'><img class='iconBank' src='".$ritualIcon."' /></div>".$ritualName."</li>";
					echo "</a>";
				}
			echo "</ul>";
		echo "</div>";
	}
?>