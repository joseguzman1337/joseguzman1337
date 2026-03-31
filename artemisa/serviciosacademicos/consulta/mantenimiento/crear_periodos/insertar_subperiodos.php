<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
ini_set("include_path", ".:/usr/share/pear_");
//print_r($_POST);
//error_reporting(2047);
//print_r($_POST);
//print_r($_SESSION);
//error_reporting(2047);
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php';
require_once realpath(dirname(__FILE__)).'/../funciones/combo.php';
require_once realpath(dirname(__FILE__)).'/../funciones/combo_bd.php';
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/funcionip.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
//PEAR::setErrorHandling(PEAR_ERROR_PRINT);
/* PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'error_handler');
function error_handler(&$obj) {
$msg = $obj->getMessage();
$code = $obj->getCode();
$info = $obj->getUserInfo();
echo $msg,' ',$code,"<br>";
if ($info) {
print htmlspecialchars($info);
} 
}
 */
?>
<?php
@session_start();
//DB_DataObject::debugLevel(5);
/* $sala =& DB::connect($dsn, $options);
$sala->setFetchMode(DB_FETCHMODE_ASSOC);
if (PEAR::isError($db)) {
    die($db->getMessage());
} */
//print_r($_SESSION);
$usuario_sesion=$_SESSION['MM_Username'];
$usuario = DB_DataObject::factory('usuario');
$usuario->get('usuario',$usuario_sesion);
$fechasubperiodo=date("Y-m-d H:i:s");
$fechahoy=date("Y-m-d H:i:s");
$ip=tomarip();
$subperiodo = DB_DataObject::factory('subperiodo');
$subperiodo_consulta=clone($subperiodo);
?>
<?php
if(isset($_POST['codigomodalidadacademica']))
{
	$query_carrera="select * from carrera c where c.codigomodalidadacademica = '".$_POST['codigomodalidadacademica']."'
	and c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."'
	order by c.nombrecarrera
	";
	$carrera=$sala->query($query_carrera);
	$row_carrera=$carrera->fetchRow();
}
?>

<?php if(isset($_POST['codigocarrera'])){	
	$query_periodo="select * FROM carreraperiodo where codigocarrera = '".$_POST['codigocarrera']."' and codigoperiodo like '".$_POST['anoperiodo']."%'";
	$periodo=$sala->query($query_periodo);
	$row_periodo=$periodo->fetchRow();

}?>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<form name="form1" method="post" action="">
  <p align="center"><span class="Estilo2"><span class="Estilo3">CREAR PERIODOS - NUEVOS SUBPERIODOS</span></span></p>
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="3">
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">A&ntilde;o<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><?php combo("anoperiodo","ano","codigoano","codigoano",'onchange="enviar()"','');?></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica<span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <?php combo("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica",'onchange="enviar()"','');?>
          </span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <select name="codigocarrera" id="codigocarrera" onChange="enviar()">
              <option value="">Seleccionar</option>
              <?php
                  do {
?>
              <option value="<?php echo $row_carrera['codigocarrera'];?>"<?php if(isset($_POST['codigocarrera'])){if($_POST['codigocarrera'] == $row_carrera['codigocarrera']){echo "selected";}}?>><?php echo $row_carrera['nombrecarrera'];?></option>
              <?php
                  } while ($row_carrera=$carrera->fetchRow());
?>
            </select>
          </span></span></td>
        </tr>
       <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
          <select name="codigoperiodo" id="codigoperiodo">
            <option value="">Seleccionar</option>
            <?php
                  do {
?>
            <option value="<?php echo $row_periodo['codigoperiodo'];?>"<?php if(isset($_POST['codigoperiodo'])){if($_POST['codigoperiodo'] == $row_periodo['codigoperiodo']){echo "selected";}}?>><?php echo $row_periodo['codigoperiodo'];?></option>
            <?php
                  } while ($row_periodo=$periodo->fetchRow());
?>
          </select>
