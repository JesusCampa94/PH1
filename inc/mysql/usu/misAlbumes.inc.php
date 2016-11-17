<?php
	//Conectamos a la BD
	require_once("../inc/mysql/com/abrirConexion.inc.php");

	//Consulta
	$IdUsu = idPorNombre($usuario);
	$sql = "SELECT IdAlbum, TituloAlbum, DescripcionAlbum FROM albumes WHERE usuarioAlbum = $IdUsu";
	$sql2 = "";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("../inc/mysql/com/ejecutarSQL.inc.php");

	//Recorremos el resultado fila a fila
	while ($fila = $resultado->fetch_object())
	{
		$IdAlbum = $fila->IdAlbum;
		$TituloAlbum = $fila->TituloAlbum;
		$DescripcionAlbum = $fila->DescripcionAlbum;

		$sql2 = "SELECT IdFoto, MiniaturaFoto FROM fotos, albumes WHERE AlbumFoto = IdAlbum AND AlbumFoto = $IdAlbum ORDER BY FechaFoto DESC LIMIT 1";

		//Hacemos la segunda consulta para sacar la miniatura de la ultima foto del album
		if (!($resultado2 = $mysqli->query($sql2)))
		{
			echo "<p>Error al ejecutar la sentencia <strong>$sql</strong>: " . $mysqli->error . "</p>";
			exit;
		}

		//Guardamos la miniatura
		if($fila2 = $resultado2->fetch_object())
		{
			$IdFoto = $fila2->IdFoto;
			$MiniaturaFoto = $fila2->MiniaturaFoto;
		}
?>
		<a href="verAlbum.php?IdAlbum=<?php echo $IdAlbum;?>">
			<article>
				<div class="marco"><img src="<?php echo '../'.$MiniaturaFoto;?>" alt="Imagen <?php echo $IdFoto;?>"></div>
				<h3><?php echo $TituloAlbum;?></h3>
				<p><?php echo $DescripcionAlbum;?></p>
			</article>
		</a>
<?php 
	}

	//Liberamos memoria y desconectamos de la BD
	require_once("../inc/mysql/com/cerrarConexion.inc.php");
?>