<?php 
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$tipo=1;
//echo 'parametro-->'.$_REQUEST['BuscarRep'];
switch($_REQUEST['BuscarRep']){
    case 'Reporte':{ //echo '<br>aca...';
        ReporterecursoA($_REQUEST["codigoperiodo"]);
    }exit;
}
if(!$db){ 
    
  require_once("../../../templates/template.php");
  $db =  getBD(true);
  $utils = new Utils_datos();
  $ruta  = '../reportes/reportes/financieros/viewReporteRecursosPresupuestoA.php';
}else{
   $ruta  = './reportes/financieros/viewReporteRecursosPresupuestoA.php'; 
}
?>
<script>
    function Consultar1(ruta){
        
        
        $.ajax({//Ajax
			  type: 'POST',
			  url: ruta,
			  async: false,
			  dataType: 'html',
			  data:$('#forma1').serialize(),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#forma1 #Divcarga').html(data);
				}//data 
		  }); //AJAX 
    }/*function Consultar*/
</script>

<form action="" method="post" id="forma1" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
            <label for="semestre" class="grid-2-12">A&ntilde;o: <span class="mandatory">(*)</span></label>
		<?php $periodos=$utils->getYearsSelect("codigoperiodo",'');  ?>
		<input type="button" value="Consultar" class="first small"  onclick="Consultar1('<?PHP echo $ruta?>')" />
	<div id='respuesta_forma'><input type="hidden" id="BuscarRep" name="BuscarRep" value="Reporte" /></div>
	</fieldset> 
    <div id="Divcarga"></div>
</form>

