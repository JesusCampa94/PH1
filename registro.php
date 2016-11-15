<?php 
	//Comprobar si el usuario está logueado para impedir su registro
	require_once("inc/func/impedirRegistro.inc.php");

	//Titulo de la pagina
	$titulo = "Registro de ususario | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Incluye el inicio de <body> y el encabezado
	require_once("inc/header.inc");
 ?>
<main class="centrado">
	<section class="encabezado">
		<h1>Registro de usuario</h1>
		<p>Rellene los campos para registrarse en la página.</p>
	</section>
	<div class="separador"></div>
	<section>
		<form action="registroCompleto.php" method="POST" enctype="multipart/form-data">
			<p><label for="nombreUsuario">Nombre de usuario <strong>(*)</strong></label></p>
			<p><input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Escribe tu nombre completo" required/></p>
			<p><label for="pass">Contraseña <strong>(*)</strong></label></p>
			<p><input type="password" name="pass" id="pass" placeholder="Introduce una contraseña" required/></p>
			<p><label for="repetirPass">Repetir contraseña <strong>(*)</strong></label></p>
			<p><input type="password" name="repetirPass" id="repetirPass" placeholder="Repite la contraseña" required/></p>
			<p><label for="email">Dirección de email <strong>(*)</strong></label></p>
			<p><input type="email" name="email" id="email" placeholder="Introduce tu email, recuerda la @" required/></p>
			<p><label for="sexo">Sexo</label></p>
			<p>
				<select name="sexo" id="sexo">
					<option value="elegir">Seleccione una opción</option>
					<option value="Hombre">Hombre</option>
					<option value="Mujer">Mujer</option>
					<option value="Otro">Otro</option>
				</select>
			</p>
			<p><label for="fecha">Fecha de nacimiento <strong>(*)</strong></label></p>
			<p><input type="date" name="fecha" id="fecha" required/></p>
			<p><label for="pais">País de residencia</label></p>
			<p><input type="text" name="pais" id="pais" placeholder="País en el que vives actualmente"/></p>
			<p><label for="ciudad">Ciudad de residencia</label></p>
			<p><input type="text" name="ciudad" id="ciudad" placeholder="Ciudad en la que vives actualmente"/></p>
			<p><label for="foto">Foto de perfil</label></p>
			<p><input type="file" name="foto" id="foto"/></p>
			<input type="submit" value="Registarse" />
		</form>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>