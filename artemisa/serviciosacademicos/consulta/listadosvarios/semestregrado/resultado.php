<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');


$codigocarrera = $_REQUEST['codigocarrera'];
$codigoperiodo = $_REQUEST['codigoperiodo'];

if(isset($_REQUEST['exportar'])) {
    $formato = 'xls';
    $nombrearchivo = "Listado";
    $strType = 'application/msexcel';
    $strName = $nombrearchivo.".xls";

    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");

}
if($codigocarrera!='todos'){
$query_nomcarrera="select nombrecarrera from carrera where codigocarrera='$codigocarrera'";
$nomcarrera= $db->Execute($query_nomcarrera);
$totalRows_nomcarrera= $nomcarrera->RecordCount();
$row_nomcarrera= $nomcarrera->FetchRow();
}

$query_nomperiodo="select nombreperiodo from periodo where codigoperiodo='$codigoperiodo'";
$nomperiodo= $db->Execute($query_nomperiodo);
$totalRows_nomperiodo= $nomperiodo->RecordCount();
$row_nomperiodo= $nomperiodo->FetchRow();

 if($codigocarrera!='todos'){
  $concarrera1="AND e.codigocarrera ='$codigocarrera'";
 }
   $query_cuentadata = "SELECT count(*) as cuenta
            
   FROM ordenpago o
   join estudiante e on e.codigoestudiante=o.codigoestudiante
   join prematricula pr on e.codigoestudiante=pr.codigoestudiante
   join carrera c on c.codigocarrera=e.codigocarrera
                                    join detalleordenpago d on o.numeroordenpago=d.numeroordenpago
                        join concepto co on d.codigoconcepto=co.codigoconcepto
                        WHERE
                        pr.codigoperiodo='$codigoperiodo'
                        AND co.cuentaoperacionprincipal=151
                        and c.codigomodalidadacademica=200                      
                        AND o.codigoperiodo='$codigoperiodo'
                        AND o.codigoestadoordenpago LIKE '4%'
                        AND e.codigoperiodo='$codigoperiodo'
                        $concarrera1";
                    $cuentadata= $db->Execute($query_cuentadata);
                    $totalRows_cuentadata= $cuentadata->RecordCount();
                    $row_cuentadata= $cuentadata->FetchRow();


?>

<html>
    <head>
      <?php
            if(!isset($_REQUEST['exportar'])){
      ?>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <?php
           }
         ?>
    </head>
    <body>
        <form action=""  name="form1" method="POST">
            
            <br><br>           
            <table  border="1" cellpadding="3" cellspacing="3" align="center">
                <?php
                if(!isset($_REQUEST['exportar'])){
                ?>
                <tr>
                    <td  colspan="<?php if($codigocarrera!='todos'){ echo "3";}else{ echo "4";} ?>" align="left" >
                        <INPUT type="button" name="Regresar" value="Regresar" onclick="window.location.href='menu.php'">
                        <INPUT type="submit" name="exportar" value="Exportar">
                    </td>
                </tr>
                <?php
                }
                ?>
                <TR>
                    <TD  align="center" colspan="<?php if($codigocarrera!='todos'){ echo "3";}else{ echo "4";} ?>" id="tdtitulogris">
                         <label id="labelresaltadogrande" >LISTADO INGRESO Y PERIODO GRADO <br><?php if($codigocarrera!='todos'){echo $row_nomcarrera['nombrecarrera'];} else{ echo "TODAS LAS CARRERAS";} ?> </label>
                    </TD>
		</tr>
		<tr>
		  <TD  align="center" colspan="<?php if($codigocarrera!='todos'){ echo "3";}else{ echo "4";} ?>" id="tdtitulogris">
                        <label id="labelresaltadogrande" ><?php echo $row_nomperiodo['nombreperiodo']; ?> </label>
                    </TD>

			</TR>
		<tr>
                  <TD  align="center" colspan="<?php if($codigocarrera!='todos'){ echo "3";}else{ echo "4";} ?>" id="tdtitulogris">
                        <label id="labelresaltadogrande" >TOTAL ESTUDIANTES=<?php echo $row_cuentadata['cuenta']; ?> </label>
                    </TD>

                        </TR>
		
                <?php
			
		if($codigocarrera!='todos'){
		   $concarrera="AND e.codigocarrera ='$codigocarrera'";
		
		}
                    $query_infodata = "SELECT count(*) as cuenta
                                ,e.codigocarrera
                                ,(select p.codigoperiodo
                                  from periodo p
                                  where r.fechagradoregistrograduado between p.fechainicioperiodo and p.fechavencimientoperiodo) periodo, c.nombrecarrera
                                
                        FROM ordenpago o
                        join estudiante e on e.codigoestudiante=o.codigoestudiante
                        join prematricula pr on e.codigoestudiante=pr.codigoestudiante
                        join carrera c on c.codigocarrera=e.codigocarrera
                        left join registrograduado r on e.codigoestudiante=r.codigoestudiante
                        join detalleordenpago d on o.numeroordenpago=d.numeroordenpago
                        join concepto co on d.codigoconcepto=co.codigoconcepto
                        WHERE
                        pr.codigoperiodo='$codigoperiodo'
                        AND co.cuentaoperacionprincipal=151
			and c.codigomodalidadacademica=200			
                        AND o.codigoperiodo='$codigoperiodo'
                        AND o.codigoestadoordenpago LIKE '4%'
                        AND e.codigoperiodo='$codigoperiodo'
			$concarrera
                        group by periodo, e.codigocarrera
                        order by e.codigocarrera,periodo";
                    $infodata= $db->Execute($query_infodata);
                    $totalRows_infodata= $infodata->RecordCount();
                    $row_infodata= $infodata->FetchRow();
		if($totalRows_infodata!=""){
		?>
		 <tr>
		   <?php if($codigocarrera=='todos'){  ?>		   
                   <td id="tdtitulogris">CARRERA</td>
		   <?php
		   }
		   ?>
                   <td id="tdtitulogris">PERIODO EGRESO</td>
                   <td id="tdtitulogris">CANTIDAD</td> 
                   <td id="tdtitulogris">%</td> 
                 </tr>

		    <?php 
                    do{ ?>
                    <tr>
                        <?php 
			if($codigocarrera=='todos'){			
			?>
			<td ><?php echo  $row_infodata['nombrecarrera']; ?></td>
			<?php }  ?>
			<td ><?php if($row_infodata['periodo']!=''){ echo  $row_infodata['periodo'];}else{echo "Sin Registro";} ?></td>
                        <td ><?php echo $row_infodata['cuenta']; ?></td>
                        <td ><?php $porcentaje=$row_infodata['cuenta']*100/$row_cuentadata['cuenta'];  echo round($porcentaje)."%"; ?></td>
                    </tr>    
                    <?php
                    }while($row_infodata = $infodata->FetchRow());
                }
		else{
		echo '<script language="JavaScript">alert("No se encuentran resultados asociados al periodo.");
		window.location.href="menu.php";
		</script>';
		}
                ?>
            </table>
                      
        </form>
    </body>
</html>
