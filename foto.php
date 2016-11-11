<?php 
	//Controlar acceso a parte privada
	$err = 3; //Tipo de error
	require_once("inc/func/controlAcceso.inc.php");

	//Titulo de la pagina
	$titulo = "Detalle de foto | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Cargar header. Incluye etiqueta de inicio de <body>
	require_once("inc/header_usu.inc");

	//Cargar una página u otra segun la paridad del identificador de la foto
	$correcto = false;

	if (isset($_GET["id"]))
	{
		$id = $_GET["id"];

		if (is_numeric($id))
		{
			if ($id % 2 != 0)
				require_once("inc/foto1.inc");

			else
				require_once("inc/foto2.inc");

			$correcto = true;
		}
	}

	if ($correcto == false)
	{
		require_once("inc/foto_error.inc");
	}

	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>