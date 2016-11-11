<?php
	//Titulo de la pagina
	$titulo = "Registro completo | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Comprueba si el usuario esta logueado para elegir el header
	require_once("inc/func/elegirHeader.inc.php");	

	//Comprobamos que han introducido los campos adecuados
	if (isset($_POST["nombreUsuario"], $_POST["pass"], $_POST["email"], $_POST["sexo"], $_POST["fecha"], $_POST["pais"], $_POST["ciudad"]))//falta comprobar la foto
	{
		//Creamos las variables para guardar los datos del formulario
		$usuario = $_POST["nombreUsuario"];
		$pass = "Eso es secreto";
		$email = $_POST["email"];
		$sexo = $_POST["sexo"];
		$fecha = $_POST["fecha"];
		$pais = $_POST["pais"];
		$ciudad = $_POST["ciudad"];
		$fotoPerfil = "img/users/avatar_Yisus.png";

		//variables que cambiaremos segun los datos del registro
		$h1 = "Registro completado";
		$p = "Resumen de los datos de tu registro, compuebalo todo bien.";
		$correcto = true;
	}

	else
	{
		$h1 = "Algo ocurríó";
		$p = "Deja de intentar hackearme.";
		$correcto = false;
	}
?>
<main class="centrado">
	<section class="encabezado">
		<h1><?php echo $h1;?></h1>
		<p><?php echo $p;?></p>
	</section>
	<?php if($correcto){ ?>
	<div class="separador"></div>
	<section id="datos" class="tarjeta">
		<p><?php echo "<img src='$fotoPerfil' height='128' width='128' alt='Foto perfil' />"; ?></p>
		<p><strong>Nombre de usuario:</strong> <?php echo $usuario;?></p>
		<p><strong>Contraseña:</strong> <?php echo $pass;?></p>
		<p><strong>Dirección de correo:</strong> <?php echo $email;?></p>
		<p><strong>Genero:</strong> <?php echo $sexo;?></p>
		<p><strong>Fecha de nacimiento:</strong> <?php echo $fecha;?></p>
		<p><strong>País de residencia:</strong> <?php echo $pais;?></p>
		<p><strong>Localidad:</strong> <?php echo $ciudad;?></p>
	</section>
	<?php  } ?>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>