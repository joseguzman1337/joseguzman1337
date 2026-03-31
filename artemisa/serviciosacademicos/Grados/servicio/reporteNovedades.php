<?php
/**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright  Desarrollo Tecnologico
 * @package servicio
 */
 
	include '../lib/pdf/dompdf/dompdf_config.inc.php';
	 
	$contenido  = $_POST['contenido'];	
	$html='
			
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>Documentos digitalizados</title>
					<style>
						tr {
							
						}
					</style>
				 </head>
					<body>'.$contenido.'</body>
			</html>';
	$mipdf = new DOMPDF();
	$mipdf ->set_paper("A4", "portrait");
	$mipdf ->load_html(utf8_decode(utf8_encode( $html )));
	$mipdf ->render();
	$mipdf ->stream('ReporteNovedades.pdf');
?>