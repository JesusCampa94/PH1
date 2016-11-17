<?php
	//Conectamos a la BD
	require_once("abrirConexion.inc.php");

	//Consulta
	$sql = "SELECT IdAlbum, TituloAlbum FROM albumes, usuarios WHERE UsuarioAlbum = IdUsuario AND NomUsuario = '$usuario'";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("ejecutarSQL.inc.php");
?>	
	<p><label for="album_usuario">Álbum de usuario <strong>(*)</strong></label></p>
	<p>
		<select name="album_usuario" id="album_usuario">
			<option value="0">Seleccionar álbum...</option>
<?php
	//Recorremos el resultado fila a fila
	while ($fila = $resultado->fetch_object())
	{
		$IdAlbum = $fila->IdAlbum;
		$TituloAlbum = $fila->TituloAlbum;
?>
	<option value="<?php echo $IdAlbum; ?>"><?php echo $TituloAlbum; ?></option>
<?php 
	}
	echo "</select></p>";
	//Liberamos memoria y desconectamos de la BD
	require_once("cerrarConexion.inc.php");
?>
