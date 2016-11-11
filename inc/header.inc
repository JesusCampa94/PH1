<body>	
	<header>
		<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
				<li><a href="busqueda.php">Búsqueda</a></li>
				<li><a href="registro.php">Registrarse</a></li>
			</ul>
		</nav>
		<section class="iniciar-sesion">				
			<p><a href="#login">Iniciar sesión</a></p>
		</section>
	</header>
	<div id="login">
		<aside class="login-contenedor">
			<a href="#">Cerrar</a>
			<section class="encabezado">
				<h2>Login</h2>
				<p>Introduzca sus datos para iniciar sesión.</p>
			</section>
			<form action="usu_controlAcceso.php" method="POST">
				<p><label for="usuario">Usuario</label></p>
				<p><input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario o email" required/></p>
				<p><label for="pass">Contraseña</label></p>
				<p><input type="password" name="pass" id="pass" placeholder="Introduce tu contraseña" required/></p>
				<P><input type="checkbox" name="recordar" id="recordar" value="recordar"><label for="recordar">No me olvides nunca</label></P>
				<p><input type="submit" value="Iniciar sesión" /></p>
			</form>
		</aside>
	</div>
	<div class="marco-dios">