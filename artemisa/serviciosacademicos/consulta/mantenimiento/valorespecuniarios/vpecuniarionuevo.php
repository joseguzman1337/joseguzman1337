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
require_once '../funciones/gui/combo_valida_post.php';
require_once '../funciones/gui/campotexto_valida_post.php';
require_once('../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
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
?>

<form name="form1" method="post" action="">

<p align="center" class="Estilo3">Nuevo valor pecuniario </p>
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Codigoperiodo<span class="Estilo4"></span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><?php echo $_GET['codigoperiodo']?> </td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto</div></td>
        <td nowrap bgcolor="#FEF7ED"><?php $validacion['concepto']=combo_valida_post("codigoconcepto","concepto","codigoconcepto","nombreconcepto","","codigoestado=100","nombreconcepto asc","si","Concepto") ?></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor pecuniario</div></td>
        <td nowrap bgcolor="#FEF7ED"><?php $validacion['valorpecuniario']=campotexto_valida_post("valorpecuniario","numero","Valor pecuniario","20"); ?></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Indicador proceso internet </div></td>
        <td nowrap bgcolor="#FEF7ED"><?php $validacion['codigoindicadorprocesointernet']=combo_valida_post("codigoindicadorprocesointernet","indicadorprocesointernet","codigoindicadorprocesointernet","nombreindicadorprocesointernet","","codigoestado=100","nombreindicadorprocesointernet asc","si","Indicador proceso internet") ?></td>
      </tr>
      <tr>
        <td colspan="2" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<?php
if(isset($_POST['Enviar']))
{
	$validaciongeneral=true;
	//DB_DataObject::debugLevel(5);
	$consulta_valorpecuniario->whereAdd('codigoperiodo = '.$_GET['codigoperiodo'].'');
	$consulta_valorpecuniario->whereAdd('codigoconcepto = "'.$_POST['codigoconcepto'].'"');
	$consulta_valorpecuniario->whereAdd('valorpecuniario='.$_POST['valorpecuniario'].'');
	$consulta_valorpecuniario->get('','*');
	//print_r($consulta_valorpecuniario);
	if($consulta_valorpecuniario->idvalorpecuniario!="")
	{
		$valido['mensaje']="Ya existe un concepto con las mismas características, para este periodo";
		$valido['valido']=0;
		$validacion['yaexiste']=$valido;
	}
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
		$valorpecuniario->codigoperiodo=$_GET['codigoperiodo'];
		$valorpecuniario->codigoconcepto=$_POST['codigoconcepto'];
		$valorpecuniario->valorpecuniario=$_POST['valorpecuniario'];
		$valorpecuniario->codigoestado='100';
		$valorpecuniario->codigoindicadorprocesointernet=$_POST['codigoindicadorprocesointernet'];
		//DB_DataObject::debugLevel(5);
		$insertar=$valorpecuniario->insert();
		//DB_DataObject::debugLevel(0);
		if($insertar)
		{
			echo "<script language='javascript'>alert('Datos ingresados correctamente');</script>";
			echo '<script language="javascript">window.location.reload("menu.php");</script>';
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

<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.reload('menu.php?tipo=".$_GET['tipo']."&codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica']."');</script>";
  }
?>