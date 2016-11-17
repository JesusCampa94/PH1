<?php
	require_once("com/funciones.inc.php");

	//Conectamos a la BD
	require_once("com/abrirConexion.inc.php");

	//Obtenemos datos y los saneamos
	$titulo = $mysqli->real_escape_string($_GET["titulo"]);
	$fechaInicio = $mysqli->real_escape_string($_GET["fechaInicio"]);
	$fechaFin = $mysqli->real_escape_string($_GET["fechaFin"]);
	$pais = $mysqli->real_escape_string($_GET["pais"]);

	//Hacemos los parámetros más humanos
	$titulo = ($titulo == "" ? "Cualquier título" : $titulo);
	$fechaInicio = ($fechaInicio == "" ? "El origen de los tiempos" : $fechaInicio);
	$fechaFin = ($fechaFin == "" ? "Actualidad" : $fechaFin);
	$pais = ($pais == "0" ? "Mundial" : $pais);

	//Consulta
	$sql = "SELECT IdFoto, TituloFoto, FechaFoto, PaisFoto, MiniaturaFoto FROM fotos, paises WHERE PaisFoto = IdPais";

	if ($titulo != "Cualquier título")
		$sql .= " AND TituloFoto = '$titulo'";

	if ($fechaInicio != "El origen de los tiempos")
		$sql .= " AND FechaFoto >= '$fechaInicio'";

	if ($fechaFin != "Actualidad")
		$sql .= " AND FechaFoto <= '$fechaFin'";

	if ($pais != "Mundial")
	{
		$sql .= " AND PaisFoto = '$pais'";
		$pais = nombrePorId("p", $pais);
	}

	$sql .= " ORDER BY FechaFoto DESC";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("com/ejecutarSQL.inc.php");
?>