<?php 
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$tipo=1;
switch($_REQUEST['BuscarDepu']){
    case 'Reporte':{ 
        ReporteDepuracion($_REQUEST["codigoperiodo"]);
    }exit;
}
if(!$db){ 
    
  require_once("../../../templates/template.php");
  $db =  getBD(true);
  $utils = new Utils_datos();
  $ruta  = '../reportes/reportes/financieros/viewReporteRecursosDepuracion.php';
}else{
   $ruta  = './reportes/financieros/viewReporteRecursosDepuracion.php'; 
}
?>
<script>
    function Consultar3(ruta){
     
        $.ajax({//Ajax
			  type: 'POST',
			  url: ruta,
			  async: false,
			  dataType: 'html',
			  data:$('#forma3').serialize(),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#forma3 #tableDiv').html(data);
				}//data 
		  }); //AJAX 
    }/*function Consultar*/
</script>

<form action="" method="post" id="forma3" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
            <label for="semestre" class="grid-2-12">A&ntilde;o: <span class="mandatory">(*)</span></label>
		<?php $periodos=$utils->getYearsSelect("codigoperiodo",'');  ?>
		<input type="button" value="Consultar" class="first small"  onclick="Consultar3('<?PHP echo $ruta?>')" />
	<div id='respuesta_forma'><input type="hidden" id="BuscarDepu" name="BuscarDepu" value="Reporte" /></div>
	</fieldset> 
    <div id="tableDiv"></div>
</form>

<?php 
function ReporteDepuracion($codigoperiodo){
    require_once("../../../templates/template.php");
    $db =  getBD(true);
    $utils = new Utils_datos();
//if(isset($_REQUEST["codigoperiodo"])) {
    $nivelFormacion  = $utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=40 AND codigoestado=100","orden");   
    $nivelFormacion1  =$utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=40 AND codigoestado=100","orden");
    
    while ($rowT = $nivelFormacion1->FetchRow()) { 
     $sqlT="SELECT * FROM siq_detalleformRecursosFinancieros
      INNER JOIN siq_formRecursosFinancieros on (idsiq_formRecursosFinancieros=idData)
      WHERE idCategory='".$rowT["idsiq_tipoRecursosPresupuesto"]."' and codigoperiodo=".$codigoperiodo." ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
   //  echo $sqlT;
     $rowT = $db->GetRow($sqlT);
     $T1=$T1+$rowT["dato1"];
     $T2=$T2+$rowT["dato2"];
     $T3=$T3+$rowT["dato3"];
   }
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
 ?>
  
    <table align="center" id="estructuraReporte" class="previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="9"><span>Depuración y Ajustes Sobre los Activos Fijos (en millones de pesos)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                             <?php
                                if ($tipo==1){
                                    $ti="Fuente de Financiamiento";
                                }else{
                                    $ti="Estudios en curso";
                                }
                            ?>
                            <th class="column borderR" ><span>A&ntilde;o <?php echo $_REQUEST['codigoperiodo'] ?></span></th>  
                            <th class="column "><center><span>ADICIONES</span></center></th> 
                            <th class="column "><center><span>BAJAS O PERDIDAS</span></center></th> 
                            <th class="column "><center><span>DONACIONES</span></center></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php 

                                while ($rowC = $nivelFormacion->FetchRow()) { 
                                $sql="SELECT * FROM siq_detalleformRecursosFinancieros
                                      INNER JOIN siq_formRecursosFinancieros on (idsiq_formRecursosFinancieros=idData)
                                      WHERE idCategory='".$rowC["idsiq_tipoRecursosPresupuesto"]."' 
                                      and codigoperiodo=".$codigoperiodo." ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
                               // echo $sql;
                                $row = $db->GetRow($sql);
                                 //echo $sql.'<br>';
                                $first = true;
                          ?>
                                <tr class="dataColumns">
                                        <td class="column borderR" >
                                             <?php echo $rowC["nombre"]; ?> 
                                       </td>
                                       <td class="column"><center><?php echo number_format($row["dato1"],0); ?></center></td>
                                       <td class="column"><center><?php echo number_format($row["dato2"],0); ?></center></td>
                                       <td class="column"><center><?php echo number_format($row["dato3"],0); ?></center></td>
                                </tr>
                        <?php  } ?>        
                    </tbody>
                     <tfoot>
                        <tr id="totalColumns">
                           <td class="column total title" >Total</td>   
                           <td class="column center"><?php echo number_format($T1,0); ?></td>
                           <td class="column center"><?php echo number_format($T2,0); ?></td>
                           <td class="column center"><?php echo number_format($T3,0); ?></td>
                       </tr>
                   </tfoot>
                </table>     

<?php } ?>
