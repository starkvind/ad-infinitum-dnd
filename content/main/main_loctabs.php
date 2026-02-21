<div class="locationTab">
	<ul>
	<?php
	$tabTitle = $tabTitle ?? "";
	$noSection = $noSection ?? "";
	$tabSep = "&raquo;";
	// ESTRUCTURA
	// tabTitle > locTab > tabName
	if ($tabTitle != "") {
		echo "<li>";
			switch($page) {
				case 0:
					if ($noSection == TRUE) { $linkBackSetion = $pageRoot; } else { $linkBackSetion = $pageRoot.$section."/"; }
					// Pestaña para listados con sección
					echo "<a href='".$linkBackSetion."'>".$tabTitle."</a>";
				break;
				default:
					// Pestaña para hojas
					if ($noSection == FALSE) {
						echo "<a href='".$backSection."'>".$tabTitle."</a> ".$tabSep." ";
					} else {
						echo "<a href='".$pageRoot."'>".$tabTitle."</a> ".$tabSep." ";
					}
					switch ($locTab) {
						case "":
						break;
						default:
							echo "<a href='".$backSection.$returnBackSection."'>".$locTab."</a>";
						break;
					}
				break;
			}
			// Si tenemos tabName y locTab definimos, ponemos un último separador.
			if ($locTab != "" AND $tabName !="") { echo " ".$tabSep." "; }
			if ($tabName != "") { echo $tabName; }
		echo "</li>";
	}
	?>
	</ul>
</div>