<?php 
function ReporterecursoA($codigoperiodo){
    require_once("../../../templates/template.php");
    $db =  getBD(true);
    $utils = new Utils_datos();
//if(isset($_REQUEST["codigoperiodo"])) {
    $nivelFormacion  = $utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=3 AND codigoestado=100","orden");   
    $nivelFormacion1  =$utils->getAll($db,"siq_tipoRecursosPresupuesto","actividad=3 AND codigoestado=100","orden");
    
    while ($rowT = $nivelFormacion1->FetchRow()) { 
     $sqlT="SELECT * FROM siq_detalleformPresupuestoRecursos 
      INNER JOIN siq_formPresupuestoRecursos  on (idsiq_formPresupuestoRecursos=idData)
      WHERE idCategory='".$rowT["idsiq_tipoRecursosPresupuesto"]."' and codigoperiodo=".$codigoperiodo." ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
   //  echo $sqlT;
     $rowT = $db->GetRow($sqlT);
     $Tp=$Tp+$rowT["presupuesto"];
     $Te=$Te+$rowT["ejecucion"];
   }
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
 ?>
   
    <table align="center" id="estructuraReporte" class="previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="9"><span>Presupuesto y Ejecución Presupuestal</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                             <?php
                                if ($tipo==1){
                                    $ti="Fuente de Financiamiento";
                                }else{
                                    $ti="Estudios en curso";
                                }
                            ?>
                            <th class="column borderR" ><span>CIFRAS EXPRESADAS EN MILLONES DE PESOS</span></th>  
                            <th class="column "><center><span>Presupuesto</span></center></th> 
                            <th class="column "><center><span>Ejecución a Diciembre</span></center></th> 
                            <th class="column "><center><span>% de Ejecuci&oacute;n</span></center></th>
                        </tr>
                     </thead>
                     <tbody>
                         
                         <?php 
                                $i=0;
								$rdtoNetoE = 0;
								$rdtoNetoP = 0;
                                while ($rowC = $nivelFormacion->FetchRow()) { 
                                    $sql="SELECT * FROM siq_detalleformPresupuestoRecursos
                                          INNER JOIN siq_formPresupuestoRecursos on (idsiq_formPresupuestoRecursos=idData)
                                          WHERE idCategory='".$rowC["idsiq_tipoRecursosPresupuesto"]."' and codigoperiodo=".$codigoperiodo." ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
                                   // echo $sql;
                                    $row = $db->GetRow($sql);
                                    if($i==0){
                                         ?>
                                            <tr class="dataColumns">
                                                    <td class="column" colspan='6' style='background-color:#90A860' ><center><b>INGRESOS</b></center> </td>
                                            </tr>
                                         <?php
                                    }else if($i==1){
                                       ?>
                                          <tr class="dataColumns">
                                                  <td class="column" colspan='6' style='background-color:#90A860' ><center><b>GASTOS</b></center> </td>
                                          </tr>
                                      <?php
                                      }
                                    ?>
                                        <tr class="dataColumns">
                                            <td class="column borderR" >
                                                 <?php echo $rowC["nombre"]; ?> 
                                           </td>
                                           <td class="column"><center><?php echo number_format($row['presupuesto'],0); ?></center></td>
                                           <td class="column"><center><?php echo number_format($row['ejecucion'],0); ?></center></td>
                                           <td class="column"><center><?php echo number_format((($row['ejecucion']/$row['presupuesto'])*100),2); ?></center></td>
                                        </tr>
                                <?php  
                                 if($i==0){
                                     $IngPre=$row['presupuesto'];
                                     $IngEje=$row['ejecucion'];
                                     $IngEjeP=(($row['ejecucion']/$row['presupuesto'])*100);
                                     ?>
                                        <tr class="dataColumns" style='background-color:#90A860'>
                                          <td class="column borderR" ><b> TOTAL INGRESOS OPERACIONALES</b></td>
                                         <td class="column"><center><?php echo number_format($IngPre,0); ?></center></td>
                                         <td class="column"><center><?php echo number_format($IngEje,0); ?></center></td>
                                         <td class="column"><center><?php echo number_format($IngEjeP,2); ?></center></td>
                                     </tr> 
                                    <?php
                                 }else if($i>0 && $i<=4){
                                     $GatPre=$GatPre+$row['presupuesto'];
                                     $GatEje=$GatEje+$row['ejecucion'];
                                     if($i==4){
                                         $TrdoOpre=$IngPre-$GatPre;
                                         $TrdoOeje=$IngEje-$GatEje;
                                         ?>
                                            <tr class="dataColumns" style='background-color:#90A860'>
                                                    <td class="column borderR" ><b> TOTAL GASTOS OPERACIONALES</b></td>
                                                   <td class="column"><center><?php echo number_format($GatPre,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format($GatEje,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format((($GatEje/$GatPre)*100),2); ?></center></td>
                                            </tr>
                                            <tr class="dataColumns" style='background-color:#90A860'>
                                                    <td class="column borderR" ><b>RDTO OPNAL</b></td>
                                                   <td class="column"><center><?php echo number_format($IngPre-$GatPre,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format($IngEje-$GatEje,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format(((($IngEje-$GatEje)/($IngEje-$GatEje))*100),2); ?></center></td>
                                            </tr>
                                            
                                         <?php
                                     }
                                 }else if($i>4 && $i<=6){
                                     if($InNoPre==0){
                                         $InNoPre=$row['presupuesto'];
                                     }else{
                                        $InNoPre=$InNoPre-$row['presupuesto'];
                                     }
                                     if($InNoEje==0){
                                         $InNoEje=$row['ejecucion'];
                                     }else{
                                         $InNoEje=$InNoEje-$row['ejecucion'];
                                     }
                                     if ($i==5){
                                         $InNoPre2=$row['presupuesto'];
                                         $InNoEje2=$row['ejecucion'];
                                     }
                                     if ($i==6){
                                         $GaNoPre2=$row['presupuesto'];
                                         $GaNoEje2=$row['ejecucion'];
                                     }
                                     if($i==6){
                                         ?>
                                            <tr class="dataColumns" style='background-color:#90A860'>
                                                    <td class="column borderR" ><b>RDTO NO OPNAL</b></td>
                                                   <td class="column"><center><?php echo number_format($InNoPre,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format($InNoEje,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format($InNoEje/$InNoPre,2); ?></center></td>
                                            </tr>
                                            <tr class="dataColumns" style='background-color:#90A860'>
                                                    <td class="column borderR" ><b>RDTO NETO</b></td>
                                                   <td class="column"><center><?php $rdtoNetoP = $TrdoOpre+$InNoPre; echo number_format($rdtoNetoP,0); ?></center></td>
                                                   <td class="column"><center><?php $rdtoNetoE = $TrdoOeje+$InNoEje; echo number_format($rdtoNetoE,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format(((($TrdoOeje+$InNoEje)/($TrdoOpre+$InNoPre))*100),2); ?></center></td>
                                            </tr>
                                            
                                         <?php
                                     }
                                 }else if($i>6 && $i<=8){
                                     $TInPre=$TInPre+$row['presupuesto'];
                                     $TInEje=$TInEje+$row['ejecucion'];
                                     if($i==8){
                                         ?>
                                            <tr class="dataColumns" style='background-color:#90A860'>
                                                    <td class="column borderR" ><b>TOTAL INVERSIONES</b></td>
                                                   <td class="column"><center><?php echo number_format($TInPre,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format($TInEje,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format((($TInEje/$TInPre)*100),2); ?></center></td>
                                            </tr>
                                         <?php
                                     }
                                 }else if($i>8){
                                     $RBP=$row['presupuesto'];
                                     $RBE=$row['ejecucion'];
                                     if($i==9){
                                         ?>
                                            <tr class="dataColumns" style='background-color:#90A860'>
                                                    <td class="column borderR" ><b>EXCEDENTES O SUBVENCIÓN PRESUPUESTAL</b></td>
                                                   <td class="column"><center><?php echo number_format($rdtoNetoP - $TInPre + $RBP,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format($rdtoNetoE - $TInEje + $RBE,0); ?></center></td>
                                                   <td class="column"><center><?php echo number_format(((($rdtoNetoE - $TInEje + $RBE)/($rdtoNetoP - $TInPre + $RBP))*100),2); ?></center></td>
                                            </tr>
                                         <?php
                                     }
                                 }
                                 $i++;
                                }
                      ?>        
                </table> 
  
<?php } ?>
