<?php
session_start();
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";

require_once('../../../Connections/salaado.php'); 
//$db->debug = true; 
if(isset($_GET['debug']))
{
	$db->debug = true; 
}

// Selecciona los fechas asociadas a ese grupo
// Primero muestra un listado con los grupos a asociados si ya esta asociado no permite asociar
$idgrupo = $_GET['idgrupo'];

$query_fechaeducacioncontinuada = "SELECT f.idfechaeducacioncontinuada, f.idgrupo, f.codigoestado 
FROM fechaeducacioncontinuada f
where f.idgrupo = '$idgrupo'
and f.codigoestado like '1%'";

$fechaeducacioncontinuada = $db->Execute($query_fechaeducacioncontinuada);
$totalRows_fechaeducacioncontinuada = $fechaeducacioncontinuada->RecordCount();

$asociadogrupofecha = false;
if($totalRows_fechaeducacioncontinuada > 0)
	$asociadogrupofecha = true;

if($asociadogrupofecha)
{
	$row_fechaeducacioncontinuada = $fechaeducacioncontinuada->FetchRow(); 
	$idfechaeducacioncontinuada = $row_fechaeducacioncontinuada['idfechaeducacioncontinuada']; 
	//print_r($row_fechaeducacioncontinuada);
}
else
{
	$numerodetallefechaeducacioncontinuada = 1;
	$nombredetallefechaeducacioncontinuada = 'Pago '.$numerodetallefechaeducacioncontinuada;
}

// Cuando esta Acociar quiere decir que va a insertar datos.
if(isset($_GET['Asociar']) && !$asociadogrupofecha)
{
	$query_insfechaeducacioncontinuada = "INSERT INTO fechaeducacioncontinuada(idfechaeducacioncontinuada, idgrupo, codigoestado) 
    VALUES(0, '$idgrupo', '100')";
	$insfechaeducacioncontinuada = $db->Execute($query_insfechaeducacioncontinuada);
	$idfechaeducacioncontinuada = $db->Insert_ID();
}
if(isset($_GET['Asociar']))
{
	$query_insdetallefechaeducacioncontinuada = "INSERT INTO detallefechaeducacioncontinuada(iddetallefechaeducacioncontinuada, idfechaeducacioncontinuada, numerodetallefechaeducacioncontinuada, nombredetallefechaeducacioncontinuada, fechadetallefechaeducacioncontinuada, porcentajedetallefechaeducacioncontinuada) 
	VALUES(0, '$idfechaeducacioncontinuada', '".$_GET['insnumerodetallefechaeducacioncontinuada']."', '".$_GET['insnombredetallefechaeducacioncontinuada']."', '".$_GET['insfechadetallefechaeducacioncontinuada']."', '".$_GET['insporcentajedetallefechaeducacioncontinuada']."')";
	$insdetallefechaeducacioncontinuada = $db->Execute($query_insdetallefechaeducacioncontinuada);
}

// Cuando es Aceptar quiere decir que va a modificar datos
if(isset($_GET['Aceptar']))
{
	//print_r($_GET);
	foreach($_GET as $key => $value):
		if(ereg("iddetallefechaeducacioncontinuada",$key)) :
			$query_upddetallefechaeducacioncontinuada = "UPDATE detallefechaeducacioncontinuada 
    		SET fechadetallefechaeducacioncontinuada='".$_GET['fechadetallefechaeducacioncontinuada'.$value]."', 
			porcentajedetallefechaeducacioncontinuada='".$_GET['porcentajedetallefechaeducacioncontinuada'.$value]."'
    		WHERE iddetallefechaeducacioncontinuada = '$value'";
			$upddetallefechaeducacioncontinuada = $db->Execute($query_upddetallefechaeducacioncontinuada);
			//echo "<br>$iddetallefechaeducacioncontinuada";
		endif;
	endforeach;
}
?>
<html>
<head>
<title>Fechas de pago</title>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
-->
</style>
</head>
<body>
<form name="form1" action="" method="get">
<input type="hidden" name="idgrupo" value="<?php echo $idgrupo; ?>">
  <table width="100%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr bgcolor="#FEF7ED" class="Estilo2">
          <td colspan="5"><div align="center">FECHA EDUACION CONTINUADA</div></td>
          </tr>
		  <tr class="Estilo2">
          <td bgcolor="#CCDADD" colspan="2"><div align="center">ID Grupo </div></td>
          <td colspan="3"><div align="center"><?php echo $idgrupo;?> </div></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td><div align="center">Número</div></td>
          <td><div align="center">Nombre</div></td>
          <td><div align="center">Fecha</div></td>
          <td><div align="center">Porcentaje</div></td>
		  <td><div align="center">Acción</div></td>
        </tr>
<?php
$query_detallefechaeducacioncontinuada = "SELECT iddetallefechaeducacioncontinuada, idfechaeducacioncontinuada, numerodetallefechaeducacioncontinuada, nombredetallefechaeducacioncontinuada, fechadetallefechaeducacioncontinuada, porcentajedetallefechaeducacioncontinuada 
FROM detallefechaeducacioncontinuada
where idfechaeducacioncontinuada = '$idfechaeducacioncontinuada'";

