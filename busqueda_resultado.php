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
		$titulo = $_GET["titulo"];
		$fechaInicio = $_GET["fechaInicio"];
		$fechaFin = $_GET["fechaFin"];
		$pais = $_GET["pais"];

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
			<a href="foto.php?id=1">
				<article>
					<div class="marco"><img src="img/thumb/001.jpg" height="225" width="400" alt="Imagen 001"></div>
					<h3>Panda</h3>
					<p>28/09/2016</p>
					<p>China</p>
				</article>
			</a>
			<a href="foto.php?id=2">
				<article>
					<div class="marco"><img src="img/thumb/002.jpg" height="225" width="400" alt="Imagen 002"></div>
					<h3>Pato</h3>
					<p>27/09/2016</p>
					<p>España</p>
				</article>
			</a>
			<a href="foto.php?id=3">
				<article>
					<div class="marco"><img src="img/thumb/003.jpg" height="225" width="400" alt="Imagen 003"></div>
					<h3>Tiburón</h3>
					<p>28/08/2016</p>
					<p>México</p>
				</article>
			</a>
		</section>
	</section>
	<?php } ?>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>