<?php
include_once("content/sections/contents_tabs.php");	
switch($typeManagement) {
case "addtraits":	// Inicio Rasgos
		include("management_add_trait.php");
break;
case "addfeats":	// Inicio Dotes
		include("management_add_feat.php");
break;
case "addinstances":	// Inicio Aventuras
	include("management_add_adventure.php");
break;
case "addlocations":	// Inicio Localizaciones
	include("management_add_location.php");
break;
case "addcompcard":	// Inicio Tarjetas de pifia
	include("management_add_compcard.php");
break;
case "checkcards":	// Comprobar Tarjetas de pifia
	include("management_view_cards.php");
break;
case "powers":	// Inicio Poderes
	switch($subTypeManagement) {
		case "race":
			$typeOfTopic = "poderes raciales";
			$topicSearch = "races";
		break;
		case "class":
			$typeOfTopic = "poderes de clase";
			$topicSearch = "classes";
		break;
		default:
			$typeOfTopic = "otros poderes";
		break;
	}
?>
	<p><i>Vas a añadir <?php echo $typeOfTopic; ?>.</i></p>
	<fieldset>
	<legend>Tarjeta del poder</legend>
		<form action="<?php echo $pageRoot; ?>content/user/add_db.php" method="POST">
		<input type="hidden" name="insert_type" value="<?php echo $typeManagement; ?>" />
		<table id="addPower">
			<tr>
				<td>Nombre:</td>
				<td><input type="text" name="name" maxlength="100" /></td>
				<td>Clase:</td>
				<td>
				<?php if ($subTypeManagement == "race" OR $subTypeManagement == "class") { ?>
				<select name="class">
				<?php
					$query1 = "SELECT name FROM ".$topicSearch." ORDER BY name";
					$result1 = mysql_query($query1);
					while ($rows1 = mysql_fetch_array($result1)){
						echo "<option value=\"{$rows1[0]}\"";
						if ($rows["id"] == $rows1[0]) echo " selected";
						echo ">" .$rows1[0]. "</option>\n";
					}
					mysql_free_result($result1);
				?>
				</select>				
				<?php } else { ?>
				<input type="text" name="class" maxlength="100" />
				<?php } ?>
				</td>
				<td>Nivel:</td>
				<td><input type="text" name="level" maxlength="2" /></td>
				<td>Tipo:</td>
				<td>
					<select name="powertype">
				<?php 
					switch($subTypeManagement) {
					default:
				?>
					<option value="21">Dote</option>
					<option value="31">Combinación</option>
				<?php
					break;
					case "race":
				?>
					<option value="0">Rasgo racial</option>
					<option value="1">Utilidad</option>
				<?php
					break;
					case "class":
				?>
					<option value="10">Ataque</option>
					<option value="11">Utilidad</option>
					<option value="12">Rasgo</option>
				<?php
					break;
					} 
				?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="infotext">Texto descriptivo del poder.</textarea></td>
			</tr>
			<tr>
				<td>Duración:</td>
				<td>
					<select name="type">
						<option value="A voluntad">A voluntad</option>
						<option value="Encuentro">Encuentro</option>
						<option value="Diario">Diario</option>
					</select>
				</td>
				<td>Palabras clave:</td>
				<td><input type="text" name="keywords" maxlength="300" /></td>
				<td>Acción:</td>
				<td>
					<select name="action">
						<option value="Acción estándar">Acción estándar</option>
						<option value="Acción menor">Acción menor</option>
						<option value="Acción de movimiento">Acción de movimiento</option>
						<option value="Acción gratuita">Acción gratuita</option>
						<option value="Sin acción">Sin acción</option>
						<option value="Interrupción inmediata">Interrupción inmediata</option>
						<option value="Reacción inmediata">Reacción inmediata</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Alcance:</td>
				<td>
					<select name="target_type">
						<option value="0">Personal</option>
						<option value="1">Cuerpo a cuerpo</option>
						<option value="2">A distancia</option>
						<option value="3">Alcance</option>
						<option value="4">Cercano estallido</option>
						<option value="5">Cercano explosión</option>
						<option value="6">Área explosión</option>
						<option value="7">Área muro</option>
						<option value="8">Texto >></option>
					</select>
				</td>
				<td></td>
				<td><input type="text" name="target_type2" width="2" maxlength="300" /></td>
				<td>Objetivo:</td>
				<td><input type="text" name="target" maxlength="150" /></td>
			</tr>
			<tr>
				<td>Ataque:</td>
				<td>
					<select name="attack">
						<option value="Fuerza">Fuerza</option>
						<option value="Constitución">Constitución</option>
						<option value="Destreza">Destreza</option>
						<option value="Inteligencia">Inteligencia</option>
						<option value="Sabiduría">Sabiduría</option>
						<option value="Carisma">Carisma</option>
						<option value="Otro">Usar texto>></option>
					</select>
				</td>
				<td>contra</td>
				<td>
					<select name="defense">
						<option value="CA">CA</option>
						<option value="Fortaleza">Fortaleza</option>
						<option value="Reflejos">Reflejos</option>
						<option value="Voluntad">Voluntad</option>
						<option value="Otro">Usar texto>></option>
					</select>	
				</td>
				<td>Texto ataque:</td>
				<td><input type="text" name="attack2" maxlength="150" /></td>
				<td>Texto defensa:</td>
				<td><input type="text" name="defense2" maxlength="150" /></td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="combotext">Requisitos del poder.</textarea></td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="trigger">Desencadenante del poder.</textarea></td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="damage">Impacto del poder.</textarea></td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="effect">Efecto del poder.</textarea></td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="failure">Que pasa si el poder falla.</textarea></td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="special">Cosas especiales del poder.</textarea></td>
			</tr>
			<tr>
				<td colspan="10"><textarea name="miscellaneus">Mantenimientos o bonos por diseño.</textarea></td>
			</tr>
			<tr>
				<td>Origen:</td>
				<td colspan="3">
				<select name="origin">
				<?php
					$query1 = "SELECT name, id FROM ".$dydTableBibliography." ORDER BY name";
					$result1 = mysql_query($query1);
					while ($rows1 = mysql_fetch_array($result1)){
						echo "<option value=\"{$rows1[1]}\"";
						if ($rows["id"] == $rows1[0]) echo " selected";
						echo ">" .$rows1[0]. "</option>\n";
					}
					mysql_free_result($result1);
				?>
				</select>	
				</td>
				<td colspan="2"><input type="checkbox" name="canon" value="1">Homebrew</td>
			</tr>
			<tr>
				<td colspan="10"><input type="submit" value="A&ntilde;adir" /></td>
			</tr>
		</table>
	</fieldset>
	<br/>
<?php
break;			// Fin Poderes
}
?>