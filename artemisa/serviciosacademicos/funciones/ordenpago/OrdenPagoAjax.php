<?
session_start();
require_once('./../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$ruta="./../";
require_once('../claseordenpago.php');
$codigoestudiante = $_GET['codigoestudiante'];
$codigocarrera = $_GET['codigocarrera'];
$query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo
from periodo p
where p.codigoestadoperiodo not like '2%'
and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
order by 2 desc";
$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
$totalRows_selperiodo = mysql_num_rows($selperiodo);
$row_selperiodo = mysql_fetch_array($selperiodo);
$codigoperiodo = $row_selperiodo['codigoperiodo'];

//$ordenjoda = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago, $idprematricula=1, $fechaentregaordenpago=0, $codigoestadoordenpago=70);

$query_dataestudiante= "SELECT e.codigocarrera, e.codigoperiodo, eg.numerodocumento, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,
c.nombrecarrera, t.nombretipocliente, te.codigoreferenciatipoestudiante, c.codigoindicadortipocarrera, e.idestudiantegeneral,
e.codigoestudiante, eg.numerodocumento
FROM estudiante e, carrera c, estudiantegeneral eg, tipocliente t, tipoestudiante te
WHERE e.codigoestudiante = '$codigoestudiante'
AND e.codigocarrera = c.codigocarrera
and eg.idestudiantegeneral = e.idestudiantegeneral
and eg.codigotipocliente = t.codigotipocliente
and e.codigotipoestudiante = te.codigotipoestudiante
and e.codigocarrera = '$codigocarrera'";

$dataestudiante=mysql_query($query_dataestudiante,$sala) or die("$query_dataestudiante".mysql_error());
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
$row_dataestudiante = mysql_fetch_array($dataestudiante);

$query_selgrupos = "select dp.idgrupo, dp.codigomateria
from detalleprematricula dp, prematricula p
where dp.idprematricula = p.idprematricula
and p.codigoestudiante = '$codigoestudiante'
and p.codigoperiodo = '$codigoperiodo'
and (dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '3%')
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')";

$selgrupos=mysql_query($query_selgrupos,$sala) or die("$query_selgrupos".mysql_error());
$totalRows_selgrupos = mysql_num_rows($selgrupos);
while($row_selgrupos = mysql_fetch_array($selgrupos))
{
        $materiascongrupo[] = $row_grupos['idgrupo'];
}


if($_REQUEST['crearorden']=="true"){    
    echo '<div align="center">
    <input name="codigoestudiante" value="'.$codigoestudiante.'" type="hidden">
    <input name="codigocarrera" value="'.$codigocarrera.'" type="hidden">
    <input name="codigoperiodo" value="'.$codigoperiodo.'" type="hidden">
    <div id=additem>
        
    </div>
      <table width="631" align="center" border="1" bordercolor="#003333" cellpadding="2" cellspacing="1">
      <tbody><tr bgcolor="#C5D5D6">
          <td class="Estilo1"><div class="Estilo19" align="center">Id General</div></td>
          <td class="Estilo1"><div class="Estilo19" align="center">Id Estudiante</div></td>
          <td class="Estilo1"><div class="Estilo19" align="center">Centro Beneficio</div></td>
          <td class="Estilo1"><div class="Estilo19" align="center">Subperiodo</div></td>
          <td class="Estilo1"><div class="Estilo19" align="center">Cuenta por Cobrar</div></td>
          <td class="Estilo1"><div class="Estilo19" align="center">Cuenta CompensaciÃ³n</div></td>
          <td class="Estilo1"><div class="Estilo19" align="center">Fecha de Pago</div></td>
        </tr>
        <tr>
         <tr>
      <td class="Estilo1"><div align="center"><span >'.$row_dataestudiante['idestudiantegeneral'].'&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span >'.$row_dataestudiante['codigoestudiante'].'&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span >';
    if($ordeninternaocentrobeneficio != "") echo $ordeninternaocentrobeneficio; else echo "No tiene";
      echo '&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span >'.$idsubperiodo.'&nbsp;</span></div></td>
      <td class="Estilo1" ><div align="center"><span >'.$row_dataestudiante['documentocuentaxcobrarsap'].'&nbsp;</span></div></td>
      <td class="Estilo1" ><div align="center"><span >'.$row_dataestudiante['documentocuentacompensacionsap'].'&nbsp;</span></div></td>
      <td class="Estilo1" ><div align="center"><span >'.$row_dataestudiante['fechapagosapordenpago'].'&nbsp;</span></div></td>
        </tr>
     </tbody></table>';
      echo '<table width="631" align="center" border="1" bordercolor="#003333" cellpadding="2" cellspacing="1">
    <tbody><tr bgcolor="#C5D5D6">
      <td class="Estilo1"> <div class="Estilo19" align="center">No. Orden</div></td>
      <td class="Estilo1"> <div class="Estilo19" align="center">Carrera</div></td>
      <td class="Estilo1"> <div class="Estilo19" align="center">Periodo</div></td>
      <td class="Estilo1"> <div class="Estilo19" align="center">Tipo de Cliente</div></td>
    </tr>
    <tr>
      <td class="Estilo1"><div align="center"><span>&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span>'.$row_dataestudiante['nombrecarrera'].'</span></div></td>
      <td class="Estilo1"><div align="center"><span>&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span>'.$row_dataestudiante['nombretipocliente'].'</span></div></td>
    </tr>
    <tr bgcolor="#C5D5D6">
      <td class="Estilo1"> <div class="Estilo20" align="center"><strong>Fecha </strong></div></td>
      <td class="Estilo1"><div class="Estilo20" align="center"><strong>Nombre Estudiante</strong></div></td>
      <td class="Estilo1" colspan="3"><div class="Estilo20" align="center"><strong>Documento</strong></div></td>
    </tr>
    <tr>
      <td class="Estilo1"><div align="center"><span>'.date("Y-m-d").'&nbsp;</span></div></td>
      <td class="Estilo1"><div align="center"><span>'.$row_dataestudiante['nombre'].'&nbsp;</span></div></td>
      <td class="Estilo1" colspan="4"><div align="center"><span>'.$row_dataestudiante['numerodocumento'].'&nbsp;</span></div></td>
    </tr>
    <tr bordercolor="#336633">
      <td colspan="5" class="Estilo1"> <div align="center"><strong>DETALLE ORDEN DE PAGO</strong></div></td>
    </tr>
    <tr bgcolor="#C5D5D6">
      <td class="Estilo1" width="17%"><div class="Estilo20" align="center"><strong>CÃ³digo Concepto </strong></div></td>
      <td class="Estilo1" width="43%"><div class="Estilo20" align="center"><strong>Concepto</strong></div></td>
      <td class="Estilo1" width="10%"><div class="Estilo20" align="center"><strong>Cantidad</strong></div></td>
      <td class="Estilo1" width="20%"><div class="Estilo20" align="center"><strong>Valor</strong></div></td>';
      echo "<td class='Estilo10' width='10%'><div align='center'><a href=# onclick=additem(1);><img src='img/basic/plus.gif' border=0></div></td>";
      //echo "<td class='Estilo10' width='10%'><div align='center'><a href=# onclick=window.open('ordenmanual/adicionardetalle.php?numeroordenpago=1453099&amp;codigoestudiante=91857&amp;codigocarrera=125&amp;codigoperiodo=20121','miventana','width=700,height=200,top=200,left=150,scrollbars=yes');><img src='img/basic/plus.gif' border=0></div></td>";
    echo '</tr> ';
 }
 
?>
    <tr>
    <td class=" Estilo1" width="20%" align="center"><span><strong><strong>151</strong></strong></span></td>
    <td class=" Estilo1" width="50%" align="left"><span><strong>MATRICULAS(+)	</strong></span></td>
    <td class=" Estilo1" width="10%" align="center"><span><strong><strong>1</strong></strong></span></td>
    <td class=" Estilo1" width="20%" align="right"><span>$&nbsp;&nbsp;11,350,000.00</span></td>
  </tr>
</tbody></table>

  <span class=" Estilo1">

<table width="631" align="center" border="1" bordercolor="#003333" cellpadding="2" cellspacing="1">
  <tbody><tr>

    <td class=" Estilo1" colspan="4" align="center"><span><strong><strong>

<input value="Editar" name="EditarDetalle" onclick="window.open('ordenmanual/editardetalle.php?numeroordenpago=1453099&amp;codigoestudiante=91857&amp;codigocarrera=125&amp;codigoperiodo=20121','miventana','width=700,height=200,top=200,left=150,scrollbars=yes')" style="width: 80px;" type="button">
<input value="Eliminar" name="EditarDetalle" onclick="window.open('ordenmanual/eliminardetalle.php?numeroordenpago=1453099&amp;codigoestudiante=91857&amp;codigocarrera=125&amp;codigoperiodo=20121','miventana','width=700,height=200,top=200,left=150,scrollbars=yes')" style="width: 80px;" type="button">
    </strong></strong></span></td>
  </tr>
 </tbody></table>
<table width="631" align="center" border="1" bordercolor="#003333" cellpadding="2" cellspacing="1">
    <tbody><tr bordercolor="#006600">
      <td colspan="4" class=" Estilo1"><div align="center"><strong>FECHAS DE PAGO</strong></div></td>
  </tr>
  <tr bgcolor="#C5D5D6">

      <td class=" Estilo1" width="232"><div align="center"><strong>Tipo de Matricula </strong></div></td>
      <td class=" Estilo1" width="200"><div align="center"><strong>Paguese Hasta </strong></div></td>
      <td class=" Estilo1" width="175"><div align="center"><strong>Total a Pagar </strong></div></td>
  </tr>
</tbody></table>
  <span class="Estilo1">  </span>
<table width="631" align="center" border="1" bordercolor="#FF9900" cellpadding="2" cellspacing="1">
    <tbody><tr>

    <td class=" Estilo1" width="232"><div align="center"><span>Pago 1</span></div></td>
    <td class=" Estilo1" width="200"><div align="center"><span>2012-01-03</span></div></td>
    <td class=" Estilo1" width="175"><div align="center"><span>$&nbsp;11,350,000.00</span></div></td>
  </tr>
 <tr>
    <td class=" Estilo1" colspan="3" align="center"><input value="Adicionar" name="AdicionarFecha" onclick="window.open('ordenmanual/adicionarfecha.php?numeroordenpago=1453099&amp;codigoestudiante=91857&amp;codigocarrera=125&amp;codigoperiodo=20121&amp;codigoindicadortipocarrera=100','miventana','width=700,height=200,top=200,left=150')" style="width: 80px;" type="button">
	<input value="Editar" name="EditarDetalle" onclick="window.open('ordenmanual/editarfecha.php?numeroordenpago=1453099&amp;codigoestudiante=91857&amp;codigocarrera=125&amp;codigoperiodo=20121&amp;codigoindicadortipocarrera=100','miventana','width=700,height=200,top=200,left=150')" style="width: 80px;" type="button">

<input value="Eliminar" name="EditarDetalle" onclick="window.open('ordenmanual/eliminarfecha.php?numeroordenpago=1453099&amp;codigoestudiante=91857&amp;codigocarrera=125&amp;codigoperiodo=20121&amp;codigoindicadortipocarrera=100','miventana','width=700,height=200,top=200,left=150')" style="width: 80px;" type="button">
</td>
  </tr>
</tbody></table>
  <table width="631" align="center" border="1" bordercolor="#003333" cellpadding="2" cellspacing="1">
    <tbody><tr><td colspan="4" class=" Estilo1"><div align="center"><strong>CUENTAS BANCARIAS </strong></div></td></tr>
    <tr bgcolor="#C5D5D6">
      <td class=" Estilo1" width="145"><div align="center"><strong>CÃ³digo Banco </strong></div></td>
      <td class=" Estilo1" width="295"><div align="center"><strong>Nombre Banco </strong></div></td>

      <td class=" Estilo1" width="169"><div align="center"><strong>Cuenta Banco </strong></div></td>
    </tr>
  </tbody></table>
  </span>
  <table width="631" align="center" border="1" bordercolor="#FF9900" cellpadding="2" cellspacing="1">
    <tbody><tr>
    <td class=" Estilo1" width="146"><div align="center"><span>14</span></div></td>
    <td class=" Estilo1" width="295"><div align="center"><span>Helm Bank</span></div></td>

    <td class=" Estilo1" width="168"><div align="center"><span>CONVENIO No. 8032 </span></div></td>
  </tr>
</tbody></table>

  <table width="631" align="center" border="1" bordercolor="#FF9900" cellpadding="2" cellspacing="1">
    <tbody><tr>
    <td class=" Estilo1" width="146"><div align="center"><span>06</span></div></td>
    <td class=" Estilo1" width="295"><div align="center"><span>Banco Santander</span></div></td>
    <td class=" Estilo1" width="168"><div align="center"><span>CONVENIO No 2323 </span></div></td>
  </tr>
</tbody></table>
  <table width="631" align="center" border="1" bordercolor="#FF9900" cellpadding="2" cellspacing="1">
    <tbody><tr>
    <td class=" Estilo1" width="146"><div align="center"><span>03</span></div></td>
    <td class=" Estilo1" width="295"><div align="center"><span>Banco de Colombia</span></div></td>
    <td class=" Estilo1" width="168"><div align="center"><span>CONVENIO No. 4261 </span></div></td>
  </tr>
</tbody></table>
  <table width="631" align="center" border="1" bordercolor="#FF9900" cellpadding="2" cellspacing="1">
    <tbody><tr>
    <td class=" Estilo1" width="146"><div align="center"><span>01</span></div></td>
    <td class=" Estilo1" width="295"><div align="center"><span>Banco de Bogota</span></div></td>
    <td class=" Estilo1" width="168"><div align="center"><span>CODIGO No. 2121 </span></div></td>
  </tr>
</tbody></table>';

