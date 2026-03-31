<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
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
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php'); 



//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n';
?>


<?php
$fechahoy=date("Y-m-d H:i:s");
$cohorte = DB_DataObject::factory('cohorte');
$cohorte->get('idcohorte',$_GET['idcohorte']);
$consulta_cohorte=DB_DataObject::factory('cohorte');
//print_r($cohorte);
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">Edici&oacute;n de cohortes</p>
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="2">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">No. Cohorte </div></td>
          <td colspan="5" bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
        </tr>
        <tr>
          <td bgcolor="#FEF7ED"><div align="center">
              <input name="" size="1" disabled value="<?php echo $cohorte->numerocohorte?>">
          </div></td>
          <td colspan="5" bgcolor="#FEF7ED"><div align="center">
              <?php $validacion['codigocarrera']=combo_valida_post_bd("codigocarrera","carrera","codigocarrera","nombrecarrera","","fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."'","si","Carrera","cohorte","idcohorte",$_GET['idcohorte'],"codigocarrera")?>
          </div></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD"><div align="center" class="Estilo2">Periodo Cohorte </div></td>
          <td bgcolor="#FEF7ED"><div align="center">
              <?php $validacion['codigoperiodo']=combo_valida_post_bd("codigoperiodo","periodo","codigoperiodo","codigoperiodo","","","si","Periodo cohorte","cohorte","idcohorte",$_GET['idcohorte'],"codigoperiodo")?>
          </div></td>
          <td bgcolor="#CCDADD"><div align="center" class="Estilo2">Periodo inicial</div></td>
          <td bgcolor="#FEF7ED"><div align="center">
              <?php $validacion['codigoperiodoinicial']=combo_valida_post_bd("codigoperiodoinicial","periodo","codigoperiodo","codigoperiodo","","","si","Periodo inicial cohorte","cohorte","idcohorte",$_GET['idcohorte'],"codigoperiodoinicial")?>
          </div></td>
          <td bgcolor="#CCDADD"><div align="right" class="Estilo2">
            <div align="center">Periodo final </div>
          </div></td>
          <td bgcolor="#FEF7ED"><div align="center">
              <?php $validacion['codigoperiodofinal']=combo_valida_post_bd("codigoperiodofinal","periodo","codigoperiodo","codigoperiodo","","","si","Periodo inicial cohorte","cohorte","idcohorte",$_GET['idcohorte'],"codigoperiodofinal")?>
          </div></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD"><div align="center"><strong>Jornada</strong></div></td>
          <td bgcolor="#FEF7ED"><div align="center"><?php $validacion['codigojornada']=combo_valida_post_bd("codigojornada","jornada","codigojornada","nombrejornada","","","si","Jornada","cohorte","idcohorte",$_GET['idcohorte'],"codigojornada")?></div></td>
          <td bgcolor="#CCDADD">&nbsp;</td>
          <td bgcolor="#FEF7ED">&nbsp;</td>
          <td bgcolor="#CCDADD">&nbsp;</td>
          <td bgcolor="#FEF7ED">&nbsp;</td>
        </tr>
        <tr bgcolor="#CCDADD">
          <td colspan="6"><div align="center">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="Regresar" type="submit" id="Regresar" value="Regresar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>

<?php
if(isset($_POST['Eliminar']))
{
	$cohorte->codigoestadocohorte='02';
	DB_DataObject::debugLevel(5);
	$eliminar=$cohorte->update();
	DB_DataObject::debugLevel(0);
	if($eliminar)
	{
		echo "<script language='javascript'>alert('Cohorte eliminado correctamente');</script>";
		echo '<script language="javascript">window.close();</script>';
		echo '<script language="javascript">window.opener.recargar();</script>';
	}
}
?>

<?php
if(isset($_POST['Enviar']))
{

	$consulta_cohorte->whereAdd("codigocarrera='".$_POST['codigocarrera']."'");
	$consulta_cohorte->whereAdd("codigoperiodo='".$_POST['codigoperiodo']."'");
	$consulta_cohorte->get('','*');
	/*if($consulta_cohorte->codigoperiodofinal >= $_POST['codigoperiodoinicial'])
	{
		$valor['valido']=0;
		$valor['mensaje']="Periodos no se pueden cruzar, para esta carrera y para este periodo";
		$validacion['cohorteexistente']=$valor;
	}
	*/

		foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	
	if($validaciongeneral==true)
	{
		$cohorte->numerocohorte=$_POST['numerocohorte'];
		$cohorte->codigocarrera=$_POST['codigocarrera'];
		$cohorte->codigoperiodo=$_POST['codigoperiodo'];
		$cohorte->codigoperiodoinicial=$_POST['codigoperiodoinicial'];
		$cohorte->codigoperiodofinal=$_POST['codigoperiodofinal'];
		$cohorte->codigojornada=$_POST['codigojornada'];
		//DB_DataObject::debugLevel(5);
		$actualizar=$cohorte->update();
		//DB_DataObject::debugLevel(0);
		if($actualizar)
			{
				echo "<script language='javascript'>alert('Datos actualizados correctamente');</script>";
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