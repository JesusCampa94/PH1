<?php
	//Declaramos que estamos en /usu
	$dirUsu = true;

	//Controlar acceso a parte privada
	require_once("../inc/func/controlAcceso.inc.php");

	//Titulo de la pagina
	$titulo = "Mis Álbumes | Pictures & Images";

	//Estilos a cargar
	$estilos = "g";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Incluye el inicio de <body> y el encabezado
	require_once("../inc/header_usu.inc");
 ?>
<main>
	<section class="galeria-encabezado">
		<h1>Álbumes personales de <?php echo $usuario;?></h1>
		<p>Aqui encontrarás un listado de tus álbumes.</p>
	</section>
	<section class="galeria-cuerpo">
		<?php 
			require_once("../inc/mysql/com/funciones.inc.php");
			require_once("../inc/mysql/usu/misAlbumes.inc.php"); 
		?>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>