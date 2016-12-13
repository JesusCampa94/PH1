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

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = " Respuesta a crear álbum| Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	//Comprobamos que han introducido los campos adecuados
	if (isset($_POST["titulo"], $_POST["descripcion"], $_POST["fecha"], $_POST["pais"]))
	{
		$h1 = "Creando el Álbum";
		$p = "Estos son los detalles de su album:";
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
					if ($datosAlbum = validarAlbum())
					{
						if (!($datosAlbum->errorValidacion))
						{
							$userId = $_SESSION["userId"];
							$sql = "INSERT INTO albumes (TituloAlbum, DescripcionAlbum, FechaAlbum, PaisAlbum, UsuarioAlbum) VALUES ('$datosAlbum->titulo', '$datosAlbum->descripcion', '$datosAlbum->fecha', $datosAlbum->pais, $userId)";
							//INSERT
							if (ejecutarSQL($sql))
							{
								//devuelve el id de la ultima insercion
								$IdAlbum = $conexionBD->insert_id;

								$sql = "SELECT IdAlbum, TituloAlbum, DescripcionAlbum, FechaAlbum, NomPais FROM albumes, paises WHERE PaisAlbum = IdPais AND IdAlbum = $IdAlbum";
								//SELECT
								if ($resultado = ejecutarSQL($sql))
								{
									verAlbumes($resultado, true);
									$resultado->close();
								}
							}
						}

						//Error de validacion
						else
						{
							$mensajeError = "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>";

							if (isset($datosAlbum->errorTitulo))
								$mensajeError .= $datosAlbum->errorTitulo;
							if (isset($datosAlbum->errorDescripcion))
								$mensajeError .= $datosAlbum->errorDescripcion;
							if (isset($datosAlbum->errorFecha))
								$mensajeError .= $datosAlbum->errorFecha;
							if (isset($datosAlbum->errorPais))
								$mensajeError .= $datosAlbum->errorPais;

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