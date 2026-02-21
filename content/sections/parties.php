<?php
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableParties." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos el articulo en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del Artículo
			$partyName	 	 	= $dataResult["name"]; 			// Nombre del grupo.
			$partyAlignment		= $dataResult["alignment"]; 	// Alineamiento del grupo
			$partyMembers		= $dataResult["members"];		// Miembros del grupo.
			$partyOldMembers 	= $dataResult["old_members"];	// Antiguos miembros.			
			$partyNpcMembers	= $dataResult["npc_members"];	// PNJ miembros del grupo.
			$partyNpcOldMembers = $dataResult["npc_old_members"];// Antiguos PNJ miembros.
			$partyInfotext	 	= $dataResult["infotext"];		// Datos adicionales del grupo.
		// ---------------------->
			$playerParty = $partyMembers;
			$tableParty = $partyMembers;
			include("party_get_level.php");
		// ......................>
		// Tamaño de los nombres
			$memberNameStyle = "min-width:200px;";
		// ================================================================== //
			$nameSection = "Grupos";
			$titleName = "Grupo";
			$returnBackSection = "";
			$locTab = $nameSection;
			$pageTitle2 = $titleName;
		// Localización para pestañas
		if ($nameSection == "Grupos") { $locTab = ""; } // Si es un articulo per se, solo mostramos una cosa para que no quede culo
		include_once("contents_tabs.php");
		// ---------------------->
		$pageTitle3 = $partyName;
		echo "<h2>".$partyName."</h2>"; // Título del Artículo
		echo "<div class='tab_container'>"; // <=== Inicio Div de Tabs
		// ------------------------------------------------------------------ //
		echo "<div id='info' class='tab_content'>"; // <=== Contenido del TAB 1
		//if ($articleImage != "") { echo "<img src='".$pageRoot.$articleImage."' />"; }
		echo "<fieldset class='articleBody'>";
			echo "<legend>Detalles</legend>";
			echo "<ul>";
				echo "<li><b>Alineamiento:</b> ".$partyAlignment."</li>";
				if ($partyAvrgLevl != "") { echo "<li><b>Nivel medio:</b> ".$partyAvrgLevl."</li>"; }
			echo "</ul>";
			echo "<p>".$partyInfotext."</p>";
			//---------------->
			if ($partyMemberData != "" OR $partyNpcMembers != "") {
			echo "<hr class='encounterLine' />";
				echo "<div style='margin-left: 20px;'>";
				echo "<span style='font-weight:bold;'>Miembros del grupo</span>";
				echo "<ul style='list-style-type:square;'>";
				// ---------------------------------------->
				// Jugadores
				// ---------------------------------------->
				for($pM=0;$pM<$partyTotalMem;$pM++) {
					$partyMemberLink = $pageRoot.$dydSectionPlayers[0]."/".$partyMemberData[$pM]['ID']."/";	
					echo "<li class='encounterCreature'>";
						echo "<div class='enemyName' style='".$memberNameStyle."'>";
							echo "<a href='".$partyMemberLink."' target='_blank'>".$partyMemberData[$pM]['NAME']." ".$partyMemberData[$pM]['SURNAME']."</a>";
						echo "</div>";
						echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$pM]['RACE']."</div>";
						echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$pM]['CLASS']."</div>";
						echo "<div class='enemyXP' style='min-width:80px;'>Nivel ".$partyMemberData[$pM]['LEVEL']."</div>";
					echo "</li>";
					
				}
				// ---------------------------------------->
				// NPCS
				// ---------------------------------------->
				if ($partyNpcMembers != "") {
					$playerParty = $partyNpcMembers;
					$prepareNpcs = TRUE;
					include("party_get_level.php");
					for($npc1=0;$npc1<$partyTotalMem;$npc1++) {
						$partyMemberLink = $pageRoot.$dydSectionNPC[0]."/".$partyMemberData[$npc1]['ID']."/";	
						echo "<li class='encounterCreature'>";
							echo "<div class='enemyName' style='".$memberNameStyle."'>";
								echo "<a href='".$partyMemberLink."' target='_blank'>".$partyMemberData[$npc1]['NAME']." ".$partyMemberData[$npc1]['SURNAME']."</a>";
							echo "</div>";
							echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$npc1]['RACE']."</div>";
							echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$npc1]['CLASS']."</div>";
							//echo "<div class='enemyXP' style='min-width:80px;'>Nivel ".$partyMemberData[$npc1]['LEVEL']."</div>";
						echo "</li>";
						
					}
				}
				// ---------------------------------------->
				echo "</ul>";
				echo "</div>";
			}
			//---------------->
			if ($partyOldMembers != "" OR $partyNpcOldMembers != "") {
			echo "<hr class='encounterLine' />";
				echo "<div style='margin-left: 20px;'>";
				echo "<span style='font-weight:bold;'>Antiguos miembros</span>";
				echo "<ul style='list-style-type:square;'>";
				// ---------------------------------------->
				// Jugadores
				// ---------------------------------------->
				if ($partyOldMembers != "") {
					$playerParty = $partyOldMembers;
					$prepareOldMembers = TRUE;
					include("party_get_level.php");
					for($oM=0;$oM<$partyTotalMem;$oM++) {
						$partyMemberLink = $pageRoot.$dydSectionPlayers[0]."/".$partyMemberData[$oM]['ID']."/";	
						echo "<li class='encounterCreature'>";
							echo "<div class='enemyName' style='".$memberNameStyle."'>";
								echo "<a href='".$partyMemberLink."' target='_blank'>".$partyMemberData[$oM]['NAME']." ".$partyMemberData[$oM]['SURNAME']."</a>";
							echo "</div>";
							echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$oM]['RACE']."</div>";
							echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$oM]['CLASS']."</div>";
							echo "<div class='enemyXP' style='min-width:80px;'>Nivel ".$partyMemberData[$oM]['LEVEL']."</div>";
						echo "</li>";
					}
				}
				// ---------------------------------------->
				// NPCS
				// ---------------------------------------->
				if ($partyNpcOldMembers != "") {
					$playerParty = $partyNpcOldMembers;
					$prepareNpcs = TRUE;
					include("party_get_level.php");
					for($npc2=0;$npc2<$partyTotalMem;$npc2++) {
						$partyMemberLink = $pageRoot.$dydSectionNPC[0]."/".$partyMemberData[$npc2]['ID']."/";	
						echo "<li class='encounterCreature'>";
							echo "<div class='enemyName' style='".$memberNameStyle."'>";
								echo "<a href='".$partyMemberLink."' target='_blank'>".$partyMemberData[$npc2]['NAME']." ".$partyMemberData[$npc2]['SURNAME']."</a>";
							echo "</div>";
							echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$npc2]['RACE']."</div>";
							echo "<div class='enemyLevel' style='min-width:120px;'>".$partyMemberData[$npc2]['CLASS']."</div>";
							//echo "<div class='enemyXP' style='min-width:80px;'>Nivel ".$partyMemberData[$npc2]['LEVEL']."</div>";
						echo "</li>";
					}	
				}
				// ---------------------------------------->
						echo "</ul>";
					echo "</div>";
			}
			//---------------->
		echo "</fieldset>";
		echo "</div>"; // <=== FIN TAB 1
		// ------------------------------------------------------------------ //
		echo "<div id='table' class='tab_content'>"; // <=== Contenido del TAB 2
			include_once("parties_table.php");
		echo "</div>"; // <=== FIN TAB 2
		// ------------------------------------------------------------------ //
		echo "</div>";
		// ------------------------------------------------------------------ //
		echo "<br/>";
		// Fin Hoja 
		// ------------------------------------------------------------------ //
	} else {
		// ------------------------------------------------------------------ //
		// Listado de Grupos; Texto que aparece si no se elige Hoja		  //
		// Configuramos el enlace de vuelta y título
			$dataSearchSQL = "";
			$dataListOrder = "name";
			// Data
			$articleType = "Grupos";
			$pageTitle2 = $articleType;	
			$dataListTitle = $articleType;		
		// Localización para pestañas
		if ($articleType != "Grupos") {
			$tabName = $articleType;
			$locTab = "K";
			include_once("contents_tabs.php");
		}
		// ---------->
		echo "<h3>".$dataListTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydPartiesFields." FROM ".$dydTableParties." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionParties[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>