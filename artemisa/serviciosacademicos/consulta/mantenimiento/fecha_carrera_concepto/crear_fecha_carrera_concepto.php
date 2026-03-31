<?php 
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>

<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>

<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
ini_set("include_path", ".:/usr/share/pear_");

require_once('../../../funciones/clases/autenticacion/redirect.php');
//print_r($_POST);
//print_r($_SESSION);
//error_reporting(2047);
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php';
require_once realpath(dirname(__FILE__)).'/../funciones/combo.php';
require_once realpath(dirname(__FILE__)).'/../funciones/combo_bd.php';
require_once realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php';
require_once(realpath(dirname(__FILE__)).'/../funciones/funcionip.php');
require('calendario/calendario.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);

$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
//DB_DataObject::debugLevel(5);

$ins_fecha_carrera_concepto = DB_DataObject::factory('fechacarreraconcepto');

$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica";
$sel_modalidadacademica = $sala->query($query_sel_modalidadacademica);
$row_sel_modalidadacademica = $sel_modalidadacademica->fetchRow();

$fechahoy=date("Y-m-d");
$usuario_sesion=$_SESSION['MM_Username'];
$usuario = DB_DataObject::factory('usuario');
$combo_carrera=DB_DataObject::factory('carrera');
$carrera=DB_DataObject::factory('carrera');

$combo_carrera->query("SELECT DISTINCT * FROM carrera c WHERE c.codigomodalidadacademica = '".$_POST['combomodalidadacademica']."' AND 
c.fechainiciocarrera < '$fechahoy' AND  c.fechavencimientocarrera > '$fechahoy' 
ORDER BY c.nombrecarrera ASC");

$usuario->get('usuario',$usuario_sesion);
$ip=tomarip();
$fechacarreraconcepto=date("Y-m-d H:i:s");

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

<p align="center" class="Estilo3">FECHA CARRERA CONCEPTO - CREAR</p>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="3">
      <tr>
        <td width="52%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica<span class="Estilo4">*</span> </div></td>
        <td width="48%" nowrap bgcolor="#FEF7ED"><span class="style2">
          <select name="combomodalidadacademica" id="combomodalidadacademica" onchange="enviar()">
            <option value="">Seleccionar</option>
            <?php
                  do {
?>
            <option value="<?php echo $row_sel_modalidadacademica['codigomodalidadacademica']?>"<?php if(isset($_POST['combomodalidadacademica'])){if($_POST['combomodalidadacademica'] == $row_sel_modalidadacademica['codigomodalidadacademica'] or $_GET['modalidadacademica']==$row_sel_modalidadacademica['codigomodalidadacademica']){echo "selected";}}?>><?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?></option>
            <?php
                  } while ($row_sel_modalidadacademica = $sel_modalidadacademica->fetchRow());
                  $rows = mysql_num_rows($sel_modalidadacademica);
                  if($rows > 0) {
                  	mysql_data_seek($sel_modalidadacademica, 0);
                  	$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
                  }
?>
          </select>
        </span> </td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Aplicar a todas las carreras? </div></td>
        <td nowrap bgcolor="#FEF7ED"><input name="todos" type="checkbox" id="todos" value="si" onClick="enviar()" <?php if($_POST['todos']=='si'){echo "checked";}?>></td>
      </tr>
      <?php if(!isset($_POST['todos'])){?>
	  <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrrera<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <select name="combocarrera" id="combocarrera">
            <option value="">Seleccionar</option>
            <?php

             while ($combo_carrera->fetch()){
?>
            <option value="<?php echo $combo_carrera->codigocarrera;?>"<?php if($combo_carrera->codigocarrera == $_POST['combocarrera']){echo "selected";}?>><?php echo $combo_carrera->nombrecarrera;?></option>
            <?php
            } 


?>
          </select>
        </span></span></span></td>
      </tr>
	  <?php } 
	  else
	  {
	  	//DB_DataObject::debugLevel(5);
		$carrera->whereAdd('codigomodalidadacademica='.$_POST['combomodalidadacademica'].'');
		$carrera->get('','*');
		//DB_DataObject::debugLevel(0);
	  }
	  ?>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><?php 
		//($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$tablaexistente,$indicetablaexistente,$accion)
		combo("comboconcepto","concepto","codigoconcepto","nombreconcepto","",'codigoestado=100');?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo de fecha carrera concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><?php combo("combotipofechacarreraconcepto","tipofechacarreraconcepto","codigotipofechacarreraconcepto","nombretipofechacarreraconcepto",'','codigoestado<>200');?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><input name="nombrefechacarreraconcepto" type="text" id="nombrefechacarreraconcepto" value="<?php if(isset($_POST['nombrefechacarreraconcepto'])){echo $_POST['nombrefechacarreraconcepto'];}?>"></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio carrera concepto<span class="Estilo4">*</span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php if(isset($_POST['fechainiciofechacarreraconcepto'])){escribe_formulario_fecha_vacio("fechainiciofechacarreraconcepto","form1","",@$_POST['fechainiciofechacarreraconcepto']);}else{escribe_formulario_fecha_vacio("fechainiciofechacarreraconcepto","form1","","");} ?>
        </span></span></span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha vencimiento carrera concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php if(isset($_POST['fechavencimientofechacarreraconcepto'])){escribe_formulario_fecha_vacio("fechavencimientofechacarreraconcepto","form1","",@$_POST['fechavencimientofechacarreraconcepto']);}else{escribe_formulario_fecha_vacio("fechavencimientofechacarreraconcepto","form1","","");} ?>
        </span></span></span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero d&iacute;as para vencimiento carrera concepto<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><input name="numerodiasvencimientofechacarreraconcepto" type="text" id="numerodiasvencimientofechacarreraconcepto" size="4" maxlength="4" value="<?php if(isset($_POST['numerodiasvencimientofechacarreraconcepto'])){echo $_POST['numerodiasvencimientofechacarreraconcepto'];}?>"></td>
      </tr>
      <tr>
        <td colspan="2" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
	if($_SESSION['MM_Username']=="")
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede continuar")</script>';
	}

	$validacion['req_combomodalidadacademica']=validar($_POST['combomodalidadacademica'],"requerido",'<script language="JavaScript">alert("No seleccionado la modalidad académica")</script>', true);	
	if(!isset($_POST['todos']))
	{
		$validacion['req_combocarrera']=validar($_POST['combocarrera'],"requerido",'<script language="JavaScript">alert("No seleccionado la carrera")</script>', true);	
	}
	$validacion['req_comboconcepto']=validar($_POST['comboconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado el concepto")</script>', true);	
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
		if(isset($_POST['todos']) and $_POST['todos']=='si')
		{
			do
			{
				$ins_fecha_carrera_concepto->nombrefechacarreraconcepto=$_POST['nombrefechacarreraconcepto'];
				$ins_fecha_carrera_concepto->fechafechacarreraconcepto=$fechacarreraconcepto;
				$ins_fecha_carrera_concepto->fechainiciofechacarreraconcepto=$_POST['fechainiciofechacarreraconcepto'];
				$ins_fecha_carrera_concepto->fechavencimientofechacarreraconcepto=$_POST['fechavencimientofechacarreraconcepto'];
				$ins_fecha_carrera_concepto->numerodiasvencimientofechacarreraconcepto=$_POST['numerodiasvencimientofechacarreraconcepto'];
				$ins_fecha_carrera_concepto->idusuario=$usuario->idusuario;
				$ins_fecha_carrera_concepto->ip=$ip;
				$ins_fecha_carrera_concepto->codigocarrera=$carrera->codigocarrera;
				$ins_fecha_carrera_concepto->codigoconcepto=$_POST['comboconcepto'];
				$ins_fecha_carrera_concepto->codigotipofechacarreraconcepto=$_POST['combotipofechacarreraconcepto'];
				//print_r($ins_fecha_carrera_concepto);
				//DB_DataObject::debugLevel(5);
				$insertar=$ins_fecha_carrera_concepto->insert();
				//DB_DataObject::debugLevel(0);
			}
			while($carrera->fetch());
			if($insertar)
				{
					echo "<script language='javascript'>alert('Carrera concepto creado correctamente');</script>";
					echo "<script language='javascript'>window.location.href='menu.php';</script>"; 
				}
		}
		else{
			$ins_fecha_carrera_concepto->nombrefechacarreraconcepto=$_POST['nombrefechacarreraconcepto'];
			$ins_fecha_carrera_concepto->fechafechacarreraconcepto=$fechacarreraconcepto;
			$ins_fecha_carrera_concepto->fechainiciofechacarreraconcepto=$_POST['fechainiciofechacarreraconcepto'];
			$ins_fecha_carrera_concepto->fechavencimientofechacarreraconcepto=$_POST['fechavencimientofechacarreraconcepto'];
			$ins_fecha_carrera_concepto->numerodiasvencimientofechacarreraconcepto=$_POST['numerodiasvencimientofechacarreraconcepto'];
			$ins_fecha_carrera_concepto->idusuario=$usuario->idusuario;
			$ins_fecha_carrera_concepto->ip=$ip;
			$ins_fecha_carrera_concepto->codigocarrera=$_POST['combocarrera'];
			$ins_fecha_carrera_concepto->codigoconcepto=$_POST['comboconcepto'];
			$ins_fecha_carrera_concepto->codigotipofechacarreraconcepto=$_POST['combotipofechacarreraconcepto'];
			//print_r($ins_fecha_carrera_concepto);
			$insertar=$ins_fecha_carrera_concepto->insert();
			if ($insertar)
			{
				echo "<script language='javascript'>alert('Carrera concepto creado correctamente');</script>";
				echo "<script language='javascript'>window.location.href='menu.php';</script>"; 
			}
		}
	}


}
?>



 <?php if(isset($_POST['Regresar']))
 {
  	echo "<script language='javascript'>window.location.href='menu.php';</script>";
 }
?>