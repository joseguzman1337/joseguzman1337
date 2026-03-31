<?php 

session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script><script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
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
//print_r($_POST);
//echo ini_get('include_path');

require_once(realpath(dirname(__FILE__)).'../../../funciones/clases/autenticacion/redirect.php');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');


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
$fechahoy=date("Y-m-d H:i:s");
$periodo = DB_DataObject::factory('periodo');
//selecciona periodo activo
$periodo->whereADD('codigoestadoperiodo=1');
$periodo->get('','*');
$anoperiodo=substr($periodo->codigoperiodo,0,4);
//echo $anoperiodo;

$fechaacademica = DB_DataObject::factory('fechaacademica');
$fechaacademica->get('idfechaacademica',$_GET['idfechaacademica']);
//print_r($fechaacademica);
?>
<form name="form1" method="post" action="">

  <p align="center" class="Estilo3">FECHA ACADEMICA - EDITAR </p>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Periodo</div></td>
          <td colspan="3" bgcolor="#FEF7ED"><?php echo $fechaacademica->codigoperiodo;?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td><div align="center">Carrera</div></td>
          <td colspan="3" bgcolor="#FEF7ED"><?php echo $_GET['nombrecarrera'] ?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Fecha carga acad&eacute;mica</div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechacargaacademica","form1","",$fechaacademica->fechacargaacademica);
				  $validacion['fechacargaacademica']=validaciongenerica($_POST['fechacargaacademica'], "requerido", "Fecha carga académica");?>
          </span></span></span></td>
          <td bgcolor="#CCDADD"><div align="center">Fecha de corte notas</div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechacortenotas","form1","",$fechaacademica->fechacortenotas);
			$validacion['fechacortenotas']=validaciongenerica($_POST['fechacortenotas'], "requerido", "Fecha corte notas");?>
          </span></span></span></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Fecha inicial prematr&iacute;cula </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechainicialprematricula","form1","",$fechaacademica->fechainicialprematricula);
			$validacion['fechainicialprematricula']=validaciongenerica($_POST['fechainicialprematricula'], "requerido", "Fecha inicial prematrícula");?>
          </span></span></span></td>
          <td bgcolor="#CCDADD"><div align="center">Fecha final prematr&iacute;cula </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechafinalprematricula","form1","",$fechaacademica->fechafinalprematricula);
			$validacion['fechafinalprematrícula']=validaciongenerica($_POST['fechafinalprematricula'], "requerido", "Fecha final prematrícula");?>
          </span></span></span></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Fecha inicial entrega orden pago </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechainicialentregaordenpago","form1","",$fechaacademica->fechainicialentregaordenpago);
			$validacion['fechinicialentregaordenpago']=validaciongenerica($_POST['fechainicialentregaordenpago'], "requerido", "Fecha inicial entrega orden pago");?>
          </span></span></span></td>
          <td bgcolor="#CCDADD"><div align="center">Fecha final entrega orden pago </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechafinalentregaordenpago","form1","",$fechaacademica->fechafinalentregaordenpago);
			$validacion['fechafinalentregaordenpago']=validaciongenerica($_POST['fechafinalentregaordenpago'], "requerido", "Fecha final entrega orden pago");?>
          </span></span></span></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td colspan="4"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
</div></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST['Enviar']))
{
	$validacion['fechainicialprematricula,fechafinalprematricula']=validardosfechas($_POST['fechainicialprematricula'], $_POST['fechafinalprematricula'], "La fecha final de prematrícula, no puede ser menor a la fecha de inicio");
	$validacion['fechainicialentregaordenpago,fechafinalentregaordenpago']=validardosfechas($_POST['fechainicialentregaordenpago'], $_POST['fechafinalentregaordenpago'], "La fecha final de entrega orden pago, no puede ser menor a la fecha de inicio");
	
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$fechaacademica->fechacargaacademica=$_POST['fechacargaacademica'];
		$fechaacademica->fechacortenotas=$_POST['fechacortenotas'];
		$fechaacademica->fechainicialprematricula=$_POST['fechainicialprematricula'];
		$fechaacademica->fechafinalprematricula=$_POST['fechafinalprematricula'];
		$fechaacademica->fechainicialentregaordenpago=$_POST['fechainicialentregaordenpago'];
		$fechaacademica->fechafinalentregaordenpago=$_POST['fechafinalentregaordenpago'];
		$actualizar=$fechaacademica->update();
		if($actualizar)
		{
			echo "<script language='javascript'>alert('Datos modificados correctamente');</script>";
			echo '<script language="javascript">window.close();</script>';
			echo '<script language="javascript">window.opener.recargar();</script>';
		}
		//print_r($fechaacademica);
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
<?php
if(isset($_POST['Eliminar']))
{
	$eliminar=$fechaacademica->delete();
	if($eliminar)
	{
		echo "<script language='javascript'>alert('Datos eliminados correctamente');</script>";
		echo '<script language="javascript">window.close();</script>';
		echo '<script language="javascript">window.opener.recargar();</script>';
	}
}
?>