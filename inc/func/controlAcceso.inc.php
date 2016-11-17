<?php
	session_start();
	$logueado = false;

	//Determinamos si estamos en la raiz o en la carpeta /usu
	$prefijoRuta = "";

	if (isset($dirUsu))
	{
		$prefijoRuta = "../";
	}

	//Comprobamos si existe sesion o cookie
	if (isset($_SESSION["usu"], $_SESSION["pass"]) || isset($_COOKIE["usu"], $_COOKIE["pass"]))
	{
		//Mediante sesion
		if (isset($_SESSION["usu"], $_SESSION["pass"]))
		{
			$usuario = $_SESSION["usu"];
			$pass = $_SESSION["pass"];
		}

		//Mediante cookies
		else
		{
			$usuario = $_COOKIE["usu"];
			$pass = $_COOKIE["pass"];
		}

		require_once("$prefijoRuta"."inc/mysql/com/funciones.inc.php");
		$logueado = comprobarDatosAcceso($usuario, $pass);
	}

	//No logueado, vuelta al index
	if ($logueado == false)
	{
		if (!isset($err))
		{
			$err = 2;
		}

		$host = $_SERVER["HTTP_HOST"]; 
		$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		$localizacion = "index.php?err=$err";

		header("Location: http://$host$uri/$localizacion"); 
	}
?>