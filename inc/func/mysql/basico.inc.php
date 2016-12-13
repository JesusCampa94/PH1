<?php 
	//Crea la conexion, devuelve el objeto $conexionBD o false
	function abrirConexion()
	{
		global $conexionBD, $directorioRaiz;

		//Conexion a la Base de Datos
		$conexionBD = @new mysqli("localhost", "root", "cawendie", "pibd");

		//Comprobamos que no ha habido error
		if ($conexionBD->connect_errno)
		{
			echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>
					<p>No se pudo conectar con el servidor</p>";
			return false;
		}

		$conexionBD->set_charset("utf8");

		return true;
	}


	//Ejecuta la sentencia sql, devuelve el resultado o false si hay error
	function ejecutarSQL($sql)
	{  
		global $conexionBD, $directorioRaiz;

		if (!($resultado = $conexionBD->query($sql)))
		{
			echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>";

			$tipoConsulta = explode(" ", $sql, 2)[0];

			switch ($tipoConsulta)
			{
				case "INSERT":
				case "insert":
				{
					echo "<p>No se pudo añadir los datos al servidor.</p>";
					break;
				}

				case "UPDATE":
				case "update":
				{
					echo "<p>No se pudo modificar los datos del servidor.</p>";
					break;
				}

				case "DELETE":
				case "delete":
				{
					echo "<p>No se pudo eliminar los datos del servidor.</p>";
					break;
				}

				default:
				{
					echo "<p>No se pudo recuperar los datos del servidor.</p>";
					break;
				}
			}

			return false; 
		}

		return $resultado;	
	}

	//Cierra la conexion
	function cerrarConexion($res = null)
	{
		global $conexionBD;

		if ($res != null)
		{
			$res->close();
		}

		$conexionBD->close();
	}


	//Muestra los datos de usuario
	function mostrarDatos($datos)
	{
		global $directorioRaiz;

		$fila = $datos->fetch_object();

		$NomUsuario = $fila->NomUsuario;
		$EmailUsuario = $fila->EmailUsuario;
		$SexoUsuario = ($fila->SexoUsuario == 1 ? "Hombre" : ($fila->SexoUsuario == 2 ? "Mujer" : "Otro"));
		$FNacimientoUsuario = date("j/n/Y", strtotime($fila->FNacimientoUsuario));
		$CiudadUsuario = $fila->CiudadUsuario;
		$NomPais = $fila->NomPais;
		$FotoUsuario = $fila->FotoUsuario;
?>
		<a href='<?php echo "$directorioRaiz$FotoUsuario"; ?>'><img src='<?php echo "$directorioRaiz$FotoUsuario"; ?>' width="128" height="128" alt="Foto perfil"></a>
		<p><strong>Nombre de usuario: </strong><?php echo $NomUsuario; ?></p>
		<p><strong>Email: </strong><?php echo $EmailUsuario; ?></p>
		<p><strong>Sexo: </strong><?php echo $SexoUsuario; ?></p>
		<p><strong>Fecha de nacimiento: </strong><?php echo $FNacimientoUsuario; ?></p>
		<p><strong>País de residencia: </strong><?php echo $NomPais; ?></p>
		<p><strong>Localidad: </strong><?php echo $CiudadUsuario; ?></p>
<?php
	}


	//Elimina un usuario de la base de datos
	function darDeBaja($usuario)
	{
		if (abrirConexion())
		{
			$sql = "DELETE FROM usuarios WHERE IdUsuario = $usuario";

			if (ejecutarSQL($sql))
			{
				cerrarConexion();
				setcookie('fecha', "", -1, "/");
				logout();
			}

			else
			{
				cerrarConexion();
			}
		}
	}


	//Devuelve la SQL para obtener los datos de usuario
	function getSQLUsuario($usu)
	{
		return "SELECT NomUsuario, ClaveUsuario, EmailUsuario, SexoUsuario, FNacimientoUsuario, CiudadUsuario, IdPais, NomPais, FotoUsuario FROM usuarios, paises WHERE PaisUsuario = IdPais AND NomUsuario = '$usu'";
	}


	//Devuelve la SQL para obtener la lista de paises
	function getSQLPaises()
	{
		return "SELECT IdPais, NomPais FROM paises ORDER BY NomPais ASC";
	}


	//Devuelve los datos de una foto con el id especificado
	function getSQLFoto($IdFoto)
	{
		return "SELECT IdFoto, TituloFoto, DescripcionFoto, FechaFoto, NomPais, TituloAlbum, FicheroFoto, MiniaturaFoto, NomUsuario FROM fotos, paises, albumes, usuarios WHERE PaisFoto = IdPais AND AlbumFoto = IdAlbum AND UsuarioAlbum = IdUsuario AND IdFoto = $IdFoto";
	}

	
	//Devuelve la SQL para obtener la lista de albumes de un usuario
	function getSQLAlbumes($usuario)
	{
		return "SELECT IdAlbum, TituloAlbum FROM albumes, usuarios WHERE  UsuarioAlbum = IdUsuario AND UsuarioAlbum = $usuario ORDER BY TituloAlbum ASC";
	}


	//Devuelve datos de la ultima solicitud de un usuario
	function getSQLSolicitud($usuario)
	{
		return "SELECT solicitudes.*, TituloAlbum FROM solicitudes, albumes, usuarios WHERE AlbumSolicitud = IdAlbum AND UsuarioAlbum = IdUsuario AND IdUsuario = $usuario ORDER BY FRegistroSolicitud DESC LIMIT 1";
	}
?>