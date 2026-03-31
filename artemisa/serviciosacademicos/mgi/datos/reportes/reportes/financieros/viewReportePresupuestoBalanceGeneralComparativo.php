<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

if($_GET['anio']) {
//echo 'entro...';die;
require_once("../../../templates/template.php");
$db = getBD();

$codigoperiodo = $_GET['anio'];

$fechaactual=$codigoperiodo."/01/01";
$codigoperiodoanterior = strtotime ( '-1 year' , strtotime ( $fechaactual) );
$codigoperiodoanterior=date('Y',$codigoperiodoanterior);

/*CONSULTAS PARA TRAER CADA UNA DE LAS CATEGORIAS*/
$query_categoria1="select idsiq_tipoDatoBalance, nombre from siq_tipoDatoBalance where categoria='Activo_Corriente' and codigoestado like '1%' order by 2";
$categoria1= $db->Execute($query_categoria1);
$totalRows_categoria1= $categoria1->RecordCount();

$query_categoria2="select idsiq_tipoDatoBalance, nombre from siq_tipoDatoBalance where categoria='Activo_No_Corriente' and codigoestado like '1%' order by 2";
$categoria2= $db->Execute($query_categoria2);
$totalRows_categoria2= $categoria2->RecordCount();

$query_categoria3="select idsiq_tipoDatoBalance, nombre from siq_tipoDatoBalance where categoria='Pasivo_Corriente' and codigoestado like '1%' order by 2";
$categoria3= $db->Execute($query_categoria3);
$totalRows_categoria3= $categoria3->RecordCount();

$query_categoria4="select idsiq_tipoDatoBalance, nombre from siq_tipoDatoBalance where categoria='Pasivo_Diferido' and codigoestado like '1%' order by 2";
$categoria4= $db->Execute($query_categoria4);
$totalRows_categoria4= $categoria4->RecordCount();

$query_categoria5="select idsiq_tipoDatoBalance, nombre from siq_tipoDatoBalance where categoria='Pasivo_No_Corriente' and codigoestado like '1%' order by 2";
$categoria5= $db->Execute($query_categoria5);
$totalRows_categoria5= $categoria5->RecordCount();

$query_categoria6="select idsiq_tipoDatoBalance, nombre from siq_tipoDatoBalance where categoria='Patrimonio' and codigoestado like '1%' order by 2";
$categoria6= $db->Execute($query_categoria6);
$totalRows_categoria6= $categoria6->RecordCount();

$query_categoria7="select idsiq_tipoDatoBalance, nombre from siq_tipoDatoBalance where categoria='Cuentas_Orden' and codigoestado like '1%' order by 2";
$categoria7= $db->Execute($query_categoria7);
$totalRows_categoria7= $categoria7->RecordCount();

/*CONSULTA DEL TOTAL DE LOS ACTIVOS Y DE LOS PASIVOS*/
$query_totalactivo1="select sum(pb.valor) as totalactivo 
from siq_formPresupuestoBalanceGeneral  pb,  siq_tipoDatoBalance s 
where
s.idsiq_tipoDatoBalance=pb.idtipoBalance
and pb.codigoperiodo='$codigoperiodo'
and pb.codigoestado like '1%'
and (s.categoria='Activo_Corriente' or s.categoria='Activo_No_Corriente')";
$totalactivo1= $db->Execute($query_totalactivo1);
$row_totalactivo1= $totalactivo1->FetchRow();

$query_totalactivo2="select sum(pb.valor) as totalactivo 
from siq_formPresupuestoBalanceGeneral  pb,  siq_tipoDatoBalance s 
where
s.idsiq_tipoDatoBalance=pb.idtipoBalance
and pb.codigoperiodo='$codigoperiodoanterior'
and pb.codigoestado like '1%'
and (s.categoria='Activo_Corriente' or s.categoria='Activo_No_Corriente')";
$totalactivo2= $db->Execute($query_totalactivo2);
$row_totalactivo2= $totalactivo2->FetchRow();

$query_totalpasivo1="select sum(pb.valor) as totalactivo 
from siq_formPresupuestoBalanceGeneral  pb,  siq_tipoDatoBalance s 
where
s.idsiq_tipoDatoBalance=pb.idtipoBalance
and pb.codigoperiodo='$codigoperiodo'
and pb.codigoestado like '1%'
and (s.categoria='Pasivo_Corriente' or s.categoria='Pasivo_No_Corriente' or s.categoria='Pasivo_Diferido')";
$totalpasivo1= $db->Execute($query_totalpasivo1);
$row_totalpasivo1= $totalpasivo1->FetchRow();

$query_totalpasivo2="select sum(pb.valor) as totalactivo 
from siq_formPresupuestoBalanceGeneral  pb,  siq_tipoDatoBalance s 
where
s.idsiq_tipoDatoBalance=pb.idtipoBalance
and pb.codigoperiodo='$codigoperiodoanterior'
and pb.codigoestado like '1%'
and (s.categoria='Pasivo_Corriente' or s.categoria='Pasivo_No_Corriente' or s.categoria='Pasivo_Diferido')";
$totalpasivo2= $db->Execute($query_totalpasivo2);
$row_totalpasivo2= $totalpasivo2->FetchRow();

?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="2" style="width:20%;"><span></span></th>
                    <th class="column" colspan="6" style="width:80%;text-align:center;"><span>BALANCE GENERAL COMPARATIVO A DICIEMBRE 31 DE <?php echo $codigoperiodo." - ".$codigoperiodoanterior; ?><br>(Expresado en Millones de Pesos)</span></th>                    
             </tr>
             <tr class="dataColumns">
		<th class="column" style="width:13%;text-align:center;"><span>Año Actual <?php echo $codigoperiodo;?></span></th>                    
                <th class="column" style="width:13%;text-align:center;"><span>% de Participación</span></th>
                <th class="column" style="width:13%;text-align:center;"><span>Año Anterior <?php echo $codigoperiodoanterior;?></span></th>                    
                <th class="column" style="width:13%;text-align:center;"><span>% de Participación</span></th>                
                <th class="column" style="width:14%;text-align:center;"><span>Variación Absoluta</span></th>
                <th class="column" style="width:14%;text-align:center;"><span>Variación Relativa</span></th>                
             </tr>    
        </thead>
        <tbody>
	    <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>ACTIVO</span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>CORRIENTE</span></th>
            </tr>
	<?php
	//exit();
	while($row_categoria1 = $categoria1->FetchRow()){	
	
	  $query_actcorriente1="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria1['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $actcorriente1= $db->Execute($query_actcorriente1);
	  $row_actcorriente1= $actcorriente1->FetchRow();
	  
	  $query_actcorriente2="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria1['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $actcorriente2= $db->Execute($query_actcorriente2);
	  $row_actcorriente2= $actcorriente2->FetchRow();
	  
	  /*Sumatoria activos*/
	  $total_actcorriente1=$row_actcorriente1['valor']+$total_actcorriente1;
	  $total_actcorriente2=$row_actcorriente2['valor']+$total_actcorriente2;
	  //$total_completo=$row_ebalancegeneral['completoTiempo']+$total_completo;
	  
	  /*Calculo del porcentaje participacion*/
	  $por_participacion_actcorriente1=(($row_actcorriente1['valor']/$row_totalactivo1['totalactivo'])*100);
	  $por_participacion_actcorriente2=(($row_actcorriente2['valor']/$row_totalactivo2['totalactivo'])*100);
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta=$row_actcorriente1['valor'] - $row_actcorriente2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa=(($variacion_absoluta / $row_actcorriente2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria1['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_actcorriente1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_actcorriente1,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_actcorriente2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_actcorriente2,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }
	 
	 /*Calculo del porcentaje participacion total */
	  $por_participacion_actcorriente_total1=(($total_actcorriente1/$row_totalactivo1['totalactivo'])*100);
	  $por_participacion_actcorriente_total2=(($total_actcorriente2/$row_totalactivo2['totalactivo'])*100);
	  
	  /*Calculo variacion absoluta total*/	  
	  $variacion_absoluta_total_act_corriente=$total_actcorriente1 - $total_actcorriente2;
	  
	  /*Calculo variacion relativa total*/	  
	  $variacion_relativa_total_act_corriente=(($variacion_absoluta_total_act_corriente/$total_actcorriente2)*100);	 
	 ?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>Total Activo Corriente</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_actcorriente1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo round($por_participacion_actcorriente_total1,2)."%"; ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_actcorriente2,0); ?></span></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo round($por_participacion_actcorriente_total2,2)."%"; ?></span></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_act_corriente,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_act_corriente)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>NO CORRIENTE</span></th>
            </tr>
            <?php
	//exit();
	while($row_categoria2 = $categoria2->FetchRow()){	
	
	  $query_actnocorriente1="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria2['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $actnocorriente1= $db->Execute($query_actnocorriente1);
	  $row_actnocorriente1= $actnocorriente1->FetchRow();
	  
	  $query_actnocorriente2="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria2['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $actnocorriente2= $db->Execute($query_actnocorriente2);
	  $row_actnocorriente2= $actnocorriente2->FetchRow();
	  
	  /*Sumatoria activos*/
	  $total_actnocorriente1=$row_actnocorriente1['valor']+$total_actnocorriente1;
	  $total_actnocorriente2=$row_actnocorriente2['valor']+$total_actnocorriente2;
	  
	  
	  /*Calculo del porcentaje participacion*/
	  $por_participacion_actnocorriente1=(($row_actnocorriente1['valor']/$row_totalactivo1['totalactivo'])*100);
	  $por_participacion_actnocorriente2=(($row_actnocorriente2['valor']/$row_totalactivo2['totalactivo'])*100);
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta2=$row_actnocorriente1['valor'] - $row_actnocorriente2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa2=(($variacion_absoluta2/$row_actnocorriente2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria2['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_actnocorriente1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_actnocorriente1,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_actnocorriente2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_actnocorriente2,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta2,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa2)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }
	 
	 /*Calculo del porcentaje participacion total */
	  $por_participacion_actnocorriente_total1=(($total_actnocorriente1/$row_totalactivo1['totalactivo'])*100);
	  $por_participacion_actnocorriente_total2=(($total_actnocorriente2/$row_totalactivo2['totalactivo'])*100);
	  
	  /*Calculo variacion absoluta total*/	  
	  $variacion_absoluta_total_act_nocorriente=$total_actnocorriente1 - $total_actnocorriente2;
	  
	  /*Calculo variacion relativa total*/	  
	  $variacion_relativa_total_act_nocorriente=(($variacion_absoluta_total_act_nocorriente / $total_actnocorriente2)*100);	 
	 ?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>Total Activo No Corriente</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_actnocorriente1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo round($por_participacion_actnocorriente_total1,2)."%"; ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_actnocorriente2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo round($por_participacion_actnocorriente_total2,2)."%"; ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_act_nocorriente,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_act_nocorriente)."%"; ?></span></th>
            </tr>            
            <?php 
	      $sumatotal_activo1=$total_actcorriente1+$total_actnocorriente1;
	      $sumatotal_activo2=$total_actcorriente2+$total_actnocorriente2;
	      $por_total_participacion_activo1=$por_participacion_actcorriente_total1+$por_participacion_actnocorriente_total1;
	      $por_total_participacion_activo2=$por_participacion_actcorriente_total2+$por_participacion_actnocorriente_total2;
	      $sumatotal_variacion_absoluta=$variacion_absoluta_total_act_corriente+$variacion_absoluta_total_act_nocorriente;
	      $sumatotal_variacion_relativa=$variacion_relativa_total_act_corriente+$variacion_relativa_total_act_nocorriente;            
            ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL ACTIVO</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_activo1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo round($por_total_participacion_activo1,2)."%"; ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_activo2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo round($por_total_participacion_activo2,2)."%"; ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($sumatotal_variacion_absoluta,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($sumatotal_variacion_relativa)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span></br></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>PASIVO Y PATRIMONIO</span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>PASIVO</span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>CORRIENTE</span></th>
            </tr>
            <?php
            while($row_categoria3 = $categoria3->FetchRow()){	
	
	  $query_pascorriente1="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria3['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $pascorriente1= $db->Execute($query_pascorriente1);
	  $row_pascorriente1= $pascorriente1->FetchRow();
	  
	  $query_pascorriente2="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria3['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $pascorriente2= $db->Execute($query_pascorriente2);
	  $row_pascorriente2= $pascorriente2->FetchRow();
	  
	  /*Sumatoria Pasivos*/
	  $total_pascorriente1=$row_pascorriente1['valor']+$total_pascorriente1;
	  $total_pascorriente2=$row_pascorriente2['valor']+$total_pascorriente2;	  
	  
	  /*Calculo del porcentaje participacion*/
	  $por_participacion_pascorriente1=(($row_pascorriente1['valor']/$row_totalpasivo1['totalactivo'])*100);
	  $por_participacion_pascorriente2=(($row_pascorriente2['valor']/$row_totalpasivo2['totalactivo'])*100);
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_pascorriente=$row_pascorriente1['valor'] - $row_pascorriente2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_pascorriente=(($variacion_absoluta_pascorriente/$row_pascorriente2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria3['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_pascorriente1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_pascorriente1,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_pascorriente2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_pascorriente2,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta_pascorriente,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa_pascorriente)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }
	 
	 /*Calculo del porcentaje participacion total */
	 
	  $por_participacion_pascorriente_total1=$total_pascorriente1/$row_totalpasivo1['totalactivo']*100;
	  $por_participacion_pascorriente_total2=$total_pascorriente2/$row_totalpasivo2['totalactivo']*100;
	  
	  /*Calculo variacion absoluta total*/	  
	  $variacion_absoluta_total_pas_corriente=$total_pascorriente1 - $total_pascorriente2;
	  
	  /*Calculo variacion relativa total*/	  
	  $variacion_relativa_total_pas_corriente=(($variacion_absoluta_total_pas_corriente/$total_pascorriente2)*100);	 
	 ?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>SUBTOTAL PASIVO EXIGIBLE</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_pascorriente1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($por_participacion_pascorriente_total1,2)."%"; ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_pascorriente2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($por_participacion_pascorriente_total2,2)."%"; ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_pas_corriente,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_relativa_total_pas_corriente,2)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>PASIVO DIFERIDO</span></th>
            </tr>
            <?php
            while($row_categoria4 = $categoria4->FetchRow()){	
	
	  $query_pasdiferido1="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria4['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $pasdiferido1= $db->Execute($query_pasdiferido1);
	  $row_pasdiferido1= $pasdiferido1->FetchRow();
	  
	  $query_pasdiferido2="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria4['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $pasdiferido2= $db->Execute($query_pasdiferido2);
	  $row_pasdiferido2= $pasdiferido2->FetchRow();
	  
	  /*Sumatoria Pasivos*/
	  $total_pasdiferido1=$row_pasdiferido1['valor']+$total_pasdiferido1;
	  $total_pasdiferido2=$row_pasdiferido2['valor']+$total_pasdiferido2;	  
	  
	  /*Calculo del porcentaje participacion*/
	  $por_participacion_pasdiferido1=(($row_pasdiferido1['valor']/$row_totalpasivo1['totalactivo'])*100);
	  $por_participacion_pasdiferido2=(($row_pasdiferido2['valor']/$row_totalpasivo2['totalactivo'])*100);
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_pasdiferido=$row_pasdiferido1['valor'] - $row_pasdiferido2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_pasdiferido=(($variacion_absoluta_pasdiferido / $row_pasdiferido2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria4['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_pasdiferido1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_pasdiferido1,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_pasdiferido2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo round($por_participacion_pasdiferido2,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta_pasdiferido,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa_pasdiferido)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }
	 
	 
	  $sumatotal_pasivocorriente1=$total_pascorriente1+$total_pasdiferido1;
	  $sumatotal_pasivocorriente2=$total_pascorriente2+$total_pasdiferido2;
	 /*Calculo del porcentaje participacion total */
	 
	  $por_participacion_pasdiferido_total1=$sumatotal_pasivocorriente1/$row_totalpasivo1['totalactivo']*100;
	  $por_participacion_pasdiferido_total2=$sumatotal_pasivocorriente2/$row_totalpasivo2['totalactivo']*100;
	  
	  /*Calculo variacion absoluta total*/	  
	  $variacion_absoluta_total_pasivoco=$sumatotal_pasivocorriente1 - $sumatotal_pasivocorriente2;
	  
	  /*Calculo variacion relativa total*/	  
	  $variacion_relativa_total_pasivoco=(($variacion_absoluta_total_pasivoco/$sumatotal_pasivocorriente2)*100);	 
	 ?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL PASIVO CORRIENTE</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_pasivocorriente1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($por_participacion_pasdiferido_total1,2)."%"; ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_pasivocorriente2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($por_participacion_pasdiferido_total2,2)."%"; ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_pasivoco,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_relativa_total_pasivoco,2)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span>NO CORRIENTE</span></th>
            </tr>
            <?php
            while($row_categoria5 = $categoria5->FetchRow()){	
	
	  $query_pasnocorriente1="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria5['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $pasnocorriente1= $db->Execute($query_pasnocorriente1);
	  $row_pasnocorriente1= $pasnocorriente1->FetchRow();
	  
	  $query_pasnocorriente2="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria5['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $pasnocorriente2= $db->Execute($query_pasnocorriente2);
	  $row_pasnocorriente2= $pasnocorriente2->FetchRow();
	  
	  /*Sumatoria Pasivos*/
	  $total_pasnocorriente1=$row_pasnocorriente1['valor'];
	  $total_pasnocorriente2=$row_pasnocorriente2['valor'];	  
	  
	  /*Calculo del porcentaje participacion*/
	  $por_participacion_pasnocorriente1=$row_pasnocorriente1['valor']/$row_totalpasivo1['totalactivo']*100;
	  $por_participacion_pasnocorriente2=$row_pasnocorriente2['valor']/$row_totalpasivo2['totalactivo']*100;
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_pasnocorriente=$row_pasnocorriente1['valor'] - $row_pasnocorriente2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_pasnocorriente=(($variacion_absoluta_pasnocorriente/$row_pasnocorriente2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria5['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_pasnocorriente1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($por_participacion_pasnocorriente1,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_pasnocorriente2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($por_participacion_pasnocorriente2,2)."%"; ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta_pasnocorriente,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_relativa_pasnocorriente,2)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	   
	 ?>
	 <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL PASIVO NO CORRIENTE</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_pasnocorriente1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($por_participacion_pasnocorriente1,2)."%"; ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_pasnocorriente2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($por_participacion_pasnocorriente2,2)."%"; ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_pasnocorriente,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_relativa_pasnocorriente,2)."%"; ?></span></th>
            </tr>
         <?php 
         $sumatotal_pasivo1=$total_pasnocorriente1 + $sumatotal_pasivocorriente1;
         $sumatotal_pasivo2=$total_pasnocorriente2 + $sumatotal_pasivocorriente2;
         $variacion_absoluta_pasivo=$sumatotal_pasivo1 - $sumatotal_pasivo2;
         $variacion_relativa_pasivo=(($variacion_absoluta_pasivo/$sumatotal_pasivo2)*100);
         ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL PASIVO</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_pasivo1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_pasivo2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_pasivo,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_relativa_pasivo,2)."%"; ?></span></th>
            </tr>	    
            <?php
            while($row_categoria6 = $categoria6->FetchRow()){	
	
	  $query_patrimonio1="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria6['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $patrimonio1= $db->Execute($query_patrimonio1);
	  $row_patrimonio1= $patrimonio1->FetchRow();
	  
	  $query_patrimonio2="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria6['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $patrimonio2= $db->Execute($query_patrimonio2);
	  $row_patrimonio2= $patrimonio2->FetchRow();
	  
	  /*Sumatoria Pasivos*/
	  $total_patrimonio1=$row_patrimonio1['valor'];
	  $total_patrimonio2=$row_patrimonio2['valor'];	  
	    
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_patrimonio=$row_patrimonio1['valor'] - $row_patrimonio2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_patrimonio=(($variacion_absoluta_patrimonio/$row_patrimonio2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>PATRIMONIO</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($row_patrimonio1['valor'],0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($row_patrimonio2['valor'],0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_patrimonio,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_relativa_patrimonio,2)."%"; ?></span></th>
            </tr>
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	   
	 ?>
	 <?php 
         $sumatotal_pasivoYpatri1=$total_patrimonio1 + $sumatotal_pasivo1 ;
         $sumatotal_pasivoYpatri2=$total_patrimonio2 + $sumatotal_pasivo2;
         $variacion_absoluta_pasivoYpatri=$sumatotal_pasivoYpatri1 - $sumatotal_pasivoYpatri2;
         $variacion_relativa_pasivoYpatri=(($variacion_absoluta_pasivoYpatri/$sumatotal_pasivoYpatri2)*100);
         ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL PASIVO Y PATRIMONIO</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_pasivoYpatri1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumatotal_pasivoYpatri2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_pasivoYpatri,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_relativa_pasivoYpatri,2)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="7" style="width:14%;text-align:left;"><span></br></span></th>
            </tr>
            <?php
            while($row_categoria7 = $categoria7->FetchRow()){	
	
	  $query_cuentas1="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria7['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $cuentas1= $db->Execute($query_cuentas1);
	  $row_cuentas1= $cuentas1->FetchRow();
	  
	  $query_cuentas2="select valor from siq_formPresupuestoBalanceGeneral where idtipoBalance='".$row_categoria7['idsiq_tipoDatoBalance']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $cuentas2= $db->Execute($query_cuentas2);
	  $row_cuentas2= $cuentas2->FetchRow();
	  
	   /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_cuentas=$row_cuentas1['valor'] - $row_cuentas2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_cuentas=($variacion_absoluta_cuentas/$row_cuentas2['valor'])*100;	  
	  
	?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>Cuentas de Orden</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($row_cuentas1['valor'],0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($row_cuentas2['valor'],0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100%</span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_cuentas,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_relativa_cuentas,2)."%"; ?></span></th>
            </tr>
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	   
	 ?>            
        </tbody>        	
    </table>
<?php
/*$end1 = microtime(true);
$time = $end1 - $start1;
echo "<br/><br/>";echo('totales tardo '. $time . ' seconds to execute.');*/
exit();

}

if(!$db){
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $ruta  = '../reportes/reportes/financieros/viewReportePresupuestoBalanceGeneralComparativo.php';
}else{
    $ruta  = './reportes/financieros/viewReportePresupuestoBalanceGeneralComparativo.php';
}

?>

<form action="" method="post" id="balancegeneral" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#balancegeneral");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url:'<?PHP echo $ruta?>',
				async: false,
				data: $('#balancegeneral').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#balancegeneral #tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
