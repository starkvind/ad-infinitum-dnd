<?php
    $paymentDate = date('Y-m-d');
    $paymentDate=date('Y-m-d', strtotime($paymentDate));;
    //echo $paymentDate; // echos today! 
    $contractDateBegin = date('Y-m-d', strtotime("04/07/2014"));
    $contractDateEnd = date('Y-m-d', strtotime("04/27/2014"));
    if (($paymentDate > $contractDateBegin) && ($paymentDate < $contractDateEnd)) {
		//echo "is between";
		$dndCompetition = TRUE;
    } else {
		//echo "NO GO!";  
		if ($mainUserName == "maverick") { 
			$dndCompetition = TRUE;
		} else {
			$dndCompetition = FALSE;
		}
    }
	// Comprobamos si la sesión está activada if ()
	if (isset($mainUserName) AND $userLevel >= 0) {
	// Preparamos los Get y el percal
	$typeManagement 	= $typItem;
	$subTypeManagement 	= $typSubType;
	// ------------------------------------ //
	// Preparamos el PJ activo y su nivel
	// ------------------------------------ //
	//include_once("get_active_player.php");
	// Continuamos.
	switch($typeManagement) {
	case "powers":
		$pageTitle3 = "Poderes";
?>
	<h2>Gesti&oacute;n de poderes</h2>
<?php
		include("management_page.php");
	break;	
	// Añadir Rasgos
	case "addtraits":
		$pageTitle3 = "Añadir rasgos";
?>
	<h2>Gesti&oacute;n de rasgos</h2>
<?php
		include("management_page.php");
	break;	
	// Añadir Dotes
	case "addfeats":
		$pageTitle3 = "Añadir dotes";
?>
	<h2>Gesti&oacute;n de dotes</h2>
<?php
		include("management_page.php");
	break;
	// Añadir Aventures
	case "addinstances":
		$pageTitle3 = "Añadir aventuras";
?>
	<h2>Gesti&oacute;n de aventuras</h2>
<?php
		include("management_page.php");
	break;	
	// Añadir Localizaciones
	case "addlocations":
		$pageTitle3 = "Añadir localizaciones";
?>
	<h2>Gesti&oacute;n de localizaciones</h2>
<?php
		include("management_page.php");
	break;
	// Añadir Tarjetas de pifia
	case "addcompcard":
		$pageTitle3 = "Añadir tarjetas de pifia";
?>
	<h2>Participación en el concurso</h2>
<?php
		include("management_page.php");
	break;	
	// Comprobar Tarjetas de pifia
	case "checkcards":
		$pageTitle3 = "Comprobar tarjetas de pifia";
?>
	<h2>Tarjetas para el concurso</h2>
<?php
		include("management_page.php");
	break;
	case "cultists":
	if ($_SESSION['level'] >= 4) {
		$pageTitle3 = "Cultistas";
?>
	<h3>Cultistas de Ad Infinitum</h3>
<?php
		include("management_user.php");
	}
	break;
	case "characters":
	if ($_SESSION['level'] >= 1) {
		$pageTitle3 = "Personajes";
?>
	<h3>Tus personajes</h3>
<?php
	// Localización para pestañas
	include_once("content/sections/contents_tabs.php");	
	// Datos de sesión
		$dataSearchSQL = "WHERE uploader LIKE '".$mainUserName."'";
		$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydPlayersFields." FROM ".$dydTablePlayers." ".$dataSearchSQL."";
		$dataSection	 = $dydSectionPlayers[0];
		include("content/sections/contents_list.php");
	}
	break;
	case "participation":
	if ($_SESSION['level'] >= 1) {
		$pageTitle3 = "Sesiones";
?>
	<h3>Sesiones a las que has asistido</h3>
<?php
	// Localización para pestañas
	include_once("content/sections/contents_tabs.php");	
	include_once("get_userplayers.php");
	// Preparamos los datos y buscamos
		$dataSearchSQL = "WHERE id IN (".$instanceID.")";
		$dataSearchTerms = "SELECT ".$dydBasicFields.", ".$dydAdventuresFields." FROM ".$dydTableAdventures." ".$dataSearchSQL."";
		$dataSection	 = $dydSectionAdventures[0];
		include("content/sections/contents_list.php");
	}
	break;
	case "characterwallet": // Favoritos del usuario.
		$pageTitle3 = "Cartera de ".$mainUserNick;
		include_once("management_playerwallet.php");
	break;
	case "favorites": // Favoritos del usuario.
		$pageTitle3 = "Favoritos de ".$mainUserNick;
		include_once("favorites.php");
	break;
	case "topaz": // Selección de topacios del infinito.
		$pageTitle3 = "Topacios del infinito";
		include_once("get_usertopaz.php");
		include_once("management_topaz.php");
	break;
	case "enchantment": // Encantamientos aprendidos
		if ($_SESSION['player_can_enc'] == TRUE) {
			$pageTitle3 = "Encantamientos de ".$_SESSION['player_name'];
			include_once("management_enchants.php");
		}
	break;
	default: // Menu General de Gestion
	//$userPoints = $_SESSION['points'];
	include_once("get_usertopaz.php");
	//$userFavs;
	include_once("get_userfavs.php");
?>
	<h2>Gesti&oacute;n</h2>
	<!-- Formulario Cambio de nick -->
	<div class="userChanges" id="changeNick">
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userdata.php">
			<label>Nuevo apodo: </label><input type="text" name="newnick" style="width:100px;" value="<?=$mainUserNick?>" />
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="typeChange" value="nickChange" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input type="submit" value="Cambiar" />
		</form>
	</div>
	<!-- Formulario Cambio de pass -->
	<div class="userChanges" id="changePass" style="width: 400px;">
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userdata.php">
			<label>Nueva llave: </label><input type="text" name="newpass" style="width:100px;" />
			&nbsp;
			<label>Vieja llave: </label><input type="text" name="oldpass" style="width:100px;" />
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="typeChange" value="passChange" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input type="submit" value="Cambiar" />
		</form>
	</div>
	<!-- Formulario Cambio de menú -->
	<div class="userChanges" id="changeMenu" style="width:auto;">
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userdata.php">
			<input class="radioUser" type="radio" value="1" name="menutype" checked /><label>Estilo "Mav"</label>
			&nbsp;
			<input class="radioUser" type="radio" value="0" name="menutype" /><label>Estilo "Tsu"</label>
			<input class="radioUser" type="radio" value="2" name="menutype" /><label>Estilo "Neo"</label>
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="typeChange" value="menuChange" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input style="margin-left:10px;" type="submit" value="Cambiar" />
		</form>
	</div>
	<!-- Formulario Cambio de avatar -->
	<div class="userChanges" id="changeAvatar" style="width:auto;">
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userdata.php">
			<b>Avatar:</b>
			&nbsp;
			<select name="avatartype">
			<?php
				$dir = "media/avatar/";
				if (is_dir($dir)) {
					if ($dh = opendir($dir)) {
						while (($file = readdir($dh)) !== false) {
							$checkFile = explode(".", $file);
							if ($checkFile[1] == "png") {
								echo "<option value='".$checkFile[0]."'";
								if ($_SESSION['avatar'] == $checkFile[0]) {
									echo "selected";
								}
								echo ">".ucfirst($checkFile[0])."</option>";
							}
						}
						closedir($dh);
					}
				}
			?>
			</select> 
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="typeChange" value="avatarChange" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input style="margin-left:10px;" type="submit" value="Cambiar" />
		</form>
	</div>	
	<!-- Formulario Cambio de CSS -->
	<div class="userChanges" id="changeCSS" style="width:auto;">
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userdata.php">
			<b>Estilo web:</b>
			&nbsp;
			<select name="csstype">
				<option value="0">Leyenda Azul</option>
			<?php
				$dir = "media/css/";
				if (is_dir($dir)) {
					if ($dh = opendir($dir)) {
						while (($file = readdir($dh)) !== false) {
							$checkFile = explode(".", $file);
							if ($checkFile[1] == "css") {
								echo "<option value='".$checkFile[0]."'";
								if ($_SESSION['user_css'] == $checkFile[0]) {
									echo "selected";
								}
								echo ">".ucfirst($checkFile[0])."</option>";
							}
						}
						closedir($dh);
					}
				}
			?>
			</select> 
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="typeChange" value="cssChange" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input style="margin-left:10px;" type="submit" value="Cambiar" />
		</form>
	</div>
	<!-- Formulario Cambio de personaje -->
	<div class="userChanges" id="changePlayer" style="width:auto;">
		<form method="post" action="<?php echo $pageRoot; ?>content/user/update_userdata.php">
			<b>Personaje:</b>
			&nbsp;
			<select name="playerlist">
			<?php
				$playerQuest = "WHERE uploader LIKE '".$mainUserName."'";
				$orderData ="SELECT name, surname, url FROM ".$dydTablePlayers." ".$playerQuest.""; // Elegimos las transacciones en la Base de Datos
				$queryData = mysql_query ($orderData, $link);
				$rowsData = mysql_num_rows($queryData);
				if ($rowsData != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
					for($dt=0;$dt<$rowsData;$dt++) {
						$queryResult = mysql_fetch_array($queryData);
						$playerName	 = $queryResult["name"];
						$playerSurname	= $queryResult["surname"];
						$playerURL	 = $queryResult["url"];
							echo "<option value='".$playerURL."'";
							if ($playerURL == $playerActiveURL) {
								echo " selected";
							}
							echo ">".$playerName." ".$playerSurname."</option>";
					}
				}
			?>
			</select> 
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<input type="hidden" name="typeChange" value="playerChange" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
			<input style="margin-left:10px;" type="submit" value="Cambiar" />
		</form>
	</div>
	<!-- Fin formularios -->
		<p><i>Te damos la bienvenida, <?=$mainUserNick?>.</i></p>
		<p class="userPoints">
			<a href="../user/topaz/">
				<img src="<?php echo $pageRoot."media/icon/icon_topaz.png"?>" title="Topacios del infinito" /> <?php echo $userPoints; ?>
			</a>
		</p>
		<p class="userFavs">
			<a href="../user/favorites/">
				<img src="<?php echo $pageRoot."media/icon/social_fav.png"?>" title="Favoritos de <?=$$mainUserNick?>" /> <?php echo $userFavs; ?>
			</a>	
		</p>
		<fieldset>
			<legend>Opciones de usuario</legend>
			<ul class="managementMenu">
				<li id="showplayerlist">Personaje activo</li>
				<li id="shownick">Apodo</li>
				<li id="showpass">Contraseña</li>
				<li id="showavatar">Avatar</li>
				<li id="showmenustyle">Estilo de menú</li>
				<li id="showcsstyle">Estilo web</li>
			</ul>
			<br/>
		</fieldset>
		<p>Emplea las opciones de arriba para personalizar tu usuario. También puedes echar un vistazo a todos tus aportes utilizando la última opción.</p>
		<?php if ($_SESSION['level'] >= 0) { ?>
		<fieldset>
			<legend>Información</legend>
			<ul class="managementMenu">
				<?php if ($_SESSION['level'] >= 5) { ?><a href="../user/cultists/"><li>Cultistas</li></a><?php } ?>
				<a href="../user/participation/"><li>Sesiones</li></a>
				<a href="../user/characters/"><li>Tus personajes</li></a>
				<a href="../user/characterwallet/"><li>Tu cartera</li></a>
				<?php if ($_SESSION['player_can_enc'] == TRUE) { ?><a href="../user/enchantment/"><li>Tus encantamientos</li></a><?php } ?>
				<!--<a><li id="notWorking">Raza</li></a>
				<a><li id="notWorking">Clase</li></a>
				<a><li id="notWorking">Poder</li></a>
				<?php //echo $pageRoot; ?>
				<!-- <li>
					Poder
					<ul>
						<a href="management/powers/race/">	<li>Racial</li></a>
						<a href="management/powers/class/">	<li>Cláseo</li></a>
						<a href="management/powers/other/">	<li>Otros</li></a>
					</ul>
				</li> -->
				<!-- <a><li id="notWorking">Dote</li></a>
				<a><li id="notWorking">Trasfondo</li></a>
				<a><li id="notWorking">Objeto</li></a>
				<a><li id="notWorking">Criatura</li></a> -->
			</ul>
			<br/>
		</fieldset>
		<!-- <p>Ahora mismo algunas de las funcionalidades de este menú están desactivadas. Permanece atento a las actualizaciones para saber cuando se podrán utilizar esas secciones.</p> -->
		<?php } ?>
		<?php if ($dndCompetition == TRUE) { ?>
		<p>Para participar en el concurso "Tarjetas de pifia" de <b>Ad Infinitum</b>, pulsa la opción "Añadir tarjeta".</p>
		<fieldset>
			<legend>Opciones de concurso</legend>
			<ul class="managementMenu">
			<a href="../user/addcompcard/">		<li>Añadir tarjeta</li>		</a>
			<a href="../user/checkcards/">		<li>Comprobar tarjetas</li>	</a>
			</ul>
			<br/>
		</fieldset>
		<?php } ?>
		<?php if ($_SESSION['level'] >= 4) { ?>
		<p>Si deseas añadir contenido a la base de datos, utiliza las opciones de abajo. Obtendrás <b>topacios del infinito</b> si tus colaboraciones son correctas.</p>
		<fieldset>
			<legend>Base de datos</legend>
			<ul class="managementMenu">
			<a href="../user/addtraits/">		<li>Añadir rasgos</li>		</a>
			<a href="../user/addfeats/">		<li>Añadir dotes</li>		</a>
			<a href="../user/addinstances/">	<li>Añadir aventuras</li>	</a>
			<a href="../user/addlocations/">	<li>Añadir localizaciones</li>	</a>
			</ul>
			<br/>
		</fieldset>
		<?php } ?>
	<br/>
	<!-- Scripts -->  
	<script>
		// Opciones de usuario
		$("#shownick").click(function () {
			if ($('#changeNick').is(":hidden")) {
				$("#changeNick").fadeIn();
				// --
				$("#changePass").fadeOut();
				$("#changeMenu").fadeOut();
				$("#changeAvatar").fadeOut();
				$("#changePlayer").fadeOut();
				$("#changeCSS").fadeOut();
			} else if ($('#changeNick').is(":visible")) {
				$("#changeNick").fadeOut();
			}
		});
		$("#showpass").click(function () {
			if ($('#changePass').is(":hidden")) {
				$("#changePass").fadeIn();
				// --
				$("#changeNick").fadeOut();
				$("#changeMenu").fadeOut();
				$("#changeAvatar").fadeOut();
				$("#changePlayer").fadeOut();
				$("#changeCSS").fadeOut();
			} else if ($('#changePass').is(":visible")) {
				$("#changePass").fadeOut();
			}
		});
		$("#showmenustyle").click(function () {
			if ($('#changeMenu').is(":hidden")) {
				$("#changeMenu").fadeIn();
				// --
				$("#changeNick").fadeOut();
				$("#changePass").fadeOut();
				$("#changeAvatar").fadeOut();
				$("#changePlayer").fadeOut();
				$("#changeCSS").fadeOut();
			} else if ($('#changeMenu').is(":visible")) {
				$("#changeMenu").fadeOut();
			}
		});
		$("#showavatar").click(function () {
			if ($('#changeAvatar').is(":hidden")) {
				$("#changeAvatar").fadeIn();
				// --
				$("#changeNick").fadeOut();
				$("#changePass").fadeOut();
				$("#changeMenu").fadeOut();
				$("#changePlayer").fadeOut();
				$("#changeCSS").fadeOut();
			} else if ($('#changeAvatar').is(":visible")) {
				$("#changeAvatar").fadeOut();
			}
		});
		$("#showplayerlist").click(function () {
			if ($('#changePlayer').is(":hidden")) {
				$("#changePlayer").fadeIn();
				// --
				$("#changeNick").fadeOut();
				$("#changePass").fadeOut();
				$("#changeMenu").fadeOut();
				$("#changeAvatar").fadeOut();
				$("#changeCSS").fadeOut();
			} else if ($('#changePlayer').is(":visible")) {
				$("#changePlayer").fadeOut();
			}
		});		
		$("#showcsstyle").click(function () {
			if ($('#changeCSS').is(":hidden")) {
				$("#changeCSS").fadeIn();
				// --
				$("#changeNick").fadeOut();
				$("#changePass").fadeOut();
				$("#changeMenu").fadeOut();
				$("#changeAvatar").fadeOut();
				$("#changePlayer").fadeOut();
			} else if ($('#changeCSS').is(":visible")) {
				$("#changeCSS").fadeOut();
			}
		});
	</script>
<?php
	break;
	} // Fin del Switch
	// Si no estamos registrados, no dejamos que nadie vea el contenido.
	} else {
		echo $phraseNoAuth;
	}
?>