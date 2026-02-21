<?php $variableData = ""; ?>
<?php 
	$numerokAse = $_GET['block'];
	switch ($numerokAse) {
		default:
			echo "No has escogido nada, jusep.";
		break;
		case "info":
			echo "Eres un moai. (".$numerokAse.")";
		break;
		case "powers": 
			echo "Dani te ataca con un lanzapenes.(".$numerokAse.")";
		break;
	}
	if ($numerokAse == 0) { $numerokAse = 1; }
?>
<div id="pop-up">  
<!--<h3>Lanza del crepúsculo</h3>
	<p>Formas un tremebundo pilar de energía vertical en la palma de tu mano, que rebosa fuerza psíquica de las tierras sombrías.</p>

		<a href="javascript:void(0);" onclick="getBlock(powers)"><li>Poderes</li></a>
		<a href="javascript:void(0);" onclick="getBlock(info)"><li>Información</li></a>
-->
	<?php //$powerId = $numerokAse; include ("power_card.php"); ?>
</div>