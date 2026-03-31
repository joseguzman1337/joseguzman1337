<script language="javascript">
function enviar()
{
	document.conceptos.submit()
}
</script>
<script language="javascript">enviar();</script>
<?php
//error_reporting(2047);
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
ini_set("include_path", ".:/usr/share/pear_");
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$database = "sala";
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
//require('../../../Connections/sap.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
mysql_select_db($database, $sala);
$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado, 
e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, 
e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
from estadoconexionexterna e
where e.codigoestado like '1%'";
//and dop.codigoconcepto = '151'
//echo "sdas $query_ordenes<br>";
$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());     
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
/*
if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
{
	$login = array (                              // Set login data to R/3 
    "ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name 
	"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number 
	"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client 
	"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user 
	"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
	"CODEPAGE"=>"1100");              												// codepage  

	$rfc = saprfc_open($login);
	if(!$rfc) 
	{
		// We have failed to connect to the SAP server
		//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
		//exit(1);
	}
}
*/
/*****************************   VALIDACION DE CONEXION Y EXISTENCIA DE TABLA DE CONCEPTOS EN SAP **********/
/*
$rfcfunction = "ZFICA_SALA_CONSULT_OPERACIONES";
$resultstable = "ZTAB_OPERACIONES";

$rfc = saprfc_open($login);

if(!$rfc)
{
	echo "Failed to connect to the SAP server".saprfc_error();
	exit(1);
}

$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

if(!$rfchandle)
{
	echo "We have failed to discover the function".saprfc_error($rfc);
	exit(1);
}
// traigo la tabla interna de SAP
saprfc_table_init($rfchandle,$resultstable);


@$rfcresults = saprfc_call_and_receive($rfchandle);


$numrows = saprfc_table_rows($rfchandle,$resultstable);

for ($i=1; $i <= $numrows; $i++)
{
	$results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
}

//var_dump($results);

if ($results <> "")
{  // if 1
	foreach ($results as $valor => $total)
	{ // foreach 1
		foreach ($total as $valor1 => $total1)
		{ // foreach 2
			if ($valor1 == "HVORG")
			{
				$opprincipal = $total1;
				//echo $opprincipal,"<br>";
			}
			if ($valor1 == "TVORG")
			{
				$opparcial = $total1;
			}
			if ($valor1 == "TXT30")
			{
				$nombreoperacion = $total1;
				//echo $nombreoperacion,"<br>";
			}
		} // foreach 2

		$totalconceptos[] = array($nombreoperacion,$opprincipal,$opparcial);
	} // foreach 1
} // if 1
//print_r($totalconceptos);

/************************************************************************************************************/


$options = &PEAR::getStaticProperty('DB_DataObject','options');
$options = array(
    'database'         => "mysql://$username_sala:$password_sala@$hostname_sala/$database_sala",
    'schema_location'  => '../funciones/clases_tablas',
    'class_location'   => '../funciones/clases_tablas',
    'require_prefix'   => '../funciones/clases_tablas',
    'class_prefix'     => 'DataObjects_',
);



//DB_DataObject::debugLevel(5);



$concepto = DB_DataObject::factory('concepto');
$concepto->whereAdd("codigoconcepto='".$_GET['codigoconcepto']."'");
$concepto->find();
$concepto->fetch();
//print_r($concepto);echo "<br>";
//$original=clone($concepto);
$tipoconcepto = DB_DataObject::factory('tipoconcepto');
$tipoconcepto->get('tipoconcepto','*');

$aplicarecargo = DB_DataObject::factory('aplicarecargo');
$aplicarecargo->get('aplicarecargo','*');

$referenciaconcepto = DB_DataObject::factory('referenciaconcepto');
$referenciaconcepto->get('referenciaconcepto','*');

$aplicabloqueodeuda = DB_DataObject::factory('aplicabloqueodeuda');
$aplicabloqueodeuda->get('aplicabloqueodeuda','*');

$cambiovalorconcepto = DB_DataObject::factory('cambiovalorconcepto');
$cambiovalorconcepto->get('cambiovalorconcepto','*');

