<p><i>Vas a añadir una dote.</i></p>
<fieldset>
<legend>Detalles</legend>
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
			<input type="text" name="class" maxlength="100" value ="<?php if ($_SESSION['remember_class'] != "") { echo $_SESSION['remember_class']; } ?>" />
			<?php } ?>
			</td>
			<td>Grado:</td>
			<td>
				<select name="tier">
					<option value="Heroico" <?php if ($_SESSION['remember_tier'] == "Heroico") { echo "selected"; } ?>>Heroico</option>
					<option value="Parangón" <?php if ($_SESSION['remember_tier'] == "Parangón") { echo "selected"; } ?>>Parangón</option>
					<option value="Épico" <?php if ($_SESSION['remember_tier'] == "Épico") { echo "selected"; } ?>>Épico</option>
				</select>
			</td>
			<td>Tipo:</td>
			<td>
				<select name="type">
					<option value="General" <?php if ($_SESSION['remember_type'] == "General") { echo "selected"; } ?>>General</option>
					<option value="Clásea" <?php if ($_SESSION['remember_type'] == "Clásea") { echo "selected"; } ?>>Clásea</option>
					<option value="Racial" <?php if ($_SESSION['remember_type'] == "Racial") { echo "selected"; } ?>>Racial</option>
					<option value="Divina" <?php if ($_SESSION['remember_type'] == "Divina") { echo "selected"; } ?>>Divina</option>
					<option value="Multiclase" <?php if ($_SESSION['remember_type'] == "Multiclase") { echo "selected"; } ?>>Multiclase</option>
					<option value="Híbrida" <?php if ($_SESSION['remember_type'] == "Híbrida") { echo "selected"; } ?>>Híbrida</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Prerrequisitos:</td>
			<td colspan="9">
				<textarea name="required" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>
		<tr>
			<td>Beneficio:</td>
			<td colspan="9">
				<textarea name="bonus" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>
		<tr>
			<td>Texto decorativo:</td>
			<td colspan="9">
				<textarea name="flavortext" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>
		<tr>
			<td>Especial:</td>
			<td colspan="9">
				<textarea name="special" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>
		<tr>
			<td>Poder:</td>
			<td>
				<select name="power">
					<option value="">-</option>
					<?php
						$query1 = "SELECT id, name FROM ".$dydTablePowers." WHERE class LIKE 'Dote'";
						$result1 = mysql_query($query1);
						while ($rows1 = mysql_fetch_array($result1)){
							echo "<option value=\"{$rows1[0]}\"";
							echo ">" .$rows1[1]. "</option>\n";
						}
						mysql_free_result($result1);
					?>
				</select>
			</td>
			<td>Origen:</td>
			<td colspan="4">
				<select name="origin">
					<?php
						$query1 = "SELECT id, name FROM ".$dydTableBibliography." ORDER BY name";
						$result1 = mysql_query($query1);
						while ($rows1 = mysql_fetch_array($result1)){
							echo "<option value=\"{$rows1[0]}\"";
							if ($rows1[0] == $_SESSION['remember_origin']) { echo "selected"; }
							echo ">".$rows1[1]."</option>\n";
						}
						mysql_free_result($result1);
					?>
				</select>
			</td>
		</tr>
		<tr>
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<td colspan="2"><input type="checkbox" name="remember" value="1" <?php if ($_SESSION['remember_me'] == 1) { echo "checked"; } ?>>Recordar Clase, Grado y Tipo</td>
			<td colspan="2"><input type="submit" value="A&ntilde;adir" /></td>
		</tr>
		</table>
</fieldset>
<br/>