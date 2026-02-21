<?php
	if ($page != 0) {
	// ================================================================== //
	echo "<div id='card' class='tab_content'>"; // <=== Contenido del TAB 1
		echo "<div id='powerItemLayout'>";
			$enemyId = $page; // Damos la id del Enemigo.
			include ("enemy_card.php");
			$pageTitle3 =  $enemyName;
		echo "</div>";
	echo "</div>";
	// ================================================================== //
	// Configuramos el enlace de vuelta
	switch ($enemyElite) {
		case 0: // Enemigos
		case 1:
		case 2:
		case 3:
		case 7:
		case 9:
			$returnBackSection = "enemies/";
		break;
		case 4: // Aliados
			$returnBackSection = "allies/";
		break;
		case 5: // Familiares
			$returnBackSection = "familiars/";
		break;
		case 6: // Trampas
			$returnBackSection = "traps/";
		break;
		case 8: // Monturas
			$returnBackSection = "mounts/";
		break;
	}
	// Finalizamos la configuración del enlace de vuelta
	echo "<div id='info' class='tab_content'>"; // <=== Contenido del TAB 2
	// Nombre de la criatura, rol y nivel
		echo "<h2>".$enemyName."</h2>";
		if ($enemyLevel == 0) { $showEnemyLvl = ""; } else { $showEnemyLvl = "nivel ".$enemyLevel.""; }
		echo "<p style='font-style:italic;'>".$enemyRole." ".$showEnemyLvl."</p>";
		if ($enemyLore != "") {
			// Dividimos las piezas de información
			$enemyInformation = explode("|", $enemyLore);
			// Descripción general de la criatura
			if ($enemyInformation[0] != "") { echo "<fieldset><legend>Descripción</legend><p>".$enemyInformation[0]."</p></fieldset>"; }
			// Tácticas de la criatura
			if ($enemyInformation[1] != "") { echo "<br/><br/><fieldset><legend>Tácticas</legend><p>".$enemyInformation[1]."</p></fieldset>"; }
			// Pruebas de conocimiento de la criatura
			if ($enemyInformation[2] != "") { 
				$enemyLoreInfo = explode("^", $enemyInformation[2]);
				$enemyLoreCD = explode ("]", $enemyLoreInfo[1]);
				echo "<br/><br/>";
				echo "<fieldset>";
					echo "<legend>Conocimiento</legend>";
						echo "<p>".$enemyLoreInfo[0]."</p>";
						echo "<ul>";
							$enemyNumbInfo = count($enemyLoreCD);
							for($icd=0;$icd<$enemyNumbInfo;$icd++) {
								echo "<li style='margin-bottom:4px;'>".$enemyLoreCD[$icd]."</li>";
							}
						echo "</ul>";
				echo "</fieldset>"; 
			}
			if ($enemySounds != "") {
				echo "<br/><br/>";
				echo "<fieldset>";
				echo "<legend>Audio de ".$enemyName."</legend>";
				$arraySounds = explode("|", $enemySounds);
					for ($soundSlot=0;$soundSlot<count($arraySounds);$soundSlot++) {
						$creatureSound = explode(":", $arraySounds[$soundSlot]);
						//echo $creatureSound[0].": ".$creatureSound[1];
						echo "<div class='enemyAudio'>";
						echo "<span>".$creatureSound[0]."</span>";
						echo "<br />";
?>
<audio class="audioPlayer" controls preload>
	<source src="<?php echo $pageRoot.$dydSoundPath.$enemyUrl."/".$creatureSound[1]; ?>" type="audio/ogg" />
</audio>
<?php
						echo "</div>";
					}
				echo "</fieldset>";
			}
		// La criatura no tiene información relevante.
		} else {
			echo "<p>Esta criatura no dispone de información relevante.</p>";
		}
	echo "</div>";
	// Finalizamos el TAB 2
	echo "<div id='pict' class='tab_content'>"; // <=== Contenido del TAB 3
		echo "<div id='powerItemLayout'>";
			$enemyPic = $pageRoot."media/monster/".$enemyPicture.".jpg";
			echo "<center>";
				echo "<a href='".$enemyPic."' target='_blank'>";
					echo "<img src='".$enemyPic."' class='enemyPic' alt='".$enemyName."' title='".$enemyName."' />";
				echo "</a>";
			echo "</center>";
		echo "</div>";
	echo "</div>";
	// Finalizamos el TAB 3
	// ================================================================== //
	echo "<br/>";
		// Localización para pestañas
		include_once("contents_tabs.php");
		if ($locTab != "Familiares") {
			$pageTitle2 = substr($locTab, 0, -1);
		} else {
			$pageTitle2 = substr($locTab, 0, -2);
		}
	} else {
		// ------------------------------------------------------------------ //
			switch($typItem) {
				case "enemies":
					$dataSearchSQL = "WHERE elite IN (0,1,2,3,7,9)";
					$powerTypeTitle = "Enemigos";
				break;
				case "allies":
					$dataSearchSQL = "WHERE elite = 4";
					$powerTypeTitle = "Aliados";
				break;
				case "familiars":
					$dataSearchSQL = "WHERE elite = 5";
					$powerTypeTitle = "Familiares";
				break;
				case "traps":
					$dataSearchSQL = "WHERE elite = 6";
					$powerTypeTitle = "Trampas";
				break;
				case "mounts":
					$dataSearchSQL = "WHERE elite = 8";
					$powerTypeTitle = "Monturas";
				break;
				case "hirelings":
					$dataSearchSQL = "WHERE elite = 4 AND hireling != ''";
					$powerTypeTitle = "Compañeros";
				break;
				default:
					$dataSearchSQL = "WHERE elite >= 0";
					$powerTypeTitle = "Criaturas";
				break;
			}
		// Localización para pestañas
		if ($powerTypeTitle != "Criaturas") {
			$locTab = "K"; // Le damos un valor para que no de la murga
			$tabName = $powerTypeTitle;
			include_once("contents_tabs.php");
		}
		// ---------->
		echo "<h3>".$powerTypeTitle."</h3>";
		if ($powerTypeTitle != $pageTitle2) {
			$pageTitle3 =  $powerTypeTitle;
		}
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydCreaturesFields." FROM ".$dydTableCreatures." ".$dataSearchSQL." ".$userLevelCheck."";
			$dataSection	 = $dydSectionCreatures[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>