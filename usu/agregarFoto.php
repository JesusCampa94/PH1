<?php 
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");
	include_once("../inc/func/mysql/formularios.inc.php");
	
	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = "Añadir foto a álbum | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
?>
<main class="centrado">
	<section class="encabezado">
		<h1>Agregar nueva foto</h1>
		<p>Aqui podrás incorporar nuevas imagenes en tus álbumes favoritos.</p>
	</section>
	<hr />
	<section>
		<?php
			if (abrirConexion())
			{
				$sql = getSQLPaises();

				if ($resultadoPaises = ejecutarSQL($sql))
				{
					$sql = getSQLAlbumes($_SESSION["userId"]);

					if ($resultadoAlbumes = ejecutarSQL($sql))
					{
		?>
						<form action="agregarFoto_respuesta.php" method="POST" enctype="multipart/form-data">
							<p><label for="titulo">Título</label></p>
							<p><input type="text" name="titulo" id="titulo" placeholder="Título de la foto..." required/></p>
							<p><label for="descripcion">Descripción</label></p>
							<p><textarea name="descripcion" id="descripcion" placeholder="Escribe una breve descripción de la foto..."></textarea></p>
							<p><label for="fecha">Fecha</label></p>
							<p><input type="date" name="fecha" id="fecha" required/></p>
							<?php
								selectorPais($resultadoPaises); 
								selectorAlbum($resultadoAlbumes); 
							?>
							<p><a href="crearAlbum.php">Crea uno nuevo</a></p>
							<p><label for="ficheroFoto">Nueva foto: </label></p>
							<p><input type="file" name="ficheroFoto" id="ficheroFoto"/></p>
							<p><input type="submit" value="Agregar"/></p>
						</form>
		<?php
						$resultadoAlbumes->close();
					}

					$resultadoPaises->close();
				}

				cerrarConexion();	
			}		
		?>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>