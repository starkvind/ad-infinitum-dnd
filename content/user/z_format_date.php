<?php
// Format this sexy date.
	list($year, $month, $day) = explode('-', $formatDate);
	$time = mktime(0, 0, 0, $month, $day, $year);
	$date = date('d-m-Y', $time);
	//echo $date."\n";
	if ($addWeek == TRUE) {
		$weekAdd = $time + (60*60*24*7);
		$date = date('d-m-Y', $weekAdd);
	}
	//echo $date."\n"; 
?>