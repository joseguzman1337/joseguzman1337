<?php
if(isset($_REQUEST["action"])){
    include_once("../../../templates/template.php");
    $db = getBD();
    if($_REQUEST["action"]==="getCategories"){
        if(!isset($_REQUEST["tipo"])){
            echo json_encode(array("success"=>true,"data"=>changeCategories($db,$_REQUEST["mes"],$_REQUEST["anio"],$_REQUEST["alias"]))); 
        } else {
             echo json_encode(array("success"=>true,"data"=>changeCategories($db,$_REQUEST["mes"],$_REQUEST["anio"],$_REQUEST["alias"],$_REQUEST["tipo"]))); 
        }
       
    }
}

function changeCategories($db,$mes,$anio,$alias,$tipo=1){
    $date = date( "Y-m-d H:i:s", strtotime( $anio."-".$mes."-01 00:00:00" ) );
    //$periodo = getCurrentPeriodo($db,$date);
    $resultados = false;
    $query2 = getQueryInicial($alias);
    $html = '';
    $exec2= $db->Execute($query2);
			while($row2 = $exec2->FetchRow()) {
                            
                                    
                                    $html .= '<tr class="dataColumns category">';
                                    if($tipo===1){
                                        //DEPORTE Y CULTURA
                                        $html .= '<th colspan="8" class="borderR">'.$row2['clasificacionesinfhuerfana'].'</th>';               
                                    } else if($tipo===2 || $tipo==="2"){
                                        //SALUD
                                        $html .= '<th colspan="7" class="borderR">'.$row2['clasificacionesinfhuerfana'].'</th>';               
                                    }
                                    $html .= '</tr>';
                                    $html .= '<tr class="dataColumns">';
                                            $html .= '<th rowspan="2" class="borderR">Servicio o actividad</th>';               
                                            $html .= '<th colspan="3" class="borderR">Estudiantes</th>';               
                                            $html .= '<th rowspan="2" class="borderR">Docentes</th>';               
                                            $html .= '<th rowspan="2" class="borderR">Administrativos</th>';
                                            if($tipo===1 || $tipo===2 || $tipo==="2"){
                                                $html .= '<th rowspan="2" class="borderR">Familiares</th>';
                                            }
                                            if($tipo===1){
                                                //DEPORTE Y CULTURA
                                                $html .= '<th rowspan="2" class="borderR">Nro. de encuentros o presentaciones oficiales</th>';
                                            }
                                            if($row2['aliasclasificacionesinfhuerfana']=='p_evu_ddbu') {
                                              //VOLUNTARIADO
						$html .= '<th rowspan="2" class="borderR">Beneficiarios comunidad</th>';
						$html .= '<th rowspan="2" class="borderR">Nro. de encuentros o presentaciones oficiales</th>';
                                            }
                                    $html .= '</tr>';
                                    $html .= '<tr class="dataColumns ">';
                                            $html .= '<th>Pregado</th>';               
                                            $html .= '<th>Posgrado</th>';
                                            $html .= '<th class="borderR">Egresados</th>';
                                    $html .= '</tr>';

                                    $query=getQueryCateories($db,$row2['idclasificacionesinfhuerfana'],$date);
                                    //echo $query;
                                    $exec= $db->Execute($query);
                                    while($row = $exec->FetchRow()) {
                                            $resultados = true;
                                            $html .= '<tr id="contentColumns" class="row">';
                                                    $html .= '<td class="column borderR">';
                                                            $html .= '<input type="hidden" name="aux['.$row['idclasificacionesinfhuerfana'].']" value="'.$row['idclasificacionesinfhuerfana'].'">';
                                                            $html .= $row['clasificacionesinfhuerfana'].': <span class="mandatory">(*)</span>';
                                                    $html .= '</td>';
                                                    $html .= '<td class="column" align="center"><input type="text" class="required number" name="pregrado['.$row['idclasificacionesinfhuerfana'].']" id="pregrado['.$row['idclasificacionesinfhuerfana'].']" title="Pregado" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
                                                    $html .= '<td class="column" align="center"><input type="text" class="required number" name="posgrado['.$row['idclasificacionesinfhuerfana'].']" id="posgrado['.$row['idclasificacionesinfhuerfana'].']" title="Posgrado" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
                                                    $html .= '<td class="column borderR" align="center"><input type="text" class="required number" name="egresados['.$row['idclasificacionesinfhuerfana'].']" id="egresados['.$row['idclasificacionesinfhuerfana'].']" title="Egresados" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
                                                    $html .= '<td class="column borderR" align="center"><input type="text" class="required number" name="docentes['.$row['idclasificacionesinfhuerfana'].']" id="docentes['.$row['idclasificacionesinfhuerfana'].']" title="Docentes" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
                                                    $html .= '<td class="column borderR" align="center"><input type="text" class="required number" name="administrativos['.$row['idclasificacionesinfhuerfana'].']" id="administrativos['.$row['idclasificacionesinfhuerfana'].']" title="Administrativos" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
                                                    if($tipo===1 || $tipo===2 || $tipo==="2"){
                                                        $html .= '<td class="column borderR" align="center"><input type="text" class="required number" name="familiares['.$row['idclasificacionesinfhuerfana'].']" id="familiares['.$row['idclasificacionesinfhuerfana'].']" title="Familiares" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
                                                    }
                                                    if($tipo===1){
                                                        //DEPORTE Y CULTURA
                                                        $html .= '<td class="column borderR" align="center"><input type="text" class="required number" name="encuentros['.$row['idclasificacionesinfhuerfana'].']" id="encuentros['.$row['idclasificacionesinfhuerfana'].']" title="Nro. de encuentros o presentaciones oficiales" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
                                                    }
                                                    if($row2['aliasclasificacionesinfhuerfana']=='p_evu_ddbu') {
                                                        //VOLUNTARIADO
							$html .= '<td class="column borderR" align="center"><input type="text" class="required number" name="beneficiarios['.$row['idclasificacionesinfhuerfana'].']" id="beneficiarios['.$row['idclasificacionesinfhuerfana'].']" title="Beneficiarios comunidad" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';
							$html .= '<td class="column " align="center"><input type="text" class="required number" name="encuentros['.$row['idclasificacionesinfhuerfana'].']" id="encuentros['.$row['idclasificacionesinfhuerfana'].']" title="Nro. de encuentros o presentaciones oficiales" maxlength="10" tabindex="1" autocomplete="off" size="6" style="text-align:center" /></td>';

						}
                                              $html .= '</tr>';
                                    }
			}
                        if(!$resultados){
                            $html = "";
                        }
    return $html;
}

