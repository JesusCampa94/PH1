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
	$titulo = "Solicitar álbum impreso | Pictures & Images";

	//Estilos a cargar
	$estilos = "f";

	//Incluye el DOCTYPE, la etiqueta de inicio de <html> y el <head> (formado con los parametros de arriba)
	require_once("../inc/head.inc");

	//Elegir header en funcion de si el usuario esta logueado
	require_once(elegirHeader());
 ?>
<main>
	<section class="encabezado">
		<h1>Solicitar álbum impreso</h1>
		<p>En esta página el usuario puede solicitar el envío de uno de sus álbumes en formato impreso a la dirección que especifique.</p>
	</section>
	<div class="separador"></div>
	<section class="solicitud-y-tabla">
		<?php 
			if (abrirConexion())
			{
				$sql = getSQLAlbumes($_SESSION["userId"]);

				if ($resultado = ejecutarSQL($sql))
				{
		?>
					<aside>
						<section class="encabezado">
							<h2>Precios</h2>
							<p>Precio de las distintas opciones de impresión.</p>						
						</section>
						<table>
							<thead>
								<tr>
									<th>Concepto</th>
									<th>Tarifa</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Menos de 5 páginas</td>
									<td>0,10 €/página</td>
								</tr>
								<tr>
									<td>De 5 a 10 páginas</td>
									<td>0,08 €/página</td>
								</tr>
								<tr>
									<td>Más de 10 páginas</td>
									<td>0,07 €/página</td>
								</tr>
								<tr>
									<td>Blanco y Negro</td>
									<td>0,00 €/foto</td>
								</tr>
								<tr>
									<td>Color</td>
									<td>0,05 €/foto</td>
								</tr>
								<tr>
									<td>Resolución mayor que 300dpi</td>
									<td>0,02 €/foto</td>
								</tr>
							</tbody>
						</table>
					</aside>
					<section>
						<section class="encabezado">
							<h2>Formulario de solicitud</h2>
							<p>Rellena el siguiente formulario para especificar los detalles del envío.</p>
							<p><em>NOTAS: La fecha de recepcion es aproximada. Los campos marcados con <strong>(*)</strong> son obligatorios.</em></p>
						</section>
						<form action="solicitarAlbum_respuesta.php" method="POST">
							<p><label for="nombre">Nombre <strong>(*)</strong></label></p>
							<p><input type="text" name="nombre" id="nombre" placeholder="Escribe tu nombre completo" required/></p>
							<p><label for="titulo_album">Título del álbum <strong>(*)</strong></label></p>
							<p><input type="text" name="titulo_album" id="titulo_album" placeholder="Ponle un título del álbum" required/></p>
							<p><label for="comentario">Comentario</label></p>
							<p><textarea name="comentario" id="comentario" placeholder="Escribe información adicional como una descripción, dedicatorias..."></textarea></p>
							<p><label for="email">Email <strong>(*)</strong></label></p>
							<p><input type="email" name="email" id="email" placeholder="Introduce tu email" required/></p>
							<p><label for="direccion_calle">Dirección</label></p>
							<p>
								<input type="text" name="direccion_calle" id="direccion_calle" placeholder="Calle"/>
								<input type="number" name="direccion_numero" id="direccion_numero" placeholder="Número"/>
								<input type="text" name="direccion_CP" id="direccion_CP" pattern="[0-9]{5}" placeholder="Código Postal"/>
								<select name="direccion_localidad" id="direccion_localidad">
									<option>Localidad</option>
									<option>La Campaneta</option>
									<option>Callosa de Segura</option>
								</select>
								<select name="direccion_provincia" id="direccion_provincia">
									<option>Provincia</option>
									<option>Alicante</option>
									<option>Valencia</option>
								</select>
							</p>
							<p><label for="telefono">Teléfono</label></p>
							<p><input type="tel" name="telefono" id="telefono" placeholder="Teléfono de contacto"/></p>
							<p><label for="color_portada">Color de la portada</label></p>
							<p><input type="color" name="color_portada" id="color_portada"/></p>
							<p><label for="copias">Numero de copias</label></p>
							<p><input type="number" min="1" name="copias" id="copias" placeholder="Elija cantidad"/></p>
							<p><label for="resolucion">Resolución</label></p>
							<p><input type="number" min="150" max="900" step="150" value="150" name="resolucion" id="resolucion" /> dpi</p>
							<?php selectorAlbum($resultado); ?>
							<p><label for="fecha-recepcion">Fecha de recepción</label></p>
							<p><input type="date" name="fecha-recepcion" id="fecha-recepcion"/></p>
							<p><label for="radio_bw">Modo de impresión</label></p>
							<p>
								<input type="radio" name="bw_cmyk" value="blanco/negro" id="radio_bw"><label for="radio_bw">Blanco y Negro</label>
								<input type="radio" name="bw_cmyk" value="color" id="radio_cmyk"><label for="radio_cmyk">Color</label>
							</p>
							<p><input type="submit" value="Solicitar"></p>
						</form>
					</section>		
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