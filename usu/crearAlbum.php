<?php 
	//Controlar acceso a parte privada
	require_once("../inc/func/controlAcceso.inc.php");

	//Titulo de la pagina
	$titulo = "Crear álbum | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";
	$dirUsu = true;

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Incluye el inicio de <body> y el encabezado
	require_once("../inc/header_usu.inc");
?>
<main class="centrado">
	<section class="encabezado">
		<h1>Crear álbum</h1>
		<p>Rellena los campos para crear un nuevo álbum.</p>
	</section>
	<div class="separador"></div>
	<section>
		<form action="#" method="POST">
			<p><label for="titulo">Título</label></p>
			<p><input type="text" name="titulo" id="titulo" placeholder="Título del álbum." required/></p>
			<p><label for="descripcion">Descripción</label></p>
			<p><textarea name="descripcion" id="descripcion" placeholder="Describe brevemente el álbum."></textarea></p>
			<p><label for="fecha">Fecha</label></p>
			<p><input type="date" name="fecha" id="fecha" required/></p>
			<p><label for="pais">País</label></p>
			<p><input type="text" name="pais" id="pais" placeholder="País mostrado en el álbum." required/></p>
			<p><input type="submit" value="Crear"></p>
		</form>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>