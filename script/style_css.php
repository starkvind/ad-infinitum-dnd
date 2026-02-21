<!-- ================================================================ -->
<!-- CSS -->
<!-- ================================================================ -->
	<!-- Estilo principal -->
	<link href="<?php echo $pageRoot; ?>script/style.css" rel="stylesheet" type="text/css" />
	<!-- Sección principal -->
	<link href="<?php echo $pageRoot; ?>script/section-main.css" rel="stylesheet" type="text/css" />	
	<!-- Menú de Mantenimiento -->
	<link href="<?php echo $pageRoot; ?>script/section-main_management.css" rel="stylesheet" type="text/css" />	
	<!-- Pantalla de Combates -->
	<link href="<?php echo $pageRoot; ?>script/section-combat_screen.css" rel="stylesheet" type="text/css" />
	<!-- Menú superior de la web y pestañas -->
	<link href="<?php echo $pageRoot; ?>script/section-user.css" rel="stylesheet" type="text/css" />
	<!-- Tarjetas de poderes, enemigos, objetos, etc -->
	<link href="<?php echo $pageRoot; ?>script/section-card.css" rel="stylesheet" type="text/css" />
	<!-- Ordertables -->
	<link href="<?php echo $pageRoot; ?>script/ordertable.css" rel="stylesheet" type="text/css" />
	<!-- Tooltipster -->
	<link href="<?php echo $pageRoot; ?>script/tooltipster.css" rel="stylesheet" type="text/css" />
<?php
	// Cogemos el estilo predefinido.
	if(isset($_SESSION['user_css'])) {
		if ($_SESSION['user_css'] != "0") {
?>
	<!-- Estilo Web personalizado -->
	<link href="<?php echo $pageRoot; ?>media/css/<?=$_SESSION['user_css']?>.css" rel="stylesheet" type="text/css" />
<?php
		}
	}
	include_once("style_jscript.php");

?>
