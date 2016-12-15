<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");
	include_once("../inc/func/mysql/formularios.inc.php");
	include_once("../inc/func/ficheros.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = " Respuesta a modificar datos| Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	//Comprobamos que han introducido los campos adecuados
	if ((isset($_POST["nombreUsuario"], $_POST["email"], $_POST["sexo"], $_POST["fecha"], $_POST["pais"], $_POST["ciudad"]) || isset($_POST["pass"], $_POST["repetirPass"])) && isset($_POST["passActual"]))
	{
		$h1 = "Datos de cuenta actualizados";
		$p = "A continuación se muestran los detalles de su cuenta.";
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
					if ($datosUsuario = validarUsuario())
					{
						if (!($datosUsuario->errorValidacion))
						{
							if ($datosUsuario->passActual == $_SESSION["passActual"])
							{
								$_SESSION["passActual"] = "";
								$userId = $_SESSION["userId"];
								
								//Llego desde modificarPass
								if (isset($datosUsuario->pass))
								{
									$sql = "UPDATE usuarios SET ClaveUsuario = '$datosUsuario->pass' WHERE IdUsuario = $userId";
								}

								//Llego desde modificarDatos
								else
								{								
									$sql = "UPDATE usuarios SET NomUsuario = '$datosUsuario->usuario', EmailUsuario = '$datosUsuario->email', SexoUsuario = $datosUsuario->sexo, FNacimientoUsuario = '$datosUsuario->fecha', CiudadUsuario = '$datosUsuario->ciudad', PaisUsuario = $datosUsuario->pais WHERE IdUsuario = $userId";
								}

								//UPDATE
								if (ejecutarSQL($sql))
								{
									$campo = "foto";

									//Hay que modificar la foto si se cambia de nombre o se sube una nueva
									if ($_SESSION["userName"] != $datosUsuario->usuario || comprobarArchivo($campo))
									{
										if (modificarFotoUsuario($campo, $datosUsuario->fotoPerfil))
										{								
											$IdUsuario = $_SESSION["userId"];
											$sql = "UPDATE usuarios SET FotoUsuario = '$datosUsuario->fotoPerfil' WHERE  IdUsuario = $IdUsuario";

											//Update de la foto
											ejecutarSQL($sql);
										}
									}

									//Si hemos cambiado el nombre de usuario, hay que actualizar la variable de sesion
									$_SESSION["userName"] = $datosUsuario->usuario;

									$sql = getSQLUsuario($_SESSION["userName"]);

									//SELECT
									if ($resultado = ejecutarSQL($sql))
									{
										mostrarDatos($resultado);	
										$resultado->close();
									}
								}
							}

							else
							{
								echo "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>
										<p>No has introducido una contraseña correcta. Los datos no han sido modificados</p>";
							}
						}

						//Error de validacion
						else
						{
							$mensajeError = "<p><img src='$directorioRaiz"."img/com/error.png' alt='Error' /></p>";

							if (isset($datosUsuario->errorUsuario))
								$mensajeError .= $datosUsuario->errorUsuario;

							if (isset($datosUsuario->errorEmail))
								$mensajeError .= $datosUsuario->errorEmail;

							if (isset($datosUsuario->errorSexo))
								$mensajeError .= $datosUsuario->errorSexo;

							if (isset($datosUsuario->errorFecha))
								$mensajeError .= $datosUsuario->errorFecha;

							if (isset($datosUsuario->errorPass))
								$mensajeError .= $datosUsuario->errorPass;

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
	require_once("../inc/footer.inc");
?>