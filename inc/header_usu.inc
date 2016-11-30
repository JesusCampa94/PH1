<?php
	$userName = $_SESSION["userName"];
	$fecha = $_COOKIE["fecha"];
?>

<body>	
	<header>
		<nav>
			<ul>
				<li><a href="<?php echo $directorioRaiz; ?>index.php">Inicio</a></li>
				<li><a href="<?php echo $directorioRaiz; ?>busqueda.php">Búsqueda</a></li>
			</ul>
		</nav>
		<section class="logueado">
			<p>Usuario:<?php echo " $userName "; ?>| Última visita:<?php echo " $fecha "; ?></p>
			<p><a href="<?php echo $directorioUsu; ?>perfil.php">Ir al perfil</a><a href="<?php echo $directorioUsu; ?>logout.php">Salir</a></p>
		</section>
	</header>
	<div class="marco-dios">