<?php
	// ------------
	$encQuest = "WHERE user LIKE '".$mainUserName."'";
	$orderData = "SELECT * FROM ".$dydTableUserEnch." ".$encQuest." ORDER BY date DESC LIMIT 1"; // Elegimos las encantamientos en la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	// ------------------------------------------------------------------ //
	// Localización para pestañas
		include_once("content/sections/contents_tabs.php");
	// ------------------------------------------------------------------ //
	// Pruebas
	//mail("maverickk@gmail.com","asuntillo","Este es el cuerpo del mensaje");
?>
<h3>Aprendizaje de <?php echo $_SESSION['player_name'];?></h3>
<fieldset class="learnEnchant">
<?php
	//echo $todayDate;
	// Listado de encantamientos
	if ($rowsData != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
		for($dt=0;$dt<$rowsData;$dt++) {
			$queryResult = mysql_fetch_array($queryData);
			$encStDate	 = $queryResult["date"];
			$encStId	 = $queryResult["enchant_id"];
			$encStTopaz	 = $queryResult["topaz"];
			// Comprobamos la fecha.
			// ----> Chequeamos el nombre del ritual.
				$checkRiteQuest = "WHERE id LIKE ".$encStId."";
				$riteData = "SELECT name, levels FROM ".$dydTableEnchants." ".$checkRiteQuest." LIMIT 1"; // Elegimos las transacciones en la Base de Datos
				$queryRite = mysql_query ($riteData, $link);
				$rowsRite = mysql_num_rows($queryRite);
				if ($rowsRite != 0) {
					$riteResult = mysql_fetch_array($queryRite);
					$encRiteName = $riteResult["name"];
					$encRiteLvls = $riteResult["levels"];
					// Preparamos el nivel mínimo del ritual.
						$arrayLevels = explode("|", $encRiteLvls);
						// Contamos y quitamos valores en blanco del array
						$cleanArrayLevels = array_values(array_diff($arrayLevels, array("")));
						if ($cleanArrayLevels[0] != "") {
							$checkArrayLevel = explode("+", $cleanArrayLevels[0]);
							$levelsEnchant = str_replace("Niv. ", "", $checkArrayLevel[0]);
							$levelsEnchant = str_replace(" ", "", $levelsEnchant);
						}
				}
			// Comprobamos si hemos usado topacios
			if ($encStTopaz == 1) {
				$topazPhrase = ", y empleaste <b>topacios del infinito</b>";
			} else {
				$topazPhrase = "";
			}
			// Preparamos la fecha.
			$addWeek = FALSE;
			$formatDate = $encStDate;
			include("z_format_date.php");
			$oldEncDate = $date;
			echo "<p>El día ".$oldEncDate." aprendiste el encantamiento <b>".$encRiteName."</b>, con nivel mínimo ".$levelsEnchant.$topazPhrase.".</p>";
		}
		// Comprobamos la fecha donde no se usaron topacios del infinito
		$encQuest2 = "WHERE user LIKE '".$mainUserName."' AND topaz LIKE 0";
		$orderData2 = "SELECT * FROM ".$dydTableUserEnch." ".$encQuest2." ORDER BY date DESC LIMIT 1"; // Elegimos las encantamientos en la Base de Datos
		$queryData2 = mysql_query ($orderData2, $link);
		$rowsData2 = mysql_num_rows($queryData2);
		if ($rowsData2 != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
			$queryResult2 = mysql_fetch_array($queryData2);
			$encStDate2	 = $queryResult2["date"];
			// Preparamos la fecha.
			$addWeek = TRUE;
			$formatDate = $encStDate2;
			include("z_format_date.php");
			$newEncDate = $date;
		}
		// ----> Mostramos los datos
		if ((strtotime($encStDate2) < strtotime("1 week ago")) == FALSE) {
			$showYouCantStudy = TRUE;
		}
	}
	if ($_SESSION['no_more_enchants'] == TRUE) {
		echo "<p>Parece que ".$_SESSION['player_name']." no puede aprender más encantamientos. ¡Prueba a subir de nivel e intentarlo otro día!</p>";
		$_SESSION['no_more_enchants'] = FALSE;
	}
	if ($showYouCantStudy == TRUE) {
?>
	<?php include_once("get_usertopaz.php"); ?>
	<p><?php echo $_SESSION['player_name']; ?> no puede aprender más encantamientos esta semana, pero podrás aprender un encantamiento gratuito de nuevo el día <?php echo $newEncDate; ?>. 
	<?php if ($userPoints > 9) { ?><br/>Si lo deseas, puedes gastar <b>topacios del infinito</b> (tienes <?php echo $userPoints; ?>) para conseguir un nuevo estudio. <?php } ?>
	</p>
	<?php if ($userPoints > 9) { ?>
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userenchants.php">
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="level" value="<?=$_SESSION['player_lvl']?>" />
			<input type="hidden" name="enchants" value="<?=$_SESSION['dyd_enchants']?>" />
			<input type="hidden" name="topaz" value="si" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input type="submit" class="sendButton" value="Gastar 10 topacios" />
		</form>
	<?php } ?>
<?php
	} else {
?>
	<p>¿Quieres aprender un nuevo encantamiento para <?php echo $_SESSION['player_name']; ?>? Pulsa el botón "Aprender encantamiento" para investigar.</p>
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userenchants.php">
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="level" value="<?=$_SESSION['player_lvl']?>" />
			<input type="hidden" name="enchants" value="<?=$_SESSION['dyd_enchants']?>" />
			<input type="hidden" name="topaz" value="" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input type="submit" class="sendButton" value="Aprender encantamiento" />
		</form>
<?php } ?>
</fieldset>
<br/>
<?php if ($_SESSION['dyd_enchants'] != "") { ?>
<hr style ="width:960px;margin-bottom:22px;" />

<h3>Encantamientos de <?php echo $_SESSION['player_name'];?></h3>
<!-- Mostramos todos los encantamientos que conocemos -->
<div id="mainSectionList">
<?php
	// Datos de sesión
		$dataSearchSQL = "WHERE id IN (".$_SESSION['dyd_enchants'].")";
		$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydEnchantsFields." FROM ".$dydTableEnchants." ".$dataSearchSQL; //
	// Mostramos los encantamientos
	echo "<h3>".$enchantTitle."</h3>";
		$dataSection = $dydSectionEnchants[0];
		include("content/sections/contents_list.php");
?>
<br/>
</div>
<?php } ?>