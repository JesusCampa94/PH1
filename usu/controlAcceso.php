<?php
	require_once("../inc/mysql/com/funciones.inc.php");

	//Datos introducidos en el formulario
	if(isset($_POST["usuario"], $_POST["pass"]))
	{
		$usuario = $_POST["usuario"];
		$pass = $_POST["pass"];
		$fecha = date("j/n/Y") . " a las " . date("G:i:s");
		$correcto = true;
	}

	//Formamos la direccion de redireccion
	$host = $_SERVER["HTTP_HOST"]; 
	$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\"); 

	if($correcto)
	{
		//Contrastar datos de acceso en BD
		if (comprobarDatosAcceso($usuario, $pass))
		{
			$tiempoExpiracion = 0; //Duracion de la sesion

			if (isset($_POST["recordar"]))
			{
				$tiempoExpiracion = time() + 365 * 24 * 60 * 60 * 10; //La cookie durara una decada
				setcookie('usu', $usuario, $tiempoExpiracion, "/");
				setcookie('pass', $pass, $tiempoExpiracion, "/");
			}

			else
			{
				session_start();
				$_SESSION["usu"] = $usuario;
				$_SESSION["pass"] = $pass;
			}

			setcookie('fecha', $fecha, $tiempoExpiracion, "/");

	 		$localizacion = "perfil.php"; 
		}

		else
			$localizacion = "index.php?err=1";
	}
	else 
	{
		$localizacion = "index.php?err=2";
	}

	header("Location: http://$host$uri/$localizacion"); 
?>