$detallefechaeducacioncontinuada = $db->Execute($query_detallefechaeducacioncontinuada);
$totalRows_detallefechaeducacioncontinuada = $detallefechaeducacioncontinuada->RecordCount();
while($row_detallefechaeducacioncontinuada = $detallefechaeducacioncontinuada->FetchRow()) : 
	$iddetallefechaeducacioncontinuada = $row_detallefechaeducacioncontinuada['iddetallefechaeducacioncontinuada'];
	$numerodetallefechaeducacioncontinuada = $row_detallefechaeducacioncontinuada['numerodetallefechaeducacioncontinuada']+1;
	$nombredetallefechaeducacioncontinuada = 'Pago '.$numerodetallefechaeducacioncontinuada;
?>
        <tr class="Estilo1">
          <td><div align="center"><input type="hidden" value="<?php echo $iddetallefechaeducacioncontinuada ?>" name="iddetallefechaeducacioncontinuada<?php echo $iddetallefechaeducacioncontinuada ?>">
		  <?php echo $row_detallefechaeducacioncontinuada['numerodetallefechaeducacioncontinuada'];?></div></td>
          <td><div align="center"><?php echo $row_detallefechaeducacioncontinuada['nombredetallefechaeducacioncontinuada'];?></div></td>
          <td><div align="center"><input name="fechadetallefechaeducacioncontinuada<?php echo $iddetallefechaeducacioncontinuada ?>" id="fecha<?php echo $numerodetallefechaeducacioncontinuada;?>" type="text" readonly="true" value="<?php echo $row_detallefechaeducacioncontinuada['fechadetallefechaeducacioncontinuada'];?>"></div></td>
          <td><div align="center"><input name="porcentajedetallefechaeducacioncontinuada<?php echo $iddetallefechaeducacioncontinuada ?>" id="porcentaje" type="text" value="<?php echo $row_detallefechaeducacioncontinuada['porcentajedetallefechaeducacioncontinuada'];?>" size="2" maxlength="2"></div></td>
		  <td><div align="center">
            			<!-- <input name="Modificar" type="submit" id="Modificar" value="Modificar"> --></div></td>
        </tr>
		  <script type="text/javascript">
  Calendar.setup(
	  {
		inputField  : "fecha<?php echo $numerodetallefechaeducacioncontinuada; ?>",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime   : true,
		timeFormat  : "24"
	  }
  );
</script>
<?php
endwhile;

if($fechadetallefechaeducacioncontinuada == "")
	$fechadetallefechaeducacioncontinuada = date("Y-m-d");
if($porcentajedetallefechaeducacioncontinuada == "")
	$porcentajedetallefechaeducacioncontinuada = 0;
	
if(isset($_GET['Adicionar'])) :
?>        
		
		<tr class="Estilo1">
          <td><div align="center"><input type="hidden" value="<?php echo $numerodetallefechaeducacioncontinuada ?>" name="insnumerodetallefechaeducacioncontinuada">
		  <?php echo $numerodetallefechaeducacioncontinuada;?></div></td>
          <td><div align="center"><input type="hidden" value="<?php echo $nombredetallefechaeducacioncontinuada ?>" name="insnombredetallefechaeducacioncontinuada">
		  <?php echo $nombredetallefechaeducacioncontinuada;?></div></td>
          <td><div align="center"><input name="insfechadetallefechaeducacioncontinuada" id="fecha" type="text" readonly="true" value="<?php echo $fechadetallefechaeducacioncontinuada;?>"></div></td>
          <td><div align="center"><input name="insporcentajedetallefechaeducacioncontinuada" id="porcentaje" type="text" value="<?php echo $porcentajedetallefechaeducacioncontinuada;?>" size="2" maxlength="2"></div></td>
		  <td><div align="center"><?php
?>
            			<input name="Asociar" type="submit" id="Asociar" value="Asociar">
							  <script type="text/javascript">
  Calendar.setup(
	  {
		inputField  : "fecha",         // ID of the input field
		ifFormat    : "%Y-%m-%d",    // the date format
		showsTime   : true,
		timeFormat  : "24"
	  }
  );
</script>
<?php
endif;
?></div></td>
        </tr>
        		<tr bgcolor="#FEF7ED" class="Estilo1">
   		    <td colspan="5"><div align="center">

			            &nbsp;&nbsp;&nbsp;&nbsp;
<?php
if(!isset($_GET['Adicionar'])) 
{
?>
            <input name="Cerrar" type="submit" id="Cerrar" value="Cerrar" onClick="window.close()">
            <input name="Aceptar" type="submit" id="Aceptar" value="Aceptar">
            <input name="Adicionar" type="submit" id="Adicionar" value="Adicionar">
<?php 
}
else
{
?>
<input name="Cancelar" type="submit" id="Cancelar" value="Cancelar">
<?php
}
?>
</div></td>
          </tr>
        
      </table></td>
    </tr>
  </table>
</form>	
  </body>
</html>
