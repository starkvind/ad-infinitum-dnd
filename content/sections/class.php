<?php
	$dontShowClassFeatures = $dontShowClassFeatures ?? FALSE;
	$traitsRows = $traitsRows ?? 0;
	$debugClassMode = false; // Public ?debug=class previously exposed raw SQL and record contents.
	$debugClassRows = array();
	$debugBuildRows = array();
	$debugTraitRows = array();
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
	if (!function_exists('dyd_h')) {
		function dyd_h($text)
		{
			return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
		}
	}
	if (!function_exists('dyd_hex_preview')) {
		function dyd_hex_preview($text)
		{
			$value = (string) $text;
			$len = function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
			return "len=".$len." hex=".bin2hex(substr($value, 0, 32));
		}
	}
	$idGetData = $page; // Cogemos datos del GET "page"
	$orderData ="SELECT * FROM ".$dydTableClasses." WHERE ".$pageField." LIKE '".$idGetData."' LIMIT 1;"; // Elegimos la Clase en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);

	if ($rowsData != "") { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		$dataResult = mysql_fetch_array($queryData); // Empezamos a recolectar los datos. ~~ #SEC01
		// ================================================================== //
		// Datos básicos del personaje
			$classId			= $dataResult["id"];			// ID de la Clase.
			$className 	 	 	= dyd_safe_label($dataResult["name"], $dataResult["url"] ?? ""); 			// Nombre de la Clase.
			$classFlavor		= $dataResult["flavortext"];	// Una línea que describe la Clase.
			$classTier	 		= $dataResult["tier"]; 			// Grado de la Clase.
			$classRequired	 	= $dataResult["required"]; 		// Requisitos de Senda o Destino.
			$classRole	 		= $dataResult["role"]; 			// Rol de la Clase.
			$classRoleText	 	= $dataResult["roletext"]; 		// Descripción del Rol de la Clase.
			$classSource		= $dataResult["source"]; 		// Fuente de poder de la Clase.
			$classSourceText 	= $dataResult["sourcetext"]; 	// Descripción de la Fuente de poder de la Clase.
			$classStats	 		= $dataResult["stats"]; 		// Habilidades de característica necesarias en la Clase.
			$classArmor	 		= $dataResult["armor"]; 		// Competencia con armaduras.
			$classWeapon 		= $dataResult["weapon"];		// Competencia con armas de la Clase.
			$classImplement		= $dataResult["implement"];		// Competencia con utensilios.
			$classBonusDef 		= $dataResult["bonusdefense"]; 	// Bonificadores a las Defensas.
			$classHpLevelOne	= $dataResult["hp1stlvl"]; 		// PG a nivel 1.
			$classHpPerLevel	= $dataResult["hpperllvl"]; 	// PG ganados por nivel.
			$classHealingSurges	= $dataResult["healingsurges"]; // Esfuerzos curativos por nivel.
			$classSkillText		= $dataResult["skilltext"]; 	// Habilidad entrenada y texto de habilidades.
			$classSkillList		= $dataResult["skill_list"]; 	// Lista de habilidades de la clase.
			$classFeatures		= $dataResult["class_features"];// Rasgos de la clase.
			$classInfoText 		= $dataResult["info_text"]; 	// Texto informativo de la clase.
			$classCreateText 	= $dataResult["create_text"]; 	// Información como crear la Clase.
			$classFeaturesText 	= $dataResult["features_text"]; // Larga sección con todo lo de la clase.
			$classMiscTitle	 	= $dataResult["misctitle"];		// Titulo de la sección miscelánea de la Clase.
			$classMiscText	 	= $dataResult["misctext"];		// Texto de la sección miscelánea de la Clase.
			$classImplementText	= $dataResult["implement_text"];// Descripción de los utensilios que usa la clase.
			$classImage		 	= $dataResult["image"];			// Imagen de la Clase.
			$classOriginText	= $dataResult["origintext"];	// Texto donde se explica el origen de la Clase, si es que tiene.
			$classOrigin		= $dataResult["origin"]; 		// Origen de la Clase.
			if ($debugClassMode) {
				$debugClassRows[] = array(
					"id" => $classId,
					"url" => $dataResult["url"] ?? "",
					"name_raw" => $dataResult["name"] ?? "",
					"name_safe" => $className,
					"class_features" => $classFeatures,
				);
			}
		// ================================================================== //
		// Conseguimos datos del Origen
			$dataListOrigin = $classOrigin;
			$retrieveFrom = "origin";
			include (__DIR__ . "/retrieve_origin.php");
		// ================================================================== //
		$pageTitle3 = $className;
		// ================================================================== //
		// Localización para pestañas
		include_once(__DIR__ . "/contents_tabs.php");
		// ================================================================== //
		if ($originCanon != 0) {
		echo "<h2>".$className."</h2>"; // Título de la Clase
		if ($classFlavor != "") { echo "<p style='font-style:italic;'>".$classFlavor."</p>"; }
		echo "<div class='tab_container'>"; // <=== Inicio Div de Tabs
		// ------------------------------------------------------------------ //
		// TAB 01 - INFORMACION
		// ------------------------------------------------------------------ //
			echo "<div id='info' class='tab_content'>"; // <=== Contenido del TAB 1
			include_once(__DIR__ . "/origin_icon.php");
			// Primer Fieldset - Rasgos de Clase
			// ------------------------------------------------------------------ //
			echo "<img src='".$pageRoot.$classImage."' />";
			echo "<fieldset style='text-align:left;'>"; 
				echo "<legend>Datos básicos</legend>";
				// Detalles Basicos
				if ($classTier <= 0 OR $classTier == 4) {	// Si el grado de la clase es Heroico (0) o Essentials (4), es Básica y mostramos todo.
				// Si es superior, debe ser una Senda de Parangón, Destino épico o un Tema de Personaje.
				echo "<ul>"; 
					if ($classRequired != "" AND $classTier == 4) {
						// Essentials
						include_once(__DIR__ . "/class_essentials.php");
						echo "<li><b>Clase base:</b> ".$subClassText."</li>"; 
					}
					echo "<li><b>Rol:</b> ".$classRole.". ".$classRoleText."</li>"; 
					echo "<li><b>Fuente de poder:</b> ".$classSource.". ".$classSourceText."</li>"; 
					if ($classStats != "") {
						echo "<li><b>Características clave:</b> ";
						// Sección de puntuaciones de característica de la clase
						$classCarstats = explode("/", $classStats);
						$statCount = count($classCarstats);
						$statComma = $statCount -1;
							for($cs=0;$cs<$statCount;$cs++) {
								// Comprobamos el nombre del stat
								switch($classCarstats[$cs]) {
									case "FUE":
										$classStat[$cs] = "Fuerza";
									break;
									case "CON":
										$classStat[$cs] = "Constitución";
									break;
									case "DES":
										$classStat[$cs] = "Destreza";
									break;
									case "INT":
										$classStat[$cs] = "Inteligencia";
									break;
									case "SAB":
										$classStat[$cs] = "Sabiduría";
									break;
									case "CAR":
										$classStat[$cs] = "Carisma";
									break;
								}
							// Lo mostramos
							echo $classStat[$cs];
							// Le damos una coma si procede
							if ($cs < $statComma) { echo ", "; }
							}
						// Finalizamos sección
						echo "</li>";
					}
				echo "</ul>";
				// Equipo
				echo "<ul>"; 
					echo "<li><b>Competencias con armaduras:</b> ".$classArmor."</li>";
					echo "<li><b>Competencias con armas:</b> ".$classWeapon."</li>";
					if ($classImplement != "") { echo "<li><b>Utensilios:</b> ".$classImplement."</li>"; }
					// Seccion de bonificadores de Defensa.
					echo "<li><b>Bonificador a defensa:</b> ";
					$classDefenses = explode(";", $classBonusDef);
					$defenseCount = count($classDefenses);
					$defenseComma = $defenseCount -1;
						for($cd=0;$cd<$defenseCount;$cd++) {
							$classDefenseText = explode (":", $classDefenses[$cd]);
							// Comprobamos el nombre de la defensa
							switch ($classDefenseText[0]) {
								case "FOR":
									$classDefenseName[$cd] = "Fortaleza";
								break;
								case "REF":
									$classDefenseName[$cd] = "Reflejos";
								break;
								case "VOL":
									$classDefenseName[$cd] = "Voluntad";
								break;
							}
							$classDefenseVal[$cd] = $classDefenseText[1];
							// La mostramos
							echo "+".$classDefenseVal[$cd]." a ".$classDefenseName[$cd];
							// Le damos una coma si procede
							if ($cd < $defenseComma) { echo ", "; }
						}
					echo "</li>";
					// Fin bonificadores de defensa.
				echo "</ul>";
				// Salud
				echo "<ul>"; 
					echo "<li><b>Puntos de golpe a primer nivel:</b> ".$classHpLevelOne." + puntuación de Constitución</li>";
					echo "<li><b>Puntos de golpe ganados por nivel:</b> ".$classHpPerLevel."</li>";
					if ($classHealingSurges > 2) { $healingSurgeText = "+ modificador de Constitución"; }
					echo "<li><b>Esfuerzos curativos por día:</b> ".$classHealingSurges." ".$healingSurgeText."</li>";
				echo "</ul>";
				// Habilidades
				echo "<ul>";
					echo "<li><b>Habilidades entrenadas:</b> ".$classSkillText."</li>";
					echo "<li><b>Habilidades de clase:</b> ".$classSkillList."</li>";
				echo "</ul>";	
				// Datos finales
				echo "<ul>";
				// Builds de clase
					$searchBuilds	= "SELECT * FROM ".$dydTableBuilds." WHERE class LIKE '".$className."' ORDER BY name";
					$buildQuery 	= mysql_query($searchBuilds, $link);
					$buildRows 		= mysql_num_rows($buildQuery);
					// Mostramos las builds y preparamos los enlaces
					// ------------------>
					if ($buildRows > 0 AND $classTier == 0) {
						echo "<li><b>Opciones de diseño:</b> ";
						for($cb=0;$cb<$buildRows;$cb++) {
							$buildResult = mysql_fetch_array($buildQuery);
							$buildName[$cb]   = dyd_safe_label($buildResult["name"], $buildResult["url"] ?? "");
							$buildInfo[$cb]	  = $buildResult["infotext"];	// Información del Diseño.
							$buildFeat[$cb]	  = $buildResult["feat"];		// Dote del Diseño.
							$buildTrait[$cb]  = $buildResult["trait"];		// Rasgo del Diseño.
							$buildSkills[$cb] = $buildResult["skills"];		// Habilidades del Diseño.
							$buildPowers[$cb] = $buildResult["powers"];		// Poderes del Diseño.
							if ($debugClassMode) {
								$debugBuildRows[] = array(
									"id" => $buildResult["id"] ?? "",
									"url" => $buildResult["url"] ?? "",
									"name_raw" => $buildResult["name"] ?? "",
									"name_safe" => $buildName[$cb],
								);
							}
							echo "<a href='#".strtolower(quitar_acentos($className)).($cb+1)."'>".strtolower($className)." ".strtolower($buildName[$cb])."</a>";
							if ($cb+1 < $buildRows) { echo  ", "; }
						}
						echo ".</li>";
					}
					// ------------------>
				// Fin de Builds
				// Rasgos de clase
					if ($classTier == 0) {
						if ($classFeatures == "") { $classFeatures = 0; }
						showBdClassTraits:
						$searchTraits	= "SELECT * FROM ".$dydTableTraits." WHERE class LIKE '".$className."' OR id IN (".$classFeatures.") ORDER BY traitlist DESC, level, name";
						$traitsQuery 	= mysql_query($searchTraits, $link);
						$traitsRows 	= mysql_num_rows($traitsQuery);
						if ($debugClassMode) {
							$debugClassRows[] = array(
								"traits_sql" => $searchTraits,
								"traits_rows" => $traitsRows,
							);
						}
						// Mostramos los rasgos y preparamos los enlaces
						// ------------------>
						if ($traitsRows > 0) {
							$traitList = array();
							if ($dontShowClassFeatures == FALSE) { echo "<li>"; }
							if ($classTier != 3) { echo "<b>Rasgos de ".$featureText.":</b> "; }
							// Ponemos a 0 la variable para contar rasgos locos
							$numberOfTraitsToPoint = 0;
							for($ct=0;$ct<$traitsRows;$ct++) {
								$traitResult = mysql_fetch_array($traitsQuery);
								$traitID[$ct] = $traitResult["id"];				// ID del Rasgo
								$traitName[$ct] = dyd_safe_label($traitResult["name"], $traitResult["url"] ?? "");			// Nombre del Rasgo
								$traitLevel[$ct] = $traitResult["level"];		// Nivel del Rasgo
								$traitInfo[$ct]	= $traitResult["infotext"]; 	// Información del Rasgo.
								$traitChoose[$ct] = $traitResult["choosetext"]; // Elecciones del Rasgo.
								$traitFlavor[$ct] = $traitResult["flavortext"]; // Texto decorativo del Rasgo.
								$traitList2[$ct] = $traitResult["traitlist"]; 	// Listado de rasgos del Rasgo.
								if ($debugClassMode) {
									$debugTraitRows[] = array(
										"id" => $traitID[$ct],
										"url" => $traitResult["url"] ?? "",
										"name_raw" => $traitResult["name"] ?? "",
										"name_safe" => $traitName[$ct],
										"traitlist" => $traitList2[$ct],
									);
								}
								// Listado de rasgos en uno del Rasgo.
								if ($traitList2[$ct] != "") {
									$addTraitsToTraitList = explode(",",$traitList2[$ct]);
									$traitList = array_merge($traitList, $addTraitsToTraitList);
								}
							// Ponemos la variable de contar :D
							$numberOfTraitsToNotPoint = count($traitList);
								// Mostramos el acceso directo
								if (!in_array($traitID[$ct], $traitList)) { 
									if ($classTier != 3) {
										$numberOfTraitsToPoint = $numberOfTraitsToPoint+1;
										echo "<a href='#trait".($ct+1)."'>".strtolower($traitName[$ct])."</a>";
										// Sumamos los datos que tenemos, y si no son iguales al nº de rasgos, ponemos coma y espacio.
										$sumNumberTraits = $numberOfTraitsToPoint+$numberOfTraitsToNotPoint;
										if ($sumNumberTraits != $traitsRows) { echo  ", "; }
									}				
								}
							}						
							if ($classTier != 3) { echo "."; }
							if ($dontShowClassFeatures == FALSE) { echo "</li>"; }
						}
					}					
					// ------------------>
				// Fin de Rasgos de clase
					if ($classTier != 0 AND $dontShowClassFeatures == FALSE) { 
						echo "<li><b>Rasgos de ".$featureText.":</b> ".$classFeatures."</li>";
					}
				// Subclases
					if ($classRequired == "" AND $classTier == 0) {	include_once(__DIR__ . "/class_essentials.php"); }
				echo "</ul>";
				if ($debugClassMode) {
					echo "<div style='margin:12px 0;padding:10px;border:1px solid #666;background:#f7f7f7;font-size:12px;line-height:1.4;'>";
					echo "<b>DEBUG CLASS</b> (quitar con URL sin <code>?debug=class</code>)";
					foreach ($debugClassRows as $row) {
						echo "<pre style='white-space:pre-wrap;word-break:break-word;margin:8px 0;'>";
						foreach ($row as $k => $v) {
							echo dyd_h($k).": ".dyd_h($v)."\n";
							if ($k === "name_raw") {
								echo dyd_h($k)."_meta: ".dyd_h(dyd_hex_preview($v))."\n";
							}
						}
						echo "</pre>";
					}
					if (count($debugBuildRows) > 0) {
						echo "<b>DEBUG BUILDS</b>";
						foreach ($debugBuildRows as $row) {
							echo "<pre style='white-space:pre-wrap;word-break:break-word;margin:8px 0;'>";
							echo "id: ".dyd_h($row["id"])."\n";
							echo "url: ".dyd_h($row["url"])."\n";
							echo "name_raw: ".dyd_h($row["name_raw"])."\n";
							echo "name_raw_meta: ".dyd_h(dyd_hex_preview($row["name_raw"]))."\n";
							echo "name_safe: ".dyd_h($row["name_safe"])."\n";
							echo "</pre>";
						}
					}
					if (count($debugTraitRows) > 0) {
						echo "<b>DEBUG TRAITS</b>";
						foreach ($debugTraitRows as $row) {
							echo "<pre style='white-space:pre-wrap;word-break:break-word;margin:8px 0;'>";
							echo "id: ".dyd_h($row["id"])."\n";
							echo "url: ".dyd_h($row["url"])."\n";
							echo "name_raw: ".dyd_h($row["name_raw"])."\n";
							echo "name_raw_meta: ".dyd_h(dyd_hex_preview($row["name_raw"]))."\n";
							echo "name_safe: ".dyd_h($row["name_safe"])."\n";
							echo "traitlist: ".dyd_h($row["traitlist"])."\n";
							echo "</pre>";
						}
					}
					echo "</div>";
				}
				} else if ($classTier >= 1 OR $classTier <= 3) {
				//  SENDA DE PARANGON Y DESTINO EPICO
				echo "<div style='padding-left:14px;'>";
				if ($classTier == 3) {
					echo "<p><b>Clases sugeridas:</b> ".$classRole."</p>"; 
				} else {
					echo "<p><b>Requisitos:</b> ".$classRequired.".</p>"; 
				}
				if ($classFeatures != "" AND $classTier <= 2) { 
					echo "<p><b>Rasgos de ".$featureText.":</b> ".$classFeatures."</p>"; 
				} else {
					$classFeatures = 0;
					$dontShowClassFeatures = TRUE;
					$classFeaturesText = "<p>Tienes los siguientes rasgos de clase:</p>";
					goto showBdClassTraits;
				}
				echo "</div>";
				} else {
				// Mostramos los escuetos datos de parangon, epico o tema pj.
				echo "<ul>";
					echo "<li><b>Clases sugeridas:</b> ".$classRole."</li>"; 
					echo "<li><b>Beneficios:</b> ".$classFeatures."</li>";
				echo "</ul>";
				}			
			echo "</fieldset>";
			// ------------------------------------------------------------------ //
			// Segundo Fieldset - Información de la clase
			// ------------------------------------------------------------------ //
			echo "<a name='class_howto'></a>";
			echo $classInfoText;
			// ------------------------------------------------------------------ //
			// Tercer Fieldset - Como crear la clase
			// ------------------------------------------------------------------ //
			if ($classCreateText !="") {
				echo "<fieldset>";
					echo "<legend>Cómo crear un ".$className."</legend>";
					echo $classCreateText;
					// -------------------------------------------------------- //
					// Preparamos para mostrar las Builds
					// -------------------------------------------------------- //
					if ($buildRows > 0 AND $classTier == 0) {
						for($cb=0;$cb<$buildRows;$cb++) {
						// ----------------------------------------------------------------------------------------- //
							// Contenido de la Build
							echo "<a name='".strtolower(quitar_acentos($className)).($cb+1)."'><h4>".$className." ".strtolower($buildName[$cb])."</h4></a>";
								echo "<p>".$buildInfo[$cb]."</p>";
								echo "<ul>";
									// Rasgo de clase
									if ($buildTrait[$cb] != "") { echo "<li><b>Rasgo de clase sugerido:</b> ".$buildTrait[$cb].".</li>"; }
									// Dotes 
									if ($buildFeat[$cb] != "") { 
										$feats = explode("|", $buildFeat[$cb]);
										echo "<li><b>Dote sugerida:</b> ".$feats[0].".</li>";
										if ($feats[1] != "") { echo "<li><b>Dote humana:</b> ".$feats[1].".</li>"; } 
									}
									// Habilidades
									if ($buildSkills[$cb] != "") { echo "<li><b>Habilidades sugeridas:</b> ".$buildSkills[$cb].".</li>"; }
									// Poderes
									if ($buildPowers[$cb] != "") { 
										$powers = explode("|", $buildPowers[$cb]);
										if ($powers[0] != "") { echo "<li><b>Poderes a voluntad sugeridos:</b> ".$powers[0].".</li>"; }
										if ($powers[1] != "") { echo "<li><b>Poder de encuentro sugerido:</b> ".$powers[1].".</li>"; }
										if ($powers[2] != "") { echo "<li><b>Poder diario sugerido:</b> ".$powers[2].".</li>"; }
									}
								echo "</ul>";
							// Fin de la Build
						// ----------------------------------------------------------------------------------------- //	
						}
					}
				echo "</fieldset>";
			}
			// ------------------------------------------------------------------ //
			// Cuarto Fieldset - Rasgos de la clase
			// ------------------------------------------------------------------ //
			if ($classFeaturesText !="") {
				echo "<br />";
				// ------------------------------------------------------------------ //
				echo "<a name='class_feats'></a>";
				echo "<fieldset>";
					echo "<legend>Rasgos de ".$featureText." del ".$className."</legend>";
					echo $classFeaturesText;
					// -------------------------------------------------------- //
					// Preparamos para mostrar los Rasgos
					// -------------------------------------------------------- //
					if ($traitsRows > 0 AND $classTier <= 3) {
						for($ct=0;$ct<$traitsRows;$ct++) {
						// ----------------------------------------------------------------------------------------- //
							if (!in_array($traitID[$ct], $traitList)) {						
							// Contenido del Rasgo
							echo "<a name='trait".($ct+1)."'><h4>".$traitName[$ct]."</h4></a>";
							if ($traitFlavor[$ct] != "") {
								echo "<p>".$traitFlavor[$ct]."</p>";
							}
							if ($traitLevel[$ct] > 1 AND $classTier <= 2) {
								$traitBoldLevel = "<b>Nivel ".$traitLevel[$ct].":</b> ";
							} else if ($classTier == 3) {
								$traitBoldLevel = "<b>Beneficio:</b> ";
							} else {
								$traitBoldLevel = "";
							}							
							echo "<p>".$traitBoldLevel.$traitInfo[$ct]."</p>";
							if ($traitList2[$ct] != "") {
								$newTraitList = $traitList2[$ct];
								$searchTraits2	= "SELECT * FROM ".$dydTableTraits." WHERE id IN (".$newTraitList.") ORDER BY name";
								$traitsQuery2	= mysql_query($searchTraits2, $link);
								$traitsRows2 	= mysql_num_rows($traitsQuery2);	
								// Mostramos los rasgos y preparamos los enlaces
								// ------------------>
								if ($traitsRows2 > 0) {
									for($ct2=0;$ct2<$traitsRows2;$ct2++) {
										$traitResult2 = mysql_fetch_array($traitsQuery2);
										//$traitID[$ct] = $traitResult["id"];	// Nombre del Rasgo
										$traitName2[$ct2] = dyd_safe_label($traitResult2["name"], $traitResult2["url"] ?? "");	// Nombre del Rasgo
										$traitInfo2[$ct2] = $traitResult2["infotext"];	// Nombre del Rasgo
										//echo $traitName2[$ct2]."<br/>".$traitInfo2[$ct2];
?>
										<fieldset class="classFieldset">
										<legend><?php echo $traitName2[$ct2]; ?></legend>
										<p><?php echo $traitInfo2[$ct2]; ?></p>
										</fieldset>
<?php
									if ($ct2+1<$traitsRows2) { echo "<br/>"; }
									}
								}
							}
							echo $traitChoose[$ct];
							}
						}
					// Fin del rasgo
				// ----------------------------------------------------------------------------------------- //	
					}
				echo "</fieldset>";
			}
			// ------------------------------------------------------------------ //
			if ($classMiscText !="") {
				echo "<br/>";
				// Fieldset intermedio - Datos misceláneos
				// ------------------------------------------------------------------ //
				echo "<fieldset>";
					echo "<legend>".$classMiscTitle."</legend>";
					echo $classMiscText;
				echo "</fieldset>";
			}
			// ------------------------------------------------------------------ //
			if ($classImplementText !="") {
				echo "<br/>";
				// Quinto Fieldset - Utensilios de la clase
				// ------------------------------------------------------------------ //
				echo "<fieldset>";
					if ($classTier != 3) {
						echo "<legend>Utensilios</legend>";
					} else {
						echo "<legend>Poderes opcionales</legend>";
					}
					echo $classImplementText;
				echo "</fieldset>";
			}
			// ------------------------------------------------------------------ //
			echo "</div>"; // <=== Fin del TAB 1
		// ------------------------------------------------------------------ //
		// TAB 02 - PODERES Y DOTES
		// ------------------------------------------------------------------ //
			echo "<div id='powers' class='tab_content'>"; // <=== Contenido del TAB 2
		// Sexto Fieldset - Poderes
			// Poderes de la clase
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydPowersFields." FROM ".$dydTablePowers." WHERE class LIKE '".$className."'";
			$dataSection	 = "powers";
			// ------------------- >
			// Mostrar los Poderes de la Clase
			// ------------------- >
			include("race_class_content.php");
			if ($dataRows != 0) {
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Poderes de ".$className."</h3>";
					include(__DIR__ . "/contents_list.php");
				echo "</fieldset>";
			}
			$powerRows = $dataRows; // Comprobar poderes
			// ------------------- >
			// Salto de línea 1
			if ($powerRows != 0) { echo "<br />"; }
		// Séptimo Fieldset - Dotes
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydFeatsFields." FROM ".$dydTableFeats." WHERE class LIKE '".$className."'";
			$dataSection	 = "feats";
			// ------------------- >
			// Mostrar las Dotes de la clase
			// ------------------- >
			include("race_class_content.php");
			if ($dataRows != 0) {
			// Salto de línea 2
				if ($powerRows != 0) { echo "<br />"; }
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Dotes de ".$className."</h3>";
					include(__DIR__ . "/contents_list.php");
				echo "</fieldset>";
			// Salto de línea 3
			if ($powerRows == 0) { echo "<br />"; }
			}
			$featRows = $dataRows; // Comprobar dotes
			// ------------------- >
			echo "</div>"; // <=== Fin del TAB 2
		// ------------------------------------------------------------------ //
		// TAB 03 - RAZAS RECOMENDADAS
		// ------------------------------------------------------------------ //
			echo "<div id='races' class='tab_content'>"; // <=== Contenido del TAB 3
		// Octavo Fieldset - Razas recomendadas
		$statSearch = explode("/", $classStats);
		if ($statSearch[2] != "") {
			$raceStatSearch = "LIKE '%".$statSearch[0]."%' AND abilities LIKE '%".$statSearch[1]."%' OR abilities LIKE '%".$statSearch[0]."%' AND abilities LIKE '%".$statSearch[2]."%'";
		} else {
			$raceStatSearch = "LIKE '%".$statSearch[0]."%' AND abilities LIKE '%".$statSearch[1]."%'";
		}
			// Razas
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydRacesFields." FROM ".$dydTableRaces." WHERE abilities ".$raceStatSearch."";
			$dataSection	 = "races";
			// ------------------- >
			// Mostrar las Razas recomendadas de la Clase
			// ------------------- >
			include("race_class_content.php");
			if ($dataRows != 0) {
				echo "<fieldset class='noInfoLink'>";
					echo "<h3 class='powerTitle'>Razas recomendadas</h3>";
					include(__DIR__ . "/contents_list.php");
				echo "</fieldset>";
				echo "<br />";
			}
			$classRows = $dataRows; // Comprobar razas
			// ------------------- >
			echo "</div>"; // <=== Fin del TAB 3
	// Fin Hoja
	echo "</div>"; // <=== Fin Div de Tabs
	echo "<br/>";
	// Texto del origen de la clase. Para dar los enlaces y eso.
	if ($classOriginText != "") {
		echo "<p class='originFoot'>".$classOriginText."</p>";
	}
	// ------------------- >
	} else {
		echo $phraseNoAuth;
	}
	// ------------------------------------------------------------------ //
	} else {
	// ------------------------------------------------------------------ //
	// Listado de Clases; Texto que aparece si no se elige Hoja			  //
			switch($typItem) {
				case "heroic":	// Grado Heroico
				default:
					$classTierTitle = "Heroicas";
					$dataSearchSQL = "WHERE tier LIKE 0";
				break;
				case "essentials":	// Essentials
					$classTierTitle = "Essentials";
					$dataSearchSQL = "WHERE tier LIKE 4";
				break;
				case "paragon":	// Sendas de Parangón
					$classTierTitle = "Sendas de parangón";
					$dataSearchSQL = "WHERE tier LIKE 1";
				break;
				case "epic":	// Destinos épicos
					$classTierTitle = "Destinos épicos";
					$dataSearchSQL = "WHERE tier LIKE 2";
				break;
				case "themes":	// Temas de Personaje
					$classTierTitle = "Temas de personaje";
					$dataSearchSQL = "WHERE tier LIKE 3";
				break;
			}
		// Localización para pestañas
		$tabName = $classTierTitle;
		include_once(__DIR__ . "/contents_tabs.php");
		// Cambiamos el título
		if ($classTierTitle == "Heroicas") { 
			$classTierTitle = "Clases ".strtolower($classTierTitle); 
			$pageTitle2 = "Clases";
		} else {
			$pageTitle2 = $classTierTitle;
		}
		// ------------------------->
		echo "<h3>".$classTierTitle."</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydClassesFields." FROM ".$dydTableClasses." ".$dataSearchSQL."";
			$dataSection	 = $dydSectionClasses[0];
		include(__DIR__ . "/contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>


