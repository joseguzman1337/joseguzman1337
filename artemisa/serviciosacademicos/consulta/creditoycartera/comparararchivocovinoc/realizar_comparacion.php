<?php
session_start();
require_once('../../../Connections/sala2.php'); 
require_once('../../../funciones/funcionip.php');

if (!$_SESSION['MM_Username'])
 {
   header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
 }
mysql_select_db($database_sala, $sala); 

$query_periodo = "select *
from periodo p
ORDER BY p.codigoperiodo DESC";
//echo "$query_periodo<br>";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Realizar Comparación entre Archivos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<link rel="stylesheet" type="text/css" href="../../../sala.css">
<form method="post" action="" name="f1">
<body>
<p>Realizar Comparación entre Archivos</p>

<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
  <tr>
    <td id"titulonaranja">Carga Archivo Covinoc <a onClick="window.open('cargararchivoscovinoc.php','mensajes','width=550,height=700,left=150,top=50,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/correo1.png" width="20" height="20" alt="Carga Archivo Covinoc"></a></td>
	<td>Carga Archivo Sap <a onClick="window.open('cargararchivossap.php','mensajes','width=550,height=700,left=150,top=50,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/correo1.png" width="20" height="20" alt="Carga Archivo Sap"></a></td>
  </tr>
   <tr>
    <td>Periodo a Verificar Estudiantes Reportados doble vez</td>	
	<td><select name="periodo">
  <?php
do {  
?>
           <option value="<?php echo $row_periodo['codigoperiodo']?>"<?php if (!(strcmp($row_periodo['codigoperiodo'], $_POST['periodo']))) {echo "SELECTED";} ?>><?php echo $row_periodo['nombreperiodo']?></option>
   <?php
} while ($row_periodo = mysql_fetch_assoc($periodo));
  $rows = mysql_num_rows($periodo);
  if($rows > 0) {
      mysql_data_seek($periodo, 0);
	  $row_periodo = mysql_fetch_assoc($periodo);
  }
?>
        </select> </td>	
  </tr>
   <tr>
    <td><input type="submit" name="comparar" value="Realizar Comparación" ></td>	
	<td><input type="submit" name="resetear" value="Generar Nueva Carga" ></td>	
  </tr>
</table>
</body>

