<?php
	//Conectamos a la BD
	require_once("../inc/mysql/com/abrirConexion.inc.php");

	//Consulta
	$sql = "SELECT NomUsuario, EmailUsuario, SexoUsuario, FNacimientoUsuario, CiudadUsuario, PaisUsuario, FotoUsuario FROM usuarios WHERE NomUsuario = '$usuario'";

	//Ejecutamos la SQL si no da error y la guardamos en $resultado
	require_once("../inc/mysql/com/ejecutarSQL.inc.php");

	//Recuperamos el resultado
	$fila = $resultado->fetch_object();

	$NomUsuario = $fila->NomUsuario;
	$EmailUsuario = $fila->EmailUsuario;
	$SexoUsuario = ($fila->SexoUsuario == 0 ? "Hombre" : ($fila->SexoUsuario == 1 ? "Mujer" : "Otro"));
	$FNacimientoUsuario = date("j/n/Y", strtotime($fila->FNacimientoUsuario));
	$CiudadUsuario = $fila->CiudadUsuario;
	$PaisUsuario = nombrePorId("p", $fila->PaisUsuario);
	$FotoUsuario = $fila->FotoUsuario;
		
?>
	<a href="../foto.php"><img src="../<?php echo $FotoUsuario; ?>" width="128" height="128" alt="Foto perfil"></a>
	<p><strong>Nombre de usuario: </strong><?php echo $NomUsuario; ?></p>
	<p><strong>Email: </strong><?php echo $EmailUsuario; ?></p>
	<p><strong>Sexo: </strong><?php echo $SexoUsuario; ?></p>
	<p><strong>Fecha de nacimiento: </strong><?php echo $FNacimientoUsuario; ?></p>
	<p><strong>País de residencia: </strong><?php echo $PaisUsuario; ?></p>
	<p><strong>Localidad: </strong><?php echo $CiudadUsuario; ?></p>
<?php
	//Liberamos memoria y desconectamos de la BD
	require_once("../inc/mysql/com/cerrarConexion.inc.php");
?>