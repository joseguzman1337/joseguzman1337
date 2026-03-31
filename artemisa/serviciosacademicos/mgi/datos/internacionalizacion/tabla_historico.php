<?
if($db==null){

require_once("../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

}

		$query_historial = "select es.idestudiantesituacionmovilidad,es.idsituacionmovilidad, s.nombre,es.periodoinicial,es.periodofinal,s.descripcion 
		  from estudiantesituacionmovilidad es, situacionmovilidad s
		  where es.idsituacionmovilidad=s.idsituacionmovilidad
		  and es.codigoestudiante='".$_REQUEST['codigoestudiante']."'
		  and es.codigoestado =100";
		$historial = $db->Execute($query_historial);
		$totalRows_historial= $historial->RecordCount();
		$row_historial = $historial->FetchRow();
		
		$html='';
		
		if ($totalRows_historial >0){ 		
		
		$html='<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:70%">';
		  $html.='<thead>';            
		    $html.='<tr class="dataColumns">';
		      $html.='<th class="column" colspan="5"><span>Historico del Estudiante</span></th>';
		    $html.='</tr>';
		    $html.='<tr class="dataColumns">';
		      $html.='<th align="center">Tipo Situación</th>';
		      $html.='<th align="center">Periodo Inicio</th>';	
		      $html.='<th align="center">Periodo Finalización</th>';                    
		      $html.='<th align="center">Descripción Situación</th>';
		      $html.='<th align="center">Modificar/Eliminar';
		    $html.='</tr>';
		  $html.='</thead>';
		  $html.='<tbody>';
		                    
		    do { 
		    
		    $html.='<tr class="contentColumns" class="row">';
			$html.='<TD align="left" class="column">'.$row_historial['nombre'].'</TD>';
			$html.='<TD class="column" align="left">'.$row_historial['periodoinicial'].'</TD>';
			$html.='<TD class="column" align="left">'.$row_historial['periodofinal'].'</TD>';                    
			$html.='<TD class="column" align="left">'.$row_historial['descripcion'].'</TD>';
			$html.='<TD class="column" align="center"><img src="../../images/Pencil3_Edit.png" alt="Editar" width="12%" style="cursor:pointer" onclick="modificar_dato('.$row_historial['idestudiantesituacionmovilidad'].')">&nbsp;&nbsp;&nbsp;<img src="../../images/delete.png" alt="Eliminar" style="cursor:pointer" width="12%" onclick="eliminar_dato('.$row_historial['idestudiantesituacionmovilidad'].')"></TD>';
		    $html.='</tr>';		  
		    } while($row_historial = $historial->FetchRow());		  
		  $html.='</tbody>';
		$html.='</table>';                
                }
                else{
                
                $html='<div id="sinDatos" class="msg-success msg-error"><span style="font-style:italic; color:black">Actualmente el estudiante no tiene información histórica de Movilidad</span></div>';                
                }
                
                echo $html;
                
                ?>         