<?php
// Preparamos los rasgos que tiene el personaje por sí.
	$playerTraitChoice = explode("|", $playerTraits);
// Orden de los rasgos
	$traitOrder = "ORDER BY choosetext, level, name";
// Vamos preparando las solicitudes a la BDD según lo que tengamos.
	// Rasgos raciales
	echo "<h4>".$raceName."</h4>";
	echo "<div class='playerListOfTraits'>";
		$stMoreTraits	= "OR id IN ('".$raceTraits."')";
		$traitTerms		= "WHERE class LIKE '".$raceName."' ".$stMoreTraits." ".$traitOrder."";
		include("player_get_traits_2.php");
	echo "</div>";
	// Rasgos de clase
	echo "<h4>".$className."</h4>";
	echo "<div class='playerListOfTraits'>";
		$stMoreTraits	= "OR id IN ('".$classTraits."')";
		$traitTerms		= "WHERE class LIKE '".$className."' ".$stMoreTraits." ".$traitOrder."";
		include("player_get_traits_2.php");
	echo "</div>";
	// Rasgos de Tema de Personaje
	if ($themeName != "") {
	echo "<h4>".$themeName."</h4>";
	echo "<div class='playerListOfTraits'>";
		$stMoreTraits	= "";
		$traitTerms		= "WHERE class LIKE '".$themeName."' ".$traitOrder."";
		include("player_get_traits_2.php");
	echo "</div>";
	}
	// Rasgos de la Senda de Parangón
	if ($paragonName != "") {
	echo "<h4>".$paragonName."</h4>";
	echo "<div class='playerListOfTraits'>";
		$stMoreTraits	= "";
		$traitTerms		= "WHERE class LIKE '".$paragonName."' ".$traitOrder."";
		include("player_get_traits_2.php");
	echo "</div>";
	}
	// Rasgos del Destino épico
	if ($epicName != "") {
	echo "<h4>".$epicName."</h4>";
	echo "<div class='playerListOfTraits'>";
		$stMoreTraits	= "";
		$traitTerms		= "WHERE class LIKE '".$epicName."' ".$traitOrder."";
		include("player_get_traits_2.php");
	echo "</div>";
	}
?>