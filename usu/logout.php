<?php 
	session_start();
	$correcto = false;

	//Comprobamos si existe sesion o cookie
	if (isset($_SESSION["usu"], $_SESSION["pass"]) || isset($_COOKIE["usu"], $_COOKIE["pass"]))
	{
		require_once("../inc/mysql/com/funciones.inc.php");
		
		//Mediante sesion
		if (isset($_SESSION["usu"], $_SESSION["pass"]))
		{
			$usuario = $_SESSION["usu"];
			$pass = $_SESSION["pass"];

			//Eliminar sesion
			if (comprobarDatosAcceso($usuario, $pass))
			{
				session_destroy();
				$correcto = true;
			}
		}

		//Mediante cookies
		else
		{
			$usuario = $_COOKIE["usu"];
			$pass = $_COOKIE["pass"];

			//Eliminar cookies
			if (comprobarDatosAcceso($usuario, $pass))
			{
				setcookie('usu', "", -1, "/");
				setcookie('pass', "", -1, "/");
				$correcto = true;
			}
		}
	}
		$host = $_SERVER["HTTP_HOST"]; 
		$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

	//No logueado, vuelta al index
	if ($correcto == false)
	{
		$localizacion = "../index.php?err=2";
		header("Location: http://$host$uri/$localizacion"); 
	}

	//Eliminar fecha ultima visita y devolver al index
	setcookie('fecha', "", -1, "/");

	$localizacion = "../index.php";

	header("Location: http://$host$uri/$localizacion");
?>