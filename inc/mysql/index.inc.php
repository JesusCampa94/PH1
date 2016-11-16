<?php
	include_once("com/funciones.inc.php");

	//Conectamos a la BD
	require_once("com/abrirConexion.inc.php");

	//Consulta
	$sql = "SELECT IdFoto, TituloFoto, FechaFoto, PaisFoto, MiniaturaFoto FROM fotos ORDER BY FechaFoto DESC LIMIT 5";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("com/ejecutarSQL.inc.php");

	//Recorremos el resultado fila a fila
	while ($fila = $resultado->fetch_object())
	{
		$IdFoto = $fila->IdFoto;
		$TituloFoto = $fila->TituloFoto;
		$FechaFoto = $fila->FechaFoto;
		$PaisFoto = nombrePorId("p", $fila->PaisFoto);
		$MiniaturaFoto = $fila->MiniaturaFoto;
?>
		<a href="foto.php?id=<?php echo $IdFoto; ?>">
			<article>
				<div class="marco"><img src="<?php echo $MiniaturaFoto; ?>" height="225" width="400" alt="Imagen 001"></div>
				<h3><?php echo $TituloFoto; ?></h3>
				<p><?php echo $FechaFoto; ?></p>
				<p><?php echo $PaisFoto; ?></p>
			</article>
		</a>
<?php 
	}

	//Liberamos memoria y desconectamos de la BD
	require_once("com/cerrarConexion.inc.php");
?>

