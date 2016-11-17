<?php
	//Conectamos a la BD
	require_once("../inc/mysql/com/abrirConexion.inc.php");

	//Consulta
	$sql = "SELECT IdFoto, TituloFoto, FechaFoto, PaisFoto, MiniaturaFoto FROM fotos WHERE albumFoto = $IdAlbum";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("../inc/mysql/com/ejecutarSQL.inc.php");

	//Incluímos mostrar galeria que se encarga del resto
	require_once("../inc/mysql/com/mostrarGaleria.inc.php");

	//Liberamos memoria y desconectamos de la BD
	require_once("../inc/mysql/com/cerrarConexion.inc.php");
?>