<?php 
if ($_POST['comparar'])
 {
    unset($Arraycovinoc);
	unset($Arraydoblefactura);
	unset($Arraysap);
	$move = true;
	/**** datos SAP ****/
	$query_sap = "select distinct interlocutor 
	from zdatossap
	where procesado = ''";
	$sap = mysql_query($query_sap, $sala) or die(mysql_error());
	$row_sap = mysql_fetch_assoc($sap);
	$totalRows_sap = mysql_num_rows($sap);	
     
	 do{
		   $query_sap2 = "select monto
		   from zdatossap
		   where interlocutor = '".$row_sap['interlocutor']."'
		   and procesado = ''";
		   $sap2 = mysql_query($query_sap2, $sala) or die(mysql_error());
		   $row_sap2 = mysql_fetch_assoc($sap2);
		   $totalRows_sap2 = mysql_num_rows($sap2);	
           $valor = 0;
		   do{
		     $valor =  $valor + $row_sap2['monto'];		   
		   }while($row_sap2 = mysql_fetch_assoc($sap2));	  
	       
		   $Arraysap[$row_sap['interlocutor']]= $valor;    
   	      
	  }while($row_sap = mysql_fetch_assoc($sap));
 
  // print_r($Arraysap);
 
    $query_doble = "SELECT COUNT(*) AS cuenta,numerodocumento,factura,codigoperiodo
	FROM zdatoscovinoc
	WHERE codigoperiodo = '".$_POST['periodo']."'
	GROUP by 2,4
	HAVING cuenta > 1 ";
	$doble = mysql_query($query_doble, $sala) or die(mysql_error());
	$row_doble = mysql_fetch_assoc($doble);
	$totalRows_doble = mysql_num_rows($doble);	
 
    do{
	  
	$query_doble1 = "SELECT *
	FROM zdatoscovinoc
	WHERE numerodocumento = '".$row_doble['numerodocumento']."'
	and codigoperiodo = '".$_POST['periodo']."'
	and factura <>  '".$row_doble['factura']."'";
	$doble1 = mysql_query($query_doble1, $sala) or die(mysql_error());
	$row_doble1 = mysql_fetch_assoc($doble1);
	$totalRows_doble1 = mysql_num_rows($doble1);	
	
	if ($row_doble1 <> "")
	 {
	   $Arraydoblefactura[$row_doble['numerodocumento']] = $row_doble['factura']."&nbsp; -- &nbsp;".$row_doble1['factura']; 
	 }
	
	}while($row_doble = mysql_fetch_assoc($doble)); 
 
 
 //*** datos covinoc *////
 
    $query_covinoc = "select distinct numerodocumento,nombreestudiante 
	from zdatoscovinoc
	where procesado = ''";
	$covinoc = mysql_query($query_covinoc, $sala) or die(mysql_error());
	$row_covinoc = mysql_fetch_assoc($covinoc);
	$totalRows_covinoc = mysql_num_rows($covinoc);	
     
	 do{
		   $query_covinoc2 = "select monto
		   from zdatoscovinoc
		   where numerodocumento = '".$row_covinoc['numerodocumento']."'
		   and procesado = ''";
		   $covinoc2 = mysql_query($query_covinoc2, $sala) or die(mysql_error());
		   $row_covinoc2 = mysql_fetch_assoc($covinoc2);
		   $totalRows_covinoc2 = mysql_num_rows($covinoc2);	
           $valor = 0;
		   do{		     
			 $valor =  $valor + $row_covinoc2['monto'];			     
		   }while($row_covinoc2 = mysql_fetch_assoc($covinoc2));	  
	       
		   
		   $valor = calculado($valor);
		
		   //echo  "<br>$valor<br>"; 
		   $query_inter = "select idestudiantegeneral
		   from estudiantegeneral
		   where numerodocumento = '".$row_covinoc['numerodocumento']."'";
		   //echo "$query_inter";
		   $inter = mysql_query($query_inter, $sala) or die(mysql_error());
		   $row_inter = mysql_fetch_assoc($inter);
		   $totalRows_inter = mysql_num_rows($inter);	 
		   if ($row_inter <> "")
		    {		   
		     $Arraycovinoc[$row_inter['idestudiantegeneral']]= $valor;    
   	        } 
		   else
		    {
			 //if ($row_covinoc['nombreestudiante'] <> 0)
			  $noencontrados[$row_covinoc['numerodocumento']] = $row_covinoc['nombreestudiante'];
			
			}
	  }while($row_covinoc = mysql_fetch_assoc($covinoc));
 
    if (is_array($Arraycovinoc))
	 {
	 foreach ($Arraycovinoc as $document => $value)
	  {
	    $flag = 0;
		foreach($Arraysap as $documetsap => $valuesap)
		 {
		   if ($document == $documetsap)
		    {			
			 //echo "$document == $documetsap <br> ";
			 $flag = 1;
			 if ($valuesap < $value) // debe ir <
			  {			    
			    $inconsistencia[] = $document;
			    $valorerrado[$document] = "SAP -> $".number_format($valuesap).  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COVINOC -> $".number_format($value); 
			  }
			}
		 }	  
	    //echo $flag;
		if ($flag == 0)
		 {
		  $noencontrosap[]= $document;
		 }	  
	  }
	 } 
  // print_r($noencontrosap);
 }

