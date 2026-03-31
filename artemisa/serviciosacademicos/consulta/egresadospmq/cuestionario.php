<?php require_once('../../Connections/egresado.php');session_start();
 $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   if(! $row)
	   {
	     echo '<script language="JavaScript">alert("Los datos basicos son requeridos")</script>';	
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
		 exit();
	   }

        $base="select * 
	          from  carreraegresado 
			  where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 

mysql_select_db($database_conexion, $conexion);
$query_encuesta = "SELECT e.idencuesta,i.iditemsencuesta,i.nombreitemsencuesta
					FROM encuesta e,detalleencuesta d,itemsencuesta i,carreraencuesta cen
					WHERE e.idencuesta = d.idencuesta
					AND cen.codigocarrera = '".$row['codigocarrera']."'
					AND cen.idencuesta = e.idencuesta
					AND d.iditemsencuesta = i.iditemsencuesta
					AND codigoestadoencuesta LIKE '1%'
					AND codigoestadoitemsencuesta LIKE '1%'
					AND codigotipoitemsencuesta LIKE '1%'
					ORDER BY 2";
$encuesta = mysql_query($query_encuesta, $conexion) or die(mysql_error());
$row_encuesta = mysql_fetch_assoc($encuesta);
$totalRows_encuesta = mysql_num_rows($encuesta);
$encustasre = $row_encuesta['idencuesta'];  
mysql_select_db($database_conexion, $conexion);
$query_valoracion = "SELECT * 
						FROM valoracionencuesta
						order by 1					
					";
$valoracion = mysql_query($query_valoracion, $conexion) or die(mysql_error());
$row_valoracion = mysql_fetch_assoc($valoracion);
$totalRows_valoracion = mysql_num_rows($valoracion);

?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: x-small;
}
.style2 {
	font-size: small;
	font-weight: bold;
}
.style7 {font-size: x-small}
.style4 {font-size: x-small; font-weight: bold; }
-->
</style>

<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-size: xx-small}
-->
</style>
<form name="form1" method="post" action="cuestionario.php">
 <h6 align="center" class="style2 style7">OPINION EN LA FORMACIÓN RECIBIDA</h6>
 <p align="center" class="style2 style7">&nbsp;</p>
 <table width="60%"  border="1" align="center" bordercolor="#003333">
   <tr>
     <td bgcolor="#C6CFD0" width="76%" class="style1"><div align="center"><strong>ASPECTOS</strong></div></td>
     <td bgcolor="#C6CFD0" width="24%" class="style1"><div align="center"><strong>VALORACI&Oacute;N</strong></div></td>
   </tr>
<?php
 $j = 1;   
   do {
   echo "<tr>";
     echo "<td width='46%'><div align='center' class=style1>".$row_encuesta['nombreitemsencuesta']."</div></td>";
     ?>
	 <td width='76%' class="style1"><div align='center'><strong>
	 <?php
	echo "<select name='valor".$j."'>";
   ?> 
	 <option value="0" <?php if (!(strcmp("0", $_POST['valor'.$j]))) {echo "SELECTED";} ?>>Seleccionar</option>
     <?php
do {  
?>
     <option value="<?php echo $row_valoracion['codigovaloracionencuesta']?>"<?php if (!(strcmp($row_valoracion['codigovaloracionencuesta'], $_POST['valor'.$j]))) {echo "SELECTED";} ?>><?php echo $row_valoracion['codigovaloracionencuesta']."&nbsp;-&nbsp;".$row_valoracion['nombrevaloracionencuesta']?></option>
     <?php
} while ($row_valoracion = mysql_fetch_assoc($valoracion));
  $rows = mysql_num_rows($valoracion);
  if($rows > 0) {
      mysql_data_seek($valoracion, 0);
	  $row_valoracion = mysql_fetch_assoc($valoracion);
  }
?>
     </select>
	    </strong>	 
	 </div></td>
<?php	 
   echo "</tr>";
   $j++;

}while ($row_encuesta = mysql_fetch_assoc($encuesta));
?> 
 </table>
 <p align="center" class="style2 style7 style1 style7">&nbsp;  </p>
 <span class="style1">
 <?php 
$query_encuesta1 = "SELECT e.idencuesta,i.iditemsencuesta,i.nombreitemsencuesta
					FROM encuesta e,detalleencuesta d,itemsencuesta i,carreraencuesta cen 
					WHERE e.idencuesta = d.idencuesta
					AND cen.codigocarrera = '".$row['codigocarrera']."'
					AND cen.idencuesta = e.idencuesta
					AND d.iditemsencuesta = i.iditemsencuesta
					AND codigoestadoencuesta LIKE '1%'
					AND codigoestadoitemsencuesta LIKE '1%'
					AND codigotipoitemsencuesta LIKE '2%'
					ORDER BY 2";
$encuesta1 = mysql_query($query_encuesta1, $conexion) or die(mysql_error());
$row_encuesta1 = mysql_fetch_assoc($encuesta1);
$totalRows_encuesta1 = mysql_num_rows($encuesta1);

?>
 </span> 
<table width="60%"  border="1" align="center" bordercolor="#003333">
 <tr>
     <td bgcolor="#C6CFD0" class="style1"><div align="center"><strong>ASPECTOS</strong></div></td>
     <td bgcolor="#C6CFD0" class="style1"><div align="center">
       <p><strong>DESCRIPCI&Oacute;N </strong><strong>(<span class="Estilo1">Hasta 200 Caracteres</span>) </strong></p>
       </div></td>
   </tr>
<?php
$i= 1;
 do {?>   
   <tr>
     <td width="62%" class="style1"><div align="center"><?php echo $row_encuesta1['nombreitemsencuesta'];?>:</div></td>
     <td width="38%" class="style1"><div align="center">
<?php       
	   echo "<input name='respuesta".$i."' type='text' size='50' maxlength='200' value=".$_POST['respuesta'.$i].">";
 ?>       
	 </div></td>
   </tr>
<?php 
$i++;
}while ($row_encuesta1 = mysql_fetch_assoc($encuesta1));?>
</table>
<p align="center">
  <input type="submit" name="Submit" value="Guardar">
</p>
<?php
$query_encuesta2 = "SELECT *
					FROM respuestaencuesta r
					WHERE r.numerodocumento = '".$_SESSION['numerodocumento']."'
					and r.idencuesta = '$encustasre' 		
					";
//echo $query_encuesta2 ;
//exit();
if ($_POST['Submit'])
{ 
$encuesta2= mysql_query($query_encuesta2, $conexion) or die(mysql_error());
$row_encuesta2 = mysql_fetch_assoc($encuesta2);
$totalRows_encuesta2 = mysql_num_rows($encuesta2);
 
 if ($row_encuesta2 <> "")
  {
   echo '<script language="JavaScript">alert("Ya Contesto esta Encuesta")</script>';	
   exit();
  }
$bandera = 0;

for($m = 1; $m < $j ;$m++)
 {
   if ($_POST['valor'.$m] == 0)
   {
     //echo $_POST['valor'.$m],"jeje<br>";
	 echo '<script language="JavaScript">alert("Debe Calificar los Aspectos")</script>';	
     $m = $j+1;
	 $bandera = 1;
   }  
 }


if ($bandera == 0)
     {
     require_once('capturacuestionario.php');
     }
}
    ?>
</form>
