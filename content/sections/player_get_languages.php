<?php
// -------------------------------------------------------------------------------------- 	
// THE DANI IDIOMAS
// -------------------------------------------------------------------------------------- 
	// Ya que estamos, colocamos los idiomas aquí
	if ($playerLanguages != "") {
		echo "<p><b>Idiomas conocidos:</b> ";
// Cogemos todos los idiomas.
	$languageTerms	= "WHERE id IN (".$playerLanguages.") ORDER BY id";
	$languageQuery 	= "SELECT ".$dydBasicFields." FROM ".$dydTableArticles." ".$languageTerms."";
	$languageIdQuery= mysql_query($languageQuery, $link);
	$languageRows 	= mysql_num_rows($languageIdQuery);
// Preparamos los idiomas que tiene el personaje por sí.
		if ($languageRows > 0) {
			for($lgr=0;$lgr<$languageRows;$lgr++) {
				$languageQueryResult= mysql_fetch_array($languageIdQuery);
				// ID del idioma
				$languageID 		= $languageQueryResult["id"];
				// Nombre del idioma
				$languageName 		= $languageQueryResult["name"];
				// Enlace del idioma. Los idiomas son artículos.
				$languageLink 		= $pageRoot.$dydSectionArticles[0]."/".$languageID."/";
				echo "<a href='".$languageLink."' target='_blank'>".strtolower($languageName)."</a>";
				// Ponemos la puntuación.
				if ($lgr > ($languageRows-2)) { echo "."; } else { echo ", "; }
			}
		}
		echo "</p>";
	}
?>