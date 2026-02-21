<?php
	session_start();
		// Base de datos
		include_once("../rosetta.php"); 	 // Archivo de la base de datos
		mysql_select_db($bdd, $link); 	 // Seleccionamos la base de datos
	if (isset($mainUserName)) { // comprobamos que se hayan enviado los datos del formulario
		// Preparamos variables
		$user 		= $_POST["user"];		// Cogemos nombre de usuario
		$section 	= $_POST["section"];	// Cogemos URL
		$typeChange = $_POST["typeChange"];	// Cogemos tipo de cambio
		$newNick 	= $_POST["newnick"]; 	// Nuevo nick
		$newPass	= $_POST["newpass"]; 	// Nueva llave
		$oldPass	= $_POST["oldpass"]; 	// Vieja llave
		$menutype	= $_POST["menutype"]; 	// Tipo de menu
		$avatartype	= $_POST["avatartype"]; // Tipo de menu
		$playerlist	= $_POST["playerlist"]; // Personaje activo
		$csstype	= $_POST["csstype"]; 	// Tipo de menu
		// Procedemos a los cambios
		switch($typeChange) {
			case "nickChange":
				// Si no hay nick, no hay cambio
				if ($newNick != "") {
					mysql_query("UPDATE ".$tableUsers." SET nick = '".$newNick."' WHERE ".$mainUserNameRow." = '".$user."'",$link);
					// Cerramos
					mysql_close($link);	
					$_SESSION['nick'] = $newNick;
				}
			break;
			case "passChange":
				$passData = "SELECT ".$mainUserKeyRow." FROM ".$tableUsers." WHERE ".$mainUserNameRow." = '".$user."' LIMIT 1;"; // Elegimos la Vieja pass
				$passQuery = mysql_query ($passData, $link);
				$passCheck = mysql_fetch_array($passQuery);
				$olderPass = $passCheck["".$mainUserKeyRow.""]; // Vieja llave.
				if ($olderPass == $oldPass AND $newPass != "") {
					mysql_query("UPDATE ".$tableUsers." SET ".$mainUserKeyRow." = '".$newPass."' WHERE ".$mainUserNameRow." = '".$user."'",$link);
				}
				// Cerramos
				mysql_close($link);	
			break;
			case "menuChange":
				// Preparamos las opciones viejas
				$oldMenuStyle = "MENUSTYLE:".$_SESSION['menustyle']."|";
				// Ponemos ahora las nuevas
				$newMenuStyle = "MENUSTYLE:".$menutype."|";
				// Lo sustituimos
				$newOptionsUser = str_replace($oldMenuStyle, $newMenuStyle, $_SESSION['options']);
				// Realizamos la actualización
				mysql_query("UPDATE ".$tableUsers." SET options = '".$newOptionsUser."' WHERE ".$mainUserNameRow." = '".$user."'",$link);
				// Cerramos
				mysql_close($link);	
				$_SESSION['options'] = $newOptionsUser;
				$_SESSION['menustyle'] = $menutype;
			break;
			case "avatarChange":
				// Preparamos las opciones viejas
				$oldAvatar = "AVATAR:".$_SESSION['avatar']."|";
				// Ponemos ahora las nuevas
				$newAvatar = "AVATAR:".$avatartype."|";
				// Lo sustituimos
				$newOptionsUser = str_replace($oldAvatar, $newAvatar, $_SESSION['options']);
				mysql_query("UPDATE ".$tableUsers." SET options = '".$newOptionsUser."' WHERE ".$mainUserNameRow." = '".$user."'",$link);
				// Cerramos
				mysql_close($link);	
				$_SESSION['options'] = $newOptionsUser;
				$_SESSION['avatar'] = $avatartype;
			break;			
			case "cssChange":
				// Preparamos las opciones viejas
				$oldUserCSS = "CSS:".$_SESSION['user_css']."|";
				// Ponemos ahora las nuevas
				$newUserCSS = "CSS:".$csstype."|";
				// Lo sustituimos
				$newOptionsUser = str_replace($oldUserCSS, $newUserCSS, $_SESSION['options']);
				mysql_query("UPDATE ".$tableUsers." SET options = '".$newOptionsUser."' WHERE ".$mainUserNameRow." = '".$user."'",$link);
				// Cerramos
				mysql_close($link);	
				$_SESSION['options'] = $newOptionsUser;
				$_SESSION['user_css'] = $csstype;
			break;
			case "playerChange":
				mysql_query("UPDATE ".$tableUsers." SET dyd_active_player = '".$playerlist."' WHERE ".$mainUserNameRow." = '".$user."'",$link);
				include_once("get_active_player.php");
				// Datos nuevos
				$_SESSION['player_url']		= $playerActiveURL;
				$_SESSION['player_lvl']		= $playerLevel;
				$_SESSION['player_name']	= $playerActiveName;
				$_SESSION['player_surname']	= $playerActiveSurname;
				$_SESSION['player_race']	= $playerActiveRace;
				$_SESSION['player_class']	= $playerActiveClass;
				$_SESSION['player_can_enc'] = $playerHasEnchantItem;
				// Cerramos
				mysql_close($link);	
				//$_SESSION['avatar'] = $avatartype;
			break;
		}
		header("Location: ".$section."");
	}
?>