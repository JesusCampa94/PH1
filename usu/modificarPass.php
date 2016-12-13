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
	$titulo = "Modificar contraseña | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
 ?>
<main class="centrado">
	<section class="encabezado">
		<h1>Modificar contraseña</h1>
		<p>Rellene los campos siguientes para modificar la contraseña asociada a su cuenta.</p>
		<p>Por motivos de seguridad, introduzca al final su contraseña actual.</p>
	</section>
	<hr />
	<section>
	<?php 
		if (abrirConexion())
		{
			$sql = getSQLUsuario($_SESSION["userName"]);

			if ($resultado = ejecutarSQL($sql))
			{
				$fila = $resultado->fetch_object();

				$NomUsuario = $fila->NomUsuario;
				$ClaveUsuario = $fila->ClaveUsuario;
				
				$_SESSION["passActual"] = $ClaveUsuario;
	?>
				<form action="modificarDatos_respuesta.php" method="POST" enctype="multipart/form-data">
					<p><label for="pass">Contraseña nueva</label></p>
					<p><input type="password" name="pass" id="pass" placeholder="Introduce la nueva contraseña" required/></p>
					<p><label for="repetirPass">Repetir contraseña nueva</label></p>
					<p><input type="password" name="repetirPass" id="repetirPass" placeholder="Repite la nueva contraseña" required/></p>
					<p><label for="passActual">Contraseña actual</label></p>
					<p><input type="password" name="passActual" id="passActual" placeholder="Introduce tu contraseña actual" required/></p>
					<input type="submit" value="Cambiar contraseña" />
				</form>
				
	<?php
				$resultado->close();
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