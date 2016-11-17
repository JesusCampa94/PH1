<?php
	//Conectamos a la BD
	require_once("../com/abrirConexion.inc.php");

	//Saneamos datos
	$usuario = $mysqli->real_escape_string($usuario);
	$pass = $mysqli->real_escape_string($pass);

	//Consulta
	$sql = "SELECT ClaveUsuario FROM usuarios WHERE NomUsuario = '$usuario'";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("../com/ejecutarSQL.inc.php");

	//Recuperamos el resultado
	$fila = $resultado->fetch_object();

	

	//Liberamos memoria y desconectamos de la BD
	require_once("../com/cerrarConexion.inc.php");
?>