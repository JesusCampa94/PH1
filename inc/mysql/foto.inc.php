<?php
	require_once("com/funciones.inc.php");

	//Conectamos a la BD
	require_once("com/abrirConexion.inc.php");

	//Consulta
	$sql = "SELECT TituloFoto, FechaFoto, PaisFoto, AlbumFoto, FicheroFoto, NomUsuario FROM fotos, albumes, usuarios WHERE AlbumFoto = IdAlbum AND UsuarioAlbum = IdUsuario AND IdFoto = $id";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("com/ejecutarSQL.inc.php");

	//Recuperamos resultado
	$fila = $resultado->fetch_object();

	$TituloFoto = $fila->TituloFoto;
	$FechaFoto = $fila->FechaFoto;
	$PaisFoto = nombrePorId("p", $fila->PaisFoto);
	$AlbumFoto = nombrePorId("a", $fila->AlbumFoto);
	$FicheroFoto = $fila->FicheroFoto;
	$NomUsuario = $fila->NomUsuario;
?>
	<main>
		<section class="foto-contenedor">
			<h1><?php echo $TituloFoto; ?></h1>
			<img src="<?php echo $FicheroFoto; ?>" width="1280" height="720" alt="Imagen $id">
			<section class="foto-info">
				<p><strong>Fecha: </strong><?php echo $FechaFoto; ?></p>
				<p><strong>País: </strong><?php echo $PaisFoto; ?></p>
				<p><strong>Álbum: </strong><?php echo $AlbumFoto; ?></p>
				<p><strong>Subida por: </strong><?php echo $NomUsuario; ?></p>
			</section>
		</section>
	</main>
<?php
	//Liberamos memoria y desconectamos de la BD
	require_once("com/cerrarConexion.inc.php");
?>