<?php
	// race_class_content.php (mysqli)
	$dataList = $dataSearchTerms;

	// Intentamos asegurar que exista la conexión $link
	if (!isset($link)) {
		@include_once("content/rosetta.php"); // intenta definir $link si falta
	}

	// Ejecutamos la consulta con mysqli y prevenimos warnings si falla
	if (isset($link) && $dataList != "") {
		$dataIdQuery = @mysqli_query($link, $dataList);
		if ($dataIdQuery === false) {
			// En desarrollo puede ser útil ver el error; en producción podrías comentarlo
			// error_log("MySQLi error: " . mysqli_error($link));
			$dataRows = 0;
		} else {
			$dataRows = mysqli_num_rows($dataIdQuery);
		}
	} else {
		$dataIdQuery = false;
		$dataRows = 0;
	}
?>
