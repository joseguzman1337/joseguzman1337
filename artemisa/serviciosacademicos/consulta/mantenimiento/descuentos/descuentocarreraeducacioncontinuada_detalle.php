<style type="text/css">@import url(../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-setup.js"></script>

<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
-->
</style>
<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d");
//print_r($_POST);
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
@session_start();
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/funcionip.php');
//DB_DataObject::debugLevel(5);
$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php
@session_start();
//print_r($_SESSION);
if($_SESSION['MM_Username']=='')
{
	$valido['mensaje']="Sesión perdida, no se pueden ingresar datos";
	$valido['valido'] = 0;
	$validacion['sesion']=$valido;
	echo "<script language='javascript'>alert('Sesión perdida, no se pueden ingresar datos');</script>";
}
$usuario = DB_DataObject::factory('usuario');
$carrera=DB_DataObject::factory('carrera');
$directivo=DB_DataObject::factory('directivo');
$descuentocarreraeducacioncontinuada=DB_DataObject::factory('descuentocarreraeducacioncontinuada');
$descuentocarreraeducacioncontinuada->get('iddescuentocarreraeducacioncontinuada',$_GET['iddescuentocarreraeducacioncontinuada']);
//print_r($descuentocarreraeducacioncontinuada);
$usuario_sesion=$_SESSION['MM_Username'];
$usuario->get('usuario',$usuario_sesion);
$directivo->orderBy('apellidosdirectivo');
$directivo->get('','*');
$fechahoy=date("Y-m-d");
$ip=tomarip();

//$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">DESCUENTO CARRERA EDUCACION CONTINUADA - EDITAR </p>
  <table width="100%"  border="1" bordercolor="#000000">
    <tr>
      <td><table width="100%"  border="0">
        <tr>
          <td width="184" bgcolor="#CCDADD" class="Estilo2"><div align="center">Descripci&oacute;n descuento </div></td>
          <td width="448" bgcolor="#FEF7ED"><?php $validacion['descripciondescuentocarreraeducacioncontinuada']=campotexto_valida_post_bd("descripciondescuentocarreraeducacioncontinuada","requerido","Descripción descuento","50","descuentocarreraeducacioncontinuada","iddescuentocarreraeducacioncontinuada",$_GET['iddescuentocarreraeducacioncontinuada'],"descripciondescuentocarreraeducacioncontinuada")?></td>
        </tr>
          <tr><td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
           <td bgcolor="#FEF7ED"><?php $validacion['codigocarrera']=combo_valida_post_bd("codigocarrera","carrera","codigocarrera","nombrecarrera","","","si","Carrera","descuentocarreraeducacioncontinuada","iddescuentocarreraeducacioncontinuada",$_GET['iddescuentocarreraeducacioncontinuada'],"codigocarrera");?></td>
        </tr>
          <tr>
            <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Indicador descuento</div></td>
            <td bgcolor="#FEF7ED"><?php $validacion['codigoindicadordescuentouniversidad']=combo_valida_post_bd("codigoindicadordescuentouniversidad","indicadordescuentouniversidad","codigoindicadordescuentouniversidad","nombreindicadordescuentouniversidad","","","si","Indicador descuento","descuentocarreraeducacioncontinuada","iddescuentocarreraeducacioncontinuada",$_GET['iddescuentocarreraeducacioncontinuada'],"codigoindicadordescuentouniversidad")?></td>
          </tr>
		 <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Descuento</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['iddescuentoeducacioncontinuada']=combo_valida_post_bd("iddescuentoeducacioncontinuada","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada","nombredescuentoeducacioncontinuada","","fechahastadescuentoeducacioncontinuada>='".$fechahoy."'","si","Descuento","descuentocarreraeducacioncontinuada","iddescuentocarreraeducacioncontinuada",$_GET['iddescuentocarreraeducacioncontinuada'],"iddescuentoeducacioncontinuada")//fechadesdedescuentoeducacioncontinuada<='".$fechahoy."' and ?></td>
		 </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha desde </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php $validacion['fechadesdedescuentocarreraeducacioncontinuada']=campotexto_valida_post_bd("fechadesdedescuentocarreraeducacioncontinuada","fecha","Fecha desde","7","descuentocarreraeducacioncontinuada","iddescuentocarreraeducacioncontinuada",$_GET['iddescuentocarreraeducacioncontinuada'],"fechadesdedescuentocarreraeducacioncontinuada")?>
            <button id="btfechadesdedescuentocarreraeducacioncontinuada">...</button>
                      </span></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha hasta </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php $validacion['fechahastadescuentocarreraeducacioncontinuada']=campotexto_valida_post_bd("fechahastadescuentocarreraeducacioncontinuada","fecha","Fecha hasta","7","descuentocarreraeducacioncontinuada","iddescuentocarreraeducacioncontinuada",$_GET['iddescuentocarreraeducacioncontinuada'],"fechahastadescuentocarreraeducacioncontinuada")?>
            <button id="btfechahastadescuentocarreraeducacioncontinuada">...</button>
            </span></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Directivo autoriza </div></td>
          <td bgcolor="#FEF7ED"><select name="iddirectivo">
		  <option value="">Seleccionar</option>
              <?php do{ ?>
              <option value="<?php echo $directivo->iddirectivo?>" <?php if($descuentocarreraeducacioncontinuada->iddirectivo==$directivo->iddirectivo){echo "selected";}?>><?php echo $directivo->apellidosdirectivo,' ',$directivo->nombresdirectivo?></option>
              <?php }while($directivo->fetch())?>
            </select>
            <?php
			$validacion['iddirectivo']=validaciongenerica($_POST['iddirectivo'], "requerido", "Directivo");
			?></td>
        </tr>
        <tr bgcolor="#CCDADD">
          <td colspan="2"><div align="center">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input name="Regresar" type="submit" id="Regresar" value="Regresar">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input name="Eliminar" type="submit" id="Regresar" value="Eliminar">
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  </form>
<?php
if(isset($_POST['Enviar']))
{
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$descuentocarreraeducacioncontinuada->descripciondescuentocarreraeducacioncontinuada=$_POST['descripciondescuentocarreraeducacioncontinuada'];
		$descuentocarreraeducacioncontinuada->fechadescuentocarreraeducacioncontinuada=$fechahoy;
		$descuentocarreraeducacioncontinuada->codigocarrera=$_POST['codigocarrera'];
		$descuentocarreraeducacioncontinuada->iddescuentoeducacioncontinuada=$_POST['iddescuentoeducacioncontinuada'];
		$descuentocarreraeducacioncontinuada->fechadesdedescuentocarreraeducacioncontinuada=$_POST['fechadesdedescuentocarreraeducacioncontinuada'];
		$descuentocarreraeducacioncontinuada->fechahastadescuentocarreraeducacioncontinuada=$_POST['fechahastadescuentocarreraeducacioncontinuada'];
		$descuentocarreraeducacioncontinuada->idusuario=$usuario->idusuario;
		$descuentocarreraeducacioncontinuada->ip=$ip;
		$descuentocarreraeducacioncontinuada->iddirectivo=$_POST['iddirectivo'];
		$descuentocarreraeducacioncontinuada->codigoindicadordescuentouniversidad=$_POST['codigoinidcadordescuentouniversidad'];
		//print_r($descuentocarreraeducacioncontinuada);
		//DB_DataObject::debugLevel(5);
		$actualizar=$descuentocarreraeducacioncontinuada->update();
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
	echo '<script language="Javascript">window.close();</script>';
	
}
?>
<?php
if(isset($_POST['Eliminar']))
{
	$descuentocarreraeducacioncontinuada->fechadesdedescuentocarreraeducacioncontinuada='0000-00-00';
	$descuentocarreraeducacioncontinuada->fechahastadescuentocarreraeducacioncontinuada='0000-00-00';
	$actualizar=$descuentocarreraeducacioncontinuada->update();
	//DB_DataObject::debugLevel(0);
	if($actualizar)
	{
		echo "<script language='javascript'>alert('Datos eliminados correctamente');</script>";
		echo '<script language="javascript">window.close();</script>';
		echo '<script language="javascript">window.opener.recargar();</script>';
	}
}
?>
<script type="text/javascript">
Calendar.setup(
{
inputField : "fechadesdedescuentocarreraeducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechadesdedescuentocarreraeducacioncontinuada" // ID of the button
}
);
</script>

<script type="text/javascript">
Calendar.setup(
{
inputField : "fechahastadescuentocarreraeducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechahastadescuentocarreraeducacioncontinuada" // ID of the button
}
);
</script>
