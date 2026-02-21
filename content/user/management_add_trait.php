<p><i>Vas a añadir un rasgo.</i></p>
<fieldset>
<legend>Detalles</legend>
	<form name="trait" action="<?php echo $pageRoot; ?>content/user/add_db.php" method="POST">
	<input type="hidden" name="insert_type" value="<?php echo $typeManagement; ?>" />
	<table id="addPower">
		<tr>
			<td>Nombre:</td>
			<td><input type="text" name="name" maxlength="100" /></td>
			<td>Clase:</td>
			<td>
			<select name="class">
			<?php
				$query1 = "SELECT id, name FROM ".$dydTableClasses." ORDER BY name";
				$result1 = mysql_query($query1);
				while ($rows1 = mysql_fetch_array($result1)){
					echo "<option value=\"{$rows1[1]}\"";
					if ($rows1[1] == $_SESSION['remember_class']) echo " selected";
					echo ">" .$rows1[1]. "</option>\n";
				}
				mysql_free_result($result1);
			?>
			</select>				
			</td>
			<td>Nivel:</td>
			<td>
				<select name="level">
					<option value="1" <?php if ($_SESSION['remember_level'] == "1") { echo "selected"; } ?>>1</option>
					<option value="5" <?php if ($_SESSION['remember_level'] == "5") { echo "selected"; } ?>>5</option>
					<option value="10" <?php if ($_SESSION['remember_level'] == "10") { echo "selected"; } ?>>10</option>
					<option value="11" <?php if ($_SESSION['remember_level'] == "11") { echo "selected"; } ?>>11</option>
					<option value="16" <?php if ($_SESSION['remember_level'] == "16") { echo "selected"; } ?>>16</option>
					<option value="21" <?php if ($_SESSION['remember_level'] == "21") { echo "selected"; } ?>>21</option>
					<option value="24" <?php if ($_SESSION['remember_level'] == "24") { echo "selected"; } ?>>24</option>
					<option value="26" <?php if ($_SESSION['remember_level'] == "26") { echo "selected"; } ?>>26</option>
					<option value="30" <?php if ($_SESSION['remember_level'] == "30") { echo "selected"; } ?>>30</option>
				</select>
			</td>
			<td>Tipo:</td>
			<td>
				<select name="type">
					<optgroup label="Raciales">
					<option value="Aura" <?php if ($_SESSION['remember_type'] == "Aura") { echo "selected"; } ?>>Aura</option>
					<option value="Defensa" <?php if ($_SESSION['remember_type'] == "Defensa") { echo "selected"; } ?>>Defensa</option>
					<option value="Origen" <?php if ($_SESSION['remember_type'] == "Origen") { echo "selected"; } ?>>Origen</option>
					<option value="Pasiva" <?php if ($_SESSION['remember_type'] == "Pasiva") { echo "selected"; } ?>>Pasiva</option>
					<option value="Racial" <?php if ($_SESSION['remember_type'] == "Racial") { echo "selected"; } ?>>Racial</option>
					<option value="Salvaciones" <?php if ($_SESSION['remember_type'] == "Salvaciones") { echo "selected"; } ?>>Salvaciones</option>
					<optgroup label="Cláseos">
					<option value="Clase" <?php if ($_SESSION['remember_type'] == "Clase") { echo "selected"; } ?>>Clase</option>
					<option value="Poder" <?php if ($_SESSION['remember_type'] == "Poder") { echo "selected"; } ?>>Poder</option>
					<optgroup label="Otros rasgos">
					<option value="Parangón" <?php if ($_SESSION['remember_type'] == "Parangón") { echo "selected"; } ?>>Parangón</option>
					<option value="Épico" <?php if ($_SESSION['remember_type'] == "Épico") { echo "selected"; } ?>>Épico</option>
					<option value="Tema" <?php if ($_SESSION['remember_type'] == "Tema") { echo "selected"; } ?>>Tema de personaje</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Texto decorativo:</td>
			<td colspan="9">
				<textarea name="flavortext" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>	
		<tr>
			<td>Beneficio:</td>
			<td colspan="9">
				<textarea name="infotext" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>		
		<tr>
			<td>Elegir:</td>
			<td colspan="9">
				<textarea name="choosetext" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>
		<tr>
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
			<td colspan="2"><input type="checkbox" name="remember" value="1" <?php if ($_SESSION['remember_me'] == 1) { echo "checked"; } ?>>Recordar Clase, Nivel y Tipo</td>
			<td colspan="2"><input type="submit" value="A&ntilde;adir" /></td>
		</tr>
		</table>
</fieldset>
<br/>