$indicadorestadocuentaconcepto=DB_DataObject::factory('indicadorestadocuentaconcepto');
$indicadorestadocuentaconcepto->get('indicadorestadocuentaconcepto','*');
?>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="conceptos" method="post" action="">
  <p align="center" class="Estilo3">CREAR CONCEPTOS - CONSULTAR DETALLE </p>
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="3">
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2">Codigo concepto</td>
          <td bgcolor="#FEF7ED"><input name="codigoconcepto" readonly type="text" id="codigoconcepto" value="<?php echo $concepto->codigoconcepto?>"></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre concepto <span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED">
          <input name="nombreconcepto" type="text" id="nombreconcepto" value="<?php echo $concepto->nombreconcepto;?>">          
           <!-- <select name="cuentacontable" id="cuentacontable" onChange="enviar()">
              <option value="">Seleccionar</option>
              <?php
/*
foreach ($totalconceptos as $valor => $total)
{ // foreach 1
	$contador = 1;
	$codigosap = "";
	foreach ($total as $valor1 => $total1)
	{ // foreach 2
		if ($contador == 1)
		{
			$codigosap = $codigosap . $total1;
			$contador++;
		}
		else
		if ($contador == 2)
		{
			$codigosap = $codigosap. "-" . $total1;
			$contador++;
		}
		else
		if ($contador == 3)
		{
			$codigosap = $codigosap . "-" . $total1;
			$contador++;
		}
	} // foreach 2

	$insertacodigo = explode("-", $codigosap);*/

?>
              <option value="<?php echo $insertacodigo[0]."-".$insertacodigo[1]."-".$insertacodigo[2];?>"<?php $name = explode("-", $_POST['cuentacontable']); if($_POST['cuentacontable']==$insertacodigo[0]."-".$insertacodigo[1]."-".$insertacodigo[2]){echo "selected";}elseif($concepto->cuentaoperacionprincipal == $insertacodigo[1] and $concepto->cuentaoperacionparcial == $insertacodigo[2]){echo "selected";}?>><?php echo  strtoupper($insertacodigo[0]);?></option>
              <?php            


//}

?>
            </select>-->
</td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo concepto<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <select name="codigotipoconcepto" id="codigotipoconcepto">
              <option value="">Seleccionar</option>
<?php
do {
?>
              <option value="<?php echo $tipoconcepto->codigotipoconcepto;?>"<?php if($concepto->codigotipoconcepto == $tipoconcepto->codigotipoconcepto){echo "selected";}?>><?php echo $tipoconcepto->nombretipoconcepto;?></option>
              <?php
} while ($tipoconcepto->fetch())
?>
            </select>
</span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Cuenta op. principal</div></td>
          <td bgcolor="#FEF7ED"><?php if(isset($name[1])){echo $name[1];}else{echo $concepto->cuentaoperacionprincipal;}/* strtoupper($insertacodigo[1]) */?></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Cuenta op. parcial </div></td>
          <td bgcolor="#FEF7ED"><?php if(isset($name[2])){echo $name[2];}else{echo $concepto->cuentaoperacionparcial;}?></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Aplica recargo<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <select name="codigoaplicarecargo" id="codigoaplicarecargo">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $aplicarecargo->codigoaplicarecargo;?>"<?php if($concepto->codigoaplicarecargo == $aplicarecargo->codigoaplicarecargo){echo "selected";}?>><?php echo $aplicarecargo->nombreaplicarecargo;?></option>
              <?php
              } while ($aplicarecargo->fetch())
?>
            </select>
          </span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD"><div align="center"><span class="Estilo2">Referencia concepto</span><span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <select name="codigoreferenciaconcepto" id="codigoreferenciaconcepto">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $referenciaconcepto->codigoreferenciaconcepto;?>"<?php if($concepto->codigoreferenciaconcepto == $referenciaconcepto->codigoreferenciaconcepto){echo "selected";}?>><?php echo $referenciaconcepto->nombrereferenciaconcepto;?></option>
              <?php
              } while ($referenciaconcepto->fetch())
?>
            </select>
          </span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD"><div align="center"><span class="Estilo2">Aplica bloqueo deuda</span><span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <select name="codigoaplicabloqueodeuda" id="codigoaplicabloqueodeuda">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $aplicabloqueodeuda->codigoaplicabloqueodeuda;?>"<?php if($concepto->codigoaplicabloqueodeuda == $aplicabloqueodeuda->codigoaplicabloqueodeuda){echo "selected";}?>><?php echo $aplicabloqueodeuda->nombreaplicabloqueodeuda;?></option>
              <?php
              } while ($aplicabloqueodeuda->fetch())
