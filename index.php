<?php 
	//Titulo de la pagina
	$titulo = "Inicio | Pictures & Images";

	//Estilos a cargar
	$estilos = "fg";

	
	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("inc/head.inc");

	//Comprueba si el usuario esta logueado para elegir el header
	require_once("inc/func/elegirHeader.inc.php");	

	if (isset($_GET["err"]))
	{
		if ($_GET["err"] == 1)
		{
			require_once("inc/aviso_login.inc");
		}

		else if ($_GET["err"] == 2)
		{
			require_once("inc/aviso_antihack.inc");
		}

		else if ($_GET["err"] == 3)
		{
			require_once("inc/aviso_fotos.inc");
		}

		unset($_GET["err"]);
	}
?>
<main>
	<h1>PI - Pictures and Images</h1>
	<section>
		<section class="galeria-encabezado"><h2>Últimas fotos</h2></section>
		<section class="galeria-cuerpo">				
			<a href="foto.php?id=1">
				<article>
					<div class="marco"><img src="img/thumb/001.jpg" height="225" width="400" alt="Imagen 001"></div>
					<h3>Panda</h3>
					<p>28/09/2016</p>
					<p>China</p>
				</article>
			</a>
			<a href="foto.php?id=2">
				<article>
					<div class="marco"><img src="img/thumb/002.jpg" height="225" width="400" alt="Imagen 002"></div>
					<h3>Pato</h3>
					<p>27/09/2016</p>
					<p>España</p>
				</article>
			</a>
			<a href="foto.php?id=3">
				<article>
					<div class="marco"><img src="img/thumb/003.jpg" height="225" width="400" alt="Imagen 003"></div>
					<h3>Tiburón</h3>
					<p>28/08/2016</p>
					<p>México</p>
				</article>
			</a>
			<a href="foto.php?id=4">
				<article>
					<div class="marco"><img src="img/thumb/004.jpg" height="225" width="400" alt="Imagen 004"></div>
					<h3>Tigre</h3>
					<p>25/08/2016</p>
					<p>Brasil</p>
				</article>
			</a>
			<a href="foto.php?id=5">
				<article>
					<div class="marco"><img src="img/thumb/005.jpg" height="225" width="400" alt="Imagen 005"></div>
					<h3>Tortuga marina</h3>
					<p>21/07/2016</p>
					<p>EE.UU</p>
				</article>
			</a>
		</section>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("inc/footer.inc");
?>