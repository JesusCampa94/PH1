<?php 
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/mysql/formularios.inc.php");
	include_once("../inc/func/accesos.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = "Resultado de Solicitud | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

 	if (isset($_POST["nombre"], $_POST["titulo_solicitud"], $_POST["comentario"], $_POST["email"], $_POST["direccion_calle"], $_POST["direccion_numero"], $_POST["direccion_CP"], $_POST["direccion_localidad"], $_POST["direccion_provincia"], $_POST["telefono"], $_POST["color_portada"], $_POST["copias"], $_POST["resolucion"], $_POST["album_usuario"], $_POST["fecha-recepcion"]))
	{	
		//Titulo y descripcion de pagina
		$h1 = "Solicitud completa";
		$p = "A continuacion se resumen los datos de la solicitud del álbum.";

		//Todo fue normalmente
		$datosCorrectos = true;
	}

	else
	{
		$h1 = "Algo ocurrió";
		$p = "No se recibieron los datos que esperaba está página.";
		$datosCorrectos = false;
	}
?>
<main class="centrado">
	<section class="encabezado">
		<h1><?php echo $h1; ?></h1>
		<p><?php echo $p; ?></p>
	</section>
	<hr />
	<section class="resultados">
		<?php 
			if($datosCorrectos)
			{
				if (abrirConexion())
				{
					if ($datosSolicitud = validarSolicitud())
					{
						if (!($datosSolicitud->errorValidacion))
						{
							$direccion = "$datosSolicitud->direccion_calle".", $datosSolicitud->direccion_numero - $datosSolicitud->direccion_CP $datosSolicitud->direccion_localidad ($datosSolicitud->direccion_provincia)";

							$sql = "INSERT INTO solicitudes (AlbumSolicitud, NombreSolicitud, TituloSolicitud, DescripcionSolicitud, EmailSolicitud, DireccionSolicitud, TelefonoSolicitud, ColorSolicitud, CopiasSolicitud, ResolucionSolicitud, FechaSolicitud, IColorSolicitud, CosteSolicitud) VALUES ($datosSolicitud->album_PI, '$datosSolicitud->nombre', '$datosSolicitud->titulo', '$datosSolicitud->comentario', '$datosSolicitud->email', '$direccion', '$datosSolicitud->telefono', '$datosSolicitud->color_portada', $datosSolicitud->copias, $datosSolicitud->resolucion, '$datosSolicitud->fecha_recepcion', $datosSolicitud->bw_cmyk, $datosSolicitud->coste)";

							//INSERT
							if (ejecutarSQL($sql))
							{
								//Recuperamos datos de la solicitud recien creada
								if ($datosSolicitud = ultimaSolicitud($_SESSION["userId"]))
								{
		?>
									<p class="campo-resultado">Nombre</p>
									<p><?php echo $datosSolicitud->NombreSolicitud;?></p>
									<p class="campo-resultado">Título del álbum</p>
									<p><?php echo $datosSolicitud->TituloSolicitud;?></p>
									<p class="campo-resultado">Comentario</p>
									<p><?php echo $datosSolicitud->DescripcionSolicitud;?></p>
									<p class="campo-resultado">Correo electrónico</p>
									<p><?php echo $datosSolicitud->EmailSolicitud;?></p>
									<p class="campo-resultado">Dirección</p>
									<p><?php echo $datosSolicitud->DireccionSolicitud; ?></p>
									<p class="campo-resultado">Teléfono</p>
									<p><?php echo $datosSolicitud->TelefonoSolicitud;?></p>
									<p class="campo-resultado">Color de portada</p>
									<p><?php echo $datosSolicitud->ColorSolicitud;?></p>
									<p class="campo-resultado">Número de copias</p>
									<p><?php echo $datosSolicitud->CopiasSolicitud;?></p>
									<p class="campo-resultado">Resolución de impresión</p>
									<p><?php echo $datosSolicitud->ResolucionSolicitud;?> dpi</p>
									<p class="campo-resultado">Álbum de PI</p>
									<p><?php echo $datosSolicitud->TituloAlbum;?></p>
									<p class="campo-resultado">Fecha de recepción</p>
									<p><?php echo date("j/n/Y", strtotime($datosSolicitud->FechaSolicitud));?></p>
									<p class="campo-resultado">Tipo de impresión</p>
									<p><?php echo ($datosSolicitud->IColorSolicitud == 0 ? "Blanco y Negro" : "Color");?></p>
									<p class="campo-resultado">Precio Total</p>
									<p><?php echo $datosSolicitud->CosteSolicitud?> €</p>
		<?php	
								}
							}
						}

						//Error de validacion
						else
						{
							$mensajeError = "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>";

							if (isset($datosSolicitud->errorNombre))
								$mensajeError .= $datosSolicitud->errorNombre;

							if (isset($datosSolicitud->errorTitulo))
								$mensajeError .= $datosSolicitud->errorTitulo;

							if (isset($datosSolicitud->errorComentario))
								$mensajeError .= $datosSolicitud->errorComentario;

							if (isset($datosSolicitud->errorEmail))
								$mensajeError .= $datosSolicitud->errorEmail;

							if (isset($datosSolicitud->errorDireccionCalle))
								$mensajeError .= $datosSolicitud->errorDireccionCalle;

							if (isset($datosSolicitud->errorDireccionNumero))
								$mensajeError .= $datosSolicitud->errorDireccionNumero;

							if (isset($datosSolicitud->errorDireccionCP))
								$mensajeError .= $datosSolicitud->errorDireccionCP;

							if (isset($datosSolicitud->errorDireccionLocalidad))
								$mensajeError .= $datosSolicitud->errorDireccionLocalidad;

							if (isset($datosSolicitud->errorDireccionProvincia))
								$mensajeError .= $datosSolicitud->errorDireccionProvincia;

							if (isset($datosSolicitud->errorTelefono))
								$mensajeError .= $datosSolicitud->errorTelefono;

							if (isset($datosSolicitud->errorColor))
								$mensajeError .= $datosSolicitud->errorColor;

							if (isset($datosSolicitud->errorCopias))
								$mensajeError .= $datosSolicitud->errorCopias;

							if (isset($datosSolicitud->errorResolucion))
								$mensajeError .= $datosSolicitud->errorResolucion;

							if (isset($datosSolicitud->errorAlbumPI))
								$mensajeError .= $datosSolicitud->errorAlbumPI;

							if (isset($datosSolicitud->errorFecha))
								$mensajeError .= $datosSolicitud->errorFecha;

							if (isset($datosSolicitud->errorBlancoNegro))
								$mensajeError .= $datosSolicitud->errorBlancoNegro;

							if (isset($datosSolicitud->errorCoste))
								$mensajeError .= $datosSolicitud->errorCoste;

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