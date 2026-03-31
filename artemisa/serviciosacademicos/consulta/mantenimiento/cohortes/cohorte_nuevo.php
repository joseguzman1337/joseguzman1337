<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<?php
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php'); 



//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n';	
//PEAR::setErrorHandling(PEAR_ERROR_PRINT);
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'error_handler');
function error_handler(&$obj) {
$msg = $obj->getMessage();
$code = $obj->getCode();
$info = $obj->getUserInfo();
echo $msg,' ',$code,"<br>";
if ($info) {
print htmlspecialchars($info);
} 
}

?>


<?php
$fechahoy=date("Y-m-d H:i:s");
$cohorte = DB_DataObject::factory('cohorte');
$consulta_cohorte=DB_DataObject::factory('cohorte');
//print_r($consulta_cohorte);
$periodo = DB_DataObject::factory('periodo');
$periodo->get('codigoperiodo',$_GET['codigoperiodo']);
//print_r($periodo);

?>
<form name="form1" action="" method="post">
  <p align="center" class="Estilo3">Nuevo Cohorte</p>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2">
      <tr>
        <td width="30%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad acad&eacute;mica</div></td>
        <td colspan="3" bgcolor="#FEF7ED" class="Estilo1"><?php $validacion['codigocarrera']=combo_valida_post("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica","onChange='enviar()'","","","si","Modalidadacademica")?>          <div align="center"></div>          <div align="left">
        </div></td>
        </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
        <td colspan="3" bgcolor="#FEF7ED" class="Estilo1">
          <?php $validacion['codigocarrera']=combo_valida_post("codigocarrera","carrera","codigocarrera","nombrecarrera","","codigomodalidadacademica='".$_POST['codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."'","nombrecarrera asc","si","Carrera")?>
            </td>
        </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">No. cohorte</div></td>
        <td width="24%" nowrap bgcolor="#CCDADD"><?php $validacion['numerocohorte']=campotexto_valida_post("numerocohorte","numero","N&uacute;mero de cohorte","5","cohorte","idcohorte",$_GET['idcohorte'],"numerocohorte");?></td>
        <td width="38%" nowrap bgcolor="#CCDADD"><div align="center" class="Estilo2">Periodo Cohorte </div></td>
        <td width="8%" nowrap bgcolor="#FEF7ED"><div align="center"><?php echo $periodo->codigoperiodo?>        </div>          <div align="center">
          </div>          <div align="right" class="Estilo2">
              <div align="center"></div>
          </div>          <div align="center">
          </div></td>
        </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center" class="Estilo2">Periodo inicial</div></td>
        <td nowrap bgcolor="#CCDADD"><?php $validacion['codigoperiodoinicial']=combo_valida_post("codigoperiodoinicial","periodo","codigoperiodo","codigoperiodo","","","","si","Periodo inicial cohorte","cohorte","idcohorte",$_GET['idcohorte'],"codigoperiodoinicial")?></td>
        <td nowrap bgcolor="#CCDADD"><div align="center" class="Estilo2">Periodo final </div></td>
        <td nowrap bgcolor="#FEF7ED">          <div align="center">
          <?php $validacion['codigoperiodofinal']=combo_valida_post("codigoperiodofinal","periodo","codigoperiodo","codigoperiodo","","","","si","Periodo inicial cohorte","cohorte","idcohorte",$_GET['idcohorte'],"codigoperiodofinal")?>
        </div></td>
        </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Jornada</div></td>
        <td nowrap bgcolor="#CCDADD"><?php $validacion['codigojornada']=combo_valida_post("codigojornada","jornada","codigojornada","nombrejornada","","","nombrejornada","si","Jornada")?></td>
        <td nowrap bgcolor="#CCDADD">&nbsp;</td>
        <td nowrap bgcolor="#FEF7ED">&nbsp;</td>
      </tr>
      <tr bgcolor="#CCDADD">
        <td colspan="4"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Regresar" type="submit" id="Regresar" value="Regresar">

        </div></td>
      </tr>
    </table></td>
  </tr>
</table>

</form>
<?php
if(isset($_POST['Enviar'])){
$consulta_cohorte->whereAdd("codigocarrera='".$_POST['codigocarrera']."'");
$consulta_cohorte->whereAdd("codigoperiodo='".$_GET['codigoperiodo']."'");
$consulta_cohorte->whereAdd("codigoestadocohorte=01");
$consulta_cohorte->get('','*');
if($consulta_cohorte->codigoperiodofinal >= $_POST['codigoperiodoinicial'] or $_POST['codigoperiodoinicial'] > $_POST['codigoperiodofinal'])
{
	$valor['valido']=0;
	$valor['mensaje']="Periodos no se pueden cruzar, para esta carrera y para este periodo";
	$validacion['cohorteexistente']=$valor;
}
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}

	if($validaciongeneral==true)
	{
		$cohorte->numerocohorte=$_POST['numerocohorte'];
		$cohorte->codigocarrera=$_POST['codigocarrera'];
		$cohorte->codigoperiodo=$_GET['codigoperiodo'];
		$cohorte->codigoestadocohorte='01';
		$cohorte->codigoperiodoinicial=$_POST['codigoperiodoinicial'];
		$cohorte->codigoperiodofinal=$_POST['codigoperiodofinal'];
		$cohorte->codigojornada=$_POST['codigojornada'];
		
		//DB_DataObject::debugLevel(5);
		$insertar=$cohorte->insert();
		//print_r($db_error);
		//DB_DataObject::debugLevel(0);
		if($insertar)
		{
				echo "<script language='javascript'>alert('Datos insertados correctamente');</script>";
				echo '<script language="javascript">window.close();</script>';
				echo '<script language="javascript">window.opener.recargar();</script>';
		}
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>
<?php
if(isset($_POST['Regresar']))
{
	echo '<script language="javascript">window.close();</script>';
	echo '<script language="javascript">window.opener.recargar();</script>';
}
?>