<!-- Contenidos de Poderes Enemigos --->
	<?php
	$attackSelect = $typeOfAttacks;
	$attackIconFolder = $pageRoot."media/attack";
	$attackSeparator = "&#8226;";
		$arrayEnemy = explode("|", $attackSelect);
		$numberAttacks = count($arrayEnemy);
		for($i=0;$i<$numberAttacks;$i++) {
			$attackData = explode("^", $arrayEnemy[$i]);			
	?>
		<div class="enemyAttack">
			<?php
			// -------------------------------------------- //
			$attackGetIcon = explode("]", $attackData[0] ?? "");	// Cogemos tipo de ataque
			$attackGetIcon[0] = trim($attackGetIcon[0] ?? "");	// Quitamos espacios
			// -------------------------------------------- //
			switch ($attackGetIcon[0][1] ?? "") {	// Definimos el icono del ataque
				case "A": // Explosión
					$attackIcon = $attackIconFolder."/icon_blast.png";
					$attackIconTitle = "Explosión";
				break;
				case "B": // Estallido
					$attackIcon = $attackIconFolder."/icon_burst.png";
					$attackIconTitle = "Estallido";
				break;
				case "C": // Cuerpo a Cuerpo
					$attackIcon = $attackIconFolder."/icon_melee.png";
					$attackIconTitle = "Cuerpo a cuerpo";
				break;
				case "D": // A distancia
					$attackIcon = $attackIconFolder."/icon_ranged.png";
					$attackIconTitle = "A distancia";
				break;
				case "E": // Aura
					$attackIcon = $attackIconFolder."/icon_aura.png";
					$attackIconTitle = "Aura";
				break;
				case "F": // Cuerpo a cuerpo Basico
					$attackIcon = $attackIconFolder."/icon_basicmelee.png";
					$attackIconTitle = "Cuerpo a cuerpo, básico";
				break;
				case "G": // A distancia Basico
					$attackIcon = $attackIconFolder."/icon_basicranged.png";
					$attackIconTitle = "A distancia, básico";
				break;
				default: // NADAAAA
					$attackIcon = "";
					$attackIconTitle = "";
				break;
			}
			// Si no tiene icono, no le ponemos nada
			if ($attackIcon != "") { 
				echo "<img src='".$attackIcon."' class='attackIcon' title='".$attackIconTitle."'/>"; // Colocamos Icono
				$attackTitle = $attackGetIcon[1] ?? "";
			} else {
				$attackTitle = $attackData[0] ?? "";	
			}
			// Dividimos toda la información de los ataques para mostrarlo de una manera u otra
			$attackUses = explode("-", $attackTitle); // Separamos NOMBRE DE ATAQUE de † A voluntad / Encuentro / Etc
			$attackTypes = explode("(", $attackUses[0] ?? ""); // Separamos el tipo de armas, elementos o tipos de ataque
			if (($attackTypes[1] ?? "") != "") {
			// == > Tiene tipos de ataque (poder estandar, menor, etc)
				echo "<b>".$attackTypes[0]."</b>"; 
				echo "(".$attackTypes[1]."";
			} else {
				echo "<b>".($attackUses[0] ?? "")."</b>";
			}
			// == > No tiene tipos de ataque. Será un rasgo
				if (($attackUses[1] ?? "") != "") { echo $attackSeparator; }
			// == > Vamos a ver si tiene dados de recarga
			$attackDice = explode("{", $attackUses[1] ?? ""); // Separamos los numeros
			$attackDiceCheck = trim($attackDice[0]);
			// == > Si tenemos Dados de recarga, vamos preparando el asunto
			if ($attackDiceCheck == "Recarga") { 
				echo " <b>".$attackDiceCheck."</b> ";
				// == > Separamos los numeros, que van a ir por comas
				$attackDiceImg = explode(",", $attackDice[1] ?? "");
				$attackDiceQty = count($attackDiceImg);
					for($samurai=0;$samurai<$attackDiceQty;$samurai++) {
					// ==> Quitamos cualquier espacio que nos pueda joder la operación
						$attackDiceImg[$samurai] = trim ($attackDiceImg[$samurai]);
						echo "<img src='".$attackIconFolder."/".$attackDiceImg[$samurai]."d6.png' class='attackIcon' id='dice' title='Recarga en ".$attackDiceImg[$samurai]."' />";
					}
			// => Acabamos si tenemos dados
			} else {
				echo "<b>".($attackUses[1] ?? "")."</b>";
			}
			// Acabamos con los dados
			// Finalizamos esta mierda
		?>
		</div>
		<div class="enemyAttackInfo">
			<?php echo $attackData[1]; ?>
		</div>
	<?php
		}
		if ($i == $numberAttacks) { echo "<div style='height: 0px; border-bottom: 1px solid #003366;'></div>";} 
	?>
