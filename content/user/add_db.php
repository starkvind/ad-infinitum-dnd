<?php
session_start();
	// Base de datos
	include_once("../rosetta.php"); 	 // Archivo de la base de datos
	mysql_select_db($bdd, $link); 	 // Seleccionamos la base de datos
if (isset($mainUserName)) { // comprobamos que se hayan enviado los datos del formulario
?>
<html>
	<head>
		<?php $dataType = $_POST["insert_type"]; ?>
		<meta http-equiv="Refresh" content="1;url=<?php echo $pageRoot."/user/".$dataType."/"; ?>">
		<title>AÑADIENDO DATOS A LA BASE DE DATOS...</title>
	</head>
	<body>
<?php
	switch($dataType) {
		// Abrimos sección de tarjetas de pifia
		case "addcompcard":
			$dataName 		= $_POST["name"];
			$dataType		= $_POST["type"];
			$dataInfotext	= $_POST["infotext"];
			$dataEffect		= $_POST["effect"];
			$dataPicture	= $_POST["picture"];
			$dataUser		= $_POST["user"];
			$dataDate		= date("y/m/d H:i:s");
		// Actualizados la BDD
		mysql_query("INSERT INTO ".$tableCompetition." (name,type,infotext,effect,picture,uploader,date) VALUES (
		'".$dataName."', 
		'".$dataType."',		
		'".$dataInfotext."', 
		'".$dataEffect."',
		'".$dataPicture."', 
		'".$dataUser."', 
		'".$dataDate."'
		)",$link);
		// Cerramos
		mysql_close($link);
?>
	<p>Has añadido la tarjeta de pifia <?php echo $dataName; ?> (<?php echo $dataType; ?>).</p>
<?php
	//echo $img."<br/>".$img2;
	// Configuración de correo
	$subjectMail = "Ad Infinitum: ".$dataUser." ha añadido una tarjeta de pifia.";
	$bodyMail = "El usuario ".$dataUser." ha añadido en el día ".date("Y-m-d H:i:s")." la tarjeta de pifia '".$dataName."', de tipo ".$dataType.".";
	mail($adminMail,$subjectMail,$bodyMail,$fromMail1,$fromMail2);
	// FIN
		break;		
		// Abrimos sección de rasgos
		case "addtraits":
			$dataName 		= $_POST["name"];
			$dataClass		= $_POST["class"];
			$dataLevel		= $_POST["level"];
			$dataType		= $_POST["type"];
			$dataInfotext	= $_POST["infotext"];
			$dataChoosetext	= $_POST["choosetext"];
			$dataFlavortext	= $_POST["flavortext"];
			$dataOrigin		= $_POST["origin"];
			$dataUser		= $_POST["user"];
			$remember		= $_POST["remember"];
			$dataDate		= date("y/m/d");
		// Actualizados la BDD
		mysql_query("INSERT INTO ".$dydTableTraits." (name,class,level,type,infotext,choosetext,flavortext,origin,uploader,date) VALUES (
		'".$dataName."', 
		'".$dataClass."', 
		'".$dataLevel."', 
		'".$dataType."',		
		'".$dataInfotext."', 
		'".$dataChoosetext."',
		'".$dataFlavortext."', 
		'".$dataOrigin."', 
		'".$dataUser."', 
		'".$dataDate."'
		)",$link);
		// Topacios
		$query1 = "SELECT id FROM ".$dydTableTraits." WHERE name LIKE '".$dataName."'";
		$result1 = mysql_query($query1);
		$result2 = mysql_fetch_array($result1);
		$topID	 = $result2["id"];
		//---->
		$topPhrase = "Subir el rasgo";
		$topQuanty = 1;	
		mysql_query("INSERT INTO ".$tableTopaz." (user,amount,infotext,auto,date,idsection,section) VALUES (
		'".$dataUser."', 
		'".$topQuanty."', 
		'".$topPhrase." ".$dataName.".',
		'0',
		'".$dataDate."',
		'".$topID."',
		'".$dydTableTraits."'
		)",$link);
		// Cerramos
		mysql_close($link);
?>
	<p>Has añadido el rasgo <?php echo $dataName; ?>, <?php echo $dataClass; ?> (<?php echo $dataType; ?>) y de nivel <?php echo $dataLevel; ?>.</p>
<?php
	if ($remember == 1) {
		echo "Vas a recordar.";
		$_SESSION['remember_me'] = 1;
		$_SESSION['remember_class'] = $dataClass;
		$_SESSION['remember_type'] = $dataType;
		$_SESSION['remember_level'] = $dataLevel;
		$_SESSION['remember_origin'] = $dataOrigin;
	} else {
		$_SESSION['remember_me'] = 0;
		$_SESSION['remember_class'] = "";
		$_SESSION['remember_type'] = "";
		$_SESSION['remember_level'] = "";
		$_SESSION['remember_origin'] = "";
	}
?>
<?php
		break;			
		// Abrimos sección de dotes
		case "addfeats":
			$dataName 		= $_POST["name"];
			$dataClass		= $_POST["class"];
			$dataTier		= $_POST["tier"];
			$dataType		= $_POST["type"];
			$dataRequired	= $_POST["required"];
			$dataFlavortext	= $_POST["flavortext"];
			$dataBonus		= $_POST["bonus"];
			$dataSpecial	= $_POST["special"];
			$dataPower		= $_POST["power"];
			$dataOrigin		= $_POST["origin"];
			$dataUser		= $_POST["user"];
			$remember		= $_POST["remember"];
			$dataDate		= date("y/m/d");
		// Actualizados la BDD
		mysql_query("INSERT INTO ".$dydTableFeats." (name,class,tier,type,required,flavortext,bonus,special,power,origin,uploader,date) VALUES (
		'".$dataName."', 
		'".$dataClass."', 
		'".$dataTier."', 
		'".$dataType."',		
		'".$dataRequired."', 
		'".$dataFlavortext."', 
		'".$dataBonus."',		
		'".$dataSpecial."', 
		'".$dataPower."',		
		'".$dataOrigin."', 
		'".$dataUser."', 
		'".$dataDate."'
		)",$link);
		// Topacios
		$query1 = "SELECT id FROM ".$dydTableFeats." WHERE name LIKE '".$dataName."'";
		$result1 = mysql_query($query1);
		$result2 = mysql_fetch_array($result1);
		$topID	 = $result2["id"];
		//---->
		$topPhrase = "Agregar la dote";
		$topQuanty = 1;	
		mysql_query("INSERT INTO ".$tableTopaz." (user,amount,infotext,auto,date,idsection,section) VALUES (
		'".$dataUser."', 
		'".$topQuanty."', 
		'".$topPhrase." ".$dataName.".',
		'0',
		'".$dataDate."',
		'".$topID."',
		'".$dydTableFeats."'
		)",$link);
		// Cerramos
		mysql_close($link);
?>
	<p>Has añadido la dote <?php echo $dataName; ?>, <?php echo $dataClass; ?> (<?php echo $dataType; ?>) y de grado <?php echo $dataTier; ?>.</p>
<?php
	if ($remember == 1) {
		echo "Vas a recordar.";
		$_SESSION['remember_me'] = 1;
		$_SESSION['remember_class'] = $dataClass;
		$_SESSION['remember_tier'] = $dataTier;
		$_SESSION['remember_type'] = $dataType;
		$_SESSION['remember_origin'] = $dataOrigin;
	} else {
		$_SESSION['remember_me'] = 0;
		$_SESSION['remember_class'] = "";
		$_SESSION['remember_tier'] = "";
		$_SESSION['remember_type'] = "";
		$_SESSION['remember_origin'] = "";
	}
?>
<?php
		break;		
		// Abrimos sección de aventuras
		case "addinstances":
			$dataName 		= $_POST["name"];
			$dataCampaign	= $_POST["campaign"];
			$dataLevel		= $_POST["levels"];
			$dataNumber		= $_POST["number"];
			$dataEncounters	= $_POST["encounters"];
			$dataXP			= $_POST["xp"];
			$dataPlayers	= $_POST["players"];
			$dataNPCs		= $_POST["npcs"];
			$dataInfo		= $_POST["infotext"];
			$dataOrigin		= $_POST["origin"];
			$dataUser		= $_POST["user"];
			$remember		= $_POST["remember"];
			$dataDate		= date("y/m/d");
		// Actualizados la BDD
		mysql_query("INSERT INTO ".$dydTableAdventures." (id,url,name,campaign,levels,number,encounters,xp,players,npcs,infotext,origin,uploader,date) VALUES (
		'NULL',
		'NULL',
		'".$dataName."', 
		'".$dataCampaign."', 
		'".$dataLevel."', 
		'".$dataNumber."',		
		'".$dataEncounters."', 
		'".$dataXP."', 
		'".$dataPlayers."',		
		'".$dataInfo."', 	
		'".$dataOrigin."', 
		'".$dataUser."', 
		'".$dataDate."'
		)",$link);
		$pollasEnTucara = mysql_query("INSERT INTO ".$dydTableAdventures." (name,campaign,levels,number,encounters,xp,players,npcs,infotext,origin,uploader,date) VALUES (
		'".$dataName."', 
		'".$dataCampaign."', 
		'".$dataLevel."', 
		'".$dataNumber."',		
		'".$dataEncounters."', 
		'".$dataXP."', 
		'".$dataPlayers."',		
		'".$dataNPCs."', 		
		'".$dataInfo."', 	
		'".$dataOrigin."', 
		'".$dataUser."', 
		'".$dataDate."'
		)",$link);
		// Topacios
		$query1 = "SELECT id FROM ".$dydTableAdventures." WHERE name LIKE '".$dataName."'";
		$result1 = mysql_query($query1);
		$result2 = mysql_fetch_array($result1);
		$topID	 = $result2["id"];
		//---->
		$topPhrase = "Arbitrar la sesión";
		$topQuanty = 8;	
		mysql_query("INSERT INTO ".$tableTopaz." (user,amount,infotext,auto,date,idsection,section) VALUES (
		'".$dataUser."', 
		'".$topQuanty."', 
		'".$topPhrase." ".$dataName.".',
		'0',
		'".$dataDate."',
		'".$topID."',
		'".$dydTableAdventures."'
		)",$link);
		// Cerramos
		mysql_close($link);
?>
	<p>Has añadido la aventura <?php echo "(".$pollasEnTucara.")<br/>"; echo $dataName; echo "(".$query1.")<br/>"; ?>, de <?php echo $dataCampaign; ?> (<?php echo $dataXP; ?> px) y de nivel <?php echo $dataLevel; ?>.</p>
<?php
	if ($remember == 1) {
		echo "Vas a recordar.";
		$_SESSION['remember_me'] = 1;
		$_SESSION['remember_campaign'] = $dataCampaign;
		$_SESSION['remember_players'] = $dataPlayers;
		$_SESSION['remember_origin'] = $dataOrigin;
	} else {
		$_SESSION['remember_me'] = 0;
		$_SESSION['remember_campaign'] = "";
		$_SESSION['remember_players'] = "";
		$_SESSION['remember_origin'] = "";
	}
?>
<?php
		break;		
		// Abrimos sección de localizaciones
		case "addlocations":
			$dataName 		= $_POST["name"];
			$dataKindgom	= $_POST["kingdom"];
			$dataType		= $_POST["type"];
			$dataLat		= $_POST["lat"];
			$dataLng		= $_POST["lng"];
			$dataInfo		= $_POST["infotext"];
			$dataUser		= $_POST["user"];
			$dataDate		= date("y/m/d");
		// Actualizados la BDD
		mysql_query("INSERT INTO ".$dydTableMap." (name,kingdom,type,lat,lng,infotext,uploader,date) VALUES (
		'".$dataName."', 
		'".$dataKindgom."', 
		'".$dataType."',		
		'".$dataLat."', 
		'".$dataLng."', 	
		'".$dataInfo."', 	
		'".$dataUser."', 
		'".$dataDate."'
		)",$link);
		// Topacios
		$query1 = "SELECT id FROM ".$dydTableMap." WHERE name LIKE '".$dataName."'";
		$result1 = mysql_query($query1);
		$result2 = mysql_fetch_array($result1);
		$topID	 = $result2["id"];
		//---->
		$topPhrase = "Añadir la localización";
		$topQuanty = 1;	
		mysql_query("INSERT INTO ".$tableTopaz." (user,amount,infotext,auto,date,idsection,section) VALUES (
		'".$dataUser."', 
		'".$topQuanty."', 
		'".$topPhrase." ".$dataName.".',
		'0',
		'".$dataDate."',
		'".$topID."',
		'".$dydTableMap."'
		)",$link);
		// Cerramos
		mysql_close($link);
?>
	<p>Has añadido la localización <?php echo $dataName; ?>, en <?php echo $dataKindgom; ?> y de tipo <?php echo $dataType; ?>.</p>
<?php
		break;
		default:
			echo "Ha habido un error.";
		break;
	}
}
?>
	</body>
</html>