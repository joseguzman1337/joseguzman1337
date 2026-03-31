<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
ini_set("include_path", ".:/usr/share/pear_");
@session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
if($_SESSION['MM_Username']=="")
	{
		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede ingresar datos")</script>';
	}
//print_r($_POST);
//print_r($_SESSION);
//error_reporting(2047);
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/pear/DB/DataObject.php';
require_once '../funciones/combo.php';
require_once '../funciones/combo_bd.php';
require('calendario/calendario.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
//DB_DataObject::debugLevel(5);
//combo("nombrevarpost/ger","nombredataobjeto","etiqueta_para_el_combo","dato_que_ingresa_combo");
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
  <p align="center" class="Estilo2"><span class="Estilo3">CREAR PERIODOS - INSERTAR PERIODOS</span></p>
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="3">
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">A&ntilde;o<span class="Estilo4">*</span> </div></td>
          <td nowrap bgcolor="#FEF7ED"><?php combo("anoperiodo","ano","codigoano","codigoano",'onchange="enviar()"','');?>
          </td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio primer periodo<span class="Estilo4">*</span></div></td>
          <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechainicioprimerperiodo'])){escribe_formulario_fecha_vacio("fechainicioprimerperiodo","form1","",@$_POST['fechainicioprimerperiodo']);}else{escribe_formulario_fecha_vacio("fechainicioprimerperiodo","form1","","");} ?>
          </span> </span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha vencimiento primer periodo<span class="Estilo4">*</span></div></td>
          <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechavencimientoprimerperiodo'])){escribe_formulario_fecha_vacio("fechavencimientoprimerperiodo","form1","",@$_POST['fechavencimientoprimerperiodo']);}else{escribe_formulario_fecha_vacio("fechavencimientoprimerperiodo","form1","","");} ?>
          </span> </span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio segundo periodo<span class="Estilo4">*</span></div></td>
          <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechainiciosegundoperiodo'])){escribe_formulario_fecha_vacio("fechainiciosegundoperiodo","form1","",@$_POST['fechainiciosegundoperiodo']);}else{escribe_formulario_fecha_vacio("fechainiciosegundoperiodo","form1","","");} ?>
          </span></span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha vencimiento segundo periodo<span class="Estilo4">*</span></div></td>
          <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechavencimientosegundoperiodo'])){escribe_formulario_fecha_vacio("fechavencimientosegundoperiodo","form1","",@$_POST['fechavencimientosegundoperiodo']);}else{escribe_formulario_fecha_vacio("fechavencimientosegundoperiodo","form1","","");} ?>
          </span></span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Asociar Autom&aacute;ticamente los periodos a todas las carreras?<span class="Estilo4">*</span></div></td>
          <td nowrap bgcolor="#FEF7ED"><div align="center">
            <input name="asociar" type="checkbox" id="asociar" value="si" checked>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" nowrap bgcolor="#CCDADD"><div align="center">
              <input name="Regresar" type="submit" id="Regresar" value="Regresar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Enviar" type="submit" id="Enviar" value="Enviar">
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

	$validacion['req_anoperiodo']=validar($_POST['anoperiodo'],"requerido",'<script language="JavaScript">alert("No digitado el año para crear los periodos")</script>', true);
	$validacion['req_anoperiodo']=validar($_POST['anoperiodo'],"numero",'<script language="JavaScript">alert("No digitado correctamente el año para crear los periodos")</script>', true);
	$validacion['num_año']=validar($_POST['anoperiodo'],$_POST['fechainicioprimerperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del primer periodo, no corresponde con el año seleccionado")</script>', true);
	$validacion['dat_año_inicioprimerperiodo']=validafechaano($_POST['anoperiodo'],$_POST['fechainicioprimerperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del primer periodo, no corresponde con el año seleccionado")</script>', true);
	$validacion['dat_año_iniciosegundoperiodo']=validafechaano($_POST['anoperiodo'],$_POST['fechainiciosegundoperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del segundo periodo, no corresponde con el año seleccionado")</script>', true);
	$validacion['dat_año_vencimientoprimerperiodo']=validafechaano($_POST['anoperiodo'],$_POST['fechavencimientoprimerperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del primer periodo, no corresponde con el año seleccionado")</script>', true);
	$validacion['dat_año_vencimientosegundoperiodo']=validafechaano($_POST['anoperiodo'],$_POST['fechavencimientosegundoperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del segundo periodo, no corresponde con el año seleccionado")</script>', true);
	$validacion['req_fechainicioprimerperiodo']=validar($_POST['fechainicioprimerperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de incio del primer periodo")</script>', true);
	$validacion['req_fechavencimientoprimerperiodo']=validar($_POST['fechavencimientoprimerperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de vencimiento del primer periodo")</script>', true);
	$validacion['req_fechainiciosegundoperiodo']=validar($_POST['fechainiciosegundoperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de incio del segundo periodo")</script>', true);
	$validacion['req_fechavencimientosegundoperiodo']=validar($_POST['fechavencimientosegundoperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de vencimiento del segundo periodo")</script>', true);
	$validacion['dat_fechainicio_fechavem_primerperiodo']=validadosfechas($_POST['fechainicioprimerperiodo'],$_POST['fechavencimientoprimerperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del primer periodo no puede ser menor a la fecha de inicio")</script>', true);
	$validacion['dat_fechainicio_fechavem_segundoperiodo']=validadosfechas($_POST['fechainiciosegundoperiodo'],$_POST['fechavencimientosegundoperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del segundo periodo no puede ser menor a la fecha de inicio")</script>', true);
	$validacion['dat_fechaven_primerperiodo_fechaini_segundoperiodo']=validadosfechas($_POST['fechavencimientoprimerperiodo'],$_POST['fechainiciosegundoperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento primer periodo no puede ser menor menor a la fecha de inicio del segundo periodo")</script>', true);
	
	foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
		
	$periodo = DB_DataObject::factory('periodo');
	$periodo->query("select * FROM {$periodo->__table} where codigoperiodo like '".$_POST['anoperiodo']."%'");
	while ($periodo->fetch()) {
	$periodoexistente=$periodo->codigoperiodo;
	}
	
	if($periodoexistente!="" and $_POST['anoperiodo']!= "")
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("Ya existen periodos para el año seleccionado")</script>';
	}
	//echo "<h1>",$validaciongeneral,"</h1>" ;
	if($validaciongeneral==true){
		$periodonuevo1 = DB_DataObject::factory('periodo');
		$periodonuevo1->codigoperiodo=$_POST['anoperiodo'].'1';
		$periodonuevo1->nombreperiodo='PRIMER PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
		$periodonuevo1->codigoestadoperiodo='2';
		$periodonuevo1->fechainicioperiodo=$_POST['fechainicioprimerperiodo'];
		$periodonuevo1->fechavencimientoperiodo=$_POST['fechavencimientoprimerperiodo'];
		$periodonuevo1->numeroperiodo='1';
		//print_r($periodonuevo1);
		
		$periodonuevo2 = DB_DataObject::factory('periodo');
		$periodonuevo2->codigoperiodo=$_POST['anoperiodo'].'2';
		$periodonuevo2->nombreperiodo='SEGUNDO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
		$periodonuevo2->codigoestadoperiodo='2';
		$periodonuevo2->fechainicioperiodo=$_POST['fechainiciosegundoperiodo'];
		$periodonuevo2->fechavencimientoperiodo=$_POST['fechavencimientosegundoperiodo'];
		$periodonuevo2->numeroperiodo='2';
		//print_r($periodonuevo2);
 		$periodonuevo1->numeroperiodo='1';
		
		$primerperiodo=$periodonuevo1->insert(); 
		$segundoperiodo=$periodonuevo2->insert();
		if($primerperiodo and $segundoperiodo and !isset($_POST['asociar']))
		{
		  	echo "<script language='javascript'>alert('Periodos creados correctamente');</script>";
		  	echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 
		}

		if($_POST['asociar']=='si')
		{
			include_once('llenar_carreraperiodo_masivo.php');
		}		
		}


}
?>

 <?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
  }
?>