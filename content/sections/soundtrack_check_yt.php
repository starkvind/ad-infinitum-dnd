<?php
	// Comprobamos si el enlace es de YouTube
	if (strpos($musicLink, "youtu") !== false) { $isYouTube = TRUE;	$ytShortLink = TRUE; }
	if (strpos($musicLink, "youtube") !== false) { $isYouTube = TRUE; $ytShortLink = FALSE; }
	if ($isYouTube = TRUE) { 
		switch($ytShortLink) {
			case TRUE:
				$prepareInsertVideo = str_replace("http://youtu.be/", "", $musicLink);
				$prepareInsertVideo = str_replace("https://youtu.be/", "", $prepareInsertVideo);
			break;
			case FALSE:
				$prepareInsertVideo = str_replace("http://www.youtube.com/watch?v=", "", $musicLink);
				$prepareInsertVideo = str_replace("https://www.youtube.com/watch?v=", "", $prepareInsertVideo);
			break;
		}
		switch($mainWork[0]) {
			case $sectionOST[0]:
				$iframeStyle = "soundTrackYouTube";
			break;
			default:
				$iframeStyle = "otherPageYouTube";
			break;
		}
?>
	<!-- Ahora con los datos del video, lo incluímos -->
	<iframe class="<?php echo $iframeStyle; ?>" src="//www.youtube.com/embed/<?php echo $prepareInsertVideo; ?>" frameborder="0"></iframe>
	<br/><br/>
<?php
	}
?>