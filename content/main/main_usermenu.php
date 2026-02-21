<fieldset>
<?php
    if(empty($mainUserName)) { // comprobamos que las variables de sesión estén vacías        
?>
	<legend>Acceso</legend>
	<div style="margin-right:60px;">
        <form action="<?php echo $pageRoot; ?>content/user/check_person.php" method="post">
            <label>Persona:</label>
            <input type="text" name="persona" /><br />
            <label>Llave:</label>
            <input type="password" name="llave" /><br />
            <input type="submit" class="sendButton" name="enviar" value="CONECTARSE" />
			<input type="hidden" name="section" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
        </form>  
	</div>
<?php
    } else { //
?>
	<legend><?=$mainUserNick?></legend>
		<!--<div class="transBackground"></div>-->
		<?php 
			$menuStyle = $_SESSION['menustyle']; // Estilo del menú
			$userLevel = $_SESSION['level']; // Nivel del usuario
			$userAvatar = $_SESSION['avatar']; // Avatar del usuario
			// --------------------------
			if ($userAvatar != "") {
				$avatarShow = "media/avatar/".$userAvatar.".png";
			} else {
				$avatarShow = "media/user/noavatar.png";
			}
			// --------------------------
			
			switch($menuStyle) { 
				default:
		?>
        <p><!--Estás identificad@ -->
			<?php if ($userLevel >= 0) { ?>
			<a href="<?php echo $pageRoot; ?>user/">
				<img src="<?php echo $pageRoot; ?>media/user/user_frame.png" style="z-index:10;position:absolute;" />
				<img src="<?php echo $pageRoot.$avatarShow; ?>" title="Usuario" style="z-index:8;" />
				Usuario
			</a>
			<br />
			<?php if ($userLevel >= 1) { ?>
			<a href="<?php echo $pageRoot; ?>user/topaz/">
				<img src="<?php echo $pageRoot; ?>media/user/icon_topaz.png" title="Topacios del infinito" />
				Topacios
			<br />
			<?php } ?>
			<a href="<?php echo $pageRoot; ?>user/favorites/">
				<img src="<?php echo $pageRoot; ?>media/user/icon_fav.png" title="Favoritos" />
				Favoritos
			</a>
			<br />
			<?php } ?>
			<a href="<?php echo $pageRoot; ?>content/user/goodbye.php">
				<img src="<?php echo $pageRoot; ?>media/user/icon_out.png" title="Desconectar" />
				Desconectar
			</a>
		</p>
		<?php
				break;
				case 1:
		?>
		<?php if ($userLevel >= 1) { ?>
			<p style="width:108px;">
		<?php } else { ?>
			<p style="width:80px;">
		<?php } ?>
			<a href="<?php echo $pageRoot; ?>user/">
				<img src="<?php echo $pageRoot; ?>media/user/user_frame.png" style="z-index:10;position:absolute;" />
				<img src="<?php echo $pageRoot.$avatarShow; ?>" title="Usuario" style="z-index:8;" />
			</a>
			<?php if ($userLevel >= 1) { ?>
			<a href="<?php echo $pageRoot; ?>user/topaz/">
				<img src="<?php echo $pageRoot; ?>media/user/icon_topaz.png" title="Topacios del infinito" />
			</a>
			<?php } ?>
			<a href="<?php echo $pageRoot; ?>user/favorites/">
				<img src="<?php echo $pageRoot; ?>media/user/icon_fav.png" title="Favoritos" />
			</a>
			<a href="<?php echo $pageRoot; ?>content/user/goodbye.php">
				<img src="<?php echo $pageRoot; ?>media/user/icon_out.png" title="Desconectar" />
			</a>
		</p>
		<?php
				break;
				case 2:
		?>
			<div class="userSections">
				<div class="userAvatar">
					<?php 
						switch($adZone) {
							default:
								echo "<a href='".$pageRoot."user/'>";
							break;
							case "pkmn":
								//echo "<a href='".$pkmnRoot."user/'>";
							break;
						}
					?>
						<img src="<?php echo $pageRoot.$avatarShow; ?>" title="Usuario" />
					<?php 
						switch($adZone) {
							default:
								echo "</a>";
							break;
							case "pkmn":
								//echo "<a href='".$pkmnRoot."user/'>";
							break;
						}
					?>
				</div>
				<div class="userIcons">
				<!-- Mostramos unos iconos u otros según la sección -->
					<!-- Sección de D&D -->	
					<?php if ($adZone == "dnd") { ?>
						<?php if ($userLevel >= 0) { ?>
						<a href="<?php echo $pageRoot; ?>user/topaz/">
							<img src="<?php echo $pageRoot; ?>media/user/icon_topaz.png" title="Topacios del infinito" />
						</a>
						<?php } ?>
						<a href="<?php echo $pageRoot; ?>user/favorites/">
							<img src="<?php echo $pageRoot; ?>media/user/icon_fav.png" title="Favoritos" />
						</a>
						<a href="<?php echo $pageRoot; ?>user/characterwallet/">
							<img src="<?php echo $pageRoot; ?>media/user/icon_coin.png" title="Cartera de tus personajes" />
						</a>
						<?php if ($_SESSION['player_can_enc'] == TRUE) { ?>
						<a href="<?php echo $pageRoot; ?>user/enchantment/">
							<img src="<?php echo $pageRoot; ?>media/user/icon_enchants.png" title="Encantamientos" />
						</a>
						<?php } ?>
					<?php } ?>
					<a href="<?php echo $pageRoot; ?>content/user/goodbye.php" onClick="return confirm('¿Quieres cerrar la sesión?');">
						<img src="<?php echo $pageRoot; ?>media/user/icon_out.png" title="Desconectar" />
					</a>
				</div>
			</div>
		<?php
				break;
			}
		?>	
<?php
    }
?> 
</fieldset>