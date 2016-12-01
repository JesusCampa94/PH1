<?php 
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
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

 	if (isset($_POST["nombre"], $_POST["titulo_album"], $_POST["comentario"], $_POST["email"], $_POST["direccion_calle"], $_POST["direccion_numero"], $_POST["direccion_CP"], $_POST["direccion_localidad"], $_POST["telefono"], $_POST["color_portada"], $_POST["copias"], $_POST["resolucion"], $_POST["album_PI"], $_POST["fecha-recepcion"], $_POST["bw_cmyk"]))
	{
		//Creamos las variables para guardar los datos del formulario
		$nombre= $_POST["nombre"];
		$titulo = $_POST["titulo_album"];
		$comentario = $_POST["comentario"];
		$email = $_POST["email"];
		$direccion_calle = $_POST["direccion_calle"];
		$direccion_numero = $_POST["direccion_numero"];
		$direccion_CP = $_POST["direccion_CP"];
		$direccion_localidad = $_POST["direccion_localidad"];
		$telefono = $_POST["telefono"];
		$color_portada = $_POST["color_portada"];
		$copias = $_POST["copias"];
		$resolucion = $_POST["resolucion"];
		$album_PI = $_POST["album_PI"];
		$fecha_recepcion = $_POST["fecha-recepcion"];
		$bw_cmyk = $_POST["bw_cmyk"];
		$precioPaginas = 0.10;
		$precioColor = 0.0;
		$precioDpi = 0.0;
		$precioTotal = 0.0;
		$numPaginas = 4;//numero fijo de paginas(por ahora)
		$numFotos = 15;//numero fijo de fotos(por ahora)

		//Ahora calcularemos el precio final del album
		if($bw_cmyk == "color")//si han elegido la opcion de color
		{
			$precioColor = 0.05;
		}
		if($resolucion	>= 300)//si ha elegido mas de 300 de dpi
		{
			$precioDpi = 0.02;
		}

		$precioTotal = ($precioPaginas*$numPaginas + $precioDpi*$numFotos + $precioColor*$numFotos)*$copias;
	
		//Titulo y descripcion de pagina
		$h1 = "Solicitud completa";
		$p = "A continuacion se resumen los datos de la solicitud del álbum.";

		//Todo fue normalmente
		$correcto = true;
	}

	else
	{
		$h1 = "Algo ocurrió";
		$p = "No se recibieron los datos que esperaba está página.";
		$correcto = false;
	}
?>
<main class="centrado">
	<section class="encabezado">
		<h1><?php echo $h1; ?></h1>
		<p><?php echo $p; ?></p>
	</section>
	<div class="separador"></div>
	<section class="texto-izquierda">
		<?php 
			if($datosCorrectos)
			{
				if (abrirConexion())
				{
					if ($datosRegistro = validarUsuario())
					{
						$sql = "";

						//INSERT
						if (ejecutarSQL($sql))
						{
							$sql = "";

							//SELECT
							if ($resultado = ejecutarSQL($sql))
							{
		?>
								<p><strong>Nombre: </strong><?php echo $nombre;?></p>
								<p><strong>Título del álbum: </strong><?php echo $titulo;?></p>
								<p><strong>Comentario: </strong><?php echo $comentario;?></p>
								<p><strong>Correo electrónico: </strong><?php echo $email;?></p>
								<p><strong>Dirección: </strong>c/ <?php echo $direccion_calle;?>, <?php echo $direccion_numero;?>, <?php echo $direccion_CP;?>, <?php echo $direccion_localidad;?></p>
								<p><strong>Teléfono: </strong><?php echo $telefono;?></p>
								<p><strong>Color de portada: </strong><?php echo $color_portada;?></p>
								<p><strong>Número de copias: </strong><?php echo $copias;?></p>
								<p><strong>Resulución de impresión: </strong><?php echo $resolucion;?> dpi</p>
								<p><strong>Álbum de PI: </strong><?php echo $album_PI;?></p>
								<p><strong>Fecha de recepción: </strong><?php echo $fecha_recepcion;?></p>
								<p><strong>Tipo de impresión: </strong><?php echo $bw_cmyk;?></p>
								<p><strong>Precio Total: </strong><?php echo $precioTotal?> €</p>
		<?php	
								cerrarConexion($resultado);
							}

							else
							{
								cerrarConexion();
							}
						}

						else
						{
							cerrarConexion();
						}
					}
				}
			} 
		?>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>