function getCurrentPeriodo($db,$date=null){
    if($date===null){
        $date = date('Y-m-d H:i:s');
    } 
    $sql = "SELECT codigoperiodo FROM periodo where fechainicioperiodo<='".$date."' AND fechavencimientoperiodo>='".$date."'";
    $row = $db->GetRow($sql);
    
    return $row["codigoperiodo"];
}

function getQueryCateories($db,$idpadre,$date=null){
    $periodo = getCurrentPeriodo($db,$date);
    
    $query2="select sch.idclasificacionesinfhuerfana,sch.clasificacionesinfhuerfana, periodoInicial, periodoFinal
					from siq_clasificacionesinfhuerfana sch 
                                        inner join siq_periodosClasificacionesinfhuerfana pc on 
                                        pc.idClasificacion=sch.idclasificacionesinfhuerfana 
					where sch.estado=1 and sch.idpadreclasificacionesinfhuerfana='".$idpadre."' AND '".$periodo."'  
                    IN (SELECT codigoperiodo FROM periodo WHERE codigoperiodo>=periodoInicial 
                    AND (codigoperiodo<=periodoFinal OR periodoFinal IS NULL) )";
    
    return $query2;
}

function getQueryInicial($alias){
    
    $query2="select	 sch.clasificacionesinfhuerfana
					,sch.aliasclasificacionesinfhuerfana,
                                        sch.idclasificacionesinfhuerfana
				from siq_clasificacionesinfhuerfana sch
				join (	select idclasificacionesinfhuerfana
					from siq_clasificacionesinfhuerfana 
					where aliasclasificacionesinfhuerfana='".$alias."'
				) sub on sch.idpadreclasificacionesinfhuerfana=sub.idclasificacionesinfhuerfana
				where sch.estado";
    
    return $query2;
}
?>
