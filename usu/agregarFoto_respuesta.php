<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");
	include_once("../inc/func/mysql/formularios.inc.php");
	include_once("../inc/func/mysql/galerias.inc.php");
	include_once("../inc/func/ficheros.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = "Foto añadida | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	//Comprobamos que han introducido los campos adecuados
	if (isset($_POST["titulo"], $_POST["descripcion"], $_POST["fecha"], $_POST["pais"], $_POST["album_usuario"])) //Falta foto
	{
		$h1 = "Añadiendo foto";
		$p = "A continuación se muestran los datos de la foto enviada.";
		$datosCorrectos = true;
	}

	else
	{
		$h1 = "Algo ocurrió";
		$p = "No se recibieron los datos esperados.";
		$datosCorrectos = false;
	}
?>
<main class="centrado">
	<section class="encabezado">
		<h1><?php echo $h1;?></h1>
		<p><?php echo $p;?></p>
	</section>
	<hr />
	<section>
		<?php 
			if($datosCorrectos)
			{
				if (abrirConexion())
				{
					if ($datosFoto = validarFoto())
					{
						if (!($datosFoto->errorValidacion))
						{
							$sql = "INSERT INTO fotos (TituloFoto, DescripcionFoto, FechaFoto, PaisFoto, AlbumFoto) VALUES ('$datosFoto->titulo', '$datosFoto->descripcion', '$datosFoto->fecha', $datosFoto->pais, $datosFoto->album_usuario)";

							//INSERT
							if (ejecutarSQL($sql))
							{
								//Quitamos la extension, subirImagen() la necesita así
								$sinExtension = explode(".", $datosFoto->ficheroFoto)[0];
								$IdFoto = $conexionBD->insert_id;

								//Incluimos la imagen y su miniatura
								if (subirImagen("ficheroFoto", $sinExtension))
								{
									if (copy($directorioRaiz. $datosFoto->ficheroFoto, $directorioRaiz . $datosFoto->miniaturaFoto))
									{	
										$sql = "UPDATE fotos SET FicheroFoto = '$datosFoto->ficheroFoto', MiniaturaFoto = '$datosFoto->miniaturaFoto' WHERE IdFoto = $IdFoto";

										ejecutarSQL($sql);
									}
								}

								$sql = getSQLFoto($IdFoto);

								//SELECT
								if ($resultado = ejecutarSQL($sql))
								{
									//Con true mostramos todos los datos
									verFotos($resultado, true);
									$resultado->close();
								}
							}
						}

						//Error de validacion
						else
						{
							$mensajeError = "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>";

							if (isset($datosFoto->errorTitulo))
								$mensajeError .= $datosFoto->errorTitulo;

							if (isset($datosFoto->errorDescripcion))
								$mensajeError .= $datosFoto->errorDescripcion;

							if (isset($datosFoto->errorFecha))
								$mensajeError .= $datosFoto->errorFecha;

							if (isset($datosFoto->errorPais))
								$mensajeError .= $datosFoto->errorPais;

							if (isset($datosFoto->errorAlbumUsuario))
								$mensajeError .= $datosFoto->errorAlbumUsuario;

							if (isset($datosFoto->errorFichero))
								$mensajeError .= $datosFoto->errorFichero;

							echo $mensajeError;
						}
					}

					cerrarConexion();
				}
			} 
		?>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>