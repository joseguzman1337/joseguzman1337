<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>

<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
@session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
//print_r($_POST);
//print_r($_SESSION);
//error_reporting(2047);
ini_set("include_path", ".:/usr/share/pear_");
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once '../funciones/pear/DB/DataObject.php';
require_once '../funciones/combo.php';
require_once '../funciones/combo_bd.php';
require_once '../funciones/conexion/conexion.php';
require_once('../funciones/funcionip.php');
require('calendario/calendario.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
//DB_DataObject::debugLevel(5);

?>
<?php
@session_start();

$query_caconcepto = "SELECT * FROM fechacarreraconcepto where idfechacarreraconcepto='".$_GET['idfechacarreraconcepto']."'";
$sel_caconcepto = $sala->query($query_caconcepto);
$row_caconcepto = $sel_caconcepto->fetchRow();
/*print_r($row_caconcepto);
exit();*/
/*$mod_fecha_carrera_concepto = DB_DataObject::factory('fechacarreraconcepto');
$mod_fecha_carrera_concepto->get('idfechacarreraconcepto',$_GET['idfechacarreraconcepto']);*/
$fechahoy=date("Y-m-d");
$usuario_sesion=$_SESSION['MM_Username'];
$usuario = DB_DataObject::factory('usuario');
$query_usuario = "SELECT idusuario FROM usuario where usuario='$usuario_sesion'";
$sel_usuario = $sala->query($query_usuario);
$row_usuario = $sel_usuario->fetchRow();
$idusuario=$row_usuario['idusuario'];


$combo_carrera=DB_DataObject::factory('carrera');

$combo_carrera->query("SELECT DISTINCT * FROM carrera c WHERE c.codigomodalidadacademica = '".$_POST['combomodalidadacademica']."' AND 
c.fechainiciocarrera < '$fechahoy' AND  c.fechavencimientocarrera > '$fechahoy' and c.codigocarrera='".$row_caconcepto['codigocarrera']."'
ORDER BY c.nombrecarrera ASC");

$usuario->get('usuario',$usuario_sesion);
$ip=tomarip();
$fechacarreraconcepto=date("Y-m-d H:i:s");

$query_conceptos = "select * from tipofechacarreraconcepto
where codigoestado like '1%'
;";
$conceptos = $sala->query($query_conceptos);
$row_conceptos = $conceptos->fetchRow();


?>


<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>

<form name="form1" method="post" action="">

<p align="center" class="Estilo3">FECHA CARRERA CONCEPTO - MODIFICAR - DETALLE </p>
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrrera<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1"><?php echo $_GET['nombrecarrera'];?>
        </span></span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1"><?php echo $_GET['nombreconcepto'];?></span></span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo de fecha carrera concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED">
		<select name="combotipofechacarreraconcepto" id="combotipofechacarreraconcepto">
        	        <option value="">Seleccionar</option>
                	<?php
	                  do {
        	        ?>
                	<option value="<?php echo $row_conceptos['codigotipofechacarreraconcepto'];?>"
	                <?php if(isset($_POST['combotipofechacarreraconcepto']) && $_POST['combotipofechacarreraconcepto'] == $row_conceptos['codigotipofechacarreraconcepto']){
        	                echo "selected";
                        }
                        else{
                        	if($row_caconcepto['codigotipofechacarreraconcepto'] == $row_conceptos['codigotipofechacarreraconcepto']){
                                echo "selected"; }	
                        }
                        ?>><?php echo $row_conceptos['nombretipofechacarreraconcepto'];?></option>
	                <?php
        	        } while ($row_conceptos = $conceptos->fetchRow());
	                ?>
        	</select>
	</td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><input name="nombrefechacarreraconcepto" type="text" id="nombrefechacarreraconcepto" value="<?php echo $row_caconcepto['nombrefechacarreraconcepto'];?>"></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio carrera concepto<span class="Estilo4">*</span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php escribe_formulario_fecha_vacio("fechainiciofechacarreraconcepto","form1","",$row_caconcepto['fechainiciofechacarreraconcepto']);?>
        </span></span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha vencimiento carrera concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php escribe_formulario_fecha_vacio("fechavencimientofechacarreraconcepto","form1","",$row_caconcepto['fechavencimientofechacarreraconcepto']);?>
        </span></span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero d&iacute;as para vencimiento carrera concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><input name="numerodiasvencimientofechacarreraconcepto" type="text" id="numerodiasvencimientofechacarreraconcepto" size="4" maxlength="4" value="<?php echo $row_caconcepto['numerodiasvencimientofechacarreraconcepto'];?>"></td>
      </tr>
      <tr>
        <td colspan="2" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Modificar" type="submit" id="Modificar" value="Modificar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Regresar" type="submit" id="Regresar" value="Regresar">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Anular" type="submit" id="Anular" value="Anular">
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<?php
if(isset($_POST['Anular']))
{

		$query_anula = "update fechacarreraconcepto set fechafechacarreraconcepto='$fechacarreraconcepto',fechainiciofechacarreraconcepto='0000-00-00'
		,fechavencimientofechacarreraconcepto='0000-00-00'
		,idusuario=$idusuario
		,ip='$ip'
		where idfechacarreraconcepto='".$_GET['idfechacarreraconcepto']."'"; 
		$sel_anula = $sala->query($query_anula); 

		/*$mod_fecha_carrera_concepto->fechafechacarreraconcepto=$fechacarreraconcepto;
		$mod_fecha_carrera_concepto->fechainiciofechacarreraconcepto='0000-00-00';
		$mod_fecha_carrera_concepto->fechavencimientofechacarreraconcepto='0000-00-00';
		$mod_fecha_carrera_concepto->idusuario=$usuario->idusuario;
		$mod_fecha_carrera_concepto->ip=$ip;
		$anular=$mod_fecha_carrera_concepto->update();*/
		if ($sel_anula)
		{
			echo "<script language='javascript'>alert('Carrera concepto anulado correctamente');</script>";
		  	echo "<script language='javascript'>window.location.href='menu.php';</script>";  
		}
	
}
?>
<?php
if(isset($_POST['Modificar']))
{

	$validaciongeneral=true;	
	if($_SESSION['MM_Username']=="")
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede continuar")</script>';
	}

	$validacion['req_combotipofechacarreraconcepto']=validar($_POST['combotipofechacarreraconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado el tipo de fecha del concepto")</script>', true);	
	$validacion['req_nombrefechacarreraconcepto']=validar($_POST['nombrefechacarreraconcepto'],"requerido",'<script language="JavaScript">alert("No digitado el nombre")</script>', true);		
	$validacion['req_fechainiciofechacarreraconcepto']=validar($_POST['fechainiciofechacarreraconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de inicio")</script>', true);		
	$validacion['req_fechavencimientofechacarreraconcepto']=validar($_POST['fechavencimientofechacarreraconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de vencimiento")</script>', true);		
	$validacion['dat_fechainicio_fechavem_fechacarreraconcepto']=validadosfechas($_POST['fechainiciofechacarreraconcepto'],$_POST['fechavencimientofechacarreraconcepto'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento no puede ser menor menor a la fecha de inicio")</script>', true);
	$validacion['req_numerodiasvencimientofechacarreraconcepto']=validar($_POST['numerodiasvencimientofechacarreraconcepto'],"requerido",'<script language="JavaScript">alert("No digitado el número de días para el vencimiento")</script>', true);		
	$validacion['num_numerodiasvencimientofechacarreraconcepto']=validar($_POST['numerodiasvencimientofechacarreraconcepto'],"numero",'<script language="JavaScript">alert("No digitado correctamente el número de días para el vencimiento")</script>', true);		
	
		foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
		
	if($validaciongeneral==true)
	{

		 $query_actualiza="update fechacarreraconcepto set nombrefechacarreraconcepto='".$_POST['nombrefechacarreraconcepto']."'
		,fechafechacarreraconcepto='$fechacarreraconcepto'
		,fechainiciofechacarreraconcepto='".$_POST['fechainiciofechacarreraconcepto']."'
		,fechavencimientofechacarreraconcepto='".$_POST['fechavencimientofechacarreraconcepto']."'
		,numerodiasvencimientofechacarreraconcepto='".$_POST['numerodiasvencimientofechacarreraconcepto']."'
		,idusuario='$idusuario'
		,ip='$ip'
		,codigotipofechacarreraconcepto='".$_POST['combotipofechacarreraconcepto']."' 
		where idfechacarreraconcepto='".$_GET['idfechacarreraconcepto']."'";

                $sel_actualiza = $sala->query($query_actualiza);

		/*

		$mod_fecha_carrera_concepto->nombrefechacarreraconcepto=$_POST['nombrefechacarreraconcepto'];
		$mod_fecha_carrera_concepto->fechafechacarreraconcepto=$fechacarreraconcepto;
		$mod_fecha_carrera_concepto->fechainiciofechacarreraconcepto=$_POST['fechainiciofechacarreraconcepto'];
		$mod_fecha_carrera_concepto->fechavencimientofechacarreraconcepto=$_POST['fechavencimientofechacarreraconcepto'];
		$mod_fecha_carrera_concepto->numerodiasvencimientofechacarreraconcepto=$_POST['numerodiasvencimientofechacarreraconcepto'];
		$mod_fecha_carrera_concepto->idusuario=$usuario->idusuario;
		$mod_fecha_carrera_concepto->ip=$ip;
		$mod_fecha_carrera_concepto->codigocarrera=$_POST['combocarrera'];
		$mod_fecha_carrera_concepto->codigoconcepto=$_POST['comboconcepto'];
		$mod_fecha_carrera_concepto->codigotipofechacarreraconcepto=$_POST['combotipofechacarreraconcepto'];
		//print_r($mod_fecha_carrera_concepto);
		$modificar=$mod_fecha_carrera_concepto->update();*/
		if ($sel_actualiza)
		{
			echo "<script language='javascript'>alert('Carrera concepto modificado correctamente');</script>";
		  	echo "<script language='javascript'>window.location.href='menu.php';</script>"; 
		}
		
	}


}
?>



 <?php if(isset($_POST['Regresar']))
 {
  	echo "<script language='javascript'>window.location.href='menu.php';</script>";
 }
?>
