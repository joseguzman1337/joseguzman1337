<?php 

    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

?>
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<?php
//error_reporting(2048);
ini_set("include_path", ".:/usr/share/pear_");
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/combo.php');
require_once realpath(dirname(__FILE__)).'/../funciones/combo_bd.php';
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/funcionip.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
//DB_DataObject::debugLevel(5);
?>
<?php
//print_r($options);
@session_start();
$fechahoy=date("Y-m-d");
$usuario_sesion=$_SESSION['MM_Username'];
$usuario = DB_DataObject::factory('usuario');

$fechanumeroordeninternasap=date("Y-m-d H:i:s");

$combo_carrera=DB_DataObject::factory('carrera');
$combo_carrera->query("SELECT DISTINCT * FROM carrera c WHERE c.codigomodalidadacademica = '".$_POST['modalidadacademica']."' AND 
c.fechainiciocarrera < '$fechahoy' AND  c.fechavencimientocarrera > '$fechahoy' 
ORDER BY c.nombrecarrera ASC");

$consulta_numeroordeninternasap=DB_DataObject::factory('numeroordeninternasap');
$consulta_numeroordeninternasap->query("SELECT DISTINCT * FROM numeroordeninternasap n WHERE n.codigocarrera = '".$_POST['carrera']."' AND 
n.fechainicionumeroordeninternasap < '$fechahoy' AND  n.fechavencimientonumeroordeninternasap > '$fechahoy' ");

$mod_numeroordeninternasap=DB_DataObject::factory('numeroordeninternasap');
$mod_numeroordeninternasap->get('idnumeroordeninternasap',$_POST['consulta_numeroordeninternasap']);
//print_r($mod_numeroordeninternasap);


$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica";
$sel_modalidadacademica = $sala->query($query_sel_modalidadacademica);
$row_sel_modalidadacademica = $sel_modalidadacademica->fetchRow();
?>
<form name="form1" method="post" action="">

<p align="center" class="Estilo3">ORDEN INTERNA SAP - MODIFICAR </p>
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
      <tr bordercolor="#003333">
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica<span class="Estilo4">*</span></div></td>
        <td bgcolor='#FEF7ED'><div align="center"><span class="style2">
            <select name="modalidadacademica" id="modalidadacademica" onchange="enviar()">
              <option value="">Seleccionar</option>
              <?php
                  do {
?>
              <option value="<?php echo $row_sel_modalidadacademica['codigomodalidadacademica']?>"<?php if(isset($_POST['modalidadacademica'])){if($_POST['modalidadacademica'] == $row_sel_modalidadacademica['codigomodalidadacademica'] or $_GET['modalidadacademica']==$row_sel_modalidadacademica['codigomodalidadacademica']){echo "selected";}}?>><?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?></option>
              <?php
                  } while ($row_sel_modalidadacademica = $sel_modalidadacademica->fetchRow());
                  $rows = mysql_num_rows($sel_modalidadacademica);
                  if($rows > 0) {
                  	mysql_data_seek($sel_modalidadacademica, 0);
                  	$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
                  }
?>
            </select>
        </span></div></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <select name="carrera" id="carrera" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php

             while ($combo_carrera->fetch()){
?>
            <option value="<?php echo $combo_carrera->codigocarrera;?>"<?php if($combo_carrera->codigocarrera == $_POST['carrera']){echo "selected";}?>><?php echo $combo_carrera->nombrecarrera;?></option>
            <?php
            } 


?>
          </select>
        </span></span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero de orden interna SAP<span class="Estilo4">*</span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <select name="consulta_numeroordeninternasap" id="consulta_numeroordeninternasap" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php

            while ($consulta_numeroordeninternasap->fetch()) {
?>
            <option value="<?php echo $consulta_numeroordeninternasap->idnumeroordeninternasap;?>"<?php if( $consulta_numeroordeninternasap->idnumeroordeninternasap == $_POST['consulta_numeroordeninternasap']){echo "selected";}?>><?php echo $consulta_numeroordeninternasap->numeroordeninternasap;?></option>
            <?php
            } 


?>
          </select>
        </span></span></span></td>
      </tr>
      <?php if(isset($_POST['consulta_numeroordeninternasap']) and $_POST['consulta_numeroordeninternasap']!=""){ ?>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio n&uacute;mero orden interna SAP <span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php escribe_formulario_fecha_vacio("fechainicionumeroordeninternasap","form1","",$mod_numeroordeninternasap->fechainicionumeroordeninternasap); ?>
        </span> </span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha vencimiento n&uacute;mero orden interna SAP<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php escribe_formulario_fecha_vacio("fechavencimientonumeroordeninternasap","form1","",$mod_numeroordeninternasap->fechavencimientonumeroordeninternasap); ?>
        </span> </span></span></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="2" nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input type="submit" name="Enviar" value="Enviar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Anular" type="submit" id="Anular" value="Anular">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Regresar" type="submit" id="Regresar" value="Regresar">
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
  }
?>
<?php
if(isset($_POST['Enviar']))
{

	$validaciongeneral=true;
	if($_SESSION['MM_Username']=="")
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede continuar")</script>';
	}
	$validacion['req_fechainicionumeroordeninternasap']=validar($_POST['fechainicionumeroordeninternasap'],"requerido",'<script language="JavaScript">alert("No digitado la fecha de inicio del número de orden interna SAP")</script>', true);
	$validacion['req_fechavencimientonumeroordeninternasap']=validar($_POST['fechavencimientonumeroordeninternasap'],"requerido",'<script language="JavaScript">alert("No digitado la fecha de vencimiento del número de orden interna SAP")</script>', true);
	$validacion['dat_fechainicio_fechavem_numeroordeninternasap']=validadosfechas($_POST['fechainicionumeroordeninternasap'],$_POST['fechavencimientonumeroordeninternasap'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del número de orden interna SAP no puede ser menor menor a la fecha de inicio")</script>', true);

	foreach ($validacion as $key => $valor)
	{
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}

	if($validaciongeneral==true){
	$mod_numeroordeninternasap->fechanumeroordeninternasap=$fechanumeroordeninternasap;
	$mod_numeroordeninternasap->fechainicionumeroordeninternasap=$_POST['fechainicionumeroordeninternasap'];
	$mod_numeroordeninternasap->fechavencimientonumeroordeninternasap=$_POST['fechavencimientonumeroordeninternasap'];
	$mod_numeroordeninternasap->idusuario=$usuario->idusuario;
	$mod_numeroordeninternasap->ip=$ip;
	$modificar=$mod_numeroordeninternasap->update();
	if($modificar)
	{
		echo "<script language='javascript'>alert('Registro modificado correctamente');</script>";
		echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 
	}
	}
}
?>


<?php
if(isset($_POST['Anular']))
{

	$validaciongeneral=true;
	if($_SESSION['MM_Username']=="")
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede continuar")</script>';
	}
	


	if($validaciongeneral==true){
	$mod_numeroordeninternasap->fechanumeroordeninternasap=$fechanumeroordeninternasap;
	$mod_numeroordeninternasap->fechainicionumeroordeninternasap='0000-00-00';
	$mod_numeroordeninternasap->fechavencimientonumeroordeninternasap='0000-00-00';
	$anular=$mod_numeroordeninternasap->update();
	if($anular)
	{
		echo "<script language='javascript'>alert('Registro anulado correctamente');</script>";
		echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 
	}
	}
}
?>