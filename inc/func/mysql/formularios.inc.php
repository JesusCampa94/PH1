<?php
	//Imprime un selector de paises a partir de los datos recuperados en la BD
	function selectorPais($paises, $preSel = 1)
	{
?>	
		<p><label for="pais">País</label></p>
		<p><select name="pais" id="pais">
<?php
		//Recorremos el resultado fila a fila
		while ($fila = $paises->fetch_object())
		{
			$IdPais = $fila->IdPais;
			$NomPais = $fila->NomPais;
			$selected = ($IdPais == $preSel ? "selected" : "");
?>
		<option value="<?php echo $IdPais; ?>" <?php echo $selected; ?>><?php echo $NomPais; ?></option>
<?php 
		}
		echo "</select></p>";
	}


	//Imprime un selector de albumes a partir de los datos recuperados en la BD
	function selectorAlbum($albumes, $preSel = 0)
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
			$selected = ($IdAlbum == $preSel ? "selected" : "");
?>
		<option value="<?php echo $IdAlbum; ?>" <?php echo $selected; ?>><?php echo $TituloAlbum; ?></option>
<?php 
		}
		echo "</select></p>";
	}


	//Imprime un selector de sexo con un valor preseleccionado
	function selectorSexo($preSel = 0)
	{
?>	
		<p><label for="sexo">Sexo <strong>(*)</strong></label></p>
		<p>
			<select name="sexo" id="sexo">
<?php
		$nombre[0] = "Seleccione una opción";
		$nombre[1] = "Hombre";
		$nombre[2] = "Mujer";
		$nombre[3] = "Otro";

		//Creamos options de manera dinamica
		for ($i = 0; $i < 4; $i++)
		{
			$selected = ($i == $preSel ? "selected" : "");	
?>
		<option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $nombre[$i]; ?></option>
<?php 
		}
		echo "</select></p>";
	}


	//Calcula el precio de la solicitud de un album
	function calcularPrecio($solicitud)
	{
		//Determinamos si hay que pagar extras
		$precioColor = ($solicitud->bw_cmyk == 0 ? 0.0 : 0.05);
		$precioDpi = ($solicitud->resolucion >= 300 ? 0.0 : 0.02);

		//Calculamos numero de paginas pidiendo el numero de fotos del album
		$precioPagina = 0.10;
		$numFotos = 0;
		$numPaginas = 0;
		$fotosPorPagina = 2;

		$sql = "SELECT COUNT(*) AS NumFotos FROM fotos, albumes, paises, usuarios WHERE PaisFoto = IdPais AND UsuarioAlbum = IdUsuario AND AlbumFoto = IdAlbum AND IdAlbum = $solicitud->album_PI";

		if ($resultado = ejecutarSQL($sql))
		{
			$fila = $resultado->fetch_object();
			$numFotos = $fila->NumFotos;
			$resultado->close();

			$numPaginas = $numFotos / $fotosPorPagina;

			$precioTotal = ($numPaginas * $precioPagina + $numFotos * ($precioColor + $precioDpi)) * $solicitud->copias;

			return $precioTotal;		
		}

		return false;
	}


	//Devuelve datos de la ultima solicitud de album de un usuario. Seran cadenas vacias si no hizo ninguna
	function ultimaSolicitud($usuario)
	{
		$sql = getSQLSolicitud($_SESSION["userId"]);

		if ($resultadoSolicitud = ejecutarSQL($sql))
		{
			$datos = new stdClass();

			//Puede que no hubiera hecho ninguna solicitud previamente
			if ($resultadoSolicitud->num_rows > 0)
			{
				$fila = $resultadoSolicitud->fetch_object();
				
				$datos->AlbumSolicitud = $fila->AlbumSolicitud;
				$datos->TituloAlbum = $fila->TituloAlbum;
				$datos->NombreSolicitud = $fila->NombreSolicitud;
				$datos->TituloSolicitud = $fila->TituloSolicitud;
				$datos->DescripcionSolicitud = $fila->DescripcionSolicitud;
				$datos->EmailSolicitud = $fila->EmailSolicitud;

				//Separamos datos de la direccion
				$datos->DireccionSolicitud = $fila->DireccionSolicitud;
				$auxDireccion = explode(", ", $datos->DireccionSolicitud, 2);
				$datos->DireccionCalle = $auxDireccion[0];
				$auxDireccion = explode(" - ", $auxDireccion[1], 2);
				$datos->DireccionNumero = $auxDireccion[0];
				$auxDireccion = explode(" ", $auxDireccion[1], 2);
				$datos->DireccionCP = $auxDireccion[0];
				$auxDireccion = explode(" (", $auxDireccion[1], 2);
				$datos->DireccionLocalidad = $auxDireccion[0];
				$auxDireccion = explode(")", $auxDireccion[1], 2);
				$datos->DireccionProvincia = $auxDireccion[0];

				$datos->TelefonoSolicitud = $fila->TelefonoSolicitud;
				$datos->ColorSolicitud = $fila->ColorSolicitud;
				$datos->CopiasSolicitud = $fila->CopiasSolicitud;
				$datos->ResolucionSolicitud = $fila->ResolucionSolicitud;
				$datos->FechaSolicitud = $fila->FechaSolicitud;
				$datos->IColorSolicitud = $fila->IColorSolicitud;
				$datos->BlancoNegro = ($fila->IColorSolicitud == 0 ? "checked" : "");
				$datos->EnColor = ($fila->IColorSolicitud == 1 ? "checked" : "");
				$datos->CosteSolicitud = $fila->CosteSolicitud;
			}

			else
			{
				$datos->AlbumSolicitud = "0";
				$datos->NombreSolicitud = "";
				$datos->TituloSolicitud = "";
				$datos->DescripcionSolicitud = "";
				$datos->EmailSolicitud = "";

				//Separamos datos de la direccion
				$datos->DireccionSolicitud = "";
				$datos->DireccionCalle = "";
				$datos->DireccionNumero = "";
				$datos->DireccionCP = "";
				$datos->DireccionLocalidad = "";
				$datos->DireccionProvincia = "";
				
				$datos->TelefonoSolicitud = "";
				$datos->ColorSolicitud = "#000000";
				$datos->CopiasSolicitud = "1";
				$datos->ResolucionSolicitud = "150";
				$datos->FechaSolicitud = "";
				$datos->BlancoNegro = "";
				$datos->EnColor = "";
			}

			$resultadoSolicitud->close();

			return $datos;
		}

		return false;	
	}


	//Sanea y valida los datos de usuario
	function validarUsuario()
	{
		global $conexionBD;

		//Almacenamos los datos recibidos saneados en un objeto
		$datos = new stdClass();

		$datos->errorValidacion = true;

		//Campos comunes
		if (isset($_POST["nombreUsuario"], $_POST["email"], $_POST["sexo"], $_POST["fecha"], $_POST["pais"], $_POST["ciudad"]))
		{
			$datos->errorValidacion = false;

			$datos->usuario = $conexionBD->real_escape_string($_POST["nombreUsuario"]);
			$datos->email = $conexionBD->real_escape_string($_POST["email"]);
			$datos->sexo = $conexionBD->real_escape_string($_POST["sexo"]);
			$datos->fecha = $conexionBD->real_escape_string($_POST["fecha"]);
			$datos->pais = $conexionBD->real_escape_string($_POST["pais"]);
			$datos->ciudad = $conexionBD->real_escape_string($_POST["ciudad"]);
			
			//Damos un valor por defecto a la ruta de la imagen, se ignorara si no se sube nada
			$datos->fotoPerfil = "img/usu/" . $datos->usuario;

			//VALIDACION
			if (!(preg_match("/^[A-Za-z0-9]{3,15}$/", $datos->usuario)))
			{
				$datos->errorUsuario = "<p>El nombre de usuario debe contener de 3 a 15 carácteres. Letras o números, salvo letra ñ.</p>";
				$datos->errorValidacion = true;
			}


			if (!(preg_match("/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]+\.[A-Za-z0-9]{2,4}$/", $datos->email)))
			{
				$datos->errorEmail = "<p>Por favor, introduzca un email en un formato válido.</p>";
				$datos->errorValidacion = true;
			}

			if ($datos->sexo == 0)
			{
				$datos->errorSexo = "<p>Por favor, elija un sexo.</p>";
				$datos->errorValidacion = true;
			}

			if ($datos->fecha > date("Y-m-d"))
			{
				$datos->errorFecha = "<p>Es imposible que haya usted nacido en el futuro.</p>";
				$datos->errorValidacion = true;
			}
		}


		//Para registro o cambio de pass
		if (isset($_POST["pass"], $_POST["repetirPass"]))
		{
			$datos->errorValidacion = false;
			$datos->pass = $conexionBD->real_escape_string($_POST["pass"]);
			$datos->repetirPass = $conexionBD->real_escape_string($_POST["repetirPass"]);

			if ($datos->pass == $datos->repetirPass)
			{
				$may = $min = $num = false;

				if (preg_match("/^[A-Za-z0-9_]{6,15}$/", $datos->pass))
				{
					$length = strlen($datos->pass);
					$i = 0;

					while ($i < $length)
					{
						if ($may && $min && $num)
						{
							break;
						}

						$caracter = $datos->pass[$i];

						if ($caracter >= "A" && $caracter <= "Z")
							$may = true;

						else if ($caracter >= "a" && $caracter <= "z")
							$min = true;

						else if ($caracter >= "0" && $caracter <= "9")
							$num = true;

						$i++;
					}		
				}

				if (!($may && $min && $num))
				{
					$datos->errorPass = "<p>La contraseña debe tener longitud entre 6 y 15 carácteres. Letras, números y carácter de subrayado '_'. Debe contener al menos una mayúscula, una minúscula y un número.</p>";
					$datos->errorValidacion = true;
				}
			}

			else
			{
				$datos->errorPass = "<p>No coinciden los campos de contraseña.</p>";
				$datos->errorValidacion = true;
			}
		}

		//Para modificar datos o modificar pass
		if (isset($_POST["passActual"]))
		{
			$datos->errorValidacion = false;
			$datos->passActual = $conexionBD->real_escape_string($_POST["passActual"]);
		}

		return $datos;
	}


	//Sanea y valida los datos de un álbum
	function validarAlbum()
	{
		global $conexionBD;

		//Almacenamos los datos recibidos saneados en un objeto
		$datos = new stdClass();

		$datos->errorValidacion = false;
		$datos->titulo = $conexionBD->real_escape_string($_POST["titulo"]);
		$datos->descripcion = $conexionBD->real_escape_string($_POST["descripcion"]);
		$datos->fecha = $conexionBD->real_escape_string($_POST["fecha"]);
		$datos->pais = $conexionBD->real_escape_string($_POST["pais"]);

		//VALIDACION
		if (!(preg_match("/^.{3,50}$/", $datos->titulo)))
		{
			$datos->errorTitulo = "<p>El titulo del album debe tener entre 3 y 50 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^.{0,500}$/", $datos->descripcion)))
		{
			$datos->errorDescripcion = "<p>La descripcion del album no puede sobrepasar los 500 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if ($datos->fecha > date("Y-m-d"))
		{
			$datos->errorFecha = "<p>Es imposible que haya usted nacido en el futuro.</p>";
			$datos->errorValidacion = true;
		}

		if ($datos->pais == 0)
		{
			$datos->errorPais = "<p>Por favor seleccione un país de la lista.</p>";
			$datos->errorValidacion = true;
		}

		return $datos;
	}


	//Sanea y valida los datos de una foto
	function validarFoto()
	{
		global $conexionBD;

		//Almacenamos los datos recibidos saneados en un objeto
		$datos = new stdClass();
		$datos->errorValidacion = false;

		$datos->titulo = $conexionBD->real_escape_string($_POST["titulo"]);
		$datos->descripcion = $conexionBD->real_escape_string($_POST["descripcion"]);
		$datos->fecha = $conexionBD->real_escape_string($_POST["fecha"]);
		$datos->pais = $conexionBD->real_escape_string($_POST["pais"]);
		$datos->album_usuario = $conexionBD->real_escape_string($_POST["album_usuario"]);

		//Error si no se sube foto
		$datos->errorValidacion = true;
		
		$campo = "ficheroFoto";

		if (comprobarArchivo($campo))
		{
			$rutas = nombrarFoto($campo, $datos->album_usuario);
			$datos->ficheroFoto = $rutas->fichero;
			$datos->miniaturaFoto = $rutas->miniatura;

			$datos->errorValidacion = false;
		}

		if ($datos->errorValidacion)
		{
			$datos->errorFichero = "<p>¿No olvidas algo?¿Una foto, tal vez?</p>";
		}

		//VALIDACION
		if (!(preg_match("/^.{3,50}$/", $datos->titulo)))
		{
			$datos->errorTitulo = "<p>El título debe tener entre 3 y 50 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^.{0,500}$/", $datos->descripcion)))
		{
			$datos->errorDescripcion = "<p>La descripción no debe exceder los 500 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if ($datos->fecha > date("Y-m-d"))
		{
			$datos->errorFecha = "<p>Fecha errónea ¿De verdad viene usted del futuro?</p>";
			$datos->errorValidacion = true;
		}

		if ($datos->pais == 0)
		{
			$datos->errorPais = "<p>Por favor, elija un país.</p>";
			$datos->errorValidacion = true;
		}

		if ($datos->album_usuario == 0)
		{
			$datos->errorAlbumUsuario = "<p>Por favor, elija un álbum.</p>";
			$datos->errorValidacion = true;
		}

		return $datos;
	}


	//Sanea y valida los datos de una Solicitud
	function validarSolicitud()
	{
		global $conexionBD;

		//Almacenamos los datos recibidos saneados en un objeto
		$datos = new stdClass();
		$datos->errorValidacion = false;

		$datos->nombre = $conexionBD->real_escape_string($_POST["nombre"]);
		$datos->titulo = $conexionBD->real_escape_string($_POST["titulo_solicitud"]);
		$datos->comentario = $conexionBD->real_escape_string($_POST["comentario"]);
		$datos->email = $conexionBD->real_escape_string($_POST["email"]);
		$datos->direccion_calle = $conexionBD->real_escape_string($_POST["direccion_calle"]);
		$datos->direccion_numero = $conexionBD->real_escape_string($_POST["direccion_numero"]);
		$datos->direccion_CP = $conexionBD->real_escape_string($_POST["direccion_CP"]);
		$datos->direccion_localidad = $conexionBD->real_escape_string($_POST["direccion_localidad"]);		
		$datos->direccion_provincia = $conexionBD->real_escape_string($_POST["direccion_provincia"]);
		$datos->telefono = $conexionBD->real_escape_string($_POST["telefono"]);
		$datos->color_portada = $conexionBD->real_escape_string($_POST["color_portada"]);
		$datos->copias = $conexionBD->real_escape_string($_POST["copias"]);
		$datos->resolucion = $conexionBD->real_escape_string($_POST["resolucion"]);
		$datos->album_PI = $conexionBD->real_escape_string($_POST["album_usuario"]);
		$datos->fecha_recepcion = $conexionBD->real_escape_string($_POST["fecha-recepcion"]);
		
		if (isset($_POST["bw_cmyk"]))
			$datos->bw_cmyk = $conexionBD->real_escape_string($_POST["bw_cmyk"]);

		//VALIDACION
		if (!(preg_match("/^.{3,200}$/", $datos->nombre)))
		{
			$datos->errorNombre = "<p>El nombre debe tener entre 3 y 200 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^.{3,200}$/", $datos->titulo)))
		{
			$datos->errorTitulo = "<p>El título debe tener entre 3 y 200 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^.{0,4000}$/", $datos->comentario)))
		{
			$datos->errorComentario = "<p>El comentario no puede exceder los 4000 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]+\.[A-Za-z0-9]{2,4}$/", $datos->email)))
		{
			$datos->errorEmail = "<p>Por favor, introduzca un email en un formato válido.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^.{3,100}$/", $datos->direccion_calle)))
		{
			$datos->errorDireccionCalle = "<p>La calle debe tener entre 3 y 100 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^[0-9]+$/", $datos->direccion_numero)))
		{
			$datos->errorDireccionNumero = "<p>El número debe tener sólo carácteres numéricos.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^[0-9]{5}$/", $datos->direccion_CP)))
		{
			$datos->errorDireccionCP = "<p>El Código Postal debe tener 5 números.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^.{3,100}$/", $datos->direccion_localidad)))
		{
			$datos->errorDireccionLocalidad = "<p>La localidad debe tener entre 3 y 100 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^.{3,100}$/", $datos->direccion_provincia)))
		{
			$datos->errorDireccionProvincia = "<p>La provincia debe tener entre 3 y 100 carácteres.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^([\+]{1}[0-9]{2})?[0-9]{9,}$/", $datos->telefono)))
		{
			$datos->errorTelefono = "<p>Introduzca un número de teléfono con un formato válido.</p>";
			$datos->errorValidacion = true;
		}

		if (!(preg_match("/^#[0-9A-Fa-f]{3}$/", $datos->color_portada) || preg_match("/^#[0-9A-Fa-f]{6}$/", $datos->color_portada)))
		{
			$datos->errorColor = "<p>Introduzca un color válido.</p>";
			$datos->errorValidacion = true;
		}

		if (!($datos->copias > 0))
		{
			$datos->errorCopias = "<p>Introduzca un número válido de copias.</p>";
			$datos->errorValidacion = true;
		}

		if (!($datos->resolucion % 150 == 0 && $datos->resolucion >= 150 && $datos->resolucion <= 900))
		{
			$datos->errorResolucion = "<p>Introduzca una resolución válida.</p>";
			$datos->errorValidacion = true;
		}

		if ($datos->album_PI == 0)
		{
			$datos->errorAlbumPI = "<p>Por favor, elija un álbum.</p>";
			$datos->errorValidacion = true;
		}

		if ($datos->fecha_recepcion < date("Y-m-d"))
		{
			$datos->errorFecha = "<p>Fecha errónea. Se ha tomado muy en serio ese dicho de 'Lo quiero para ayer'.</p>";
			$datos->errorValidacion = true;
		}

		if (!(isset($_POST["bw_cmyk"])))
		{
			$datos->errorBlancoNegro = "<p>Por favor, elija blanco y negro o impresión en color.</p>";
			$datos->errorValidacion = true;
		}

		//Calcular precio si todo ha ido bien
		if (!($datos->errorValidacion))
		{
			if (!($datos->coste = calcularPrecio($datos)))
			{
				$datos->errorCoste = "<p>Error al calcular el precio de la solicitud, inténtelo de nuevo.</p>";
				$datos->errorValidacion = true;
			}
		}

		return $datos;
	}
?>