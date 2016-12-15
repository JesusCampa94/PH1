<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");
	include_once("../inc/func/ficheros.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Formamos la direccion de redireccion
	$host = $_SERVER["HTTP_HOST"]; 
	$uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	
	//Redirigimos con un mensaje de confirmacion o de error
	$err = 9;

	if (borrarFotoUsuario())
	{
		//Si se borra, hay que decirselo a la BD
		if (abrirConexion())
		{
			if (session_status() == PHP_SESSION_NONE) 
			{
				session_start();
			}

			$userId = $_SESSION["userId"];

			$sql = "UPDATE usuarios SET FotoUsuario = 'img/com/avatar.png' WHERE IdUsuario = $userId";

			ejecutarSQL($sql);
			cerrarConexion();
			
			$err = 8;
		}
	}
	
	$localizacion = "$directorioUsu"."modificarDatos.php?err=$err";

	header("Location: http://$host$uri/$localizacion");
?>