<?php
	$debugSystem = FALSE;
	session_start();
 	include_once("../rosetta.php"); 	// Archivo de la base de datos
	mysql_select_db($bdd, $link); 	 	// Seleccionamos la base de datos
	$section = $_POST["section"]; 		// Pillamos la sección
    if(isset($_POST["enviar"])) { 		// comprobamos que se hayan enviado los datos del formulario
        // Comprobamos que los campos usuarios_nombre y usuario_clave no estén vacíos
        if (empty($_POST["persona"]) || empty($_POST["llave"])) {
			if ($debugSystem == FALSE) { header("Location: ".$section.""); }
        } else {
            // Comprobamos que los datos ingresados en el formulario coincidan con los de la BD.
			$formUserName 	= $_POST['persona'];
			$formUserKey 	= $_POST['llave'];
			// Limpiamos las variables de mierda
			$formUserName = preg_replace("/[^a-zA-Z0-9s]/", "", $formUserName);
			$formUserKey = preg_replace("/[^a-zA-Z0-9s]/", "", $formUserKey);
			if ($debugSystem == TRUE) { echo "'".$formUserName."' // '".$formUserKey."'"; }
			// Preparamos las secciones
			$userOrder 		= "SELECT ".$userSections." FROM ".$tableUsers." WHERE ".$mainUserNameRow." = '".$formUserName."' AND ".$mainUserKeyRow." = '".$formUserKey."'";
			$userIdQuery 	= mysql_query($userOrder, $link);
			$userRows 		= mysql_num_rows($userIdQuery);
			if ($debugSystem == TRUE) { echo "<br/>".$userRows."<br/>"; }
			if ($userRows != 0) {
				// ---------------------------------------------------------------->
				// IP
				$cultistIP				= $_SERVER["REMOTE_ADDR"];
				// Preparamos las variables de ID
				$userQueryResult 			= mysql_fetch_array($userIdQuery);
				$_SESSION['name'] 			= $userQueryResult["name"];		 // Nombre de acceso del usuario
				$_SESSION['nick'] 			= $userQueryResult["nick"];		 // Nick del usuario
				if ($debugSystem == TRUE) { echo $_SESSION['name']; }
				// Opciones de la cuenta
				$_SESSION['options'] 		= $userQueryResult["options"]; 	 // Opciones del usuario
				include_once("check_person_options.php");
				//$_SESSION['menustyle'] 		= $userQueryResult["menustyle"]; // Estilo de menú
				//$_SESSION['avatar'] 		= $userQueryResult["avatar"];	 // Avatar del usuario
				// Administrativos
				$_SESSION['level'] 			= $userQueryResult["level"];	 // Nivel del usuario
				$_SESSION['hits'] 			= $userQueryResult["hits"];		 // Usos del usuario
				$_SESSION['lastact'] 		= $userQueryResult["lastact"];	 // Última actualización del usuario
				// Encantamientos 
				$_SESSION['dyd_enchants'] 	= $userQueryResult["dyd_enchants"];		// Encantamientos de D&D
				// ---------------------------------------------------------------->
				// Preparamos la variable global $mainUserName 
				$mainUserName = $_SESSION['name'];
				// Referente al personaje activo
				include_once("get_active_player.php");		// Incluimos datos del PJ
				$_SESSION['player_url']		= $playerActiveURL;
				$_SESSION['player_lvl']		= $playerLevel;
				$_SESSION['player_name']	= $playerActiveName;
				$_SESSION['player_surname']	= $playerActiveSurname;
				$_SESSION['player_race']	= $playerActiveRace;
				$_SESSION['player_class']	= $playerActiveClass;
				$_SESSION['player_can_enc'] = $playerHasEnchantItem;
				// ---------------------------------------------------------------->
				// Chequeamos la hora para que no actualice tanto al dia.
				$todayDate = date('Y-m-d');
				$lastActDate = $_SESSION['lastact'];
				if ($todayDate != $lastActDate) {
					// Incluimos el script para añadir topacios del infinito.
					include_once("update_usertopaz.php");
					mysql_query("UPDATE ".$tableUsers." SET lastact = '".$todayDate."' WHERE ".$mainUserNameRow." = '".$formUserName."'",$link);
					// Cerramos
					$_SESSION['lastact'] = $todayDate;
				}
				// Enviamos un email para ver si se han logeado
				$subjectMail = "Ad Infinitum: ".$mainUserName." ha iniciado sesión.";
				$bodyMail = "El usuario ".$mainUserName." se ha logeado en Ad Infinitum el día ".date("Y-m-d H:i:s")." desde la IP: ".$cultistIP.".";
				mail($adminMail,$subjectMail,$bodyMail,$fromMail1,$fromMail2);
				if ($debugSystem == FALSE) { header("Location: ".$section.""); }
				
            } else {
				echo "<br/>AQUI NO HAY NADA";
                //<p>Error, que te cagas... <a href="../index.php">reintentar</a></p>
				if ($debugSystem == FALSE) { header("Location: ".$section.""); }
            }
        }
    } else {
		if ($debugSystem == FALSE) { header("Location: ".$section.""); }
    }
?> 
