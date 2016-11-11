<?php 
	//CONTROL DE ACCESO A PARTE PRIVADA
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
			//Eliminar sesion
			if ($datosAcceso[$_SESSION["usu"]] == $_SESSION["pass"])
			{
				session_destroy();
				$logueado = true;
			}
		}

		//Mediante cookies
		else
		{
			//Eliminar cookies
			if ($datosAcceso[$_COOKIE["usu"]] == $_COOKIE["pass"])
			{
				setcookie('usu', "", -1, "/");
				setcookie('pass', "", -1, "/");
				$logueado = true;
			}
		}
	}

	//No logueado, vuelta al index
	if ($logueado == false)
	{
		$host = $_SERVER["HTTP_HOST"]; 
		$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		$localizacion = "index.php?err=2";

		header("Location: http://$host$uri/$localizacion"); 
	}

	//Eliminar fecha ultima visita y devolver al index
	setcookie('fecha', "", -1, "/");

	$host = $_SERVER["HTTP_HOST"]; 
	$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$localizacion = "index.php";

	header("Location: http://$host$uri/$localizacion");
?>