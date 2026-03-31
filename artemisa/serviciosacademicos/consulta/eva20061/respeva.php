<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
include("pconexionbase.php");
mysql_select_db($database_sala, $sala);
?>
<script language="javascript">
function enviar()
	{
	 document.inscripcion.submit();
	}
</script>
<html>
<head>
<title>evaluacion</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
</head>  
<body>
<form name="inscripcion" method="post" action="">
<div align="center" class="Estilo3">
<p><img src="../../../../imagenes/preinscripcion.gif" ><br>
  <?php 
        $sss="select distinct d.nombredocente,d.apellidodocente,d.numerodocumento,e.codigocarrera,c.nombrecarrera 
from docente d,respuestas r,grupo g,evafacultad e,carrera c
where r.codigodocente=d.numerodocumento
and d.numerodocumento=g.numerodocumento
and g.idgrupo=r.idgrupo
and r.codigoestudiante=e.codigoestudiante
and e.codigocarrera='731'
and c.codigocarrera=e.codigocarrera
order by d.nombredocente";
//echo $sss;
	  $sultado=mysql_query($sss,$sala)or die("$sss".mysql_error());
		 //echo $query_data;
		 //exit();
		 //$data = mysql_query($query_data, $sala) 
		 //$totalRows_data = mysql_num_rows($data);
		 $row_data = mysql_fetch_assoc($sultado);
         
?>
    </p>
</div>
<table width="70%" border="1" align="center" bordercolor="#003333" cellpadding="0" cellspacing="0">
<tr>
<td>
<?php
if ($row_data <> "")
 { 
?>			
	
      <br>  
		  
<?php		  
		  }
?>
<table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
      <tr bgcolor='#FEF7ED'>
        <td class="Estilo2">&nbsp;Fecha de la Solicitud:</td>
        <td class="Estilo1"><?php echo date("j-n-Y g:i",time())?>&nbsp;
              <input name="hora" type="hidden" id="hora2" value="<?php echo time()?>">
        </font><strong></strong><span class="Estilo16">
        </span></td>
    </tr>
      <tr bgcolor='#FEF7ED'>
        <td class="Estilo2">&nbsp;Modalidad Ac&aacute;demica:</td>
            <td class="Estilo1"> <select name="modalidad" id="select6" onChange="enviar()">
                <option value="0" <?php if (!(strcmp("0", $_POST['modalidad']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
      do {  
?>
                <option value="<?php echo $row_data['numerodocumento']?>"<?php if (!(strcmp($row_data['numerodocumento'], $_POST['modalidad']))) {echo "SELECTED";} ?>><?php echo $row_data['nombredocente']; echo $row_data['apellidodocente'];?></option>
                <?php
      } while ($row_data = mysql_fetch_assoc($sultado));
		  $rows = mysql_num_rows($sultado);
		  if($rows > 0) 
		  {
			  mysql_data_seek($car, 0);
			  $row_data = mysql_fetch_assoc($sultado);
		  }
?>
              </select></td>
      </tr>
      <tr bgcolor='#FEF7ED'>
        <td class="Estilo2">&nbsp;Nombre del Programa:</td>
            <td class="Estilo1"> 
              <?php 
        if ($_POST['modalidad'] <> 0)
         {  // if 1  
			$fecha = date("Y-m-d G:i:s",time());
			$query_car = "SELECT DISTINCT d.nombredocente,d.apellidodocente,r.codigodocente,m.nombremateria,m.codigomateria FROM docente d, respuestas r,materia m where d.numerodocumento=r.codigodocente and m.codigomateria=r.codigomateria and r.codigodocente='".$_POST['modalidad']."' ORDER BY m.nombremateria";
			//echo $query_car;
			$car = mysql_query($query_car, $sala) or die(mysql_error());
			$row_car = mysql_fetch_assoc($car);
			$totalRows_car = mysql_num_rows($car);
       }
?>
              <select name="especializacion" id="select8" onChange="enviar()">
                <option value="0" <?php if (!(strcmp("0", $_POST['especializacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
             do {  
?>
                <option value="<?php echo $row_car['codigomateria']?>"<?php if (!(strcmp($row_car['codigomateria'], $_POST['especializacion']))) {echo "SELECTED";} ?>><?php echo $row_car['nombremateria']?></option>
                <?php
				} while ($row_car = mysql_fetch_assoc($car));
				  $rows = mysql_num_rows($car);
				  if($rows > 0) {
					  mysql_data_seek($car, 0);
					  $row_car = mysql_fetch_assoc($car);
				  }
?>
              </select></td>
      </tr>
      <tr bgcolor='#FEF7ED'>
            <td class="Estilo2">&nbsp;Periodo al que se preinscribe:</td>
            <td class="Estilo1"><span class="Estilo16"> 
              <?php 
        if ($_POST['especializacion'] <> 0)
         {  // if 1  
			$query_periodo = "SELECT DISTINCT idgrupo FROM respuestas where codigodocente='".$_POST['modalidad']."' and codigomateria='".$_POST['especializacion']."' ORDER BY idgrupo";
			$periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");
			$totalRows_periodo = mysql_num_rows($periodo);
			$row_periodo = mysql_fetch_assoc($periodo);
       }
?>
              <select name="periodo" onChange="MM_jumpMenu('consultanotassala.php',this,0)">
                <option selected>grupo</option>
                
                <option value="<?php echo $row_periodo['idgrupo']?>"><?php echo $row_periodo['idgrupo']?></option>
               
              </select>
              </span> </td>
      </tr>
</table>
      <br>
        <?php 
  if ($_POST['especializacion'] <> 0)
    {  // if 1  
?>
      </td> 
</tr>   
</table>     
<br>
 <div align="center"><a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>
   <input type="hidden" name="grabado" value="grabado"> 
  </div>
</form>     
</body>
</html>
<script language="javascript">
function grabar()
 {
  document.inscripcion.submit();
 }
</script>




<?php 
   } // if 1     
?> 
