<?php 
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
if(empty($_REQUEST['id'])){
    require_once("../../../templates/template.php");
       $db = getBD();
    $utils = new Utils_datos();
    $url='../reportes/reportes/docentes/viewReporteNumeroAcademicosCNAPorEstudio.php';
}else{
    $url='reportes/docentes/viewReporteNumeroAcademicosCNAPorEstudio.php';
}
$tipo=2;

if(empty($_REQUEST["mes"]) && empty($_REQUEST["anio"])) {
?>
<form action="" method="post" id="forma4" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <input type="button" value="Consultar" id="consul_report_bnfor4" class="first small" />
		<!--<input type="submit" value="Consultar" class="first small" />-->
		
	</fieldset>
</form>
<div id='respuesta_forma4'></div>
<?php 
}

if(isset($_REQUEST["mes"]) && isset($_REQUEST["anio"])) { 
    $periodos=$_REQUEST["codigoperiodo"]=$_REQUEST["mes"].'-'.$_REQUEST["anio"];
    //$periodos = $utils->getMesesPeriodo($db,$_REQUEST["codigoperiodo"]);
    $nivelFormacion  = $utils->getAll($db,"siq_tipoNivelFormacion","actividad=2 AND codigoestado=100","orden");
    $nivelFormacion1  = $utils->getAll($db,"siq_tipoNivelFormacion","actividad=2 AND codigoestado=100","orden");
    
    while ($rowT = $nivelFormacion1->FetchRow()) { 
     $sqlT="SELECT * FROM siq_detalleformTalentoHumanoDedicacionSemanalCNA 
      INNER JOIN siq_formTalentoHumanoDedicacionSemanalCNA on (idsiq_formTalentoHumanoDedicacionSemanalCNA=idData)
      WHERE idCategory='".$rowT["idsiq_tipoNivelFormacion"]."' and codigoperiodo='".$periodos."' ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
     //echo $sqlT;
     $rowT = $db->GetRow($sqlT);
     $T1_4=$T1_4+$rowT["tiempo1h"];
     $T1_2=$T1_2+$rowT["tiempo1_2"];
     $Tcompleto=$Tcompleto+$rowT["tiempocompleto"];
   }
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
 ?>
<div id="tableDiv">
    <table align="center" id="estructuraReporte" class="previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="9"><span>Dedicación Semanal Docentes<br>(Según categorización del CNA), por Estudios en Curso</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                             <?php
                                if ($tipo==1){
                                    $ti="Mayor Nivel de Formacion";
                                }else{
                                    $ti="Estudios en curso";
                                }
                            ?>
                            <th class="column borderR" rowspan="2"><span><?php echo $ti ?></span></th>  
                            <th class="column "><center><span>Hora Catedra</span></center></th> 
                            <th class="column " rowspan='2'><center><span>Indice</span></center></th> 
                            <th class="column "><center><span>1/2 Tiempo</span></center></th> 
                            <th class="column " rowspan='2'><center><span>Porcentaje</span></center></th> 
                            <th class="column "><center><span>Tiempo Completo</span></center></th> 
                            <th class="column " rowspan='2'><center><span>Porcentaje</span></center></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column "><center><span>1-10 horas</span></center></th> 
                            <th class="column "><center><span>11-20 horas</span></center></th> 
                            <th class="column "><center><span>29-40 horas</span></center></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php 

                                while ($rowC = $nivelFormacion->FetchRow()) { 
                                $sql="SELECT * FROM siq_detalleformTalentoHumanoDedicacionSemanalCNA
                                      INNER JOIN siq_formTalentoHumanoDedicacionSemanalCNA on (idsiq_formTalentoHumanoDedicacionSemanalCNA=idData)
                                      WHERE idCategory='".$rowC["idsiq_tipoNivelFormacion"]."' and codigoperiodo='".$periodos."' ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
                               // echo $sql;
                                $row = $db->GetRow($sql);
                                $It1_4=round($row["tiempo1h"]/$T1_4, 4);
                                $It1_2=round($row["tiempo1_2"]/$T1_2, 4);
                                $Itcompleto=round($row["tiempocompleto"]/$Tcompleto, 4);
                                $Tt1_4=round($Tt1_4+$row["tiempo1h"], 4);
                                $Pt1_4=round($Pt1_4+$It1_4, 4);
                                $Tt1_2=round($Tt1_2+$row["tiempo1_2"], 4);
                                $Pt1_2=round($Pt1_2+$It1_2, 4);
                                $TtC=round($TtC+$row["tiempocompleto"], 4);
                                $PtC=round($PtC+$Itcompleto, 4);
                                 //echo $sql.'<br>';
                                $first = true;
                          ?>
                                <tr class="dataColumns">
                                        <td class="column borderR" >
                                             <?php echo $rowC["nombre"]; ?> 
                                       </td>
                                       <td class="column"><center><?php echo $row["tiempo1h"]; ?></center></td>
                                       <td class="column"><center><?php echo $It1_4; ?></center></td>
                                       <td class="column"><center><?php echo $row["tiempo1_2"]; ?></center></td>
                                       <td class="column"><center><?php echo $It1_2; ?></center></td>
                                       <td class="column"><center><?php echo $row["tiempocompleto"]; ?></center></td>
                                       <td class="column"><center><?php echo $Itcompleto; ?></center></td>
                                </tr>
                        <?php  } ?>        
                    </tbody>
                     <tfoot>
                        <tr id="totalColumns">
                           <td class="column total title" >Total</td>   
                           <td class="column center"><?php echo $Tt1_4 ?></td>
                           <td class="column center"><?php echo $Pt1_4.'%' ?></td>
                           <td class="column center"><?php echo $Tt1_2 ?></td>
                           <td class="column center"><?php echo $Pt1_2.'%' ?></td>
                           <td class="column center"><?php echo $TtC ?></td>
                           <td class="column center"><?php echo $PtC.'%'  ?></td>
                       </tr>
                   </tfoot>
                </table>     
</div>
<?php } ?>
<script type="text/javascript">
 $(document).ready(function(){
                $("#consul_report_bnfor4").one('click', function() {
                            $.ajax({//Ajax
                              type: 'POST',
                              url: '<?php echo $url?>',
                              data: $('#forma4').serialize(), 
                             error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                             success:function(data){
                                    $('#respuesta_forma4').html(data);
                              }
                    }); //AJAX   
                }); 
  });
 </script>