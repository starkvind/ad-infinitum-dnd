<?php
	$adventTotalXP	= 0;
	// Experiencia de las aventuras
	$adventOrder	= "SELECT ".$dydBasicFields.", ".$dydAdventuresFields." FROM ".$dydTableAdventures." WHERE players LIKE '%".$playerURL."%'";
	$adventIdQuery 	= mysql_query($adventOrder, $link);
	$adventRows 	= mysql_num_rows($adventIdQuery);
	if ($adventRows != 0) {
		$playerAdventures = $adventRows;
		for($adr=0;$adr<$adventRows;$adr++) {
			$adventQueryResult = mysql_fetch_array($adventIdQuery);
			$adventXP 		= $adventQueryResult["xp"];
			$adventTotalXP 	= $adventXP + $adventTotalXP;
		}
	}
	// Experiencia de bonificación
	$bonusXpOrder	= "SELECT xp FROM ".$dydTablePlayerExp." WHERE player_url LIKE '".$playerURL."'";
	$bonusXpIdQuery	= mysql_query($bonusXpOrder, $link);
	$bonusXpRows 	= mysql_num_rows($bonusXpIdQuery);
	if ($bonusXpRows != 0) {
		for($bxr=0;$bxr<$bonusXpRows;$bxr++) {
			$bonusXpQueryResult = mysql_fetch_array($bonusXpIdQuery);
			$bonusXP 	= $bonusXpQueryResult["xp"];
			$adventTotalXP = $bonusXP + $adventTotalXP;
		}
	}
?>