<?php 
	session_start();
	$logueado = false;

	//Comprobamos si existe sesion o cookie
	if (isset($_SESSION["usu"], $_SESSION["pass"]) || isset($_COOKIE["usu"], $_COOKIE["pass"]))
	{
		//Parejas usuario-pass validas
		$datosAcceso["yisus"] = "cawendie";
		$datosAcceso["maermka"] = "odioelmundo";
		$datosAcceso["flequi"] = "#heperdido";

		//Mediante sesion
		if (isset($_SESSION["usu"], $_SESSION["pass"]))
		{
			//Comprobar que la sesion es valida
			if ($datosAcceso[$_SESSION["usu"]] == $_SESSION["pass"])
			{
				require_once("inc/header_usu.inc");
				$logueado = true;
			}
		}

		//Mediante cookies
		else
		{
			//Comprobar que la cookie es valida
			if ($datosAcceso[$_COOKIE["usu"]] == $_COOKIE["pass"])
			{
				require_once("inc/header_usu.inc");
				$logueado = true;
			}
		}
	}

	//No logueado, cargamos header normal
	if ($logueado == false)
	{
		require_once("inc/header.inc");
	}
?>