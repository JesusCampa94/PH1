<?php 
	//Titulo de la pagina
	$titulo = "Inicio | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	
	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Comprueba si el usuario esta logueado para elegir el header
	require_once("inc/func/elegirHeader.inc.php");	

	if (isset($_GET["err"]))
	{
		if ($_GET["err"] == 1)
		{
			require_once("inc/aviso_login.inc");
		}

		else if ($_GET["err"] == 2)
		{
			require_once("inc/aviso_antihack.inc");
		}

		else if ($_GET["err"] == 3)
		{
			require_once("inc/aviso_fotos.inc");
		}

		unset($_GET["err"]);
	}
?>
<main>
	<h1>PI - Pictures and Images</h1>
	<section>
		<section class="galeria-encabezado"><h2>Últimas fotos</h2></section>
		<section class="galeria-cuerpo">				
			<?php require_once("inc/mysql/index.inc.php"); ?>
		</section>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>