<?php
	//Comprueba si se ha iniciado sesion. Si recibe true, redirige a login.php o index.php con un error
	function estaLogueado()
	{
		global $directorioUsu;

		if (session_status() == PHP_SESSION_NONE) 
		{
			session_start();
		}

		//Si existe la variable y tiene ese valor, nada mas que comprobar
		if (isset($_SESSION["meCagoEnLaPaca"]))
		{
			if ($_SESSION["meCagoEnLaPaca"] == "posOk")
			{
				return true;
			}
		}

		//Si hay cookies, mandamos a login.php para loguear (o no)
		else if (isset($_COOKIE["userName"], $_COOKIE["pass"]))	
		{
			//Formamos la direccion de redireccion
			$host = $_SERVER["HTTP_HOST"]; 
			$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\"); 
			$localizacion = "$directorioUsu"."login.php";

			header("Location: http://$host$uri/$localizacion");
		}

		return false;
	}


	//Inicia la sesion del usuario
	function login($userId, $userName, $pass)
	{
		$tiempoExpiracion = time() + 365 * 24 * 60 * 60 * 10; //La cookie durara una decada

		if (isset($_POST["recordar"]))
		{
			setcookie('userName', $userName, $tiempoExpiracion, "/");
			setcookie('pass', $pass, $tiempoExpiracion, "/");
		}

		if (session_status() == PHP_SESSION_NONE) 
		{
			session_start();
		}

		$_SESSION["userId"] = $userId;
		$_SESSION["userName"] = $userName;
		$_SESSION["meCagoEnLaPaca"] = "posOk";

		$fecha = date("j/n/Y") . " a las " . date("G:i:s");
		setcookie('fecha', $fecha, $tiempoExpiracion, "/");
	}


	//Cierra la sesion del usuario
	function logout()
	{
		$host = $_SERVER["HTTP_HOST"]; 
		$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

		if (estaLogueado())
		{
			setcookie('userName', "", -1, "/");
			setcookie('pass', "", -1, "/");

			if (session_status() == PHP_SESSION_NONE) 
			{
				session_start();
			}

			$_SESSION["userId"] = "";
			$_SESSION["userName"] = "";
			$_SESSION["meCagoEnLaPaca"] = "";
			session_destroy();

			$localizacion = "../index.php";
		}

		else
		{
			$localizacion = "../index.php?err=2";
		}

		header("Location: http://$host$uri/$localizacion");
	}


	//Expulsa a un usuario no logueado de la parte privada
	function controlarAcceso()
	{
		global $directorioRaiz, $err;

		//Redirigimos a login.php (implicito en funcion estaLogueado()) o al index con error
		if(!(estaLogueado()))
		{
			//Formamos la direccion de redireccion
			$host = $_SERVER["HTTP_HOST"]; 
			$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\"); 

			if (!isset($err))
				$err = 2;
				
			$localizacion = "$directorioRaiz"."index.php?err=$err";
						
			header("Location: http://$host$uri/$localizacion");
		}
	}


	//Impide que un usuario con sesion iniciada se registre, redireccionandolo al perfil
	function impedirRegistro()
	{
		global $directorioUsu;
		
		if(estaLogueado())
		{
			//Formamos la direccion de redireccion
			$host = $_SERVER["HTTP_HOST"]; 
			$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");				
			$localizacion = "$directorioUsu"."perfil.php?err=4";
						
			header("Location: http://$host$uri/$localizacion");
		}
	}	


	//Elige el header de usuario logueado o no logueado
	function elegirHeader()
	{
		global $directorioRaiz;
		
		return (estaLogueado() ? "$directorioRaiz"."inc/header_usu.inc" : "$directorioRaiz"."inc/header.inc");
	}
?>