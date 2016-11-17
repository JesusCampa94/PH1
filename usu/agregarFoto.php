<?php 
	//Declaramos que estamos en /usu
	$dirUsu = true;

	//Controlar acceso a parte privada
	require_once("../inc/func/controlAcceso.inc.php");

	//Titulo de la pagina
	$titulo = "Añadir foto a álbum | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Incluye el inicio de <body> y el encabezado
	require_once("../inc/header_usu.inc");
?>
<main class="centrado">
	<section class="encabezado">
		<h1>Agregar nueva foto</h1>
		<p>Aqui podrás incorporar nuevas imagenes en tus álbumes favoritos.</p>
	</section>
	<div class="separador"></div>
	<section>
		<form action="#" method="POST">
			<p><label for="titulo">Título</label></p>
			<p><input type="text" name="titulo" id="titulo" placeholder="Título del álbum." required/></p>
			<p><label for="fecha">Fecha</label></p>
			<p><input type="date" name="fecha" id="fecha" required/></p>
			<?php
				require_once("../inc/mysql/com/seleccionarPais.inc.php"); 
				require_once("../inc/mysql/com/seleccionarAlbum.inc.php"); 
			?>
			<p><a href="crearAlbum.php">Crea uno nuevo</a></p>
			<p><label for="ficheroFoto">Nueva foto: </label></p>
			<p><input type="file" name="ficheroFoto" id="ficheroFoto"/></p>
			<p><input type="submit" value="Agregar"/></p>
		</form>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>