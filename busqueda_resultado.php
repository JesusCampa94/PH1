<?php 
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "";
	$directorioUsu = "usu/";

	//Funciones requeridas
	include_once("inc/func/mysql/basico.inc.php");
	include_once("inc/func/accesos.inc.php");
	include_once("inc/func/mysql/galerias.inc.php");

	//Titulo de la pagina
	$titulo = "Resultado de búsqueda | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	//Obtener datos
	if (isset($_GET["titulo"], $_GET["fechaInicio"], $_GET["fechaFin"], $_GET["pais"]))
	{
		//Titulo y descripcion de pagina
		$h1 = "Parámetros de búsqueda";
		$p = "A continuación se resumen los filtros de búsqueda especificados.";

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
<main>
	<h1>Resultado de Búsqueda</h1>
	<section class="encabezado">
		<h1><?php echo $h1; ?></h1>
		<p><?php echo $p; ?></p>
	</section>
	<div class="separador"></div>
	<?php if($datosCorrectos)
	{
		if (abrirConexion())
		{
			$datosBusqueda = buscarFotos();
			$sql = $datosBusqueda->sql;

			if ($resultado = ejecutarSQL($sql))
			{
	?>
				<section id="datos" class="tarjeta">
					<p><strong>Título: </strong><?php echo $datosBusqueda->titulo; ?></p>
					<p><strong>Fecha inicio: </strong><?php echo $datosBusqueda->fechaInicio; ?></p>
					<p><strong>Fecha fin: </strong><?php echo $datosBusqueda->fechaFin; ?></p>
					<p><strong>País: </strong><?php echo $datosBusqueda->pais; ?></p>
				</section>
				<section>
					<section class="galeria-encabezado">
						<h2>Fotos encontradas</h2>
						<p>Estas son las fotos que se han encontrado que cumplan los criterios indicados.</p>
					</section>
					<section class="galeria-cuerpo">
	<?php		
				verFotos($resultado);
				cerrarConexion($resultado);
			}

			else
			{
				cerrarConexion();
			}
		}
	?>
		</section>
	</section>
	<?php } ?>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>