<?php 
	if (!($resultado = $mysqli->query($sql)))
	{
		echo "<p>Error al ejecutar la sentencia <strong>$sql</strong>: " . $mysqli->error . "</p>";
		exit;
	}
?>