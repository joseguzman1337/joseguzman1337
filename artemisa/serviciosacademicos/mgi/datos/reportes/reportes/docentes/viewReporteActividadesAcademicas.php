<?php 
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
if(empty($_REQUEST['id'])){
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $url='../reportes/reportes/docentes/viewReporteActividadesAcademicas.php';
}else{
    $url='reportes/docentes/viewReporteActividadesAcademicas.php';
}
$tipo=1;

if(empty($_REQUEST["codigoperiodo"])) {
?>
<form action="" method="post" id="form6" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php if(isset($_REQUEST["codigoperiodo"])) {$utils->getSemestresSelect($db,"codigoperiodo",false,$_REQUEST["codigoperiodo"]); } 
                else { $utils->getSemestresSelect($db,"codigoperiodo"); } ?>
                <input type="button" value="Consultar" id="consul_report_bnfor6" class="first small" />
		<!--<input type="submit" value="Consultar" class="first small" />-->
		
	</fieldset>
</form>
<div id='respuesta_forma6'></div>
<?php
}
//echo $_REQUEST["codigoperiodo"].'-->';
if( isset($_REQUEST["codigoperiodo"])) { 
       
    $periodos = $utils->getMesesPeriodo($db,$_REQUEST["codigoperiodo"]);
    
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
    
    $sql_P="SELECT * FROM siq_tipoActividadAcademicos where actividadPadre=0";
    $row1= $db->Execute($sql_P);
    //print_r($row1);
    ?>

<div id="tableDiv">
    <table align="center" id="estructuraReporte" class="previewReport" width="92%" >
        <thead>            
            <tr class="dataColumns">
		<th class="column" colspan="2"><span>Clases Actividades</span></th>
                <th class="column"><span>Horas Semanales</span></th>
                <th class="column"><span> TIEMPOS COMPLETOS EQUIVALENTES (TCE)</span></th>
                <th class="column"><span> %</span></th>
                <th class="column"><span>Total</span></th>
                <th class="column"><span>Indice</span></th>
	    </tr>
        </thead>
        <tbody>
            <?php
            $i=0; $canC=0; 
            foreach($row1 as $dt){
                
                $idP=$dt['idsiq_tipoActividadAcademicos'];
                $sql = "SELECT d.idsiq_detalleformUnidadesAcademicasActividadesAcademicos, d.idData, idCategory, numHoras, 
                               numAcademicosTCE, t.idsiq_tipoActividadAcademicos, 
                               t.nombre, t.actividadPadre, f.codigoperiodo
                        FROM siq_detalleformUnidadesAcademicasActividadesAcademicos as d
                        inner join siq_formUnidadesAcademicasActividadesAcademicos as f 
                        on (f.idsiq_formUnidadesAcademicasActividadesAcademicos=d.idData)
                        INNER JOIN siq_tipoActividadAcademicos AS t 
                        on (t.idsiq_tipoActividadAcademicos=d.idCategory)
                        WHERE t.actividadPadre='".$idP."' and f.codigoperiodo='".$_REQUEST["codigoperiodo"]."' and actividad=2";
               // echo $sql;
                $row2= $db->Execute($sql);
                $row =$row2->GetArray();
                $canC=  count($row);
                $ToTce=0;
                foreach($row as $dt1){
                    $ToTce=$ToTce+$dt1['numAcademicosTCE']; //Total de TCE
                }
                if($row!=NULL && count($row)>0){
                    $sumaTce=0; $j=0;
                    foreach($row as $dt1){
                        $NUMa=$dt1['numHoras']/40;
                        $por=round($dt1['numHoras']/$NUMa,4); //%
                        $sumaTce=round($NUMa+$sumaTce,2); //Total
                        $ind=round($sumaTce/$ToTce,4); //Indice
                        $tHs=round($tHs+$dt1['numHoras'],4); //Total de Horas Semanales
                        $tHTce=round($tHTce+$NUMa,4); //Total de TCE
                        $tPor=round($tPor+$por,2); //Total de %
                        $tTce=round($tTce+$sumaTce,2); //Total Total
                        $tInd=round($tInd+$ind,2); //Total Indice
                        ?>
                        <tr class="dataColumns">
                              <?php if ($j==0){ ?> <td class="column" rowspan="<?php echo $canC ?>"> <?php echo $dt['nombre']; ?></td> <?php } ?>
                              
                               <td class="column"><?php echo $dt1['nombre']; ?></td>
                               <td class="column"><center><?php echo $dt1['numHoras'] ?></center></td>
                               <td class="column"><center><?php echo $NUMa ?></center></td>
                               <td class="column"><center><?php echo $por ?></center></td>
                              
                             <?php if ($j==0){ ?> <td class="column" rowspan="<?php echo $canC ?>"><center><?php echo $sumaTce ?></center></td><?php } ?>
                             <?php if ($j==0){ ?> <td class="column" rowspan="<?php echo $canC ?>"><?php echo $ind ?></td><?php } ?>
                        </tr>
                            <?php
                        $j++;
                    } 
                    ?>
                 
             
                    <?php
                }
            //$total = ($row["numAcademicosTCE"]+$row["numHoras"]);
            ?>
              
            <?php
            }
            ?>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title" colspan="2">Total</td>   
                <td class="column center"><?php echo ($tHs); ?></td>
                <td class="column center"><?php echo ($tHTce); ?></td>
                <td class="column center"><?php echo ($tPor); ?></td>
                <td class="column center"><?php echo ($tTce); ?></td>
                <td class="column center"><?php echo ($tInd); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
                $("#consul_report_bnfor6").one('click', function() {
                            $.ajax({//Ajax
                              type: 'POST',
                              url: '<?php echo $url?>',
                              data: $('#form6').serialize(), 
                             error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                             success:function(data){
                                    $('#respuesta_forma6').html(data);
                              }
                    }); //AJAX   
                }); 
  });
 </script>