<?php
	$userTopQuest = "WHERE user LIKE '".$mainUserName."'";
	$userTopQuery = "SELECT SUM(amount) AS UserTopaz FROM ".$tableTopaz." ".$userTopQuest."";
	$userTopIdQue = mysql_query($userTopQuery, $link);
	$userTopRows  = mysql_num_rows($userTopIdQue);
	if ($userTopRows != 0) {
		$userTopResult = mysql_fetch_array($userTopIdQue);
		$userPoints = $userTopResult["UserTopaz"];
	}
	if ($userPoints == "") { $userPoints = 0; }
?>