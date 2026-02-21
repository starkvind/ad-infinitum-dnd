<?php
// Datos de sesión
	$dataSearchSQL = "WHERE uploader LIKE '".$mainUserName."'";
	$dataSearchTerms = "SELECT url, name FROM ".$dydTablePlayers." ".$dataSearchSQL."";
	$queryData = mysql_query ($dataSearchTerms, $link);
	$rowsData = mysql_num_rows($queryData);
	$charactersUrl = array();
	$instanceID = array();
	$instanceName = array();
	for($dt=0;$dt<$rowsData;$dt++) {
		$dataQueryResult = mysql_fetch_array($queryData);
		$charUrl = $dataQueryResult["url"];
		$charactersUrl[$dt] = $charUrl;
		// Empezamos a comprobar las aventuras
		$searchInstanceSQL = "WHERE players LIKE '%".$charUrl."%'";
		$searchInstance = "SELECT id, name FROM ".$dydTableAdventures." ".$searchInstanceSQL."";
		$instanceData = mysql_query ($searchInstance, $link);
		$instanceRows = mysql_num_rows($instanceData);
		// Comprobamos
		if ($instanceRows != 0) {
			for($rw=0;$rw<$instanceRows;$rw++) {
				$instanceResult = mysql_fetch_array($instanceData);
				$instID = $instanceResult["id"];
				$instName = $instanceResult["name"];
				$instanceID[] = $instID;
				$instanceName[] = $instName;
			}
		}
	}
	$playerCharacters = implode(",",$charactersUrl);
	$instanceID = implode(",",$instanceID);
?>