<?php
	session_start;
/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
    include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = getBD();
    
    $data = array();
	$dataDetalle = array();
	$modalidad = array();
    $tipo = array();
    $materia = array();
	$id = "";
	
    if(isset($_REQUEST["id"])){  
	   $id = $_REQUEST["id"];
	   $utils = Utils::getInstance();
       $data = $utils->getDataEntity("carrera", $id, "codigocarrera");  
       $dataDetalle = $utils->getDataEntity("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera");
       $dataPlantilla = $utils->getDataEntityActive("plantillaCursoEducacionContinuada", $data["codigocarrera"],"codigocarrera");
		if($dataDetalle!=null && count($dataDetalle)>1){	   
		   $modalidad = $utils->getDataEntity("modalidadCertificacionEducacionContinuada", $dataDetalle["modalidadCertificacion"], "idmodalidadCertificacionEducacionContinuada"); 
		   if($dataDetalle["tipoCertificacion"]==3){
				$materia = $utils->getDataEntity("materia", $dataDetalle["codigocarrera"], "codigocarrera"); 
		   }
		   $tipo = $utils->getDataEntity("tipoCertificacionEducacionContinuada", $dataDetalle["tipoCertificacion"], "idtipoCertificacionEducacionContinuada"); 
	   }
   }
?>

				<div id="tabs-3">
					<h4>Ver Detalle Programa de Educación Continuada</h4>
						<table class="detalle">
							<tr>
								<th>Código:</th>
								<td><?php echo $data['codigocarrera']; ?></td>
								<th>Nombre:</th>
								<td><?php echo $data['nombrecarrera']; ?></td>
							</tr>
							<tr>
								<th>Modalidad:</th>
								<td><?php echo $modalidad['nombre']; if($dataDetalle["tipoCertificacion"]==3){ echo " ( ".$materia["numerocreditos"]." créditos ) "; } ?></td>
								<th>Tipo:</th>
								<td><?php echo $tipo['nombre']; ?></td>
							</tr>            
						</table>
				</div>

	<input type="button" value="<?php if($id!=="" && count($dataPlantilla)>0) { echo "Editar plantilla certificado"; } else { echo "Generar plantilla del certificado para este curso"; } ?>" id="generarPlantilla" class="first small buttonForm"/>

        <script type="text/javascript">
	
	$('#generarPlantilla').click( function () {
            popup_carga("<?php echo "../certificados/plantillaCertificados.php?curso=".$data["codigocarrera"]; ?>");
        });
    
</script>