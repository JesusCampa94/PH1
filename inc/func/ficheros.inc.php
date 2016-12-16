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
	function borrarFotoUsuario()
	{
		global $directorioRaiz;

		if (session_status() == PHP_SESSION_NONE) 
		{
			session_start();
		}

		$userName = $_SESSION["userName"];

		$ruta = $directorioRaiz . "img/usu/$userName";
		$extensiones = array (1 => ".png", ".jpg", ".jpeg", ".gif", ".bmp", ".svg");

		for ($i = 1; $i <= 6; $i++)
		{
			if (file_exists($ruta . $extensiones[$i]))
			{
				unlink($ruta . $extensiones[$i]);
				
				return true;
			}
		}

		return false;
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

	//Crea las carpetas necesarias cuando se crea un nuevo album
	function crearDirectoriosAlbum($idAlbum)
	{
		global $directorioRaiz;

		if (session_status() == PHP_SESSION_NONE) 
		{
			session_start();
		}

		$usuario = str_pad($_SESSION["userId"], 10, "0", STR_PAD_LEFT);
		$ruta = $directorioRaiz . "img/photos/" . $usuario . "/";
		
		//Creamos la carpeta del usuario si no existe ya
		if (!file_exists($ruta))
		{
			mkdir($ruta); 
		}

		$album = str_pad($idAlbum, 7, "0", STR_PAD_LEFT);
		$ruta .= $album . "/";

		//Directorios para fotos y miniaturas
		mkdir ($ruta);
		mkdir ($ruta . "thumb/");
	}

	//Determina cual sera el nombre de la siguiente foto en una carpeta
	function getSiguienteNombre($ruta)
	{
		global $directorioRaiz;


		$elementos = scandir($directorioRaiz . $ruta);				//Elementos de la carpeta (ordenados por nombre)
		$carpetas = array('.', '..', 'thumb');							//Elementos que queremos excluir de los resultados de scandir		
		$sinCarpetas = array_diff($elementos, $carpetas);			//Quitamos directorios
		
		//Primera foto
		if(empty($sinCarpetas))
		{
			$ultimoINT = 1;														//Si no hay fotos, le decimos que es la primera y punto
		}

		//Ya hay fotos
		else
		{
			$ultimo = end($sinCarpetas);										//Nos quedamos con el ultimo fichero
			$ultimo = explode(".", $ultimo)[0];								//Le quitamos la extension
			$ultimoINT = intval($ultimo);										//Lo pasamos a numerico
			$ultimoINT++;															//Lo incrementamos
		}
		
		$siguiente = str_pad($ultimoINT, 6, "0", STR_PAD_LEFT); 		//Rellenamos con ceros y lo devolvemos sin extension

		return $siguiente;
	}


	//Crea una cadena con el nombre de la ultima foto
	function nombrarFoto($campo, $album)
	{
		$sql = "SELECT IdAlbum, UsuarioAlbum FROM albumes, usuarios WHERE  UsuarioAlbum = IdUsuario AND IdAlbum = $album";

		if ($resultado = ejecutarSQL($sql))
		{
			$fila = $resultado->fetch_object();

			$rutas = new stdClass();

			//Formamos una ruta para la foto y otra para la miniatura
			$rutas->fichero = "img/photos/"; 
			$rutas->fichero .= str_pad($fila->UsuarioAlbum, 10, "0", STR_PAD_LEFT);
			$rutas->fichero .= "/";
			$rutas->fichero .= str_pad($fila->IdAlbum, 7, "0", STR_PAD_LEFT);
			$rutas->fichero .= "/";

			$rutas->miniatura = $rutas->fichero . "thumb/";

			$siguiente = getSiguienteNombre($rutas->fichero);
			$extension = getExtension($_FILES[$campo]["name"]);

			$rutas->fichero .= $siguiente;
			$rutas->fichero .= $extension;

			$rutas->miniatura .= $siguiente;
			$rutas->miniatura .= $extension;

			return $rutas;
		}
	}

	//Lee un archivo XML
	function leerXML($archivo)
	{
		global $directorioRaiz;

		if (file_exists($archivo))
		{
			if (!($fichero = @file($archivo)))
			{
				echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>
					<p>No se pudo leer la imagen destacada</p>";
			}

			else
			{
				//Elegimos una linea aleatoria
				$linea = rand(0, count($fichero) - 1);

				$xml = '<?xml version="1.0" encoding="UTF-8"?>' . $fichero[$linea];
				$datosImagen = simplexml_load_string($xml);
?>
				<section class="galeria-cuerpo destacada">
					<a href="<?php echo $directorioRaiz; ?>foto.php?id=<?php echo $datosImagen->id; ?>">
						<article>
							<div class="marco"><img src="<?php echo "$directorioRaiz$datosImagen->url"; ?>" height="337" width="600" alt="Imagen <?php echo $datosImagen->id; ?>"></div>
							<h3><?php echo "Título"; ?></h3>
							<p><?php echo $datosImagen->desc; ?></p>
							<p>Recomendada por <strong><?php echo $datosImagen->sel; ?></strong></p>
							<p><em>"<?php echo $datosImagen->com; ?>"</em></p>
						</article>
					</a>
				</section>
<?php
			}
		}
	}
?>