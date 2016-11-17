<?php
	require_once("com/funciones.inc.php");

	//Conectamos a la BD
	require_once("com/abrirConexion.inc.php");

	//Consulta
	$sql = "SELECT IdFoto, TituloFoto, FechaFoto, PaisFoto, MiniaturaFoto FROM fotos ORDER BY FechaFoto DESC LIMIT 5";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("com/ejecutarSQL.inc.php");

	require_once("com/mostrarGaleria.inc.php");

	//Liberamos memoria y desconectamos de la BD
	require_once("com/cerrarConexion.inc.php");
?>

