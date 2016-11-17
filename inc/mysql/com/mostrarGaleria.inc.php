<?php
	$cont = 0;

	//Recorremos el resultado fila a fila
	while ($fila = $resultado->fetch_object())
	{
		$IdFoto = $fila->IdFoto;
		$TituloFoto = $fila->TituloFoto;
		$FechaFoto = $fila->FechaFoto;
		$PaisFoto = nombrePorId("p", $fila->PaisFoto);
		$MiniaturaFoto = $fila->MiniaturaFoto;

		$cont++;
?>
		<a href="foto.php?id=<?php echo $IdFoto; ?>">
			<article>
				<div class="marco"><img src="<?php echo $MiniaturaFoto; ?>" height="225" width="400" alt="Imagen <?php echo $IdFoto; ?>"></div>
				<h3><?php echo $TituloFoto; ?></h3>
				<p><?php echo $FechaFoto; ?></p>
				<p><?php echo $PaisFoto; ?></p>
			</article>
		</a>
<?php 
	}

	if ($cont == 0)
		echo "<p>Aquí no hay nada que ver.</p>";
?>