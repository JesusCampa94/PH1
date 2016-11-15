<?php
	//Controlar acceso a parte privada
	require_once("../inc/func/controlAcceso.inc.php");

	//Titulo de la pagina
	$titulo = "Perfil de usuario | Pictures & Images";

	//Estilos a cargar
	$estilos = "";
	$dirUsu = true;

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Incluye el inicio de <body> y el encabezado
	require_once("../inc/header_usu.inc");
 ?>
<main class="centrado">
	<section class="encabezado">
		<h1>Perfil de usuario</h1>
		<p>Aqui encontrarás tus datos personales y otras opciones privadas.</p>
	</section>
	<div class="separador"></div>
	<section id="datos" class="tarjeta">
		<section class="encabezado">
			<h2>Datos personales</h2>
			<p>Estos son los datos personales asociados a su cuenta.</p>
		</section>
		<a href="../foto.php"><img src="../img/users/avatar_Yisus.png" height="128" width="128" alt="Foto perfíl"></a>
		<p><strong>Nombre de usuario: </strong>Yisus</p>
		<p><strong>Sexo: </strong>Hombre</p>
		<p><strong>Fecha de nacimiento: </strong>29/05/1994</p>
		<p><strong>País de residencia: </strong>España</p>
		<p><strong>Localidad: </strong>La Campaneta</p>
	</section>
	<section id="albumes" class="tarjeta">
		<section class="encabezado">
			<h2>Mis álbumes</h2>
			<p>Consulte y gestione la lista de álbumes vinculados a su cuenta.</p>
		</section>
		<h3>Lista de álbumes</h3>
		<ul>
			<li><a href="#">Cosas random</a></li>
			<li><a href="#">Fotos vergonzosas</a></li>
		</ul>
		<p><a href="crearAlbum.php" class="boton">Crear Álbum</a></p>
		<p><a href="solicitarAlbum.php" class="boton">Solicitar Álbum</a></p>
	</section>
	<section id="baja" class="tarjeta">
		<section class="encabezado">
			<h2>Baja</h2>
			<p>Aquí puedes darte de baja. Ten en cuenta que es una acción irrevertible.</p>
		</section>
		<p><a href="../index.php" class="boton peligro">Borrar cuenta</a></p>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>