<h2>Ad Infinitum</h2>

<?php // Si no estamos logeados, no mostramos el menú de búsqueda. ?> 

<p style="margin-right:2px;">Puedes explorar las diferentes secciones utilizando el menú desplegable de la parte superior, los siguientes enlaces o el cuadro de búsqueda más abajo.</p>

<div style="text-align:center;">
	<ul class="indexMenu">
		<!-- ============ -->
		<li><a href="<?php echo $pathNews; ?>">		Actualizaciones </a></li>
		<li><a href="<?php echo $pathBibl; ?>">		Bibliografía	</a></li>
		<li><a href="<?php echo $pathMusi; ?>">		Banda sonora	</a></li>
		<li><a href="<?php echo $pathArti; ?>">		Artículos		</a></li>
		<li><a href="<?php echo $pathBest; ?>">		Bestiario		</a></li>
		<li><a href="<?php echo $pathTmLn; ?>">		Línea temporal	</a></li>
		<!-- ============ -->
		<li><a href="<?php echo $pathAdve; ?>">		Aventuras		</a></li>
		<li><a href="<?php echo $pathPlay; ?>">		Personajes		</a></li>
		<li><a href="<?php echo $pathNPCS; ?>">		PNJ				</a></li>
		<li><a href="<?php echo $pathShop; ?>">		Bazares			</a></li>
		<li><a href="<?php echo $pathYMap; ?>">		Localizaciones	</a></li>
		<li><a href="<?php echo $pathEnco; ?>">		Encuentros		</a></li>
		<!-- ============ -->
		<li><a href="<?php echo $pathRace; ?>">		Razas			</a></li>
		<li><a href="<?php echo $pathClas; ?>">		Clases			</a></li>
		<li><a href="<?php echo $pathTrai; ?>">		Trasfondos		</a></li>
		<li><a href="<?php echo $pathSkil; ?>">		Habilidades		</a></li>
		<li><a href="<?php echo $pathPowe; ?>">		Poderes			</a></li>
		<li><a href="<?php echo $pathFeat; ?>">		Dotes			</a></li>
		<!-- ============ -->
		<li><a href="<?php echo $pathItem; ?>">		Objetos			</a></li>
		<li><a href="<?php echo $pathMagi; ?>">		Objetos mágicos</a></li>
		<li><a href="<?php echo $pathEnch; ?>">		Encantamientos	</a></li>
		<li><a href="<?php echo $pathRitu; ?>">		Rituales		</a></li>
		<li><a href="<?php echo $pathVehi; ?>">		Vehículos 		</a></li>
		<!-- ============ -->
		<li><a href="<?php echo $pathCrea; ?>">		Criaturas		</a></li>
	</ul>
	<br /><br /><br /><br />
	<div class="searchBodyForm">
		<form method="post" action="<?php echo $pageRoot; ?>search/">
			<input type="text" name="query" class="searchInput" value="Buscar..." onFocus='this.value="";' />
		</form>
	</div>
	<p style="font-size:9px;font-style:italic;">
		Para cualquier sugerencia, error o consulta, ponte en contacto con nosotros en la dirección de correo starkvind[arroba]naufragio.net
	</p>
	<?php
		include_once("content/rosetta.php"); // Archivo de la base de datos
		$queryVisit = "SELECT name FROM ".$tableVisitors.";";
		$idQueryVisit = mysqli_query($link, $queryVisit);
		$visitorNumber = mysqli_num_rows($idQueryVisit);
	?>
	<p style="font-size:9px;font-weight:bold;">VISITAS: <span style="font-weight:normal;"><?php echo $visitorNumber; ?></a></p>	
</div>