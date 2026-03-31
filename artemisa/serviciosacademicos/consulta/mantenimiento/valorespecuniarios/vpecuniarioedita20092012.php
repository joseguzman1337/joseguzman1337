<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<?php
//print_r($_POST);
ini_set("include_path", ".:/usr/share/pear_");
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/pear/DB/DataObject.php';
require_once '../funciones/gui/combo_valida_post_bd.php';
require_once '../funciones/gui/campotexto_valida_post_bd.php';
require_once('../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
//@session_start();
$consulta_valorpecuniario=DB_DataObject::factory('valorpecuniario');
$valorpecuniario=DB_DataObject::factory('valorpecuniario');
$periodo = DB_DataObject::factory('periodo');
$periodo->whereADD('codigoestadoperiodo=1');
$periodo->get('','*');
$valorpecuniario->get('idvalorpecuniario',$_GET['idvalorpecuniario']);
?>

<form name="form1" method="post" action="">

<p align="center" class="Estilo3">Editar valor  pecuniario </p>
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Codigoperiodo<span class="Estilo4"></span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><?php echo $_GET['codigoperiodo'];?> </td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto</div></td>
        <td nowrap bgcolor="#FEF7ED"><?php $validacion['codigoconcepto']=combo_valida_post_bd("codigoconcepto","concepto","codigoconcepto","nombreconcepto",'',"","si","Concepto","valorpecuniario","idvalorpecuniario",$_GET['idvalorpecuniario'],"codigoconcepto");?></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor pecuniario</div></td>
        <td nowrap bgcolor="#FEF7ED"><?php $validacion['valorpecuniario']=campotexto_valida_post_bd("valorpecuniario","numero","Valor pecuniario","20","valorpecuniario","idvalorpecuniario",$_GET['idvalorpecuniario'],"valorpecuniario"); ?></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Indicador proceso internet </div></td>
        <td nowrap bgcolor="#FEF7ED"><?php $validacion['codigoindicadorprocesointernet']=combo_valida_post_bd("codigoindicadorprocesointernet","indicadorprocesointernet","codigoindicadorprocesointernet","nombreindicadorprocesointernet","","","si","Indicador proceso internet","valorpecuniario","idvalorpecuniario",$_GET['idvalorpecuniario'],"codigoindicadorprocesointernet")?></td>
      </tr>
      <tr>
        <td colspan="2" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Guardar" type="submit" id="Guardar" value="Guardar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<?php
if(isset($_POST['Guardar']))
{
	
	$validaciongeneral=true;
	//DB_DataObject::debuglevel(5);
	$consulta_valorpecuniario->whereAdd('codigoperiodo = '.$_GET['codigoperiodo'].'');
	$consulta_valorpecuniario->whereAdd('codigoconcepto = "'.$_POST['codigoconcepto'].'"');
	$consulta_valorpecuniario->whereAdd('codigoindicadorprocesointernet = "'.$_POST['codigoindicadorprocesointernet'].'"');
	//$consulta_valorpecuniario->whereAdd('valorpecuniario='.$_POST['valorpecuniario'].'');
	$consulta_valorpecuniario->get('','*');

	/*if($consulta_valorpecuniario->idvalorpecuniario!="")
	{
		$valido['mensaje']="Ya existe un concepto con las mismas características, para este periodo";
		$valido['valido']=0;
		$validacion['yaexiste']=$valido;
	}
*/
	foreach ($validacion as $key => $valor)
	{
		//echo $valor['valido']; 
		if($valor['valido']==0)
		{
			$validaciongeneral=false;
		}
	}
	if($validaciongeneral==true)
	{
		$valorpecuniario->codigoconcepto=$_POST['codigoconcepto'];
		$valorpecuniario->valorpecuniario=$_POST['valorpecuniario'];
		$valorpecuniario->codigoindicadorprocesointernet=$_POST['codigoindicadorprocesointernet'];
		//DB_DataObject::debugLevel(5);
		$actualizar=$valorpecuniario->update();
		//DB_DataObject::debugLevel(0);
		if($actualizar)
		{
			echo "<script language='javascript'>alert('Datos modificados correctamente');</script>";
			echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';
		}
	}
	else
	{
		$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n';
		foreach ($validacion as $key => $valor)
			{
				if($valor['valido']==0)
				{
					$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];
				}
			}
 		
		if($validaciongeneral==false){echo "<script language='javascript'>alert('".$mensajegeneral."');</script>"; } 

	}
	
}
?>

<?php
if(isset($_POST['Eliminar']))
{
	$valorpecuniario->codigoestado='200';
	$eliminar=$valorpecuniario->update();
	if($eliminar)
	{
		echo "<script language='javascript'>alert('Dato eliminado correctamente');</script>";
		echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';
	}
}
?>