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
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post.php');
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
$grupo=DB_DataObject::factory('grupo');
$grupo->get('idgrupo',$_GET['idgrupo']);
$descuentocarreraeducacioncontinuada=DB_DataObject::factory('descuentocarreraeducacioncontinuada');
$descuentocarreraeducacioncontinuada->get('iddescuentocarreraeducacioncontinuada',$_GET['iddescuentocarreraeducacioncontinuada']);
//print_r($descuentocarreraeducacioncontinuada);
$usuario_sesion=$_SESSION['MM_Username'];
$usuario->get('usuario',$usuario_sesion);
$directivo->orderBy('apellidosdirectivo');
$directivo->get('','*');
$fechahoy=date("Y-m-d");
$ip=tomarip();
$descuentogrupoeducacioncontinuada=DB_DataObject::factory('descuentogrupoeducacioncontinuada');
//$descuentogrupoeducacioncontinuada->get('iddescuentogrupoeducacioncontinuada',$_GET['iddescuentogrupoeducacioncontinuada']);
//print_r($descuentogrupoeducacioncontinuada);
?>
<form name="form1" method="post" action="">
  <p align="center"><span class="Estilo3">DESCUENTO GRUPOS EDUCACION CONTINUADA - ASOCIAR NUEVO GRUPO </span></p>
  <table width="100%"  border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%"  border="0">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Descripci&oacute;n</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['descripciondescuentogrupoeducacioncontinuada']=campotexto_valida_post("descripciondescuentogrupoeducacioncontinuada","requerido","Descripción","50")?></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Grupo</div></td>
          <td bgcolor="#FEF7ED"><?php echo $grupo->nombregrupo?></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Descuento</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['iddescuentoeducacioncontinuada']=combo_valida_post("iddescuentoeducacioncontinuada","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada","nombredescuentoeducacioncontinuada","","fechahastadescuentoeducacioncontinuada>='".$fechahoy."'","","si","Descuento")//fechadesdedescuentoeducacioncontinuada<='".$fechahoy."' and ?></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Directivo autoriza </div></td>
          <td bgcolor="#FEF7ED"><select name="iddirectivo">
              <option value="">Seleccionar</option>
              <?php do{ ?>
              <option value="<?php echo $directivo->iddirectivo?>" <?php if($_POST['iddirectivo']==$directivo->iddirectivo){echo "selected";}?>><?php echo $directivo->apellidosdirectivo,' ',$directivo->nombresdirectivo?></option>
              <?php }while($directivo->fetch())?>
            </select>
              <?php
			$validacion['iddirectivo']=validaciongenerica($_POST['iddirectivo'], "requerido", "Directivo");
			?></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha desde </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php $validacion['fechadesdedescuentogrupoeducacioncontinuada']=campotexto_valida_post("fechadesdedescuentogrupoeducacioncontinuada","fecha","Fecha desde","7");?>
            <button id="btfechadesdedescuentogrupoeducacioncontinuada">...</button>
          </span></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha hasta </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php $validacion['fechahastadescuentogrupoeducacioncontinuada']=campotexto_valida_post("fechahastadescuentogrupoeducacioncontinuada","fecha","Fecha hasta","7");?>
            <button id="btfechahastadescuentogrupoeducacioncontinuada">...</button>
          </span></span></span></td>
        </tr>
        <tr bgcolor="#CCDADD">
          <td colspan="2" class="Estilo2"><div align="center">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  </form>
<?php
if(isset($_POST['Enviar']))
{
	if($fechadesdedescuentogrupoeducacioncontinuada>$fechahastadescuentogrupoeducacioncontinuada)
	{
		$valor['valido']=0;
		$valor['mensaje']="La fecha hasta no puede ser menor a la fecha desde";
		$validacion['mayor_fechadesde_fechahasta']=$valor;
	}
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$descuentogrupoeducacioncontinuada->descripciondescuentogrupoeducacioncontinuada=$_POST['descripciondescuentogrupoeducacioncontinuada'];
		$descuentogrupoeducacioncontinuada->idgrupo=$_GET['idgrupo'];
		$descuentogrupoeducacioncontinuada->iddescuentoeducacioncontinuada=$_POST['iddescuentoeducacioncontinuada'];
		$descuentogrupoeducacioncontinuada->iddirectivo=$_POST['iddirectivo'];
		$descuentogrupoeducacioncontinuada->fechadesdedescuentogrupoeducacioncontinuada=$_POST['fechadesdedescuentogrupoeducacioncontinuada'];
		$descuentogrupoeducacioncontinuada->fechahastadescuentogrupoeducacioncontinuada=$_POST['fechahastadescuentogrupoeducacioncontinuada'];
		$descuentogrupoeducacioncontinuada->idusuario=$usuario->idusuario;
		$descuentogrupoeducacioncontinuada->ip=$ip;
		$descuentogrupoeducacioncontinuada->fechadescuentogrupoeducacioncontinuada=$fechahoy;
		//DB_DataObject::debugLevel(5);
		$insertar=$descuentogrupoeducacioncontinuada->insert();
		//DB_DataObject::debugLevel(0);
		//print_r($descuentogrupoeducacioncontinuada);
		if($insertar)
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
<script type="text/javascript">
Calendar.setup(
{
inputField : "fechadesdedescuentogrupoeducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechadesdedescuentogrupoeducacioncontinuada" // ID of the button
}
);
</script>

<script type="text/javascript">
Calendar.setup(
	{
		inputField : "fechahastadescuentogrupoeducacioncontinuada", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		button : "btfechahastadescuentogrupoeducacioncontinuada" // ID of the button
	}
);
</script>
