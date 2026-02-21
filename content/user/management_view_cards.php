<?php
// ======================================== //
if ($mainUserName == "maverick") {
	$queryCardList = "";
} else {
	$queryCardList = "WHERE uploader LIKE '".$mainUserName."'";
}
$countQuery = "SELECT * FROM ".$tableCompetition." ".$queryCardList."";
$idCountQuery = mysql_query($countQuery, $link);
$rowsCountQuery = mysql_num_rows($idCountQuery);
	if ($rowsCountQuery != 0) {
		for($qc=0;$qc<$rowsCountQuery;$qc++) {
			$dataResult  = mysql_fetch_array($idCountQuery);
			$cardId		 = $dataResult["id"];
			$cardName 	 = $dataResult["name"];
			$cardType 	 = $dataResult["type"];
			$cardPicture = $dataResult["picture"];
			$cardInfo	 = $dataResult["infotext"];
			$cardEffect  = $dataResult["effect"];
			$cardUploader= $dataResult["uploader"];
			$cardDate	 = $dataResult["date"];
			//echo "<div>$cardName</div>";
?>
	<fieldset>
		<legend><?=$cardName?></legend>
		<ul>
			<?php
			if ($mainUserName == "maverick") {
			?>
			<li><b>Usuario:</b> <?=$cardUploader?></li>
			<?php } ?>
			<li><b>Fecha:</b> <?=$cardDate?></li>
			<li><b>Tipo:</b> <?=$cardType?></li>
			<li><a href="<?=$cardPicture?>" target="_blank">Enlace a la imagen</a></li>
		</ul>
		<p style="padding-left:28px;padding-right:28px;"><b>Información:</b><br/><?=$cardInfo?></p>
		<p style="padding-left:28px;padding-right:28px;"><b>Efecto:</b><br/><?=$cardEffect?></p>
	</fieldset>
	<br/>
<?php
		}
	}
?>