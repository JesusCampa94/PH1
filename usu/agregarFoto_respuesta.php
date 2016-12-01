<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");
	include_once("../inc/func/mysql/formularios.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = " | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	//Comprobamos que han introducido los campos adecuados
	if (isset())//falta comprobar la foto
	{
		//variables que cambiaremos segun los datos del registro
		$h1 = "";
		$p = "";
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
	<div class="separador"></div>
	<section class="tarjeta">
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