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
 ?>

<body>	
	<header>
		<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
				<li><a href="busqueda.php">Búsqueda</a></li>
			</ul>
		</nav>
		<section class="logueado">
			<p>Usuario:<?php echo " $usu "; ?>| Última visita:<?php echo " $fecha "; ?></p>
			<p><a href="usu_perfil.php">Ir al perfil</a><a href="usu_logout.php">Salir</a></p>
		</section>
	</header>
	<div class="marco-dios">