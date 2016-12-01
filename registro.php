<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "";
	$directorioUsu = "usu/";

	//Funciones requeridas
	include_once("inc/func/mysql/basico.inc.php");
	include_once("inc/func/accesos.inc.php");
	include_once("inc/func/mysql/formularios.inc.php");
 
	//Comprobar si el usuario está logueado para impedir su registro
	impedirRegistro();

	//Titulo de la pagina
	$titulo = "Registro de ususario | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
 ?>
<main class="centrado">
	<section class="encabezado">
		<h1>Registro de usuario</h1>
		<p>Rellene los campos para registrarse en la página.</p>
		<p>Los campos marcados con <strong>(*)</strong> son obligatorios.</p>
	</section>
	<div class="separador"></div>
	<section>
	<?php 
		if (abrirConexion())
		{
			$sql = getSQLPaises();

			if ($resultado = ejecutarSQL($sql))
			{
	?>
				<form action="registroCompleto.php" method="POST" enctype="multipart/form-data">
					<p><label for="nombreUsuario">Nombre de usuario <strong>(*)</strong></label></p>
					<p><input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Escribe tu nombre completo" required/></p>
					<p><label for="pass">Contraseña <strong>(*)</strong></label></p>
					<p><input type="password" name="pass" id="pass" placeholder="Introduce una contraseña" required/></p>
					<p><label for="repetirPass">Repetir contraseña <strong>(*)</strong></label></p>
					<p><input type="password" name="repetirPass" id="repetirPass" placeholder="Repite la contraseña" required/></p>
					<p><label for="email">Dirección de email <strong>(*)</strong></label></p>
					<p><input type="email" name="email" id="email" placeholder="Introduce tu email, recuerda la @" required/></p>
					<p><label for="sexo">Sexo <strong>(*)</strong></label></p>
					<p>
						<select name="sexo" id="sexo">
							<option value="0">Seleccione una opción</option>
							<option value="1">Hombre</option>
							<option value="2">Mujer</option>
							<option value="3">Otro</option>
						</select>
					</p>
					<p><label for="fecha">Fecha de nacimiento <strong>(*)</strong></label></p>
					<p><input type="date" name="fecha" id="fecha" required/></p>
					<?php selectorPais($resultado); ?>
					<p><label for="ciudad">Ciudad de residencia</label></p>
					<p><input type="text" name="ciudad" id="ciudad" placeholder="Ciudad en la que vives actualmente"/></p>
					<p><label for="foto">Foto de perfil</label></p>
					<p><input type="file" name="foto" id="foto"/></p>
					<input type="submit" value="Registarse" />
				</form>
				
	<?php
				cerrarConexion($resultado);
			}

			else
			{
				cerrarConexion();
			}
		}
	?>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>