<?php
	switch ($armorSearch) {
		case "armor":
			$whatDataSearch = $equipArmorType;
		break;
		case "shield":
			$whatDataSearch = $shieldType;
		break;
	}
	$armorOrder 	= "SELECT armor, skill, speed, thingtype FROM ".$dydTableItems." WHERE name LIKE '".$whatDataSearch."' LIMIT 1";
	$armorIdQuery 	= mysql_query($armorOrder, $link);
	$armorRows 		= mysql_num_rows($armorIdQuery);
	if ($armorRows != 0) {
		$armorQueryResult 	= mysql_fetch_array($armorIdQuery);
		$armorAC		= $armorQueryResult["armor"];
		$armorSkill 	= $armorQueryResult["skill"];
		$armorSpeed 	= $armorQueryResult["speed"];
		$armorKind		= $armorQueryResult["thingtype"];
	}
?>