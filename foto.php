<?php 
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "";
	$directorioUsu = "usu/";

	//Funciones requeridas
	include_once("inc/func/mysql/basico.inc.php");
	include_once("inc/func/accesos.inc.php");
	include_once("inc/func/mysql/galerias.inc.php");
	
	//Controlar acceso a parte privada
	$err = 3; //Tipo de error
	controlarAcceso();

	//Titulo de la pagina
	$titulo = "Detalle de foto | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
?>
<main>
	<?php
		if (isset($_GET["id"]))
		{
			$id = $_GET["id"];

			if (is_numeric($id))
			{				
				if (abrirConexion())
				{
					$sql = getSQLFoto($id);

					if ($resultado = ejecutarSQL($sql))
					{
						verFoto($resultado);
						cerrarConexion($resultado);
					}

					else
					{
						cerrarConexion();
					}
				}
			}

			else
			{
	?>
				<section class="foto-contenedor">
					<h1>No encontrado</h1>
					<div class="separador"></div>
					<img src="<?php echo 'img/com/error.png'; ?>" width="128" height="128" alt="Imagen $id">
					<section class="foto-info">
						<p>Por favor, limitese a identificadores numéricos.</p>
					</section>
				</section>
	<?php
			}	
		}

		else
		{
	?>
			<section class="foto-contenedor">
				<h1>No encontrado</h1>
				<div class="separador"></div>
				<img src="<?php echo 'img/com/error.png'; ?>" width="128" height="128" alt="Imagen $id">
				<section class="foto-info">
					<p>No se ha recibido el parámetro esperado.</p>
				</section>
			</section>
	<?php
		}
	?>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>