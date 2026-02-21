<p><i>Vas a añadir una aventura.</i></p>
<fieldset>
<legend>Detalles</legend>
	<form action="<?php echo $pageRoot; ?>content/user/add_db.php" method="POST">
	<input type="hidden" name="insert_type" value="<?php echo $typeManagement; ?>" />
	<table id="addPower">
		<tr>
			<td>Título:</td>
			<td><input type="text" name="name" maxlength="100" /></td>
			<td>Campaña:</td>
			<td>
			<select name="campaign">
				<option value="Historias personales" <?php if ($_SESSION['remember_campaign'] == "Historias personales") { echo "selected"; } ?>>Historias personales</option>
				<option value="Era Rasa" <?php if ($_SESSION['remember_campaign'] == "Era Rasa") { echo "selected"; } ?>>Era Rasa</option>
				<option value="Casus Belli" <?php if ($_SESSION['remember_campaign'] == "Casus Belli") { echo "selected"; } ?>>Casus Belli</option>
			</select>				
			</td>
			<td>Nivel:</td>
			<td>
				<select name="levels">
					<?php
						for($ak=0;$ak<30;$ak++) {
							$realValue = $ak+1;
							echo "<option value='".$realValue."'>".$realValue."</option>\n";
						}
					?>
				</select>
			</td>
			<td>Número:</td>
			<td><input type="text" name="number" maxlength="4" /></td>
		</tr>
		<tr>
			<td>Encuentros:</td>
			<td colspan="6" style="width:550px;">
				<textarea name="encounters" style="width:550px;height:18px;"></textarea>
			</td>
			<td style="width:20px;text-align:right">Exp:</td>
			<td style="width:40px"><input type="text" name="xp" maxlength="10" style="width:60px" /></td>
		</tr>
		<tr>
			<td>Jugadores:</td>
			<td colspan="9">
				<textarea name="players" style="width:800px;height:18px;"><?php if ($_SESSION['remember_players'] != "") { echo $_SESSION['remember_players']; } ?></textarea>
			</td>
		</tr>
		<tr>
			<td>PNJs:</td>
			<td colspan="9">
				<textarea name="npcs" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>
			<td>Información:</td>
			<td colspan="9">
				<textarea name="infotext" style="width:800px;height:18px;"></textarea>
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
			<td colspan="2"><input type="checkbox" name="remember" value="1" <?php if ($_SESSION['remember_me'] == 1) { echo "checked"; } ?>>Recordar Campaña y Jugadores</td>
			<td colspan="2"><input type="submit" value="A&ntilde;adir" /></td>
		</tr>
		</table>
</fieldset>
<br/>