<?php require_once('../../../Connections/sala2.php');
session_start();
//$carrera = 300;
//echo $database_sala;
$carrera = $_SESSION['codigofacultad'];
 mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT *
FROM periodo p,carreraperiodo cp
WHERE codigoestadoperiodo = '3'
AND cp.codigoperiodo = p.codigoperiodo
AND cp.codigocarrera = '$carrera'";
//echo $query_periodo;
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if ($row_periodo <> "")
  {
   $periodoactual = $row_periodo['codigoperiodo'];
  }
else
  {
    mysql_select_db($database_sala, $sala);
	$query_periodo = "SELECT *
    FROM periodo p,carreraperiodo cp
    WHERE codigoestadoperiodo = '1'
	AND cp.codigoperiodo = p.codigoperiodo
    AND cp.codigocarrera = '$carrera'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);

    $periodoactual = $row_periodo['codigoperiodo'];
  }
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {
	font-size: small;
	font-weight: bold;
}
-->
</style>
<form name="form1" method="post" action="cierresemestreaviso.php">
<p>&nbsp;</p>
<table width="410" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
        <td  bgcolor="#607766"  class="Estilo1 Estilo4 Estilo1">
        <div align="center" class="Estilo18 Estilo1 Estilo3" style="color: #FFFFFF">UNIVERSIDAD EL BOSQUE            </div></td>
   </tr>
   <tr>
        <td  bgcolor="#C5D5D6" class="Estilo4 Estilo1 Estilo2">
          <div align="center">
       <p><span class="Estilo2 Estilo23 Estilo27 Estilo1 Estilo3">ATENCI&Oacute;N !!!</span></p>
       <p><strong><font color="#000000"> Despu&eacute;s  de generado el cierre solo


podr&aacute;  hacer modificaciones directamente en el


hist&oacute;rico  de notas.</font></strong></p>
       <p>&nbsp;</p>
       <p><strong><font color="#000000">&iquest; Esta seguro de generar el cierre ? </font></strong></p>
       <p>&nbsp;</p>
          </div>
          <div align="center">
            <p><input name="seguro" type="submit" id="seguro" value="Generar Cierre">
&nbsp;&nbsp;&nbsp; &nbsp;
              <input type='button' onClick='history.go(-1)' value='Cancelar'>
            </p>
        </div></td>
   </tr>
 </table>
<p>
</p>
<?php
if ($_POST['seguro'])
{ // mayor
mysql_select_db($database_sala, $sala);
	   $query_cierre = "SELECT	*
						FROM procesoperiodo
						WHERE codigoperiodo = '$periodoactual'
				        and codigocarrera = '$carrera'
						and idproceso = '1'
						and codigoestadoprocesoperiodo = '100'";
		//echo $query_cierre,"<br>";
		//exit();
		$cierre = mysql_query($query_cierre, $sala) or die(mysql_error());
		$row_cierre = mysql_fetch_assoc($cierre);
 if ($row_cierre <> "")
  { // if 1
    if ($row_cierre['fechainicioprocesoperiodo']<=date("Y-m-d",time()) &&  date("Y-m-d",time()) <= $row_cierre['fechafinalprocesoperiodo'])
    {
	  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listafallas.php'>";
	  exit();
	}
   else
    {
	  echo '<script language="JavaScript">alert("La fecha para realizar el cierre academico es de  '.$row_cierre['fechainicioprocesoperiodo'].'  a  '.$row_cierre['fechafinalprocesoperiodo'].'")</script>';
	}
   } // if 1
 else
   { // else 1
    $query_cierre = "SELECT	*
	FROM procesoperiodo
	WHERE codigoperiodo = '$periodoactual'
    and codigocarrera = '$carrera'
	and idproceso = '1'
	and codigoestadoprocesoperiodo = '200'";
    //echo $query_estudiantes,"<br>";
	//exit();
	$cierre = mysql_query($query_cierre, $sala) or die(mysql_error());
	$row_cierre = mysql_fetch_assoc($cierre);

	  if ($row_cierre <> "")
	    {
		  //echo "Muestra listado";
		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cierresemestrelistado.php'>";
		  exit();
		}

   } // else 1
} // if mayor
?>
</form>
