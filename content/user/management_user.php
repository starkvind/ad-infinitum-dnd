<?php
if ($_SESSION['level'] >= 4) {
	$orderData ="SELECT * FROM ".$tableUsers." WHERE ".$mainUserNameRow." NOT LIKE '".$mainUserName."'"; // Elegimos la Base de Datos
	$queryData = mysql_query ($orderData, $link);
	$rowsData = mysql_num_rows($queryData);
	// ------------------------------------------------------------------ //
	if ($rowsData != 0) { // Comenzamos chequeo de datos. Si no tenemos nada, mandamos un mensaje de error.
	// Localización para pestañas
		include_once("content/sections/contents_tabs.php");	
?>
	<div id="mainSectionList">
		<table id="searchtable">
			<thead>
				<th>Login</th>
				<th>Nick</th>
				<th>IP</th>
				<th>Usos</th>
				<th>Búsquedas</th>
				<th>Útimo uso</th>
				<th>Topacios</th>
			</thead>
			<tbody>
	<?php
		for($dt=0;$dt<$rowsData;$dt++) {
			$queryResult = mysql_fetch_array($queryData);
			$userName	 = $queryResult["".$mainUserNameRow.""];
			$userNick	 = $queryResult["nick"];
			$userIp		 = $queryResult["ip"];
			$userHits	 = $queryResult["hits"];
			//$userPoints	 = $queryResult["points"];
			$userUse	 = $queryResult["lastuse"];
			echo "<tr>";
				echo "<td>".$userName."</td>";
				echo "<td>".$userNick."</td>";
				echo "<td>".$userIp."</td>";
				echo "<td>".$userHits."</td>";
				// Contar búsquedas
				$searchData ="SELECT id FROM ".$tableSearches." WHERE name LIKE '".$userName."'";
				$querySearch = mysql_query ($searchData, $link);
				$rowsSearch = mysql_num_rows($querySearch);
				// Fin de cuenta de búsquedas
				echo "<td>".$rowsSearch."</td>";
				echo "<td>".$userUse."</td>";
				// Contar topacios
				$topazData ="SELECT SUM(amount) AS AcolyteTopaz FROM ".$tableTopaz." WHERE user LIKE '".$userName."'";
				$queryTopaz = mysql_query ($topazData, $link);
				$topazResult = mysql_fetch_array($queryTopaz);
				$userPoints = $topazResult["AcolyteTopaz"];
				if ($userPoints == "") { $userPoints = 0; }
				// Fin de cuenta de topacios
				echo "<td>".$userPoints."</td>";
			echo "</tr>";
		}
	?>
			</tbody>
		</table>
	<br/>
	</div>
<?php 
	}
// Si no estamos registrados, no dejamos que nadie vea el contenido.
} else {
	echo $phraseNoAuth;
}
?>