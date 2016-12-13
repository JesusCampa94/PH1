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
	$titulo = "Crear álbum | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
?>
<main class="centrado">
	<section class="encabezado">
		<h1>Crear álbum</h1>
		<p>Rellena los campos para crear un nuevo álbum.</p>
	</section>
	<hr />
	<section>
		<?php
			if (abrirConexion())
			{
				$sql = getSQLPaises();

				if ($resultado = ejecutarSQL($sql))
				{
		?>					
					<form action="crearAlbum_respuesta.php" method="POST">
						<p><label for="titulo">Título</label></p>
						<p><input type="text" name="titulo" id="titulo" placeholder="Título del álbum." required/></p>
						<p><label for="descripcion">Descripción</label></p>
						<p><textarea name="descripcion" id="descripcion" placeholder="Describe brevemente el álbum."></textarea></p>
						<p><label for="fecha">Fecha de creación</label></p>
						<p><input type="date" name="fecha" id="fecha" required value="<?php echo date("Y-m-d");?>"/></p>
						<?php selectorPais($resultado); ?>
						<p><input type="submit" value="Crear"></p>
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
	require_once("../inc/footer.inc");
?>