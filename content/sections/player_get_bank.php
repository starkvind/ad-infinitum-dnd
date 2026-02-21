<?php
// Desglose e identificacion de los objetos en el banco del personaje
	$playerCheckBank = explode("-", $playerBank);
		if (count($playerCheckBank) > 0) {
			for($bankSlot=0;$bankSlot<count($playerCheckBank);$bankSlot++) {
				$itemKind = explode(":", $playerCheckBank[$bankSlot]);
				switch($itemKind[0]) {
					case "T":
						//echo "El objeto ".$bankSlot." es un item de TEXTO.<br/>";
						$bankType[$bankSlot] = "text";
						$bankItem[$bankSlot] = $itemKind[1];
						$bankIcon[$bankSlot] = $itemKind[2];
					break;
					case "M":
						$retrieveFrom = "magic";
						$dataListMagic = $itemKind[1];
						include ("retrieve_origin.php");
						$bankType[$bankSlot] = "magic";
						$bankItem[$bankSlot] = $magicName;
						$bankIcon[$bankSlot] = $equipIconType;
						$bankItemLink[$bankSlot] = $pageRoot.$dydSectionMagicItems[0]."/".$itemKind[1]."/";
						$bankObjectType[$bankSlot] = $objectType;
						$bankObjectIcon[$bankSlot] = $objectIcon;
					//	echo $objectIcon;
					break;
					default:
						$retrieveFrom = "thing";
						$dataListThing = $itemKind[1];
						include ("retrieve_origin.php");
						$bankType[$bankSlot] = "item";
						$bankItem[$bankSlot] = $thingName;
						$bankIcon[$bankSlot] = $equipIconType;
						$bankItemLink[$bankSlot] = $pageRoot.$dydSectionItems[0]."/".$itemKind[1]."/";
						$bankObjectType[$bankSlot] = $objectType;
						$bankObjectIcon[$bankSlot] = $objectIcon;
					break;
				}
				// switch ($retrieveFrom) {
					// case "thing":
						// echo $thingName.": ".$objectIcon."<br/>";
					// break;
					// case "magic":
						// echo $magicName.": ".$objectIcon."<br/>";
					// break;
				// }
			}
		}
	// Ya hemos localizado todos los objetos en la base de datos. Procedemos a mostrarlos
	if (count($bankItem) > 0) {
		echo "<div class='playerBankList'>";
			echo "<ul class='playerBankList'>";
				for($bankSlot2=0;$bankSlot2<count($bankItem);$bankSlot2++) {
					if ($bankType[$bankSlot2] != "text") {
						// Definimos los iconos que van a aparecer
						$getRitualIcon = FALSE;
						//echo $bankItem[$bankSlot2].">>>".$bankObjectIcon[$bankSlot2]."<br/>";
						include("player_get_bank_icons.php");
						//echo $bankItemIcon."<br/>";
						$itemImg = $dydIconDirectory.$bankItemIcon.$dydIconExtension;
						echo "<a href='".$bankItemLink[$bankSlot2]."' title='".$bankObjectType[$bankSlot2]."' target='_blank'>";
							echo "<li><div class='divBank'><img class='iconBank' src='".$itemImg."' /></div>".$bankItem[$bankSlot2]."</li>";
						echo "</a>";
					} else {
						if ($bankIcon[$bankSlot2] == "") { $bankIcon[$bankSlot2] = "icon_item"; }
						$itemImg = $dydIconDirectory.$bankIcon[$bankSlot2].$dydIconExtension;
						echo "<li><div class='divBank'><img class='iconBank' src='".$itemImg."' /></div>".$bankItem[$bankSlot2]."</li>";
					}
				}
			echo "</ul>";
		echo "</div>";
	}
?>