<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");

	//Formamos la direccion de redireccion
	$host = $_SERVER["HTTP_HOST"]; 
	$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\"); 

	//Recogemos los datos de login o por cookies
	if(isset($_POST["usuario"], $_POST["pass"]) || isset($_COOKIE["userName"], $_COOKIE["pass"]))
	{
		//Contrastar datos de acceso en BD
		if (abrirConexion())
		{
			//Datos del formulario de login
			if (isset($_POST["usuario"], $_POST["pass"]))
			{
				$usuario = $conexionBD->real_escape_string($_POST["usuario"]);
				$pass = $conexionBD->real_escape_string($_POST["pass"]);
			}

			//Datos de cookies (escapadas por si alguien las crea manualmente)
			else
			{
				$usuario = $conexionBD->real_escape_string($_COOKIE["userName"]);
				$pass = $conexionBD->real_escape_string($_COOKIE["pass"]);
			}

			$sql = "SELECT IdUsuario, ClaveUsuario FROM usuarios WHERE NomUsuario = '$usuario'";

			if ($resultado = ejecutarSQL($sql))
			{
				if ($resultado->num_rows > 0)
				{
					$fila = $resultado->fetch_object();

					if ($fila->ClaveUsuario == $pass)
					{
						login($fila->IdUsuario, $usuario, $pass);
						$localizacion = "perfil.php";
					}

					else
					{
						$localizacion = "../index.php?err=1";
					}

				}

				else
				{
					$localizacion = "../index.php?err=1";
				}

				cerrarConexion($resultado);
			}

			else
			{
				 cerrarConexion();
			}
		}
	}

	else 
	{
		$localizacion = "../index.php?err=2";
	}

	header("Location: http://$host$uri/$localizacion"); 
?>