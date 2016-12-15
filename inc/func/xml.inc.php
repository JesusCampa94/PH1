<?php
	//Array con posibles razones de elección de fotos
	

	//Lee un archivo XML
	function leerXML($archivo)
	{
		if (file_exists($archivo))
		{
			$xml = simplexml_load_file($archivo);

			//print_r($xml);
			//echo "<p>$xml->id, $xml->url, $xml->com</p>";
		}
	}

	//Genera un fichero XML
	function generarXML($archivo)
	{

	}
?>