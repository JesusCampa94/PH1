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
						return $_FILES[$campo]["error"];
					}
				}
			}
		}

		return false;
	}


	//Primero invoca a la funcion superior, y si esta devuelve true, mueve el archivo a su carpeta definitiva
	function subirArchivo ($campo, $destino)
	{
		global $directorioRaiz;

		$comprobacion = comprobarArchivo($campo);

		//Correcto
		if ($comprobacion === true)
		{
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
				move_uploaded_file($origen, $destino);

				return true;
			}

			//El fichero ya existia, cancelar
			else
			{
				echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p><p>El fichero enviado ya existe.</p>";

				return false;
			}
		}

		//No subido, o subido de forma no ordinaria
		else if ($comprobacion === false)
		{
			return false;
		}

		//Archivo correcto, subida interrumpida por error
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

			return false;
		}
	}


	//Elimina la foto de usuario
	function borrarFotoUsuario()
	{
		if (session_status() == PHP_SESSION_NONE) 
		{
			session_start();
		}

		$userName = $_SESSION["userName"];

		$ruta = "img/usu/$userName";
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

		//Formamos la direccion de redireccion
		$host = $_SERVER["HTTP_HOST"]; 
		$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		$err = ($borrado ? 8 : 9);
		$localizacion = "$directorioUsu"."modificarDatos.php?err=$err";

		header("Location: http://$host$uri/$localizacion");
	}
?>