<?php
	// --------------------- >
	$iconDir = $pageRoot."media/origin/";
	$iconExt = ".png";
	/*if ($originIcon == "") { $originIcon = "icon_origin_notdefined"; }
	$originImg = $iconDir."".$originIcon."".$iconExt;*/
	switch($mainWork) {
		case $dydSectionPlayers:
			echo "<img src='".$roleIconImg."' style='margin-left:693px;' title='".$classRole."' class='iconOrigin' />";
		break;
		case $dydSectionNPC:
			echo "<img src='".$statIconImg."' style='margin-left:693px;' title='".$npcStatusT."' class='iconOrigin' />";
		break;
		default:
			if ($originIcon == "") { $originIcon = "icon_origin_notdefined"; }
			$originImg = $iconDir."".$originIcon."".$iconExt;
			echo "<img src='".$originImg."' title='".$originName."' class='iconOrigin' />";
		break;
	}
	/*if ($roleIconImg == "") {
		echo "<img src='".$originImg."' title='".$originName."' class='iconOrigin' />";
	} else {
		echo "<img src='".$roleIconImg."' style='margin-left:693px;' title='".$classRole."' class='iconOrigin' />";
	}*/
	// --------------------- >
?>