<?php
	//Imprime un selector de paises a partir de los datos recuperados en la BD
	function selectorPais($paises, $preSel = "")
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
			$selected = ($NomPais == $preSel ? "selected" : "");
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
	function selectorSexo($sexo = 0)
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
			$selected = ($i == $sexo ? "selected" : "");	
?>
		<option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $nombre[$i]; ?></option>
<?php 
		}
		echo "</select></p>";
	}


	//Sanea y valida los datos de usuario
	function validarUsuario()
	{
		global $conexionBD;

		//Almacenamos los datos recibidos saneados en un objeto
		$datos = new stdClass();

		$datos->errorValidacion = true;

		if (isset($_POST["nombreUsuario"], $_POST["email"], $_POST["sexo"], $_POST["fecha"], $_POST["pais"], $_POST["ciudad"]))
		{
			$datos->errorValidacion = false;

			$datos->usuario = $conexionBD->real_escape_string($_POST["nombreUsuario"]);
			$datos->email = $conexionBD->real_escape_string($_POST["email"]);
			$datos->sexo = $conexionBD->real_escape_string($_POST["sexo"]);
			$datos->fecha = $conexionBD->real_escape_string($_POST["fecha"]);
			$datos->pais = $conexionBD->real_escape_string($_POST["pais"]);
			$datos->ciudad = $conexionBD->real_escape_string($_POST["ciudad"]);
			$datos->fotoPerfil = "img/usu/yisus.png";

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

			if ($datos->pais == 0)
			{
				$datos->errorPais = "<p>Por favor selecciona un país</p>";
				$datos->errorValidacion = true;
			}
		}

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
		if (!(preg_match("/^[A-Za-z0-9Ññ_\-]{3,50}$/", $datos->titulo)))
		{
			$datos->errorTitulo = "<p>El titulo del album solo puede contener mayusculas, minusculas, números y los carácteres '_' y '-'. Ademas debe tener entre 3 y 50 carácteres.</p>";
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

		//VALIDACION
		if (!(preg_match("/^.{0,50}$/", $datos->titulo)))
		{
			$datos->errorTitulo = "<p>El título no debe exceder los 50 carácteres.</p>";
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

		//VALIDACION

		return $datos;
	}
?>