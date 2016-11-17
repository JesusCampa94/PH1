//TRANQUILOS, ESTA PÁGINA NO HACE NADA, SÓLO EXISTE PARA CREAR CONTENIDO MÁS RÁPIDAMENTE... COPIAR Y PEGAR, BÁSICAMENTE
//RAÍZ
<?php
	//Conectamos a la BD
	require_once("com/abrirConexion.inc.php");

	//Consulta
	$sql = "";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("com/ejecutarSQL.inc.php");

	//Recorremos el resultado fila a fila
	while ($fila = $resultado->fetch_object())
	{
		
?>
		
<?php 
	}

	//Liberamos memoria y desconectamos de la BD
	require_once("com/cerrarConexion.inc.php");
?>

//USU
<?php
	//Conectamos a la BD
	require_once("../com/abrirConexion.inc.php");

	//Consulta
	$sql = "";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("../com/ejecutarSQL.inc.php");

	//Recorremos el resultado fila a fila
	while ($fila = $resultado->fetch_object())
	{
		
?>
		
<?php 
	}

	//Liberamos memoria y desconectamos de la BD
	require_once("../com/cerrarConexion.inc.php");
?>