<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");
	include_once("../inc/func/mysql/galerias.inc.php");

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

 	//Obtener parámetros
	if(isset($_GET["IdAlbum"]))
	{
		$IdAlbum = $_GET["IdAlbum"];
 ?>	
<main>
	<section class="galeria-encabezado">
		<h1>Ver fotos del álbum</h1>
	</section>
	<section class="galeria-cuerpo">
		<?php 
			if (abrirConexion())
			{
				$userId = $_SESSION["userId"];
				$sql = "SELECT IdFoto, TituloFoto, FechaFoto, NomPais, MiniaturaFoto FROM fotos, paises, albumes, usuarios WHERE PaisFoto = IdPais AND AlbumFoto = IdAlbum AND IdAlbum = $IdAlbum AND UsuarioAlbum = IdUsuario AND IdUsuario = $userId";

				if ($resultado = ejecutarSQL($sql))
				{
					verFotos($resultado);
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
	}
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>