function calculado($valor)
{
  $valor = $valor * 2 / 100;
  $iva = $valor * 16 / 100;
  $valor = $valor  + $iva;
  $valor = round($valor ); 
  return $valor;
} 


 if (is_array($inconsistencia))
  {
     $move = false;
  ?> 
<p>Inconsistencias Archivo Covinoc</p>
 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
     <tr>
      <td>Documento</td> 
	  <td>Nombre</td>
	  <td>Carrera</td>
	  <td>Valor</td>	 
     </tr>
<?php  
   foreach ($inconsistencia as $code => $value)
    {
	   $query_inter = "SELECT DISTINCT z.numerodocumento,nombreestudiante,nombrecarrera
	   FROM estudiantegeneral e,zdatoscovinoc z
	   WHERE z.numerodocumento = e.numerodocumento
	   AND idestudiantegeneral = '$value'
	   and procesado = ''";
	   $inter = mysql_query($query_inter, $sala) or die(mysql_error());
	   $row_inter = mysql_fetch_assoc($inter);
	   $totalRows_inter = mysql_num_rows($inter);	 
?>	  
     <tr>
	  <td><?php echo $row_inter['numerodocumento'];?></td> 
	  <td><?php echo $row_inter['nombreestudiante'];?></td>
	  <td><?php echo $row_inter['nombrecarrera'];?></td> 
	  <td><?php 
	    foreach($valorerrado as $idestudiante => $valores)
	    {
		  if ($value == $idestudiante) 
		   {
		     echo $valores;
		   }
		}	  
	  ?></td> 
     </tr> 
<?	  
	}  
?>
 </table>
<?php   
  }


 if (is_array($noencontrados))
  {
   $move = false;
?> 
<p>Estudiantes NO Encontrados en SALA</p>
 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
     <tr>
      <td>Documento</td> 
	  <td>Nombre</td>
	  <td>Carrera</td>
     </tr>
<?php  
   foreach ($noencontrados as $code => $value)
    {
	   $query_inter = "SELECT DISTINCT numerodocumento,nombreestudiante,nombrecarrera
	   FROM zdatoscovinoc 
	   WHERE numerodocumento = '$code'
	   ";
	   $inter = mysql_query($query_inter, $sala) or die(mysql_error());
	   $row_inter = mysql_fetch_assoc($inter);
	   $totalRows_inter = mysql_num_rows($inter);	 
?>	  
     <tr>
	  <td><?php echo $row_inter['numerodocumento'];?></td> 
	  <td><?php echo $row_inter['nombreestudiante'];?></td>
	  <td><?php echo $row_inter['nombrecarrera'];?></td> 
     </tr> 
<?	  
	}  
?>
 </table>
<?php   
  }


 if (is_array($noencontrosap))
  {
   $move = false;
?> 
<p>Estudiantes NO Encontrados en el Archivo de SAP</p>
 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
     <tr>
      <td>Documento</td> 
	  <td>Nombre</td>
	  <td>Carrera</td>
     </tr>
<?php  
   foreach ($noencontrosap as $code => $value)
    {
	   $query_inter = "SELECT DISTINCT z.numerodocumento,nombreestudiante,nombrecarrera
	   FROM estudiantegeneral e,zdatoscovinoc z
	   WHERE z.numerodocumento = e.numerodocumento
	   AND idestudiantegeneral = '$value'
	   ";
	   //echo $query_inter;
	   $inter = mysql_query($query_inter, $sala) or die(mysql_error());
	   $row_inter = mysql_fetch_assoc($inter);
	   $totalRows_inter = mysql_num_rows($inter);	 
?>	  
     <tr>
	  <td><?php echo $row_inter['numerodocumento'];?></td> 
	  <td><?php echo $row_inter['nombreestudiante'];?></td>
	  <td><?php echo $row_inter['nombrecarrera'];?></td> 
     </tr> 
<?	  
	}  
?>
 </table>
<?php   
  }

if (is_array($Arraydoblefactura))
  {
   $move = false;
?> 
<p>Estudiantes Reportados Doble vez por Covinoc en un mismo Periodo</p>
 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
     <tr>
      <td>Documento</td> 
	  <td>Nombre</td>
	  <td>Facturas</td>
	  <td>Desactivar</td>
     </tr>
<?php  
   $j = 0;
   foreach ($Arraydoblefactura as $code => $value)
    {
	   $query_inter = "SELECT distinct nombreestudiante
	   FROM zdatoscovinoc 
	   WHERE numerodocumento = '$code'	  
	   ";
	   //echo $query_inter;
	   $inter = mysql_query($query_inter, $sala) or die(mysql_error());
	   $row_inter = mysql_fetch_assoc($inter);
	   $totalRows_inter = mysql_num_rows($inter);	 
?>	  
     <tr>
	  <td><?php echo $code;?></td> 
	  <td><?php echo $row_inter['nombreestudiante'];?></td>
	  <td><?php echo $value;?></td>
	  <td><input type='checkbox' name='che<?php echo $j; ?>' value='<?php echo $code; ?>'></td>  
     </tr> 
<?	  
	 $j++;
	}  
?>
 </table>
<?php   
 
  }
  
if ($_POST['resetear'])
 { 
	$ip = "SIN DEFINIR";
	$ip = tomarip();
	$hoy = date("Y-m-d H:i:s");
	
	$superuser = $_SESSION['MM_Username'];	
 
	$sql = "UPDATE zdatoscovinoc
	set procesado = '100',
	ip = '$ip',
	usuario = '$superuser',
	fechaproceso = '$hoy '
	where procesado = ''";	
	$result = mysql_query($sql,$sala) or die("$sql");
	
	$sql = "UPDATE zdatossap
	set procesado = '100',
	ip = '$ip',
	usuario = '$superuser',
	fechaproceso = '$hoy '
	where procesado = ''";	
	$result = mysql_query($sql,$sala) or die("$sql"); 
 }

if ($_POST['comparar'])
 {
	for($i=0;$i<=$j;$i++)
	 {		
		if ($_POST['che'.$i] == true)
		 {	  
		  $sql = "delete from zdatoscovinoc
		  where numerodocumento = '".$_POST['che'.$i]."'
		  and codigoperiodo = '".$_POST['periodo']."'";	
		  //echo $sql;
		  $result = mysql_query($sql,$sala) or die("$sql"); 
		 }
	 }	
	 
   if ($move)
    {
	 echo "<script language='javascript'>alert('No se encontraron Inconsistencias en los archivos Comparados');</script>";
	}
 } 
?>
</form>
</html>
