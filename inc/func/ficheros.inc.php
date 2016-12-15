<?php
	//Obtiene la extension de un fichero
	function getExtension($archivo)
	{
		//Usamos end() para obtener el ultimo elemento de un array
		$ext = "." . end(explode(".", $archivo));

		//Si no es una imagen, devolvemos false
		switch ($ext)
		{
			case ".png":
			case ".jpg":
			case ".jpeg":
			case ".gif":
			case ".bmp":
			case ".svg":
			{
				return $ext;

				break;
			}

			default:
			{
				return false;
			}
		}
	}


	//Comprueba si se ha recibido un fichero por el campo de formulario indicado
	function comprobarArchivo ($campo)
	{
		if (isset($_FILES[$campo]))
		{
			if (!(empty($_FILES[$campo]["name"])))
			{
				if (is_uploaded_file($_FILES[$campo]["tmp_name"]))
				{
					//Archivo subido correctamente
					if ($_FILES[$campo]["error"] === 0)
					{
						return true;
					}

					//Hay un archivo, pero no ha podido subirse
					else
					{
						$mensajesError = 
							array
							(
								1 => "El archivo ha superado el tamaño máximo de fichero especificado por el servidor.",
								2 => "El archivo ha superado el tamaño máximo de fichero especificado en el formulario.",
								3 => "El fichero sólo fue subido parcialmente.",
								4 => "No se ha subido ningún fichero.",
								5 => "El archivo está vacío.",
								6 => "Falta la carpeta temporal",
								7 => "No se pudo escribir el fichero en el disco.",
								8 => "La subida del fichero fue detenida por una extensión de PHP."								
							);

						$mensajeError = $mensajesError[$_FILES[$campo]["error"]];

						echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p><p>$mensajeError</p>";
					}
				}
			}
		}

		return false;
	}


	//Recibe un campo de formulario y un destino (sin extension). Si el fichero es imagen y no existe ya, concatena la extension al destino y sube el fichero. 
	function subirImagen ($campo, &$destino)
	{
		global $directorioRaiz;

		$origen = $_FILES[$campo]["tmp_name"];
		$extension = getExtension($_FILES[$campo]["name"]);

		if ($extension != false)
		{
			$destino .= $extension;
		}

		else
		{
			echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>
				<p>El fichero enviado no es una imagen.</p>";

			return false;
		}

		//Movemos el fichero a su destino
		if (!(file_exists($destino)))
		{
			move_uploaded_file($origen, $directorioRaiz . $destino);

			return true;
		}

		//El fichero ya existia, cancelar
		else
		{
			echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p><p>El fichero enviado ya existe.</p>";

			return false;
		}
	}


	//Elimina la foto de usuario
	function borrarFotoUsuario($redireccion = false)
	{
		global $directorioRaiz;

		if (session_status() == PHP_SESSION_NONE) 
		{
			session_start();
		}

		$userName = $_SESSION["userName"];

		$ruta = $directorioRaiz . "img/usu/$userName";
		$extensiones = array (1 => ".png", ".jpg", ".jpeg", ".gif", ".bmp", ".svg");
		$borrado = false;

		for ($i = 1; $i <= 6; $i++)
		{
			if (file_exists($ruta . $extensiones[$i]))
			{
				unlink($ruta . $extensiones[$i]);
				$borrado = true;
				break;
			}
		}

		if ($redireccion)
		{
			//Formamos la direccion de redireccion
			$host = $_SERVER["HTTP_HOST"]; 
			$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
			$err = ($borrado ? 8 : 9);
			$localizacion = "$directorioUsu"."modificarDatos.php?err=$err";

			header("Location: http://$host$uri/$localizacion");
		}
	}

	//Renombra una foto de usuario al cambiar su nick
	function renombrarFotoUsuario(&$destino)
	{
		global $directorioRaiz;

		if (session_status() == PHP_SESSION_NONE) 
		{
			session_start();
		}

		$ruta = $directorioRaiz . "img/usu/";
		$nombreAntiguo = $_SESSION["userName"];
		$extensiones = array (1 => ".png", ".jpg", ".jpeg", ".gif", ".bmp", ".svg");
		
		//Obtenemos el nuevo nombre a partir del parámetro $destino, de forma xx/xx/nombre
		$nombreNuevo = end(explode("/", $destino));

		for ($i = 1; $i <= 6; $i++)
		{
			$actual = $ruta . $nombreAntiguo . $extensiones[$i];

			if (file_exists($actual))
			{
				$nuevo = $ruta . $nombreNuevo . $extensiones[$i];

				//Concatenamos la extension al destino, ahora que la conocemos
				$destino .= $extensiones[$i];
				
				rename($actual, $nuevo);
				
				return true;
			}
		}

		return false;
	}


	//Sustituye la foto de usuario, o la renombra cuando este cambie su nick
	function modificarFotoUsuario($campo, &$destino)
	{
		//Subir nueva foto
		if (comprobarArchivo($campo))
		{
			borrarFotoUsuario();
			return subirImagen($campo, $destino);
		}

		//Renombrar foto
		else
		{
			return renombrarFotoUsuario($destino);
		}
	}


?>