<?php 
	//Nos da un nombre a partir de un valor de clave ajena
	function nombrePorId($tipo, $id)
	{
		//Conexion a la Base de Datos
		$mysqli = new mysqli("localhost", "root", "cawendie", "pibd");
		$mysqli->set_charset("utf8");

		//Comprobamos que no ha habido error
		if ($mysqli->connect_errno)
		{
			echo "<p>Error al conectar con la base de datos: " . $mysqli->connect_error . "</p>";
			exit;
		}

		//Consulta (dependiendo de lo que se busque)
		switch ($tipo)
		{
			//Albumes
			case "a":
			{
				$sql = "SELECT TituloAlbum FROM albumes WHERE IdAlbum = $id";
				break;
			}

			//Paises
			case "p":
			{
				$sql = "SELECT NomPais FROM paises WHERE IdPais = $id";
				break;
			}
		}

		//Ejecutamos la SQL si no da error y la guardamos en $resultado
		if (!($resultado = $mysqli->query($sql)))
		{
			echo "<p>Error al ejecutar la sentencia <strong>$sql</strong>: " . $mysqli->error . "</p>";
			exit;
		}

		//Guardamos el resultado para devolverlo
		$fila = $resultado->fetch_row();

		//Liberar memoria del resultado
		$resultado->close();

		//Cerrar conexion a la BD
		$mysqli->close();

		return $fila[0];
	}

	//Nos da el Id de un usuario a partir de su nombre (nick)
	function idPorNombre($nombre)
	{
		//Conexion a la Base de Datos
		$mysqli = new mysqli("localhost", "root", "cawendie", "pibd");
		$mysqli->set_charset("utf8");

		//Comprobamos que no ha habido error
		if ($mysqli->connect_errno)
		{
			echo "<p>Error al conectar con la base de datos: " . $mysqli->connect_error . "</p>";
			exit;
		}

		$sql = "SELECT IdUsuario FROM usuarios WHERE NomUsuario = '$nombre'";

		//Ejecutamos la SQL si no da error y la guardamos en $resultado
		if (!($resultado = $mysqli->query($sql)))
		{
			echo "<p>Error al ejecutar la sentencia <strong>$sql</strong>: " . $mysqli->error . "</p>";
			exit;
		}

		//Guardamos el resultado para devolverlo
		$fila = $resultado->fetch_object();

		//Liberar memoria del resultado
		$resultado->close();

		//Cerrar conexion a la BD
		$mysqli->close();

		return $fila->IdUsuario;
	}

	//Comprueba los datos de inicio de sesión
	function comprobarDatosAcceso($usu, $pass)
	{
		//Conexion a la Base de Datos
		$mysqli = new mysqli("localhost", "root", "cawendie", "pibd");
		$mysqli->set_charset("utf8");

		//Comprobamos que no ha habido error
		if ($mysqli->connect_errno)
		{
			echo "<p>Error al conectar con la base de datos: " . $mysqli->connect_error . "</p>";
			exit;
		}

		//Saneamos datos
		$usu = $mysqli->real_escape_string($usu);
		$pass = $mysqli->real_escape_string($pass);

		//Consulta
		$sql = "SELECT ClaveUsuario FROM usuarios WHERE NomUsuario = '$usu'";

		//Ejecutamos la SQL si no da error y la guardamos en $resultado
		if (!($resultado = $mysqli->query($sql)))
		{
			echo "<p>Error al ejecutar la sentencia <strong>$sql</strong>: " . $mysqli->error . "</p>";
			exit;
		}

		//Recuperamos el resultado
		$fila = $resultado->fetch_object();

		//Contrastar con BD
		$loginOK = ($pass == $fila->ClaveUsuario ? true : false);

		//Liberar memoria del resultado
		$resultado->close();

		//Cerrar conexion a la BD
		$mysqli->close();

		return $loginOK;
	}
?>