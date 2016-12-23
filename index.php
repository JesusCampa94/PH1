<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "";
	$directorioUsu = "usu/";

	//Funciones requeridas
	include_once("inc/func/mysql/basico.inc.php");
	include_once("inc/func/accesos.inc.php");
	include_once("inc/func/mysql/galerias.inc.php");
	include_once("inc/func/ficheros.inc.php");

	//Titulo de la pagina
	$titulo = "Inicio | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";
	
	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());

	if (isset($_GET["err"]))
	{
		if ($_GET["err"] == 1)
		{
			require_once("inc/aviso_login.inc");
		}

		else if ($_GET["err"] == 2)
		{
			require_once("inc/aviso_antihack.inc");
		}

		else if ($_GET["err"] == 3)
		{
			require_once("inc/aviso_fotos.inc");
		}

		unset($_GET["err"]);
	}
?>
<main>
	<h1>PI - Pictures and Images</h1>
	<section>
		<section class="galeria-encabezado"><h2>Foto destacada</h2></section>
		<hr />
		<?php leerXML("destacada.xml"); ?>	
		<section class="galeria-encabezado"><h2>Últimas fotos</h2></section>
		<hr />
		<section class="galeria-cuerpo">				
			<?php 
				if (abrirConexion())
				{
					$sql = "SELECT IdFoto, TituloFoto, FechaFoto, NomPais, MiniaturaFoto FROM fotos, paises, albumes WHERE PaisFoto = IdPais AND AlbumFoto = IdAlbum ORDER BY FechaFoto DESC LIMIT 5";

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
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>