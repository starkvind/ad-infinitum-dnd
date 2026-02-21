<?php
	// Mostrar habilidades
	$skillSearchTrm = "SELECT ".$dydBasicFields." FROM ".$dydTableSkills.""; //
	$skillSearchQry	= mysql_query($skillSearchTrm, $link);
	$skillRows 		= mysql_num_rows($skillSearchQry);
	if ($skillRows != 0) {
		echo "<table class='playerBioData' id='playerSkills' style='width:940px;'>";
		echo "<thead>";
			echo "<th style='width:120px;'></th>";
			echo "<th style='width:86px;'>Modificador</th>";
			echo "<th style='width:86px;'>&frac12; nivel</th>";
			echo "<th style='width:86px;'>Caracter.</th>";
			echo "<th style='width:86px;'>Entrenada</th>";
			echo "<th style='width:86px;'>Racial</th>";
			echo "<th style='width:86px;'>Trasfondo</th>";
			echo "<th style='width:86px;'>Tema</th>";
			echo "<th style='width:86px;'>Objeto</th>";
			echo "<th style='width:86px;'>Penalizador</th>";
		echo "</thead>";
		echo "<tbody>";
		for($dt=0;$dt<$skillRows;$dt++) {
			echo "<tr>";
			$skillQueryResult 	= mysql_fetch_array($skillSearchQry);
			$skillName	 		= $skillQueryResult["name"];
			// Explotamos el array
			$skillValues = explode(",", $playerSkillArray[$skillName]);
			// 0 > Stat (FUE,CON,etc)
			// 1 > Medio nivel
			// 2 > Modificador stat
			// 3 > Entrenada
			// 4 > Racial
			// 5 > Trasfondo
			// 6 > Tema pj
			// 7 > Objetos
			// 8 > Penalizador de armadura
				echo "<td style='text-align:right;'>".$skillName." (".$skillValues[0].")</td>";
				if ($playerSkillMod[$skillName] >= 0) { $skillSign = "+"; } else { $skillSign = ""; }
				echo "<td>".$skillSign.$playerSkillMod[$skillName]."</td>";
				echo "<td>".$skillValues[1]."</td>";
				echo "<td>".$skillValues[2]."</td>";
				if ($skillValues[3] == 0) { $skillValues[3] = ""; }
				echo "<td>".$skillValues[3]."</td>";
				if ($skillValues[4] == 0) { $skillValues[4] = ""; }
				echo "<td>".$skillValues[4]."</td>";
				if ($skillValues[5] == 0) { $skillValues[5] = ""; }
				echo "<td>".$skillValues[5]."</td>";
				if ($skillValues[6] == 0) { $skillValues[6] = ""; }
				echo "<td>".$skillValues[6]."</td>";
				if ($skillValues[7] == 0) { $skillValues[7] = ""; }
				echo "<td>".$skillValues[7]."</td>";				
				if ($skillValues[8] == 0) { $skillValues[8] = ""; }
				echo "<td>".$skillValues[8]."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
?>