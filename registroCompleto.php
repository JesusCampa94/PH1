<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "";
	$directorioUsu = "usu/";

	//Funciones requeridas
	include_once("inc/func/mysql/basico.inc.php");
	include_once("inc/func/accesos.inc.php");
	include_once("inc/func/mysql/formularios.inc.php");

	//Titulo de la pagina
	$titulo = "Registro completo | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	//Comprobamos que han introducido los campos adecuados
	if (isset($_POST["nombreUsuario"], $_POST["pass"], $_POST["email"], $_POST["sexo"], $_POST["fecha"], $_POST["pais"], $_POST["ciudad"]))//falta comprobar la foto
	{
		//variables que cambiaremos segun los datos del registro
		$h1 = "Registro completado";
		$p = "Resumen de los datos de tu registro, compruébalo todo bien.";
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
	<section class="tarjeta">
		<?php 
			if($datosCorrectos)
			{
				if (abrirConexion())
				{
					if ($datosRegistro = validarUsuario())
					{
						$sql = "INSERT INTO usuarios (NomUsuario, ClaveUsuario, EmailUsuario, SexoUsuario, FNacimientoUsuario, CiudadUsuario, PaisUsuario) VALUES ('$datosRegistro->usuario', '$datosRegistro->pass', '$datosRegistro->email', $datosRegistro->sexo, '$datosRegistro->fecha', '$datosRegistro->ciudad', $datosRegistro->pais)";

						//Insertar usuario
						if (ejecutarSQL($sql))
						{
							$sql = getSQLUsuario($datosRegistro->usuario);

							//Recuperar datos de usuario
							if ($resultado = ejecutarSQL($sql))
							{
								mostrarDatos($resultado);
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
	require_once("inc/footer.inc");
?>