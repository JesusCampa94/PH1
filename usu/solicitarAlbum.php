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

				if ($resultadoPaises = ejecutarSQL($sql))
				{
					//Recuperamos datos la ultima solicitud del usuario para ayudarle autorellenando algunos campos
					$ultima = ultimaSolicitud($_SESSION["userId"]);
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
							<p><input type="text" name="nombre" id="nombre" placeholder="Escribe tu nombre completo" required <?php echo "value='$ultima->NombreSolicitud'"; ?>/></p>
							<p><label for="titulo_solicitud">Título de la solicitud <strong>(*)</strong></label></p>
							<p><input type="text" name="titulo_solicitud" id="titulo_solicitud" placeholder="Ponle un título a la solicitud" required <?php echo "value='$ultima->TituloSolicitud'"; ?>/></p>
							<p><label for="comentario">Comentario</label></p>
							<p><textarea name="comentario" id="comentario" placeholder="Escribe información adicional como una descripción, dedicatorias..."><?php echo "$ultima->DescripcionSolicitud"; ?></textarea></p>
							<p><label for="email">Email <strong>(*)</strong></label></p>
							<p><input type="email" name="email" id="email" placeholder="Introduce tu email" required <?php echo "value='$ultima->EmailSolicitud'"; ?>/></p>
							<p><label for="direccion_calle">Dirección  <strong>(*)</strong></label></p>
							<p>
								<input type="text" name="direccion_calle" id="direccion_calle" placeholder="Calle" <?php echo "value='$ultima->DireccionCalle'"; ?> required/>
								<input type="number" name="direccion_numero" id="direccion_numero" placeholder="Número" <?php echo "value='$ultima->DireccionNumero'"; ?> required/>
								<input type="text" name="direccion_CP" id="direccion_CP" pattern="[0-9]{5}" placeholder="Código Postal" <?php echo "value='$ultima->DireccionCP'"; ?> required/>
								<input type="text" name="direccion_localidad" id="direccion_localidad" placeholder="Localidad" <?php echo "value='$ultima->DireccionLocalidad'"; ?> required/>
								<input type="text" name="direccion_provincia" id="direccion_provincia" placeholder="Provincia" <?php echo "value='$ultima->DireccionProvincia'"; ?> required/>
							</p>
							<p><label for="telefono">Teléfono  <strong>(*)</strong></label></p>
							<p><input type="tel" name="telefono" id="telefono" placeholder="Teléfono de contacto" <?php echo "value='$ultima->TelefonoSolicitud'"; ?>/></p>
							<p><label for="color_portada">Color de la portada</label></p>
							<p><input type="color" name="color_portada" id="color_portada" <?php echo "value='$ultima->ColorSolicitud'"; ?>/></p>
							<p><label for="copias">Numero de copias</label></p>
							<p><input type="number" min="1" name="copias" id="copias" placeholder="Elija cantidad" <?php echo "value='$ultima->CopiasSolicitud'"; ?> required/></p>
							<p><label for="resolucion">Resolución</label></p>
							<p><input type="number" min="150" max="900" step="150" name="resolucion" id="resolucion" <?php echo "value='$ultima->ResolucionSolicitud'"; ?>/> dpi</p>
							<?php selectorAlbum($resultadoPaises, $ultima->AlbumSolicitud); ?>
							<p><label for="fecha-recepcion">Fecha de recepción  <strong>(*)</strong></label></p>
							<p><input type="date" name="fecha-recepcion" id="fecha-recepcion" <?php echo "value='$ultima->FechaSolicitud'"; ?> required/></p>
							<p><label for="radio_bw">Modo de impresión  <strong>(*)</strong></label></p>
							<p>
								<input type="radio" name="bw_cmyk" value="0" id="radio_bw" <?php echo "$ultima->BlancoNegro"; ?>><label for="radio_bw">Blanco y Negro</label>
								<input type="radio" name="bw_cmyk" value="1" id="radio_cmyk" <?php echo "$ultima->EnColor"; ?>><label for="radio_cmyk">Color</label>
							</p>
							<p><input type="submit" value="Solicitar"></p>
						</form>
					</section>		
		<?php
					$resultadoPaises->close();
				}

				cerrarConexion();
			}
		?>
	</section>
</main>
<?php
	//Footer y cierre de etiquetas </body> y </html> 
	require_once("../inc/footer.inc");
?>