<?php 
	error_reporting(E_ALL); // Report on all errors
	ini_set('display_errors', '0'); // Guardar los errores en log, nunca mostrarlos al visitante.
	ini_set('log_errors', '1');
	// -------------------------------------------------------------------------------------- //
	//header('Content-Type: text/html; charset=ISO-8859-15'); 
	header('Content-Type: text/html; charset=UTF-8');
	// -------------------------------------------------------------------------------------- //
	session_start();
	ob_start();
	// -------------------------------------------------------------------------------------- //
	$adZone = "dnd";						// Variable que define la parte de la web que estamos viendo.
	include_once("content/rosetta.php"); 	// Archivo de la base de datos y configuración
	mysqli_select_db($link, $bdd); 			// Seleccionamos la base de datos
	include_once("script/functions.php");	// Archivo con las funciones PHP
	// -------------------------------------------------------------------------------------- //
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Icono de la Web -->
		<link href="infinidice.ico" type="image/x-icon" rel="shortcut icon" />
	<!-- Datos jscript -->
		<?php include_once("script/style_css.php"); ?>
	<!-- Datos del orden de las tablas -->
		<script type="text/javascript" language="javascript" src="<?php echo $pageRoot; ?>script/s.pagetable.js"></script>
	<!-- Título de la web -->
	<title>%TITLE%</title>
</head>
<body onload="initialize()"> 
	<div id="mainBody"> <!-- Abrimos DIV general [001] -->
		<!-- CABECERA DE LA PÁGINA -->
		<a name="top_page"></a>
			<div id="headerBanner">
				<img src="<?php echo $pageRoot; ?>media/banner/rotate.php" alt="Banner web" />
			</div>
			<div id="headerLogo">
				<a href="http://<?php echo $interWeb; ?>"><img src="<?php echo $pageRoot; ?>media/adinfinitumlogo.png" alt="Logo Ad Infinitum" /></a>
			</div>
		<!-- MENÚ SUPERIOR -->
		<div id="topUser">
			<?php //include_once ("content/main/main_usermenu.php"); // Menu de usuario ?>
		</div>
		<!-- MENU IZQUIERDO -->
		<div id="leftMenu">
			<?php include_once ("content/main/main_menu.php"); // Menu Principal ?>
		</div>
		<!-- SECCION PRINCIPAL -->
		<div id="mainSection">
			<?php //include_once("content/main_player.php"); // Conseguimos el personaje activo. ?>
			<?php include_once("content/main_work.php"); // Contenido Principal ?>
		</div>
		<!-- MENU DE PESTAÑAS -->
		<div id="topBanner">
			<?php include_once ("content/main/main_top_menu.php");// Menu Superior ?>
		</div>
		<!-- PIE DE PÁGINA -->
		<div id="footPage">
			<?php include_once("content/main/main_foot.php"); // Pie de Página ?> 
		</div>
		<?php
			// Control de IP y acesso de usuarios
			$forHamachi = $forHamachi ?? ""; // Valor por defecto vacío

			if (!empty($forHamachi) && $pageRoot != "http://".$forHamachi."/") {
				include_once("content/user/check_ip.php");
			}
		?>
	</div>	<!-- Cerramos DIV general [001] -->
</body>
</html>	
<?php
	$pageContents = ob_get_contents(); // Get all the page's HTML into a string
	ob_end_clean(); // Wipe the buffer
	// Replace %TITLE% with $finalTitle variable contents, and print the HTML
	echo str_replace("%TITLE%", $finalTitle, $pageContents);
?>