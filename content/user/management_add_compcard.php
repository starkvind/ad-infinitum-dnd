<p><i>Vas a añadir una tarjeta de pifia para la participación.</i></p>
<fieldset>
<legend>Detalles</legend>
	<form name="compcard" action="<?php echo $pageRoot; ?>content/user/add_db.php" method="POST">
	<input type="hidden" name="insert_type" value="<?php echo $typeManagement; ?>" />
	<table id="addPower">
		<tr>
			<td>Nombre:</td>
			<td><input type="text" name="name" maxlength="100" /></td>
			<td>Tipo:</td>
			<td>
			<select name="type">
				<option value="General">General</option>
				<option value="Cuerpo a cuerpo">Cuerpo a cuerpo</option>
				<option value="A distancia">A distancia</option>
				<option value="Magia arcana">Magia arcana</option>
				<option value="Magia divina">Magia divina</option>
				<option value="Magia psíquica">Magia psíquica</option>
				<option value="Magia de la naturaleza">Magia de la naturaleza</option>
			</select>				
			</td>
			<td>URL imagen:</td>
			<td><input type="text" name="picture"></td>
		</tr>
		<tr>
			<td>Texto descriptivo:</td>
			<td colspan="9">
				<textarea name="infotext" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>	
		<tr>
			<td>Efecto:</td>
			<td colspan="9">
				<textarea name="effect" style="width:800px;height:18px;"></textarea>
			</td>
		</tr>	
		<tr>
			<input type="hidden" name="user" value="<?=$mainUserName?>" />
			<td colspan="4"><input type="submit" value="A&ntilde;adir" /></td>
		</tr>
		</table>
</fieldset>
<br/>