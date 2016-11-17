<?php 
	//Comprobamos si existe sesion o cookie
	if ((isset($_SESSION["usu"]) || isset($_COOKIE["usu"])) && isset($_COOKIE["fecha"]))
	{
		//Mediante sesion
		if (isset($_SESSION["usu"]))
		{
			$usu = $_SESSION["usu"];
		}

		//Mediante cookies
		else
		{
			$usu = $_COOKIE["usu"];			
		}

		$fecha = $_COOKIE["fecha"];
	}

	//Determinamos si estamos en la raiz o en la carpeta /usu para buscar los estilos en la ruta correcta
	$prefijoAPublico = "";
	$prefijoAUsu = "usu/";

	if (isset($dirUsu))
	{
		$prefijoAPublico = "../";
		$prefijoAUsu = "";
	}
 ?>

<body>	
	<header>
		<nav>
			<ul>
				<li><a href="<?php echo $prefijoAPublico; ?>index.php">Inicio</a></li>
				<li><a href="<?php echo $prefijoAPublico; ?>busqueda.php">Búsqueda</a></li>
			</ul>
		</nav>
		<section class="logueado">
			<p>Usuario:<?php echo " $usu "; ?>| Última visita:<?php echo " $fecha "; ?></p>
			<p><a href="<?php echo $prefijoAUsu; ?>perfil.php">Ir al perfil</a><a href="<?php echo $prefijoAUsu; ?>logout.php">Salir</a></p>
		</section>
	</header>
	<div class="marco-dios">