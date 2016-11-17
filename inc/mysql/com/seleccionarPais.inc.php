<?php
	//Conectamos a la BD
	require_once("abrirConexion.inc.php");

	//Consulta
	$sql = "SELECT IdPais, NomPais FROM paises";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("ejecutarSQL.inc.php");
?>	
	<p><label for="pais">País</label></p>
	<p><select name="pais" id="pais">
		<option value="0">Seleccionar país...</option>
<?php
	//Recorremos el resultado fila a fila
	while ($fila = $resultado->fetch_object())
	{
		$IdPais = $fila->IdPais;
		$NomPais = $fila->NomPais;
?>
	<option value="<?php echo $IdPais; ?>"><?php echo $NomPais; ?></option>
<?php 
	}
	echo "</select></p>";
	//Liberamos memoria y desconectamos de la BD
	require_once("cerrarConexion.inc.php");
?>
