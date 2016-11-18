<?php
	//Declaramos que estamos en /usu
	$dirUsu = true;

	//Controlar acceso a parte privada
	require_once("../inc/func/controlAcceso.inc.php");

	//Titulo de la pagina
	$titulo = "Perfil de usuario | Pictures & Images";

	//Estilos a cargar
	$estilos = "";

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
		<?php
			require_once("../inc/mysql/com/funciones.inc.php");
			require_once("../inc/mysql/usu/perfil.inc.php");
		?>
	</section>
	<section id="albumes" class="tarjeta">
		<section class="encabezado">
			<h2>Mis álbumes</h2>
			<p>Consulte y gestione la lista de álbumes vinculados a su cuenta.</p>
		</section>
		<div class="separador"></div>
		<p><a href="misAlbumes.php" class="boton">Lista de Álbumes</a></p>
		<p><a href="crearAlbum.php" class="boton">Crear Álbum</a></p>
		<p><a href="agregarFoto.php" class="boton">Añadir foto a un álbum</a></p>
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