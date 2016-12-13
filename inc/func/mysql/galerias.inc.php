<?php
	//Nos da un nombre a partir de un valor de clave ajena
	function nombrePorId($tipo, $id)
	{
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
		$resultado = ejecutarSQL($sql);

		if ($resultado)
		{
			//Guardamos el resultado para devolverlo
			$respuesta = $resultado->fetch_row();

			return $respuesta[0];
		}

		return false;
	}


	//Muestra una foto en la pagina detalle foto
	function verFoto($foto)
	{
		if ($foto->num_rows > 0)
		{
			$fila = $foto->fetch_object();

			$TituloFoto = $fila->TituloFoto;
			$FechaFoto = date("j/n/Y", strtotime($fila->FechaFoto));
			$NomPais = $fila->NomPais;
			$TituloAlbum = $fila->TituloAlbum;
			$FicheroFoto = $fila->FicheroFoto;
			$NomUsuario = $fila->NomUsuario;
?>
			<section class="foto-contenedor">
				<h1><?php echo $TituloFoto; ?></h1>
				<hr />
				<img class="no-error" src="<?php echo $FicheroFoto; ?>" width="1280" height="720" alt="Imagen $id">
				<hr />
				<section class="foto-info">
					<p><strong>Fecha: </strong><?php echo $FechaFoto; ?></p>
					<p><strong>País: </strong><?php echo $NomPais; ?></p>
					<p><strong>Álbum: </strong><?php echo $TituloAlbum; ?></p>
					<p><strong>Subida por: </strong><?php echo $NomUsuario; ?></p>
				</section>
			</section>
<?php
		}

		else
		{
?>
			<section class="foto-contenedor">
				<h1>No encontrado</h1>
				<hr />
				<img src="<?php echo 'img/com/error.png'; ?>" width="128" height="128" alt="Imagen $id">
				<section class="foto-info">
					<p>No se ha encontrado ninguna foto con el identificador proporcionado</p>
				</section>
			</section>
<?php
		}
	}


	//Forma una sql con los datos introducidos por el usuario en los filtros de busqueda. Devuelve un objeto con la SQL y los parametros de busqueda
	function buscarFotos()
	{
		global $conexionBD;

		//Obtenemos datos y los saneamos
		$datos = new stdClass();
		$datos->titulo = $conexionBD->real_escape_string($_GET["titulo"]);
		$datos->fechaInicio = $conexionBD->real_escape_string($_GET["fechaInicio"]);
		$datos->fechaFin = $conexionBD->real_escape_string($_GET["fechaFin"]);
		$datos->pais = $conexionBD->real_escape_string($_GET["pais"]);

		//Hacemos los parámetros más humanos
		$datos->titulo = ($datos->titulo == "" ? "Cualquier título" : $datos->titulo);
		$datos->fechaInicio = ($datos->fechaInicio == "" ? "El origen de los tiempos" : $datos->fechaInicio);
		$datos->fechaFin = ($datos->fechaFin == "" ? "Actualidad" : $datos->fechaFin);
		$datos->pais = ($datos->pais == "0" ? "Mundial" : $datos->pais);

		//Consulta
		$datos->sql = "SELECT IdFoto, TituloFoto, FechaFoto, NomPais, MiniaturaFoto FROM fotos, paises WHERE PaisFoto = IdPais";

		if ($datos->titulo != "Cualquier título")
		{
			$datos->sql .= " AND TituloFoto LIKE '%$datos->titulo%'";
			$datos->titulo = "Contiene <em>".'"'."$datos->titulo".'"</em>';
		}

		if ($datos->fechaInicio != "El origen de los tiempos")
			$datos->sql .= " AND FechaFoto >= '$datos->fechaInicio'";

		if ($datos->fechaFin != "Actualidad")
			$datos->sql .= " AND FechaFoto <= '$datos->fechaFin'";

		if ($datos->pais != "Mundial")
		{
			$datos->sql .= " AND PaisFoto = '$datos->pais'";
			$datos->pais = nombrePorId("p", $datos->pais);
		}

		$datos->sql .= " ORDER BY FechaFoto DESC LIMIT 9";

		return $datos;
	}


	//Muestra una galeria de fotos
	function verFotos($fotos, $completo = false)
	{
		global $directorioRaiz;

		//Recorremos el resultado fila a fila
		while ($fila = $fotos->fetch_object())
		{
			$IdFoto = $fila->IdFoto;
			$TituloFoto = $fila->TituloFoto;
			$FechaFoto = date("j/n/Y", strtotime($fila->FechaFoto));
			$NomPais = $fila->NomPais;
			$MiniaturaFoto = $fila->MiniaturaFoto;

			if ($completo)
			{
				$DescripcionFoto = $fila->DescripcionFoto;
				$TituloAlbum = $fila->TituloAlbum;
			}
?>
			<section class="galeria-cuerpo">
				<a href="<?php echo $directorioRaiz; ?>foto.php?id=<?php echo $IdFoto; ?>">
					<article>
						<div class="marco"><img src="<?php echo "$directorioRaiz$MiniaturaFoto"; ?>" height="225" width="400" alt="Imagen <?php echo $IdFoto; ?>"></div>
						<h3><?php echo $TituloFoto; ?></h3>
<?php
						if ($completo)
						{
							echo "<p>$DescripcionFoto</p>";
							echo "<p>$TituloAlbum</p>";
						}
?>
						<p><?php echo $FechaFoto; ?></p>
						<p><?php echo $NomPais; ?></p>
					</article>
				</a>
			</section>
<?php 
		}

		if ($fotos->num_rows == 0)
			echo "<p>Aquí no hay nada que ver.</p>";
	}


	//Muestra una lista de albumes
	function verAlbumes($albumes, $completo = false)
	{
		global $conexionBD, $directorioRaiz;

		while ($fila = $albumes->fetch_object())
		{
			$IdAlbum = $fila->IdAlbum;
			$TituloAlbum = $fila->TituloAlbum;
			$DescripcionAlbum = $fila->DescripcionAlbum;

			if($completo)
			{
				$FechaAlbum = $fila->FechaAlbum;
				$NomPais = $fila->NomPais;
			}

			$sqlPortada = "SELECT IdFoto, MiniaturaFoto FROM fotos, albumes WHERE AlbumFoto = IdAlbum AND AlbumFoto = $IdAlbum ORDER BY FechaFoto DESC LIMIT 1";

			//Hacemos la segunda consulta para sacar la miniatura de la ultima foto del album
			if ($portada = $conexionBD->query($sqlPortada))
			{
				if ($portada->num_rows > 0)
				{
					//Guardamos la miniatura
					$fila = $portada->fetch_object();
					
					$IdFoto = $fila->IdFoto;
					$MiniaturaFoto = $fila->MiniaturaFoto;
				}

				else
				{
					$IdFoto = "por defecto";
					$MiniaturaFoto = "img/com/album.png";
				}
			}
?>
			<section class="galeria-cuerpo">
				<a href="verAlbum.php?IdAlbum=<?php echo $IdAlbum;?>">
					<article>
						<div class="marco"><img src='<?php echo "$directorioRaiz$MiniaturaFoto"; ?>' alt="Imagen <?php echo $IdFoto;?>"></div>
						<h3><?php echo $TituloAlbum;?></h3>
						<p><?php echo $DescripcionAlbum;?></p>
<?php  
						if($completo)
						{
							echo "<p>$FechaAlbum</p>";
							echo "<p>$NomPais</p>";
						}
?>
					</article>
				</a>
			</section>
<?php
		}

		if ($albumes->num_rows == 0)
			echo "<p>Aquí no hay nada que ver. Si lo deseas, puedes empezar a añadir álbumes con el siguiente enlace: </p><a href='crearAlbum.php' class='boton'>Crear álbum</a>";
	}
?>