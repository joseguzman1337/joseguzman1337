<script language="javascript">
function enviar()
{
	document.periodos.submit()
}
</script>
<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
  session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
ini_set("include_path", ".:/usr/share/pear_");
//print_r($_POST);
//error_reporting(2047);
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once realpath(dirname(__FILE__)).'/../funciones/combo.php';
require_once realpath(dirname(__FILE__)).'/../funciones/combo_bd.php';
require_once realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php';
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');


//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$carreraperiodo_insertar = DB_DataObject::factory('carreraperiodo');
?>
<?php
$fechahoy=date("Y-m-d H:i:s");
if(isset($_POST['ano']))
	{ 
	  $periodo = DB_DataObject::factory('periodo');
	  $periodo->get($_POST['codigoperiodo']);
	  $periodo_mod=clone($periodo);
	  $periodo_mod->query("select distinct * FROM {$periodo->__table} where codigoperiodo like '".$_POST['ano']."%'");
  	}
  ?>
  
<?php
  if(isset($_POST['codigoperiodo']) and isset($_POST['codigomodalidadacademica'])){
  
		 $query_carreras="SELECT c.codigocarrera,c.nombrecarrera FROM carrera c WHERE 
		 c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."' and c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."' and
		 codigocarrera NOT IN (
		SELECT DISTINCT c.codigocarrera FROM carreraperiodo cp, carrera c WHERE cp.codigoperiodo='".$_POST['codigoperiodo']."' AND c.codigocarrera=cp.codigocarrera
		) ORDER BY c.nombrecarrera ASC ";
		//echo  $query_carreras;
		$carreras=$sala->query($query_carreras);
		//$row_carreras=$carreras->fetchRow();
	}
?>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>


<form name="periodos" method="post" action="">

  <p align="center"><span class="Estilo2"><span class="Estilo3">CREAR PERIODOS - CARRERAPERIODO </span></span></p>
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="3">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">A&ntilde;o<span class="Estilo4"></span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php combo("ano","ano","codigoano","codigoano",'onchange="enviar()"','');?>
          </span> </span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD"><div align="center"><span class="Estilo2">Periodo</span><span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><select name="codigoperiodo" id="codigoperiodo" onchange="enviar()" >
              <option value="">Seleccionar</option>
              <?php while ($periodo_mod->fetch()) {?>
              <option value="<?php echo $periodo_mod->codigoperiodo;?>"<?php if($_POST['codigoperiodo'] == $periodo_mod->codigoperiodo){echo "selected";}?>><?php echo $periodo_mod->nombreperiodo;?></option>
              <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica<span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <?php combo("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica",'onchange="enviar()"','');?>
          </span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><select name="carrera" id="carrera" onchange="enviar()" >
              <option value="">Seleccionar</option>
              <?php while ($row_carreras=$carreras->fetchRow()) { ?>
              <option value="<?php echo $row_carreras['codigocarrera'];?>"<?php if($_POST['carrera'] == $row_carreras['codigocarrera']){echo "selected";}?>><?php echo $row_carreras['nombrecarrera'];?></option>
              <?php } ?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
	$validacion['req_ano']=validar($_POST['ano'],"requerido",'<script language="JavaScript">alert("No seleccionado el año")</script>', true);
	$validacion['req_codigoperiodo']=validar($_POST['codigoperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado el periodo")</script>', true);	
	$validacion['req_carrera']=validar($_POST['carrera'],"requerido",'<script language="JavaScript">alert("No seleccionado la carrera")</script>', true);		

	foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
	
	
if($validaciongeneral==true){	

	$carreraperiodo_insertar->codigocarrera=$_POST['carrera'];
	$carreraperiodo_insertar->codigoperiodo=$_POST['codigoperiodo'];
	$carreraperiodo_insertar->codigoestado='100';
	$insertar=$carreraperiodo_insertar->insert();
	if($insertar)
	{
		echo "<script language='javascript'>alert('Carrera asociada correctamente a periodo seleccionado');</script>";
		echo "<script language='javascript'>window.location.reload('menu.php');</script>";
	}
	}
}
?>
<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
  }
?>