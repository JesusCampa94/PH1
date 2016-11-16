<?php 
	//Conexion a la Base de Datos
	$mysqli = new mysqli("localhost", "root", "cawendie", "pibd");
	$mysqli->set_charset("utf8");

	//Comprobamos que no ha habido error
	if ($mysqli->connect_errno)
	{
		echo "<p>Error al conectar con la base de datos: " . $mysqli->connect_error . "</p>";
		exit;
	}
?>