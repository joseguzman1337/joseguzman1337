<?php
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$ruta="../../../funciones/";
require_once('../../../funciones/ordenpago/claseordenpago.php');
?>
<style type="text/css">
<!--
.Estilo5 {font-family: tahoma; font-size: x-small; font-weight: bold; }
-->
</style>

<form action="" method="post" name="form1">
  <div align="center"><span class="Estilo5">MODIFICACION DE UNA ORDEN EXISTENTE
    </span>
  </div>
<BR><BR><BR>

<table align="center"  bordercolor="#FF9900" border="1" width="50%">
<tr  id="tdtitulogris">
<td>

<table align="center" bgcolor="#E9E9E9" width="50%">
<tr  id="tdtitulogris">
 <td id="tdtitulogris"><span class="Estilo5">Documento</span></td>
 <td id="tdtitulogris"><input name="numerodocumento" type="text" value="<?php echo $_POST['numerodocumento'];?>"></td>
</tr>
<tr>
 <td><span class="Estilo5">No. Orden </span></td>
 <td><input name="numeroordenpagoinicia" type="text" value="<?php echo $_POST['numeroordenpagoinicia'];?>"> </td>
</tr>
</table>
<div align="center">
  <input type="submit" name="consultar" value="Modificar Orden Pago">
</div></td>
</tr>
</table>

<?php //    $numeroordenpagoinicial = '1066807';	
if (isset($_POST['numeroordenpagoinicia']))
 {	
	$numeroordenpagoinicia = $_POST['numeroordenpagoinicia'];
	$numerodocumento = $_POST['numerodocumento'];
	
	$query_orden = "SELECT o.codigoestudiante,o.codigoperiodo,o.idprematricula,e.codigocarrera
	FROM ordenpago o,estudiante e,estudiantegeneral eg
	where o.codigoestudiante = e.codigoestudiante 
	and e.idestudiantegeneral = eg.idestudiantegeneral
	and o.codigoestadoordenpago like '1%'
	and o.numeroordenpago = '$numeroordenpagoinicia'
	and eg.numerodocumento = '$numerodocumento'";
	//echo "<br>".$query_orden;
	$orden = mysql_query($query_orden, $sala) or die(mysql_error());
	$row_orden = mysql_fetch_assoc($orden);
	$totalRows_orden = mysql_num_rows($orden);
	//print_r($row_orden);	
	//exit();
    if (!$row_orden)
	 {
?>  
      <script language="javascript">
	   alert("No se encontro orden pago con los datos digitados o verifique que la orden no este paga");
	   history.go(-1);
	  </script>
<?php 
       exit();
	 }		
	$codigoperiodo    = $row_orden['codigoperiodo'];
	$codigoestudiante = $row_orden['codigoestudiante'];
    $idprematricula   = $row_orden['idprematricula'];
	$codigocarrera    = $row_orden['codigocarrera'];

	$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago, $idprematricula, $fechaentregaordenpago=0, $codigoestadoordenpago=70);
	if(!@$orden->existe_ordenpago())
	{
		$orden->insertarordenpago();		
	}
	
	$query_conceptoinicial = "SELECT *
	FROM detalleordenpago d
	where d.numeroordenpago = '$numeroordenpagoinicia'";
	//echo "<br>".$query_conceptoinicial;
	$conceptoinicial = mysql_query($query_conceptoinicial, $sala) or die(mysql_error());
	$row_conceptoinicial = mysql_fetch_assoc($conceptoinicial);
	$totalRows_conceptoinicial = mysql_num_rows($conceptoinicial);

	do{
	
	   $orden->insertardetalleordenpago($row_conceptoinicial['codigoconcepto'], $row_conceptoinicial['cantidaddetalleordenpago'], $row_conceptoinicial['valorconcepto'], $row_conceptoinicial['codigotipodetalleordenpago']);
	
	}while($row_conceptoinicial = mysql_fetch_assoc($conceptoinicial));
	
	
    $query_fechas = "SELECT f.numeroordenpago, f.valorfechaordenpago, f.porcentajefechaordenpago, f.fechaordenpago
    FROM  fechaordenpago f
    where f.numeroordenpago = '$numeroordenpagoinicia'";
	//echo "<br>".$query_conceptoinicial;
	$fechas = mysql_query($query_fechas, $sala) or die(mysql_error());
	$row_fechas = mysql_fetch_assoc($fechas);
	$totalRows_fechas = mysql_num_rows($fechas);

    do{	
	    $orden->insertarfechaordenpago($row_fechas['fechaordenpago'], $row_fechas['porcentajefechaordenpago'],$row_fechas['valorfechaordenpago']);
	}while($row_fechas = mysql_fetch_assoc($fechas));
	
    $orden->insertarbancosordenpago();
	$numeronuevo = $orden->tomar_numeroordenpago();
    $query_seldetalleprematriculaorden = "select *
	from detalleprematricula 
	WHERE numeroordenpago = '$numeroordenpagoinicia'
	and codigoestadodetalleprematricula like '1%'";
	$seldetalleprematriculaorden = mysql_query($query_seldetalleprematriculaorden,$sala) or die("$query_seldetalleprematriculaorden"); 
	//$row_seldetalleprematriculacambiogrupo = mysql_fetch_array($seldetalleprematriculacambiogrupo);
	$totalRows_seldetalleprematriculaorden = mysql_num_rows($seldetalleprematriculaorden);
	  if($totalRows_seldetalleprematriculaorden != "")
		{
			while($row_seldetalleprematriculaorden = mysql_fetch_array($seldetalleprematriculaorden))
			{				
				$query_inslogdetalleprematricula = "INSERT INTO detalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago) 
				VALUES('".$row_seldetalleprematriculaorden['idprematricula']."','".$row_seldetalleprematriculaorden['codigomateria']."','".$row_seldetalleprematriculaorden['codigomateriaelectiva']."','20','".$row_seldetalleprematriculaorden['codigotipodetalleprematricula']."','".$row_seldetalleprematriculaorden['idgrupo']."','$numeronuevo')"; 
				$inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");		
			}
		}		
?>

<script language="javascript">
	window.location.reload("modificarorden.php<?php echo "?numeroordenpago=".$numeronuevo."&codigoestudiante=".$codigoestudiante."&codigoperiodo=".$codigoperiodo."&numeroordenpagoini=".$numeroordenpagoinicia."&codigocarrera=".$codigocarrera.""?> ");
</script>
</form>
<?php
 } //if isset($_POST['numeroordenpagoinicial'])
?>