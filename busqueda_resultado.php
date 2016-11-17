<?php 
	//Titulo de la pagina
	$titulo = "Resultado de búsqueda | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Comprueba si el usuario esta logueado para elegir el header
	require_once("inc/func/elegirHeader.inc.php");	

	//Obtener datos
	if (isset($_GET["titulo"], $_GET["fechaInicio"], $_GET["fechaFin"], $_GET["pais"]))
	{
		//Obtiene datos, pero no muestra la galeria ni cierra conexion con BD
		require_once("inc/mysql/busqueda_resultado.inc.php");

		//Titulo y descripcion de pagina
		$h1 = "Parámetros de búsqueda";
		$p = "A continuación se resumen los filtros de búsqueda especificados.";

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
<main>
	<h1>Resultado de Búsqueda</h1>
	<section class="encabezado">
		<h1><?php echo $h1; ?></h1>
		<p><?php echo $p; ?></p>
	</section>
	<?php if($correcto) { ?>
	<div class="separador"></div>
	<section id="datos" class="tarjeta">
		<p><strong>Título: </strong><?php echo $titulo; ?></p>
		<p><strong>Fecha inicio: </strong><?php echo $fechaInicio; ?></p>
		<p><strong>Fecha fin: </strong><?php echo $fechaFin; ?></p>
		<p><strong>País: </strong><?php echo $pais; ?></p>
	</section>
	<section>
		<section class="galeria-encabezado">
			<h2>Fotos encontradas</h2>
			<p>Estas son las fotos que se han encontrado que cumplan los criterios indicados.</p>
		</section>
		<section class="galeria-cuerpo">
			<?php 
				require_once("inc/mysql/com/mostrarGaleria.inc.php");
				require_once("inc/mysql/com/cerrarConexion.inc.php");
			?>
		</section>
	</section>
	<?php } ?>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>