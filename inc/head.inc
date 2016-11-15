<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $titulo; ?></title>

		<?php 
			//Determinamos si estamos en la raiz o en la carpeta /usu para buscar los estilos en la ruta correcta
			$prefijoRuta = "";

			if (isset($dirUsu))
			{
				$prefijoRuta = "../";
			}
		?>
		
		<link rel="stylesheet" href="<?php echo $prefijoRuta; ?>css/estilos.css" title="Estilo principal" media="screen">
		<link rel="alternate stylesheet" type="text/css" href="<?php echo $prefijoRuta; ?>css/contraste.css" title="Alto contraste">
		
		<?php 
			//Usamos la variable $estilos para determinar que estilos opcionales se incluyen

			switch ($estilos)
			{
				case "f":
				{
					require_once("css/estilos_formularios.inc");
					break;
				}

				case "g":
				{
					require_once("css/estilos_galerias.inc");
					break;
				}

				case "fg":
				{
					require_once("css/estilos_formularios.inc");
					require_once("css/estilos_galerias.inc");

					break;
				}
			}
		?>
		<link rel="stylesheet" href="<?php echo $prefijoRuta; ?>css/imprimir.css" media="print">
	</head>