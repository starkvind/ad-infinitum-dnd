<?php
if ($page != 0) {
	$encounterID = $page; // Damos la id de la Aflicción.
	include (__DIR__ . "/encounter_card.php");
	$pageTitle3 = $encounterName;
	// Localización para pestañas
	include_once(__DIR__ . "/contents_tabs.php");
	// Fin Hoja
	// ------------------------------------------------------------------ //
	echo "<br/>";
} else {
	// ------------------------------------------------------------------ //
	echo "<h3>Encuentros</h3>";
		// Mostramos la lista de encuentros 
		$encWhere = trim($userLevelCheck ?? "");
		if ($encWhere != "") {
			if (preg_match('/^(AND|OR)\b/i', $encWhere)) {
				$encWhere = "WHERE 1=1 ".$encWhere;
			} elseif (!preg_match('/^WHERE\b/i', $encWhere)) {
				$encWhere = "WHERE ".$encWhere;
			}
		}
		$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydEncounterFields." FROM ".$dydTableEncounter." ".$encWhere."";
		$dataSection	 = $dydSectionEncounter[0];
		include(__DIR__ . "/contents_list.php");
	// ------------------------------------------------------------------ //
}
?>
