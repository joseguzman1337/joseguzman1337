<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

if($_GET['anio']) {

require_once("../../../templates/template.php");
$db = getBD();

$codigoperiodo = $_GET['anio'];

$fechaactual=$codigoperiodo."/01/01";
$codigoperiodoanterior = strtotime ( '-1 year' , strtotime ( $fechaactual) );
$codigoperiodoanterior=date('Y',$codigoperiodoanterior);

/*CONSULTAS PARA TRAER CADA UNA DE LAS CATEGORIAS*/
$query_categoria1="select idsiq_tipoEstadoResultados, nombre from siq_tipoEstadoResultados where categoria='Ingresos_Operacionales' and codigoestado like '1%' order by 2";
$categoria1= $db->Execute($query_categoria1);
$totalRows_categoria1= $categoria1->RecordCount();

$query_categoria2="select idsiq_tipoEstadoResultados, nombre from siq_tipoEstadoResultados where categoria='Gastos_Operacionales' and codigoestado like '1%' order by 2";
$categoria2= $db->Execute($query_categoria2);
$totalRows_categoria2= $categoria2->RecordCount();

$query_categoria3="select idsiq_tipoEstadoResultados, nombre from siq_tipoEstadoResultados where categoria='Ingresos_No_Operacionales' and codigoestado like '1%' order by 2";
$categoria3= $db->Execute($query_categoria3);
$totalRows_categoria3= $categoria3->RecordCount();

$query_categoria4="select idsiq_tipoEstadoResultados, nombre from siq_tipoEstadoResultados where categoria='Gastos_No_Operacionales' and codigoestado like '1%' order by 2";
$categoria4= $db->Execute($query_categoria4);
$totalRows_categoria4= $categoria4->RecordCount();

$query_categoria5="select idsiq_tipoEstadoResultados, nombre from siq_tipoEstadoResultados where categoria='Pasivo_No_Corriente' and codigoestado like '1%' order by 2";
$categoria5= $db->Execute($query_categoria5);
$totalRows_categoria5= $categoria5->RecordCount();

$query_categoria6="select idsiq_tipoEstadoResultados, nombre from siq_tipoEstadoResultados where categoria='Patrimonio' and codigoestado like '1%' order by 2";
$categoria6= $db->Execute($query_categoria6);
$totalRows_categoria6= $categoria6->RecordCount();

$query_categoria7="select idsiq_tipoEstadoResultados, nombre from siq_tipoEstadoResultados where categoria='Cuentas_Orden' and codigoestado like '1%' order by 2";
$categoria7= $db->Execute($query_categoria7);
$totalRows_categoria7= $categoria7->RecordCount();

/*CONSULTA DEL TOTAL DE LOS ACTIVOS Y DE LOS PASIVOS*/
$query_totalactivo1="select sum(pb.valor) as totalactivo 
from siq_formEstadoResultadosComparativo  pb,  siq_tipoEstadoResultados s 
where
s.idsiq_tipoEstadoResultados=pb.idtipoEstado
and pb.codigoperiodo='$codigoperiodo'
and pb.codigoestado like '1%'
and (s.categoria='Activo_Corriente' or s.categoria='Activo_No_Corriente')";
$totalactivo1= $db->Execute($query_totalactivo1);
$row_totalactivo1= $totalactivo1->FetchRow();

$query_totalactivo2="select sum(pb.valor) as totalactivo 
from siq_formEstadoResultadosComparativo  pb,  siq_tipoEstadoResultados s 
where
s.idsiq_tipoEstadoResultados=pb.idtipoEstado
and pb.codigoperiodo='$codigoperiodoanterior'
and pb.codigoestado like '1%'
and (s.categoria='Activo_Corriente' or s.categoria='Activo_No_Corriente')";
$totalactivo2= $db->Execute($query_totalactivo2);
$row_totalactivo2= $totalactivo2->FetchRow();

$query_totalpasivo1="select sum(pb.valor) as totalactivo 
from siq_formEstadoResultadosComparativo  pb,  siq_tipoEstadoResultados s 
where
s.idsiq_tipoEstadoResultados=pb.idtipoEstado
and pb.codigoperiodo='$codigoperiodo'
and pb.codigoestado like '1%'
and (s.categoria='Pasivo_Corriente' or s.categoria='Pasivo_No_Corriente' or s.categoria='Pasivo_Diferido')";
$totalpasivo1= $db->Execute($query_totalpasivo1);
$row_totalpasivo1= $totalpasivo1->FetchRow();

$query_totalpasivo2="select sum(pb.valor) as totalactivo 
from siq_formEstadoResultadosComparativo  pb,  siq_tipoEstadoResultados s 
where
s.idsiq_tipoEstadoResultados=pb.idtipoEstado
and pb.codigoperiodo='$codigoperiodoanterior'
and pb.codigoestado like '1%'
and (s.categoria='Pasivo_Corriente' or s.categoria='Pasivo_No_Corriente' or s.categoria='Pasivo_Diferido')";
$totalpasivo2= $db->Execute($query_totalpasivo2);
$row_totalpasivo2= $totalpasivo2->FetchRow();

?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                    <th class="column" colspan="5" style="width:80%;text-align:center;"><span>ESTADO DE RESULTADOS COMPARATIVO<br>DEL PERIODO COMPRENDIDO ENTRE ENERO 1 A DICIEMBRE 31 DE <?php echo $codigoperiodo." - ".$codigoperiodoanterior; ?><br>(Expresado en Millones de Pesos)</span></th>                    
             </tr>
             <tr class="dataColumns">            
                <th class="column" style="width:13%;text-align:center;"><span>&nbsp;</span></th>
		<th class="column" style="width:13%;text-align:center;"><span>Año Actual <?php echo $codigoperiodo;?></span></th>       
                <th class="column" style="width:13%;text-align:center;"><span>Año Anterior <?php echo $codigoperiodoanterior;?></span></th>       
                <th class="column" style="width:14%;text-align:center;"><span>Variación Absoluta</span></th>
                <th class="column" style="width:14%;text-align:center;"><span>Variación Relativa</span></th>                
             </tr>    
        </thead>
        <tbody>
	    <tr class="contentColumns" class="row">
              <th class="column" colspan="5" style="width:14%;text-align:left;"><span>INGRESOS Y GASTOS OPERACIONALES</span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="5" style="width:14%;text-align:left;"><span>MAS: INGRESOS OPERACIONALES</span></th>
            </tr>
	<?php	
	while($row_categoria1 = $categoria1->FetchRow()){	
	
	  $query_ingresosop1="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria1['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $ingresosop1= $db->Execute($query_ingresosop1);
	  $row_ingresosop1= $ingresosop1->FetchRow();
	  
	  $query_ingresosop2="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria1['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $ingresosop2= $db->Execute($query_ingresosop2);
	  $row_ingresosop2= $ingresosop2->FetchRow();
	  
	  /*Sumatoria activos*/
	  $total_ingresosop1=$row_ingresosop1['valor'];
	  $total_ingresosop2=$row_ingresosop2['valor'];
	  
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_ingresoop=$row_ingresosop1['valor'] - $row_ingresosop2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_ingresosop=(($variacion_absoluta_ingresoop/$row_ingresosop2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria1['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_ingresosop1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_ingresosop2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta_ingresoop,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa_ingresosop)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }
	 ?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL INGRESOS OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosop2,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_ingresoop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_ingresosop)."%"; ?></span></th>
            </tr>
             <tr class="contentColumns" class="row">
              <th class="column" colspan="5" style="width:14%;text-align:left;"><span>MENOS: GASTOS OPERACIONALES</span></th>
            </tr>	 
            <?php
	//exit();
	while($row_categoria2 = $categoria2->FetchRow()){	
	
	  $query_gastosop1="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria2['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $gastosop1= $db->Execute($query_gastosop1);
	  $row_gastosop1= $gastosop1->FetchRow();
	  
	  $query_gastosop2="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria2['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $gastosop2= $db->Execute($query_gastosop2);
	  $row_gastosop2= $gastosop2->FetchRow();
	  
	  /*Sumatoria activos*/
	  $total_gastosop1=$row_gastosop1['valor']+$total_gastosop1;
	  $total_gastosop2=$row_gastosop2['valor']+$total_gastosop2;
	    
	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_gastosop=$row_gastosop1['valor'] - $row_gastosop2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_gastosop=(($variacion_absoluta_gastosop/$row_gastosop2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria2['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_gastosop1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_gastosop2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta_gastosop,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa_gastosop)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	 
	  /*Calculo variacion absoluta total*/	  
	  $variacion_absoluta_total_gastosop=$total_gastosop1 - $total_gastosop2;
	  
	  /*Calculo variacion relativa total*/	  
	  $variacion_relativa_total_gastosop=(($variacion_absoluta_total_gastosop/$total_gastosop2)*100);	 
	 ?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL GASTOS OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosop2,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_gastosop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_gastosop)."%"; ?></span></th>
            </tr>            
            <?php             
	      $total_excedenteop1=$total_ingresosop1 - $total_gastosop1;
	      $total_excedenteop2=$total_ingresosop2 - $total_gastosop2;
	      $variacion_absoluta_excedenteop=$variacion_absoluta_ingresoop - $variacion_absoluta_total_gastosop;
	      $variacion_relativa_excedenteop=(($variacion_absoluta_excedenteop/$total_excedenteop2)*100);            
            ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>EXCEDENTE OPERACIONAL</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_excedenteop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_excedenteop2,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_excedenteop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_excedenteop)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="5" style="width:14%;text-align:left;"><span></br></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="5" style="width:14%;text-align:left;"><span>INGRESOS Y GASTOS NO OPERACIONALES</span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" colspan="5" style="width:14%;text-align:left;"><span>MAS: INGRESOS NO PERACIONALES</span></th>
            </tr>            
            <?php
            while($row_categoria3 = $categoria3->FetchRow()){	
	
	  $query_ingresosnoop1="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria3['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $ingresosnoop1= $db->Execute($query_ingresosnoop1);
	  $row_ingresosnoop1= $ingresosnoop1->FetchRow();
	  
	  $query_ingresosnoop2="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria3['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $ingresosnoop2= $db->Execute($query_ingresosnoop2);
	  $row_ingresosnoop2= $ingresosnoop2->FetchRow();
	  
	  /*Sumatoria Pasivos*/
	  $total_ingresosnoop1=$row_ingresosnoop1['valor']+$total_ingresosnoop1;
	  $total_ingresosnoop2=$row_ingresosnoop2['valor']+$total_ingresosnoop2;	  
	  	   
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_ingresosnoop=$row_ingresosnoop1['valor'] - $row_ingresosnoop2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_ingresosnoop=(($variacion_absoluta_ingresosnoop/$row_ingresosnoop2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria3['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_ingresosnoop1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_ingresosnoop2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta_ingresosnoop,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa_ingresosnoop)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	 
	 /*Calculo variacion absoluta total*/	  
	  $variacion_absoluta_total_ingresosnoop=$total_ingresosnoop1 - $total_ingresosnoop2;
	  
	  /*Calculo variacion relativa total*/	  
	  $variacion_relativa_total_ingresosnoop=(($variacion_absoluta_total_ingresosnoop/$total_ingresosnoop2)*100);
	 ?>
	     <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL INGRESOS NO OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosnoop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosnoop2,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_ingresosnoop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_ingresosnoop)."%"; ?></span></th>
            </tr>            
            <tr class="contentColumns" class="row">
              <th class="column" colspan="5" style="width:14%;text-align:left;"><span>MENOS: GASTOS NO OPERACIONALES</span></th>
            </tr>
            <?php
            while($row_categoria4 = $categoria4->FetchRow()){	
	
	  $query_gastosnoop1="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria4['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $gastosnoop1= $db->Execute($query_gastosnoop1);
	  $row_gastosnoop1= $gastosnoop1->FetchRow();
	  
	  $query_gastosnoop2="select valor from siq_formEstadoResultadosComparativo where idtipoEstado='".$row_categoria4['idsiq_tipoEstadoResultados']."'
	  and codigoperiodo='$codigoperiodoanterior'
	  and codigoestado like '1%'";
	  $gastosnoop2= $db->Execute($query_gastosnoop2);
	  $row_gastosnoop2= $gastosnoop2->FetchRow();
	  
	  /*Sumatoria Pasivos*/
	  $total_gastosnoop1=$row_gastosnoop1['valor']+$total_gastosnoop1;
	  $total_gastosnoop2=$row_gastosnoop2['valor']+$total_gastosnoop2;	  
	  	  
	  /*Calculo variacion absoluta*/	  
	  $variacion_absoluta_gastosnoop=$row_gastosnoop1['valor'] - $row_gastosnoop2['valor'];
	  
	  /*Calculo variacion relativa*/	  
	  $variacion_relativa_gastosnoop=(($variacion_absoluta_gastosnoop/$row_gastosnoop2['valor'])*100);	  
	  
	?>
	    <tr class="contentColumns" class="row">
		  <td class="column" style="width:20%;"><?php echo $row_categoria4['nombre']; ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_gastosnoop1['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:13%;"><?php echo number_format($row_gastosnoop2['valor'],0); ?></td>
		  <td class="column" style="text-align:center;width:14%;"><?php echo number_format($variacion_absoluta_gastosnoop,0); ?></td>              
		  <td class="column" style="text-align:center;width:14%;"><?php echo round($variacion_relativa_gastosnoop)."%"; ?></td>    
	    </tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }
	  /*Calculo variacion absoluta total*/	  
	  $variacion_absoluta_total_gastosnoop=$total_gastosnoop1 - $total_gastosnoop2;
	  
	  /*Calculo variacion relativa total*/	  
	  $variacion_relativa_total_gastosnoop=(($variacion_absoluta_total_gastosnoop/$total_gastosnoop2)*100);	 
	 ?>
	    <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL GASTOS NO OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosnoop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosnoop2,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_gastosnoop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_gastosnoop)."%"; ?></span></th>
            </tr>
            <?php             
	      $total_excedentenoop1=$total_ingresosnoop1 - $total_gastosnoop1;
	      $total_excedentenoop2=$total_ingresosnoop2 - $total_gastosnoop2;
	      $variacion_absoluta_excedentenoop=$total_excedentenoop1 - $total_excedentenoop2;
	      $variacion_relativa_excedentenoop=($variacion_absoluta_excedentenoop/$total_excedentenoop2)*100;            
            ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>EXCEDENTE NO OPERACIONAL</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_excedentenoop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_excedentenoop2,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_excedentenoop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_excedentenoop)."%"; ?></span></th>
            </tr>
            <?php             
	      $total_excedentefunda1=$total_excedenteop1 - $total_excedentenoop1;
	      $total_excedentefunda2=$total_excedenteop2 - $total_excedentenoop2;
	      $variacion_absoluta_excedentefunda=$total_excedentefunda1 - $total_excedentefunda2;
	      $variacion_relativa_excedentefunda=(($variacion_absoluta_excedentefunda/$total_excedentefunda2)*100);            
            ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>EXCEDENTE FUNDACIONAL</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_excedentefunda1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_excedentefunda2,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_excedentefunda,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_excedentefunda)."%"; ?></span></th>
            </tr>
            
        </tbody>        	
    </table>
	
	<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 20px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                    <th class="column" colspan="7" style="width:80%;text-align:center;"><span>TABLA CONSOLIDADO P&G</span></th>                    
             </tr>
             <tr class="dataColumns">            
                <th class="column" style="width:13%;text-align:center;"><span>&nbsp;</span></th>
		<th class="column" style="width:13%;text-align:center;"><span>Año Actual <?php echo $codigoperiodo;?></span></th>     
                <th class="column" style="width:13%;text-align:center;"><span>% Participación</span></th>  
                <th class="column" style="width:13%;text-align:center;"><span>Año Anterior <?php echo $codigoperiodoanterior;?></span></th>   
                <th class="column" style="width:13%;text-align:center;"><span>% Participación</span></th>      
                <th class="column" style="width:14%;text-align:center;"><span>Variación Absoluta</span></th>
                <th class="column" style="width:14%;text-align:center;"><span>Variación Relativa</span></th>                
             </tr>   
		</thead>
	<tbody>
            <?php 
            
            $calculoingresos1=$total_ingresosop1+$total_ingresosnoop1;
            $calculoingresos2=$total_ingresosop2+$total_ingresosnoop2;
            
            $calculoingresosop1=$total_ingresosop1/$calculoingresos1*100;           
            $calculoingresosop2=$total_ingresosop2/$calculoingresos2*100;
            
            $calculoingresosnoop1=$total_ingresosnoop1/$calculoingresos1*100;
            $calculoingresosnoop2=$total_ingresosnoop2/$calculoingresos2*100;
            ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL INGRESOS OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoingresosop1,2); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosop2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoingresosop2,2); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_ingresoop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_ingresosop)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL INGRESOS NO OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosnoop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoingresosnoop1,2); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_ingresosnoop2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoingresosnoop2,2); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_ingresosnoop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_ingresosnoop)."%"; ?></span></th>
            </tr> 
            <?php
            $sumacalculoingresos1=$calculoingresosop1+$calculoingresosnoop1;
            $sumacalculoingresos2=$calculoingresosop2+$calculoingresosnoop2;
            $variacion_absoluta_ingresos=$calculoingresos1-$calculoingresos2;
            $variacion_relativa_ingresos=$variacion_absoluta_ingresos / $calculoingresos2 *100;
			
            $total_gastos1=$total_gastosop1+$total_gastosnoop1;
            $total_gastos2=$total_gastosop2+$total_gastosnoop2;
            $variacion_absoluta_gastos=$total_gastos1-$total_gastos2;
            $variacion_relativa_gastos=$variacion_absoluta_gastos / $total_gastos2 *100;
            
            $calculogastosop1=$total_gastosop1/$total_gastos1*100;           
            $calculogastosop2=$total_gastosop2/$total_gastos2*100;
			
            $calculogastosnop1=$total_gastosnoop1/$total_gastos1*100;           
            $calculogastosnop2=$total_gastosnoop2/$total_gastos2*100;
			
            ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL INGRESOS</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoingresos1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumacalculoingresos1,2); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoingresos2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($sumacalculoingresos2,2); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_ingresos,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_ingresos)."%"; ?></span></th>
            </tr> 
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL GASTOS OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculogastosop1,2); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosop2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculogastosop2,2); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_gastosop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_gastosop)."%"; ?></span></th>
            </tr> 
             <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL GASTOS NO OPERACIONALES</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosnoop1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculogastosnop1,2); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastosnoop2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculogastosnop2,2); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_total_gastosnoop,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_total_gastosnoop)."%"; ?></span></th>
            </tr>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>TOTAL GASTOS</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastos1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($total_gastos2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span>100</span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_gastos,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_gastos)."%"; ?></span></th>
            </tr>
            <?php             
	      $restatotal_excedentefunda1=$calculoingresos1 - $total_gastos1;
	      $restatotal_excedentefunda2=$calculoingresos2 - $total_gastos2;
	      $variacion_absoluta_resta_excedentefunda=$restatotal_excedentefunda1 - $restatotal_excedentefunda2;
	      $variacion_relativa_resta_excedentefunda=$variacion_absoluta_resta_excedentefunda / $restatotal_excedentefunda2 * 100;     
		  
            $calculoEF1=$restatotal_excedentefunda1/$restatotal_excedentefunda1*100;           
            $calculoEF2=$restatotal_excedentefunda2/$restatotal_excedentefunda2*100;       
            ?>
            <tr class="contentColumns" class="row">
              <th class="column" style="width:20%;text-align:left;"><span>EXCEDENTE FUNDACIONAL</span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($restatotal_excedentefunda1,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoEF1,2); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($restatotal_excedentefunda2,0); ?></span></th>
              <th class="column" style="width:13%;text-align:center;"><span><?php echo number_format($calculoEF2,2); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo number_format($variacion_absoluta_resta_excedentefunda,0); ?></span></th>
              <th class="column" style="width:14%;text-align:center;"><span><?php echo round($variacion_relativa_resta_excedentefunda)."%"; ?></span></th>
            </tr>    
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
    $ruta  = '../reportes/reportes/financieros/viewReportePresupuestoEstadoResultadosComparativo.php';
}else{
    $ruta  = './reportes/financieros/viewReportePresupuestoEstadoResultadosComparativo.php';
}
?>

<form action="" method="post" id="estadoresultados" class="report">
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
		var valido= validateForm("#estadoresultados");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#estadoresultados #tableDiv').html("");
            $("#estadoresultados #loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: '<?PHP echo $ruta?>',
				async: false,
				data: $('#estadoresultados').serialize(),                
				success:function(data){			
                                    $("#estadoresultados #loading").css("display","none");		
					$('#estadoresultados #tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
