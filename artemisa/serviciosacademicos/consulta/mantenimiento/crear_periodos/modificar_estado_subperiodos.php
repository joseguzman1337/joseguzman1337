<script language="JavaScript" src="calendario/javascripts.js"></script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.AZUL {color: #0000FF;Tahoma;font-size: 14px; font-weight: bold;}
-->
</style>
<script language="JavaScript1.2">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>

<script language="javascript">
function enviar()
{
	document.materias.submit();
}
</script>

<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require('calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
?>
<?php
$fechahoy=date("Y-m-d H:i:s");
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica";
$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

mysql_select_db($database_sala, $sala);
$query_sel_ano = "SELECT * FROM ano order by codigoano desc";
$sel_ano = mysql_query($query_sel_ano, $sala) or die(mysql_error());
$row_sel_ano = mysql_fetch_assoc($sel_ano);
$totalRows_sel_ano = mysql_num_rows($sel_ano);

if(isset($_POST['modalidadacademica'])){
mysql_select_db($database_sala, $sala);
$query_sel_carrera = "SELECT * FROM carrera c where codigomodalidadacademica='".$_POST['modalidadacademica']."' 
and c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."'
order by c.nombrecarrera asc";
$sel_carrera = mysql_query($query_sel_carrera, $sala) or die(mysql_error());
$row_sel_carrera = mysql_fetch_assoc($sel_carrera);
$totalRows_sel_carrera = mysql_num_rows($sel_carrera);
}


if(isset($_POST['carrera']))
{
	mysql_select_db($database_sala, $sala);
	$query_sel_periodo = "SELECT * FROM periodo p, carreraperiodo cp
	 where cp.codigocarrera='".$_POST['carrera']."' and cp.codigoperiodo like '".$_POST[anoperiodo]."%' 
	 and cp.codigoperiodo=p.codigoperiodo
	 order by p.codigoperiodo desc";
	$sel_periodo = mysql_query($query_sel_periodo, $sala) or die(mysql_error());
	$row_sel_periodo = mysql_fetch_assoc($sel_periodo);
	$totalRows_sel_periodo = mysql_num_rows($sel_periodo);
}
if(isset($_POST['periodo']))
{
	mysql_select_db($database_sala, $sala);
	$query_numerosubperiodo= "SELECT cp.codigocarrera,cp.codigoperiodo,sp.nombresubperiodo,sp.idsubperiodo,sp.numerosubperiodo FROM subperiodo sp, carreraperiodo cp 
	WHERE 
	cp.codigoperiodo='".$_POST['periodo']."' and
	cp.idcarreraperiodo=sp.idcarreraperiodo AND cp.codigocarrera='".$_POST['carrera']."'";
	//echo $query_numerosubperiodo;
	$numerosubperiodo=mysql_query($query_numerosubperiodo,$sala) or die(mysql_error());
	$row_numerosubperiodo=mysql_fetch_assoc($numerosubperiodo);
	//print_r($row_numerosubperiodo);
}
?>


<form name="materias" method="post" action="">
  <p align="center" class="Estilo3">SUBPERIODOS - MODIFICAR ESTADO SUBPERIODO</p>
  <table width="29%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">A&ntilde;o periodo </div></td>
          <td bgcolor="#FEF7ED" class="Estilo2"><span class="style2">
            <select name="anoperiodo" id="anoperiodo" onchange="enviar()">
              <option value="">Seleccionar</option>
              <?php
                  do {
?>
              <option value="<?php echo $row_sel_ano['codigoano']?>"<?php if(isset($_POST['anoperiodo'])){if($_POST['anoperiodo'] == $row_sel_ano['codigoano']){echo "selected";}}?>><?php echo $row_sel_ano['codigoano']?></option>
              <?php
                  } while ($row_sel_ano = mysql_fetch_assoc($sel_ano));
                  $rows = mysql_num_rows($sel_ano);
                  if($rows > 0) {
                  	mysql_data_seek($sel_ano, 0);
                  	$row_sel_ano = mysql_fetch_assoc($sel_ano);
                  }
?>
            </select>
          </span></td>
        </tr>
        <tr>
          <td width="14%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad acad&eacute;mica </div></td>
          <td width="86%" bgcolor="#FEF7ED" class="Estilo2"><span class="style2">
            <select name="modalidadacademica" id="modalidadacademica" onchange="enviar()">
              <option value="">Seleccionar</option>
              <?php
                  do {
?>
              <option value="<?php echo $row_sel_modalidadacademica['codigomodalidadacademica']?>"<?php if(isset($_POST['modalidadacademica'])){if($_POST['modalidadacademica'] == $row_sel_modalidadacademica['codigomodalidadacademica'] or $_GET['modalidadacademica']==$row_sel_modalidadacademica['codigomodalidadacademica']){echo "selected";}}?>><?php echo $row_sel_modalidadacademica['nombremodalidadacademica']?></option>
              <?php
                  } while ($row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica));
                  $rows = mysql_num_rows($sel_modalidadacademica);
                  if($rows > 0) {
                  	mysql_data_seek($sel_modalidadacademica, 0);
                  	$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
                  }
?>
            </select>
          </span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
          <td bgcolor="#FEF7ED" class="Estilo2"><span class="style2">
            <select name="carrera" id="carrera" onchange="enviar()">
              <option value="">Seleccionar</option>
              <?php
                  do {
?>
              <option value="<?php echo $row_sel_carrera['codigocarrera']?>"<?php if(isset($_POST['carrera'])){if($_POST['carrera'] == $row_sel_carrera['codigocarrera'] or $_GET['carrera']==$row_sel_carrera['codigocarrera']){echo "selected";}}?>><?php echo $row_sel_carrera['nombrecarrera']?></option>
              <?php
                  } while ($row_sel_carrera = mysql_fetch_assoc($sel_carrera));
                  $rows = mysql_num_rows($sel_carrera);
                  if($rows > 0) {
                  	mysql_data_seek($sel_carrera, 0);
                  	$row_sel_carrera = mysql_fetch_assoc($sel_carrera);
                  }
?>
            </select>
          </span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo</div></td>
          <td bgcolor="#FEF7ED" class="Estilo2"><span class="style2">
            <select name="periodo" id="periodo" onchange="enviar()">
              <option value="">Seleccionar</option>
              <?php
                  do {
?>
              <option value="<?php echo $row_sel_periodo['codigoperiodo']?>"<?php if(isset($_POST['periodo'])){if($_POST['periodo'] == $row_sel_periodo['codigoperiodo'] or $_GET['periodo']==$row_sel_periodo['codigoperiodo']){echo "selected";}}?>><?php echo $row_sel_periodo['codigoperiodo']?></option>
              <?php
                  } while ($row_sel_periodo = mysql_fetch_assoc($sel_periodo));
                  $rows = mysql_num_rows($sel_periodo);
                  if($rows > 0) {
                  	mysql_data_seek($sel_periodo, 0);
                  	$row_sel_periodo = mysql_fetch_assoc($sel_periodo);
                  }
?>
            </select>
          </span></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
              <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
        </tr>
		 </table>
	 <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
	  <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre subperiodo </div></td>
	<td bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero subperiodo </div></td>
	</tr>
        <?php 
	    do{
			 echo "
			 <tr>
			<td><span class='Estilo1'>
			<a href='modificar_estado_subperiodos_detalle.php?carrera=".$row_numerosubperiodo['codigocarrera']."&anoperiodo=".$_POST['anoperiodo']."&codigoperiodo=".$row_numerosubperiodo['codigoperiodo']."&idsubperiodo=".$row_numerosubperiodo['idsubperiodo']." '>".$row_numerosubperiodo['nombresubperiodo']."</a> 			
			</span>&nbsp;</td>
			<td>
			<div align='Center'>
			".$row_numerosubperiodo['numerosubperiodo']."
			</div>
			</td
			</tr>
		  ";}
	    	while (@$row_numerosubperiodo = mysql_fetch_assoc(@$numerosubperiodo));
			 ?>
	    </table>
        <?php  ?>
     </td>
    </tr>
  </table>    
<tr>
      <td><br>
    
 <?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
  }
?>
