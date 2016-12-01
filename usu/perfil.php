<?php
	//Variables globales
	$conexionBD = null;
	$directorioRaiz = "../";
	$directorioUsu = "";

	//Funciones requeridas
	include_once("../inc/func/mysql/basico.inc.php");
	include_once("../inc/func/accesos.inc.php");

	//Controlar acceso a parte privada
	controlarAcceso();

	//Titulo de la pagina
	$titulo = "Perfil de usuario | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());	

	if (isset($_GET["err"]))
	{
		if ($_GET["err"] == 4)
		{
			require_once("../inc/aviso_registrado.inc");
		}

		else if ($_GET["err"] == 5)
		{
			require_once("../inc/aviso_baja1.inc");
		}

		else if ($_GET["err"] == 6)
		{
			require_once("../inc/aviso_baja2.inc");
		}
	}
 ?>
<main class="centrado">
	<section class="encabezado">
		<h1>Perfil de usuario</h1>
		<p>Aqui encontrarás tus datos personales y otras opciones privadas.</p>
	</section>
	<div class="separador"></div>
	<section id="datos" class="tarjeta">
		<section class="encabezado">
			<h2>Datos personales</h2>
			<p>Estos son los datos personales asociados a su cuenta.</p>
		</section>
		<div class="separador"></div>
		<?php
			if (abrirConexion())
			{
				$sql = getSQLUsuario($_SESSION["userName"]);

				if ($resultado = ejecutarSQL($sql))
				{
					mostrarDatos($resultado);
					cerrarConexion($resultado);
				}

				else
				{
					cerrarConexion();
				}
			}
		?>
		<a href="modificarDatos.php" class="boton">Modificar datos de cuenta</a>
		<a href="modificarPass.php" class="boton">Cambiar contraseña</a>
	</section>
	<section id="albumes" class="tarjeta">
		<section class="encabezado">
			<h2>Mis álbumes</h2>
			<p>Consulte y gestione la lista de álbumes vinculados a su cuenta.</p>
		</section>
		<div class="separador"></div>
		<p><a href="misAlbumes.php" class="boton">Lista de Álbumes</a></p>
		<p><a href="crearAlbum.php" class="boton">Crear Álbum</a></p>
		<p><a href="agregarFoto.php" class="boton">Añadir foto a un álbum</a></p>
		<p><a href="solicitarAlbum.php" class="boton">Solicitar Álbum</a></p>
	</section>
	<section id="baja" class="tarjeta">
		<section class="encabezado">
			<h2>Baja</h2>
			<p>Aquí puedes darte de baja. Ten en cuenta que es una acción irrevertible.</p>
		</section>
		<div class="separador"></div>
		<p><a href="perfil.php?err=5" class="boton peligro">Borrar cuenta</a></p>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>