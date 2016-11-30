<?php
	//Imprime un selector de paises a partir de los datos recuperados en la BD
	function selectorPais($paises)
	{
?>	
		<p><label for="pais">País</label></p>
		<p><select name="pais" id="pais">
			<option value="0">Seleccionar país...</option>
<?php
		//Recorremos el resultado fila a fila
		while ($fila = $paises->fetch_object())
		{
			$IdPais = $fila->IdPais;
			$NomPais = $fila->NomPais;
?>
		<option value="<?php echo $IdPais; ?>"><?php echo $NomPais; ?></option>
<?php 
		}
		echo "</select></p>";
	}


		//Imprime un selector de albumes a partir de los datos recuperados en la BD
	function selectorAlbum($albumes)
	{
?>	
		<p><label for="album_usuario">Álbum de usuario <strong>(*)</strong></label></p>
		<p>
			<select name="album_usuario" id="album_usuario">
				<option value="0">Seleccionar álbum...</option>
<?php
		//Recorremos el resultado fila a fila
		while ($fila = $albumes->fetch_object())
		{
			$IdAlbum = $fila->IdAlbum;
			$TituloAlbum = $fila->TituloAlbum;
?>
		<option value="<?php echo $IdAlbum; ?>"><?php echo $TituloAlbum; ?></option>
<?php 
		}
		echo "</select></p>";
	}


	//Devuelve los datos del registro saneados, si pasan la validacion. Tambien devuelve la $sql necesaria para la inservion
	function validarRegistro()
	{
		global $conexionBD;

		//Almacenamos los datos recibidos saneados en un objeto
		$datos = new stdClass();
		$datos->usuario = $conexionBD->real_escape_string($_POST["nombreUsuario"]);
		$datos->pass = $conexionBD->real_escape_string($_POST["pass"]);
		$datos->email = $conexionBD->real_escape_string($_POST["email"]);
		$datos->sexo = $conexionBD->real_escape_string($_POST["sexo"]);
		$datos->fecha = $conexionBD->real_escape_string($_POST["fecha"]);
		$datos->pais = $conexionBD->real_escape_string($_POST["pais"]);
		$datos->ciudad = $conexionBD->real_escape_string($_POST["ciudad"]);
		$datos->fotoPerfil = "img/usu/yisus.png";

		//TODO: VALIDACION AQUI

		return $datos;
	}
?>