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

	//Cargamos un header u otro segun si se ha logueado
	$rutaHeader = ($logueado ? "$prefijoRuta"."inc/header_usu.inc" : "$prefijoRuta"."inc/header.inc");
	require_once($rutaHeader);
?>