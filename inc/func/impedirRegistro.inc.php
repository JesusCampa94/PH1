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
				$logueado = true;
			}
		}

		//Mediante cookies
		else
		{
			//Comprobar que la cookie es valida
			if ($datosAcceso[$_COOKIE["usu"]] == $_COOKIE["pass"])
			{
				$logueado = true;
			}
		}
	}

	//logueado, volvemos a inicio
	if ($logueado)
	{
		$host = $_SERVER["HTTP_HOST"]; 
		$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		$localizacion = "index.php?err=2";

		header("Location: http://$host$uri/$localizacion");
	}
?>