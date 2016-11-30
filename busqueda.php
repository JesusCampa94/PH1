<?php 
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "";
	$directorioUsu = "usu/";

	//Funciones requeridas
	include_once("inc/func/mysql/basico.inc.php");
	include_once("inc/func/accesos.inc.php");
	include_once("inc/func/mysql/formularios.inc.php");

	//Titulo de la pagina
	$titulo = "Búsqueda de imágenes | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
 ?>
<main class="centrado">
	<section class="encabezado">
		<h1>Búsqueda de fotos</h1>
		<p>En ésta página puede buscar fotos de acuerdo a los criterios especificados.</p>
	</section>
	<div class="separador"></div>
	<section>
		<?php 
			if (abrirConexion())
			{
				$sql = getSQLPaises();

				if ($resultado = ejecutarSQL($sql))
				{
		?>
					<form action="busqueda_resultado.php">
						<p><label for="titulo">Título</label></p>
						<p><input type="text" name="titulo" id="titulo" placeholder="Título de la imagen a buscar"/></p>
						<p><label for="fechaInicio">fecha entre: </label></p>
						<p>
							<input type="date" name="fechaInicio" id="fechaInicio" />
							<label for="fechaFin">y: </label>
							<input type="date" name="fechaFin" id="fechaFin" />
						</p>
						<?php selectorPais($resultado); ?>
						<input type="submit" value="Buscar" />
					</form>
		<?php
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
	require_once("inc/footer.inc");
?>