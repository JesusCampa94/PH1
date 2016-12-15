<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "";
	$directorioUsu = "usu/";

	//Funciones requeridas
	include_once("inc/func/mysql/basico.inc.php");
	include_once("inc/func/accesos.inc.php");
	include_once("inc/func/mysql/formularios.inc.php");
	include_once("inc/func/ficheros.inc.php");

	//Titulo de la pagina
	$titulo = "Registro completo | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	//Comprobamos que han introducido los campos adecuados
	if (isset($_POST["nombreUsuario"], $_POST["pass"], $_POST["email"], $_POST["sexo"], $_POST["fecha"], $_POST["pais"], $_POST["ciudad"]))
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
						if (!($datosRegistro->errorValidacion))
						{
							$sql = "INSERT INTO usuarios (NomUsuario, ClaveUsuario, EmailUsuario, SexoUsuario, FNacimientoUsuario, CiudadUsuario, PaisUsuario) VALUES ('$datosRegistro->usuario', '$datosRegistro->pass', '$datosRegistro->email', $datosRegistro->sexo, '$datosRegistro->fecha', '$datosRegistro->ciudad', $datosRegistro->pais)";
							
							//Insertar usuario
							if (ejecutarSQL($sql))
							{
								if (subirArchivo("foto", $datosRegistro->fotoPerfil))
								{
									$datos->fotoPerfil .= getExtension($_FILES["foto"]["name"]);

									$IdUsuario = $conexionBD->insert_id;
									$sql = "UPDATE usuarios SET FotoUsuario = '$datosRegistro->fotoPerfil' WHERE  IdUsuario = $IdUsuario";

									//Update de la foto
									ejecutarSQL($sql);
								}
								
								$sql = getSQLUsuario($datosRegistro->usuario);

								//Recuperar datos de usuario
								if ($resultado = ejecutarSQL($sql))
								{
									mostrarDatos($resultado);
									$resultado->close();
								}
							}
						}

						//Error validacion
						else
						{
							$mensajeError = "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>";

							if (isset($datosRegistro->errorUsuario))
								$mensajeError .= $datosRegistro->errorUsuario;

							if (isset($datosRegistro->errorEmail))
								$mensajeError .= $datosRegistro->errorEmail;

							if (isset($datosRegistro->errorSexo))
								$mensajeError .= $datosRegistro->errorSexo;

							if (isset($datosRegistro->errorFecha))
								$mensajeError .= $datosRegistro->errorFecha;

							if (isset($datosRegistro->errorPais))
								$mensajeError .= $datosRegistro->errorPais;

							if (isset($datosRegistro->errorPass))
								$mensajeError .= $datosRegistro->errorPass;

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
	require_once("inc/footer.inc");
?>