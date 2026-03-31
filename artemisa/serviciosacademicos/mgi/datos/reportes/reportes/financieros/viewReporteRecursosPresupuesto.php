<?php 
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$tipo=1;
switch($_REQUEST['BuscarReporte']){
    case 'Reporte':{ 
        Reporterecurso($_REQUEST["codigoperiodo"]);
    }exit;
}
if(!$db){ 
    
  require_once("../../../templates/template.php");
  $db =  getBD(true);
  $utils = new Utils_datos();
  $ruta  = '../reportes/reportes/financieros/viewReporteRecursosPresupuesto.php';
}else{
   $ruta  = './reportes/financieros/viewReporteRecursosPresupuesto.php'; 
}
?>
<script>
    function Consultar7(ruta){
        
        
        $.ajax({//Ajax
			  type: 'POST',
			  url: ruta,
			  async: false,
			  dataType: 'html',
			  data:$('#forma7').serialize(),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#forma7 #tableDiv').html(data);
				}//data 
		  }); //AJAX 
    }/*function Consultar*/
</script>
<form action="" method="post" id="forma7" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
            <label for="semestre" class="grid-2-12">A&ntilde;o: <span class="mandatory">(*)</span></label>
		<?php $periodos=$utils->getYearsSelect("codigoperiodo",'');  ?>
		<input type="button" value="Consultar" class="first small" onclick="Consultar7('<?PHP echo $ruta?>')" />
		<div id='respuesta_forma'><input type="hidden" id="BuscarReporte" name="BuscarReporte" value="Reporte" /></div>
	</fieldset> 
    <div id="tableDiv"></div>
</form>

<?php 
function Reporterecurso($codigoperiodo){
    require_once("../../../templates/template.php");
    $db =  getBD(true);
    $utils = new Utils_datos();
//if(isset($_REQUEST["codigoperiodo"])) {
    $nivelFormacion  = $utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=2 AND codigoestado=100","orden");   
    $nivelFormacion1  =$utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=2 AND codigoestado=100","orden");
    
    while ($rowT = $nivelFormacion1->FetchRow()) { 
     $sqlT="SELECT * FROM siq_detalleformPresupuestoRecursos 
      INNER JOIN siq_formPresupuestoRecursos  on (idsiq_formPresupuestoRecursos=idData)
      WHERE idCategory='".$rowT["idsiq_tipoRecursosPresupuesto"]."' and codigoperiodo=".$codigoperiodo." ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
   // echo '<br><br>'.$sqlT;
     $rowT = $db->GetRow($sqlT);
     $Tp=$Tp+$rowT["presupuesto"];
     $Te=$Te+$rowT["ejecucion"];
   }
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
 ?>
  
    <table align="center" id="estructuraReporte" class="previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="9"><span>Uso de los Recurso (en Millones de Pesos)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                             <?php
                                if ($tipo==1){
                                    $ti="Fuente de Financiamiento";
                                }else{
                                    $ti="Concepto";
                                }
                            ?>
                            <th class="column borderR" ><span><?php echo $ti ?></span></th>  
                            <th class="column "><center><span>Ejecución a Diciembre</span></center></th> 
                            <th class="column "><center><span>% de Participaci&oacute;n</span></center></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php 

                                while ($rowC = $nivelFormacion->FetchRow()) { 
                                $sql="SELECT * FROM siq_detalleformPresupuestoRecursos
                                      INNER JOIN siq_formPresupuestoRecursos on (idsiq_formPresupuestoRecursos=idData)
                                      WHERE idCategory='".$rowC["idsiq_tipoRecursosPresupuesto"]."' and codigoperiodo=".$codigoperiodo." ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
                               // echo $sql;
                                $row = $db->GetRow($sql);
                                $Itp=(($row["presupuesto"]/$Tp)*100);
                                $Ite=(($row["ejecucion"]/$Te)*100);
                                $Itpe=(($row["ejecucion"]/$row["presupuesto"])*100);
                                $TItp=$TItp+$Itp;
                                $TIte=$TIte+$Ite;
                                $TItpe=$TItpe+$Itpe;
                                 //echo $sql.'<br>';
                                $first = true;
                          ?>
                                <tr class="dataColumns">
                                        <td class="column borderR" >
                                             <?php echo $rowC["nombre"]; ?> 
                                       </td>
                                       <td class="column"><center><?php echo number_format($row["ejecucion"],0); ?></center></td>
                                       <td class="column"><center><?php echo number_format($Ite,2); ?></center></td>
                                </tr>
                        <?php  } ?>        
                    </tbody>
                     <tfoot>
                        <tr id="totalColumns">
                           <td class="column total title" >Total</td>   
                           <td class="column center"><?php echo number_format($Te,0) ?></td>
                           <td class="column center">100</td>
                       </tr>
                   </tfoot>
                </table>     

<?php } ?>
