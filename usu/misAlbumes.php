<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/mysql/galerias.inc.php");
	include_once("../inc/func/accesos.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = "Mis Álbumes | Pictures & Images";

	//Estilos a cargar
	$estilos = "g";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
 ?>
<main>
	<section class="galeria-encabezado">
		<h1>Álbumes personales de <?php echo $_SESSION["userName"];?></h1>
		<p>Aqui encontrarás un listado de tus álbumes.</p>
	</section>
	<section class="galeria-cuerpo">
		<?php
			if (abrirConexion())
			{
				$userId = $_SESSION["userId"];
				$sql = "SELECT IdAlbum, TituloAlbum, DescripcionAlbum FROM albumes WHERE usuarioAlbum = $userId";

				if ($resultado = ejecutarSQL($sql))
				{
					verAlbumes($resultado);
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
	require_once("../inc/footer.inc");
?>