</span></span></td>
        </tr>

        <tr>
          
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre subperiodo<span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><span class="style2"><span class="Estilo1">
            <input name="nombresubperiodo" type="text" id="nombresubperiodo" size="40" value="<?php echo @$_POST['nombresubperiodo']?>">
          </span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo subperiodo<span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <?php combo("idtiposubperiodo","tiposubperiodo","idtiposubperiodo","nombretiposubperiodo",'','');?>
          </span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio subperiodo acad&eacute;mico<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechainicioacademicosubperiodo'])){escribe_formulario_fecha_vacio("fechainicioacademicosubperiodo","form1","",@$_POST['fechainicioacademicosubperiodo']);}else{escribe_formulario_fecha_vacio("fechainicioacademicosubperiodo","form1","","");} ?>
          </span></span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha final subperiodo acad&eacute;mico<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechafinalacademicosubperiodo'])){escribe_formulario_fecha_vacio("fechafinalacademicosubperiodo","form1","",@$_POST['fechafinalacademicosubperiodo']);}else{escribe_formulario_fecha_vacio("fechafinalacademicosubperiodo","form1","","");} ?>
          </span></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio subperiodo financiero<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechainiciofinancierosubperiodo'])){escribe_formulario_fecha_vacio("fechainiciofinancierosubperiodo","form1","",@$_POST['fechainiciofinancierosubperiodo']);}else{escribe_formulario_fecha_vacio("fechainiciofinancierosubperiodo","form1","","");} ?>
          </span></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha final subperiodo financiero <span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php if(isset($_POST['fechafinalfinancierosubperiodo'])){escribe_formulario_fecha_vacio("fechafinalfinancierosubperiodo","form1","",@$_POST['fechafinalfinancierosubperiodo']);}else{escribe_formulario_fecha_vacio("fechafinalfinancierosubperiodo","form1","","");} ?>
          </span></span></span></td>
        </tr>
		
        <tr>
          <td colspan="2" bgcolor="#CCDADD"><div align="center">
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
	$fechainicioacademicosubperiodo=arreglarfecha($_POST['fechainicioacademicosubperiodo']);
	$fechafinalacademicosubperiodo=arreglarfecha($_POST['fechafinalacademicosubperiodo']);
	$fechainiciofinancierosubperiodo=arreglarfecha($_POST['fechainiciofinancierosubperiodo']);
	$fechafinalfinancierosubperiodo=arreglarfecha($_POST['fechafinalfinancierosubperiodo']); 

	$query_toma_numerosubperiodo= "SELECT MAX(sp.numerosubperiodo*1) AS numerosubperiodo FROM subperiodo sp, carreraperiodo cp 
	WHERE 
	cp.codigoperiodo='".$_POST['codigoperiodo']."' and
	cp.idcarreraperiodo=sp.idcarreraperiodo AND cp.codigocarrera='".$_POST['codigocarrera']."'";
	$toma_numerosubperiodo=$sala->query($query_toma_numerosubperiodo);
	$row_tomanumerosubperiodo=$toma_numerosubperiodo->fetchRow();
	$toma_numerosubperiodo->free();

	$numerosubperiodo=$row_tomanumerosubperiodo['numerosubperiodo'] + 1;
	
	
	$query_toma_ultimoID= "SELECT MAX(idsubperiodo) AS idsubperiodo FROM subperiodo sp, carreraperiodo cp 
	WHERE 
	cp.codigoperiodo='".$_POST['codigoperiodo']."' and
	cp.idcarreraperiodo=sp.idcarreraperiodo AND cp.codigocarrera='".$_POST['codigocarrera']."'";
	$toma_ultimoID=$sala->query($query_toma_ultimoID);
	$row_query_toma_ultimoID=$toma_ultimoID->fetchRow();



	$subperiodo_consulta->get('idsubperiodo',$row_query_toma_ultimoID['idsubperiodo']);
	//print_r($subperiodo_consulta);
	$validacion['req_anoperiodo']=validar($_POST['anoperiodo'],"requerido",'<script language="JavaScript">alert("No digitado el año del periodo")</script>', true);
	$validacion['num_anoperiodo']=validar($_POST['anoperiodo'],"numero",'<script language="JavaScript">alert("No digitado correctamente el año del periodo")</script>', true);
	$validacion['num_año']=validafechaano($_POST['anoperiodo'],$_POST['fechainicioacademicosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del sub periodo académico, no corresponde con el año seleccionado")</script>', true);
	$validacion['num_año']=validafechaano($_POST['anoperiodo'],$_POST['fechafinalacademicosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del sub periodo académico no corresponde con el año seleccionado")</script>', true);
	$validacion['num_año']=validafechaano($_POST['anoperiodo'],$_POST['fechainiciofinancierosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del sub periodo financiero, no corresponde con el año seleccionado")</script>', true);	
	$validacion['num_año']=validafechaano($_POST['anoperiodo'],$_POST['fechafinalfinancierosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del sub periodo financiero, no corresponde con el año seleccionado")</script>', true);
	$validacion['req_codigocarrera']=validar($_POST['codigocarrera'],"requerido",'<script language="JavaScript">alert("No seleccionado el codigo de la carrera")</script>', true);	
	$validacion['req_codigoperiodo']=validar($_POST['codigocarrera'],"requerido",'<script language="JavaScript">alert("No seleccionado el codigo del periodo")</script>', true);			
	$validacion['req_nombresubperiodo']=validar($_POST['nombresubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado el nombre del subperiodo")</script>', true);			
	$validacion['req_idtiposubperiodo']=validar($_POST['idtiposubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado tipo de subperiodo")</script>', true);			
	$validacion['req_fechainicioacademicosubperiodo']=validar($_POST['fechainicioacademicosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de inicio del subperiodo académico")</script>', true);			
	$validacion['req_fechafinalacademicosubperiodo']=validar($_POST['fechafinalacademicosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de final del subperiodo académico")</script>', true);			
	$validacion['req_fechainiciofinancierosubperiodo']=validar($_POST['fechainiciofinancierosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de inicio del subperiodo financiero")</script>', true);				
	$validacion['req_fechafinalfinancierosubperiodo']=validar($_POST['fechafinalfinancierosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de final del subperiodo financiero")</script>', true);				
	$validacion['dat_fechainicio_fechavem_academico']=validadosfechas($_POST['fechainicioacademicosubperiodo'],$_POST['fechafinalacademicosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del subperiodo académico no puede ser menor a la fecha de inicio")</script>', true);
	$validacion['dat_fechainicio_fechavem_financiero']=validadosfechas($_POST['fechainiciofinancierosubperiodo'],$_POST['fechafinalfinancierosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del subperiodo financiero no puede ser menor a la fecha de inicio")</script>', true);
	$validaciongeneral=true;
	
	
	if(
	($fechainicioacademicosubperiodo < $subperiodo_consulta->fechafinalacademicosubperiodo)
	or ($fechafinalacademicosubperiodo < $subperiodo_consulta->fechafinalacademicosubperiodo) 
	or ($fechainiciofinancierosubperiodo < $subperiodo_consulta->fechafinalfinancierosubperiodo)
	or ($fechafinalfinancierosubperiodo < $subperiodo_consulta->fechafinalfinancierosubperiodo)
	)
	{
		$validaciongeneral=false;
		echo "<script language='javascript'>alert('Fechas de subperiodo nuevo, se encuentran cruzadas con fechas de la base de datos!');</script>";
		//echo "<h1>fechas cruzadas</h1>";
	}
	
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
	$query_toma_idcarrreraperiodo="select * FROM carreraperiodo where codigocarrera = '".$_POST['codigocarrera']."' and codigoperiodo = '".$_POST['codigoperiodo']."'";
	$toma_idcarreraperiodo=$sala->query($query_toma_idcarrreraperiodo);
	$row_toma_idcarreraperiodo=$toma_idcarreraperiodo->fetchRow();
	$idcarreraperiodo=$row_toma_idcarreraperiodo['idcarreraperiodo'];


	

	
	$subperiodo->numerosubperiodo=$numerosubperiodo;
	$subperiodo->idcarreraperiodo=$idcarreraperiodo;
	$subperiodo->nombresubperiodo=$_POST['nombresubperiodo'];
	$subperiodo->fechasubperiodo=$fechasubperiodo;
	$subperiodo->fechainicioacademicosubperiodo=$_POST['fechainicioacademicosubperiodo'];
	$subperiodo->fechafinalacademicosubperiodo=$_POST['fechafinalacademicosubperiodo'];
	$subperiodo->fechainiciofinancierosubperiodo=$_POST['fechainiciofinancierosubperiodo'];
	$subperiodo->fechafinalfinancierosubperiodo=$_POST['fechafinalfinancierosubperiodo'];
	$subperiodo->idtiposubperiodo=$_POST['idtiposubperiodo'];
	$subperiodo->codigoestadosubperiodo='200';
	$subperiodo->idusuario=$usuario->idusuario;
	$subperiodo->ip=$ip;
	
	//DB_DataObject::debugLevel(5);
	$insertar=$subperiodo->insert();
	//DB_DataObject::debugLevel(0);

	if($insertar)
		{
			echo "<script language='javascript'>alert('Subperiodo insertado correctamente');</script>";
			echo "<script language='javascript'>window.location.reload('menu.php');</script>";
		}
	//print_r($subperiodo);
	}
}
?>
<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
  }
?>