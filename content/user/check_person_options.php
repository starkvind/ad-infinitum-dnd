<?php
	// Preparar las opciones del usuario para utilizarlas más tarde.
	if ($debugSystem == TRUE) { echo "<br/>"; }
	if(isset($_SESSION['options'])) {
		$mainUserOptions = explode("|", $_SESSION['options']);
		if (count($mainUserOptions) > 0) {
			for($uoc=0;$uoc<(count($mainUserOptions)-1);$uoc++) {
				$indivUserOption = explode(":", $mainUserOptions[$uoc]);
				if ($debugSystem == TRUE) { echo "'".trim($indivUserOption[0])."' es esto: ".$indivUserOption[1]."<br/>"; }
				switch(trim($indivUserOption[0])) {
					case "MENUSTYLE":
						$_SESSION['menustyle'] = $indivUserOption[1];
					break;	
					case "AVATAR":
						$_SESSION['avatar'] = $indivUserOption[1];
					break;					
					case "CSS":
						$_SESSION['user_css'] = $indivUserOption[1];
					break;
				}
				$indivUserOption = "";
			}
		}
		if ($debugSystem == TRUE) {
			echo "<br/>";
			echo "Avatar: ".$_SESSION['avatar']."<br/>";
			echo "Estilo menú: ".$_SESSION['menustyle']."<br/>";
			echo "CSS: ".$_SESSION['user_css']."<br/>";
		}
	}
?>