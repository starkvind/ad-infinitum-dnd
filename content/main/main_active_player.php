<?php
if (isset($_SESSION['player_name'])) {
	$playerActiveURL = $_SESSION['player_url'];
	$playerActiveLvl = $_SESSION['player_lvl'];
	$playerActiveName = $_SESSION['player_name'];
	$playerActiveSurname = $_SESSION['player_surname'];
	//$playerActiveRace = $plyr2Result["race"];
	//$playerActiveClass = $plyr2Result["class"];
	// Comprobamos si conoce el ritual
	/*$playerActiveInv = $_SESSION['player_inv'];
	$checkPlayerInv = explode("[RITUALS]", $playerActiveInv); // Nos quedamos con lo que hay tras [RITUALS]
	$checkPlayerInv2 = explode("|", $checkPlayerInv[1]);	  // Rompemos los datos trás | para quedanos solo con las IDs.
	if (strpos($checkPlayerInv2[0], "26") !== false) {
		echo "<br/>true"; 
	}*/
}
?>
<div class="activePlayer">
	<?php echo $playerActiveName." ".$playerActiveSurname; ?>
</div>
<div class="activePlayerLevel">
	<?php echo $playerActiveLvl; ?>
</div>