?>
            </select>
          </span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD"><div align="center" class="Estilo2">Cambio valor concepto<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <select name="codigocambiovalorconcepto" id="codigocambiovalorconcepto">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $cambiovalorconcepto->codigocambiovalorconcepto;?>"<?php if($concepto->codigocambiovalorconcepto == $cambiovalorconcepto->codigocambiovalorconcepto){echo "selected";}?>><?php echo $cambiovalorconcepto->nombrecambiovalorconcepto;?></option>
              <?php
              } while ($cambiovalorconcepto->fetch())
?>
            </select>
          </span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Indicador estado cuenta concepto<span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <select name="codigoindicadorestadocuentaconcepto" id="codigoindicadorestadocuentaconcepto">
              <option value="">Seleccionar</option>
              <?php
            do {
?>
              <option value="<?php echo $indicadorestadocuentaconcepto->codigoindicadorestadocuentaconcepto;?>"<?php if($concepto->codigoindicadorestadocuentaconcepto == $indicadorestadocuentaconcepto->codigoindicadorestadocuentaconcepto){echo "selected";}?>><?php echo $indicadorestadocuentaconcepto->nombreindicadorestadocuentaconcepto;?></option>
              <?php
            } while ($indicadorestadocuentaconcepto->fetch())
?>
            </select>
          </span></span></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD"><div align="center">
              <input name="Regresar" type="button" id="Regresar" value="Regresar" onclick="window.location.href='consultar_conceptos.php';">&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Anular" type="submit" id="Anular" value="Anular">
</div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST['Enviar'])){
$validacion['req_codigotipoconcepto']=validar($_POST['codigotipoconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado el tipo de concepto")</script>', true);
$validacion['req_codigoaplicarecargo']=validar($_POST['codigoaplicarecargo'],"requerido",'<script language="JavaScript">alert("No seleccionado aplica recargo")</script>', true);
$validacion['req_cuentacontable']=validar($_POST['nombreconcepto'],"requerido",'<script language="JavaScript">alert("No ha seleccionado nombre concepto")</script>', true);
$validacion['req_codigoreferenciaconcepto']=validar($_POST['codigoreferenciaconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado la referencia del concepto")</script>', true);
$validacion['req_codigoaplicabloqueodeuda']=validar($_POST['codigoaplicabloqueodeuda'],"requerido",'<script language="JavaScript">alert("No seleccionado el campo aplica bloqueo deuda")</script>', true);
$validacion['req_codigocambiovalorconcepto']=validar($_POST['codigocambiovalorconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado el cambo cambio valor de concepto")</script>', true);
$validacion['req_codigoindicadorestadocuentaconcepto']=validar($_POST['codigoindicadorestadocuentaconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado el indicador de estado de cuenta concepto")</script>', true);
	$validaciongeneral=true;
	foreach ($validacion as $key => $valor)
	{
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
	if($validaciongeneral==true)
	{
		//$concepto->codigoconcepto=$_POST['codigoconcepto'];
		$concepto->nombreconcepto=strtoupper($_POST['nombreconcepto']);
		$concepto->codigotipoconcepto=$_POST['codigotipoconcepto'];
		$concepto->codigoaplicarecargo=$_POST['codigoaplicarecargo'];
		$concepto->cuentaoperacionprincipal=$name[1];
		$concepto->cuentaoperacionparcial=$name[2];
		$concepto->codigoreferenciaconcepto=$_POST['codigoreferenciaconcepto'];
		$concepto->codigoaplicabloqueodeuda=$_POST['codigoaplicabloqueodeuda'];
		$concepto->codigocambiovalorconcepto=$_POST['codigocambiovalorconcepto'];
		$concepto->codigoindicadorestadocuentaconcepto=$_POST['codigoindicadorestadocuentaconcepto'];
		//DB_DataObject::debugLevel(5);
		$actualizar=$concepto->update();
		//DB_DataObject::debugLevel(0);
		if($actualizar)
		{
			echo "<script language='javascript'>alert('Registros actualizados correctamente');</script>";
			echo "<script language='javascript'>window.location.reload('menu.php');</script>";
		}
	}
}

?>

<?php if(isset($_POST['Regresar'])){
	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
}
?>
<?php if(isset($_POST['Anular'])){
	$concepto->codigoestado=200;
	//DB_DataObject::debugLevel(5);
	$anular=$concepto->update();
	//DB_DataObject::debugLevel(0);
	//print_r($concepto);
	if($anular)
	{
		echo "<script language='javascript'>alert('El registro ha sido anulado correctamente');</script>";
		echo "<script language='javascript'>window.location.reload('menu.php');</script>";
	}
}
?>