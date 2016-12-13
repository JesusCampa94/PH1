<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");
	include_once("../inc/func/mysql/formularios.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = "Modificar datos de ususario | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
 ?>
<main class="centrado">
	<section class="encabezado">
		<h1>Modificar datos de usuario</h1>
		<p>Rellene los campos siguientes para modificar los datos de su cuenta.</p>
		<p>Los campos marcados con <strong>(*)</strong> son obligatorios.</p>
		<p>Por motivos de seguridad, introduzca al final su contraseña actual.</p>
	</section>
	<hr />
	<section>
	<?php 
		if (abrirConexion())
		{
			$sql = getSQLPaises();

			if ($resultadoPaises = ejecutarSQL($sql))
			{
				$sql = getSQLUsuario($_SESSION["userName"]);

				if ($resultadoUsuario = ejecutarSQL($sql))
				{
					$fila = $resultadoUsuario->fetch_object();

					$NomUsuario = $fila->NomUsuario;
					$ClaveUsuario = $fila->ClaveUsuario;
					$EmailUsuario = $fila->EmailUsuario;
					$SexoUsuario = $fila->SexoUsuario;
					$FNacimientoUsuario = $fila->FNacimientoUsuario;
					$CiudadUsuario = $fila->CiudadUsuario;
					$IdPais = $fila->IdPais;
					$NomPais = $fila->NomPais;
					$FotoUsuario = $fila->FotoUsuario;

					$_SESSION["passActual"] = $ClaveUsuario;
	?>
					<form action="modificarDatos_respuesta.php" method="POST" enctype="multipart/form-data">
						<p><label for="nombreUsuario">Nombre de usuario <strong>(*)</strong></label></p>
						<p><input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Escribe tu nombre completo" required <?php echo "value='$NomUsuario'"; ?>/></p>
						<p><label for="email">Dirección de email <strong>(*)</strong></label></p>
						<p><input type="email" name="email" id="email" placeholder="Introduce tu email, recuerda la @" required <?php echo "value='$EmailUsuario'"; ?>/></p>
						<?php selectorSexo($SexoUsuario); ?>
						<p><label for="fecha">Fecha de nacimiento <strong>(*)</strong></label></p>
						<p><input type="date" name="fecha" id="fecha" required <?php echo "value='$FNacimientoUsuario'"; ?>/></p>
						<?php selectorPais($resultadoPaises, $IdPais); ?>
						<p><label for="ciudad">Ciudad de residencia</label></p>
						<p><input type="text" name="ciudad" id="ciudad" placeholder="Ciudad en la que vives actualmente" <?php echo "value='$CiudadUsuario'"; ?>/></p>
						<p><label for="foto">Foto de perfil</label></p>
						<p><input type="file" name="foto" id="foto"/></p>
						<p><a href="perfil.php" class="boton peligro">Borrar foto de perfil</a></p>
						<p><label for="passActual">Contraseña actual</label></p>
						<p><input type="password" name="passActual" id="passActual" placeholder="Introduce tu contraseña actual" required/></p>
						<input type="submit" value="Modificar datos" />
					</form>
				
	<?php
					$resultadoUsuario->close();
				}

				$resultadoPaises->close();
			}

			cerrarConexion();
		}
	?>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>