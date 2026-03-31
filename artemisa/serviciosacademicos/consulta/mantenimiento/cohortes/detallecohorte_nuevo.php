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
//print_r($_GET);
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
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
$detallecohorte = DB_DataObject::factory('detallecohorte');
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">Nuevo detalle cohorte</p>
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="2">
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center"><?php echo $_GET['nombrecarrera']?></div></td>
          </tr>
        <tr>
          <td width="17%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Semestre</div></td>
          <td width="38%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor</div></td>
          </tr>
        <tr>
          <td bgcolor="#FEF7ED"><div align="center"><?php $validacion['semestredetallecohorte']=campotexto_valida_post("semestredetallecohorte","numero","Semestre","5","detallecohorte","iddetallecohorte",$_GET['iddetallecohorte'],"semestredetallecohorte")?>
</div></td>
          <td bgcolor="#FEF7ED">            <div align="center">
            <?php $validacion['valordetallecohorte']=campotexto_valida_post("valordetallecohorte","numero","Valor","20","detallecohorte","iddetallecohorte",$_GET['iddetallecohorte'],"valordetallecohorte")?>
          </div></td>
          </tr>
        <tr bgcolor="#CCDADD">
          <td colspan="2"><div align="center">
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
if(isset($_POST['Regresar']))
{
	echo '<script language="javascript">window.close();</script>';
	echo '<script language="javascript">window.opener.recargar();</script>';
}
?>

<?php
if(isset($_POST['Enviar']))
{
	$validaciongeneral=true;
	$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n';

		if($_POST['valordetallecohorte']<=0)
		{
			$valor['valido']=0;
			$valor['mensaje']="El valor de cohorte no puede ser 0";
			$validacion['valorcohorte0']=$valor;
		}

	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}

	if($validaciongeneral==true)
	{
		$detallecohorte->idcohorte=$_GET['idcohorte'];
		$detallecohorte->semestredetallecohorte=$_POST['semestredetallecohorte'];
		$detallecohorte->codigoconcepto='151';
		$detallecohorte->valordetallecohorte=$_POST['valordetallecohorte'];
		//print_r($detallecohorte);
		$insertar=$detallecohorte->insert();
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