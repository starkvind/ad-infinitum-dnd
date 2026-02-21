<?php
	if ($page != 0) {
	// ================================================================== //
		echo "<div id='powerItemLayout'>";
			$ailmentId = $page; // Damos la id de la Aflicción.
			include ("ailment_card.php");
			$pageTitle3 = $ailmentName;
		echo "</div>";
	// ================================================================== //ç
	echo "<br/>";
		// Localización para pestañas
		include_once("contents_tabs.php");
	} else {
		// ------------------------------------------------------------------ //
		echo "<h3>Aflicciones</h3>";
			$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydAilmentsFields." FROM ".$dydTableAilments."";
			$dataSection	 = $dydSectionAilments[0];
		include("contents_list.php");
		// ------------------------------------------------------------------ //
	}
?>