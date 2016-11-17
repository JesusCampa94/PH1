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

	//Incluimos las funciones
	require_once("../inc/mysql/com/funciones.inc.php");

 	//Obtener parámetros
	if(isset($_GET["IdAlbum"]))
	{
		$IdAlbum = $_GET["IdAlbum"];
 ?>	
		<main>
			<section class="galeria-encabezado">
				<h1>Álbum <?php echo nombrePorId("a", $IdAlbum);?></h1>
			</section>
			<section class="galeria-cuerpo">
				<?php 
					require_once("../inc/mysql/usu/verAlbum.inc.php"); 
				?>
			</section>
		</main>
<?php
	}
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>