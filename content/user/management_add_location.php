<p><i>Vas a añadir una localización al mapa.</i></p>
<fieldset>
<legend>Detalles</legend>
	<form name="trait" action="<?php echo $pageRoot; ?>content/user/add_db.php" method="POST">
	<input type="hidden" name="insert_type" value="<?php echo $typeManagement; ?>" />
	<table id="addPower">
		<tr>
			<td>Nombre:</td>
			<td><input type="text" name="name" maxlength="100" /></td>
			<td>Reino:</td>
			<td>
			<select name="kingdom">
			<?php
				$query1 = "SELECT DISTINCT kingdom FROM ".$dydTableMap." ORDER BY kingdom";
				$result1 = mysql_query($query1);
				while ($rows1 = mysql_fetch_array($result1)){
					echo "<option value=\"{$rows1[0]}\"";
					echo ">" .$rows1[0]. "</option>\n";
				}
				mysql_free_result($result1);
			?>
			</select>				
			</td>
			<td>Tipo:</td>
			<td>
			<select name="type">
			<?php
				$query1 = "SELECT DISTINCT type FROM ".$dydTableMap." ORDER BY type";
				$result1 = mysql_query($query1);
				while ($rows1 = mysql_fetch_array($result1)){
					echo "<option value=\"{$rows1[0]}\"";
					echo ">" .$rows1[0]. "</option>\n";
				}
				mysql_free_result($result1);
			?>
			</select>				
			</td>
		</tr>
		<tr>
			<td style="text-align:right;">Latitud:</td>
			<td colspan="2"><input type="text" name="lat" maxlength="100" style="width:95%;" /></td>
			<td style="text-align:right;">Longitud:</td>
			<td colspan="2"><input type="text" name="lng" maxlength="100" style="width:95%;" /></td>
		</tr>
		<tr>
			<td>Información:</td>
			<td colspan="9">
				<textarea name="infotext" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>		
		<tr>
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<td colspan="2"><input type="submit" value="A&ntilde;adir" /></td>
		</tr>
		</table>
</fieldset>
<br/>