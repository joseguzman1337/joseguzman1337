<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<script language="JavaScript" src="calendario/javascripts.js"></script>

<?php
//print_r($_POST);
//error_reporting(2047);
ini_set("include_path", ".:/usr/share/pear_");
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once('../funciones/pear/DB/DataObject.php');
require_once('../funciones/combo.php');
require_once '../funciones/combo_bd.php';
require_once('calendario/calendario.php');
require_once('../funciones/funcionip.php');
require_once('../funciones/arreglarfecha.php');
require_once('../funciones/conexion/conexion.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');


$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
@session_start();
$anoperiodo=$_GET['anoperiodo'];
//
//print_r($_SESSION);
$usuario_sesion=$_SESSION['MM_Username'];
/*$usuario = DB_DataObject::factory('usuario');
$usuario->get('usuario',$usuario_sesion);*/
$query_usuario="select * from usuario
where usuario='$usuario_sesion'";
$usuario=$sala->query($query_usuario);
$row_usuario=$usuario->fetchRow();

$fechasubperiodo=date("Y-m-d H:i:s");
$ip=tomarip();
//DB_DataObject::debugLevel(5);
/*$subperiodo = DB_DataObject::factory('subperiodo');
$original=clone($subperiodo);
$subperiodo_consulta=clone($subperiodo);
$subperiodo->get('idsubperiodo',$_GET['idsubperiodo']);
//DB_DataObject::debugLevel(5);
*/

$query_subperiodo="select * from subperiodo
where idsubperiodo='".$_GET['idsubperiodo']."'";
$subperiodo=$sala->query($query_subperiodo);
$row_subperiodo=$subperiodo->fetchRow();

$query_estsubperiodo="select * from estadosubperiodo";
$estsubperiodo=$sala->query($query_estsubperiodo);
//$row_estsubperiodo=$estsubperiodo->fetchRow();

$query_tiposubperiodo="select * from tiposubperiodo";
$tiposubperiodo=$sala->query($query_tiposubperiodo);


/*$query_subperiodo_max="SELECT MAX(sp.numerosubperiodo) AS numerosubperiodo FROM subperiodo sp, carreraperiodo cp 
	WHERE 
	cp.codigoperiodo='".$_GET['codigoperiodo']."' and
	cp.idcarreraperiodo=sp.idcarreraperiodo AND cp.codigocarrera='".$_GET['carrera']."'";

$subperiodo_max = $sala->query($query_subperiodo_max);
$row_subperiodo_max = $subperiodo_max->fetchRow();
$subperiodo_consulta->get('numerosubperiodo',$row_subperiodo_max['numerosubperiodo']);*/

//DB_DataObject::debugLevel(0);
//print_r($subperiodo);
?>

<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-famil y: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<form name="form1" method="post" action="">
  <p align="center"><span class="Estilo2"><span class="Estilo3">CREAR PERIODOS - MODIFICAR ESTADO SUBPERIODOS</span></span></p>
  <table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="200" border="0" align="center" cellpadding="3">
       <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero Periodo<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2">
            <input name="codigoperiodo" type="text" id="codigoperiodo" disabled value="<?php echo $_GET['codigoperiodo']?>">
</span></span></td>
        </tr>

        <tr>
          
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre subperiodo<span class="Estilo4">*</span> </div></td>
          <td bgcolor="#FEF7ED"><span class="style2"><span class="Estilo1">
            <input name="nombresubperiodo" type="text" id="nombresubperiodo" value="<?php echo $row_subperiodo['nombresubperiodo'];?>">
          </span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Estado subperiodo<span class="Estilo4">*</span></div></td>
	  <td bgcolor="#FEF7ED"><select name="codigoestadosubperiodo" id="codigoestadosubperiodo" >
              <option value="">Seleccionar</option>
              <?php
            while ($row_estsubperiodo=$estsubperiodo->fetchRow()){
		?>
              <option value="<?php echo $row_estsubperiodo['codigoestadosubperiodo'];?>"<?php if($row_subperiodo['codigoestadosubperiodo'] == $row_estsubperiodo['codigoestadosubperiodo']){echo "selected";}?>><?php echo $row_estsubperiodo['nombreestadosubperiodo'];?></option>
              <?php
            }
		?>
            </select>
          </td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo subperiodo<span class="Estilo4">*</span> </div></td>
	  <td bgcolor="#FEF7ED"><select name="idtiposubperiodo" id="idtiposubperiodo" >
              <option value="">Seleccionar</option>
              <?php
            while ($row_tiposubperiodo=$tiposubperiodo->fetchRow()){
                ?>
              <option value="<?php echo $row_tiposubperiodo['idtiposubperiodo'];?>"<?php if($row_subperiodo['idtiposubperiodo'] == $row_tiposubperiodo['idtiposubperiodo']){echo "selected";}?>><?php echo $row_tiposubperiodo['nombretiposubperiodo'];?></option>
              <?php
            }
                ?>
            </select>
          </td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio subperiodo acad&eacute;mico<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php escribe_formulario_fecha_vacio("fechainicioacademicosubperiodo","form1","",$row_subperiodo['fechainicioacademicosubperiodo']);?>
          </span></span></span></td>
        </tr>
        <tr>
          <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha final subperiodo acad&eacute;mico<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php escribe_formulario_fecha_vacio("fechafinalacademicosubperiodo","form1","",$row_subperiodo['fechafinalacademicosubperiodo']); ?>
          </span></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio subperiodo financiero<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php escribe_formulario_fecha_vacio("fechainiciofinancierosubperiodo","form1","",$row_subperiodo['fechainiciofinancierosubperiodo']); ?>
          </span></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha final subperiodo financiero <span class="Estilo4">*</span></div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
            <?php escribe_formulario_fecha_vacio("fechafinalfinancierosubperiodo","form1","",$row_subperiodo['fechafinalfinancierosubperiodo']); ?>
          </span></span></span></td>
        </tr>
        <input name="idsubperiodo" type="hidden" value="<?php echo $row_subperiodo['idsubperiodo'];?>">
        <input name="codigocarrera" type="hidden" value="<?php echo $_GET['carrera'];?>">
        <input name="idusuario" type="hidden" value="<?php echo $row_usuario['idusuario'];?>">
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

	$validaciongeneral=true;
	$fechainicioacademicosubperiodo=arreglarfecha($_POST['fechainicioacademicosubperiodo']);
	$fechafinalacademicosubperiodo=arreglarfecha($_POST['fechafinalacademicosubperiodo']);
	$fechainiciofinancierosubperiodo=arreglarfecha($_POST['fechainiciofinancierosubperiodo']);
	$fechafinalfinancierosubperiodo=arreglarfecha($_POST['fechafinalfinancierosubperiodo']);
	
	
	$query_toma_numerosubperiodo= "SELECT MAX(numerosubperiodo) as numerosubperiodo FROM subperiodo sp,carreraperiodo cp WHERE cp.idcarreraperiodo = sp.idcarreraperiodo AND cp.codigocarrera='".$_POST['codigocarrera']."'";
	$toma_numerosubperiodo=$sala->query($query_toma_numerosubperiodo);
	$row_tomanumerosubperiodo=$toma_numerosubperiodo->fetchRow();
	$numerosubperiodo=$row_tomanumerosubperiodo['numerosubperiodo'] + 1;
	
	$query_toma_ultimoID= "SELECT MAX(idsubperiodo) AS idsubperiodo FROM subperiodo sp, carreraperiodo cp 
	WHERE 
	cp.codigoperiodo='".$_POST['codigoperiodo']."' and
	cp.idcarreraperiodo=sp.idcarreraperiodo AND cp.codigocarrera='".$_POST['codigocarrera']."'";
	$toma_ultimoID=$sala->query($query_toma_ultimoID);
	$row_query_toma_ultimoID=$toma_ultimoID->fetchRow();
	//$subperiodo_consulta->get('idsubperiodo',$row_query_toma_ultimoID['idsubperiodo']);
	//print_r($subperiodo_consulta);
/* if(
	($fechainicioacademicosubperiodo < $subperiodo_consulta->fechafinalacademicosubperiodo)
	or ($fechafinalacademicosubperiodo < $subperiodo_consulta->fechafinalacademicosubperiodo) 
	or ($fechainiciofinancierosubperiodo < $subperiodo_consulta->fechafinalfinancierosubperiodo)
	or ($fechafinalfinancierosubperiodo < $subperiodo_consulta->fechafinalfinancierosubperiodo)
	)
	{
		$validaciongeneral=false;
		echo "<script language='javascript'>alert('Fechas de subperiodo nuevo, se encuentran cruzadas con fechas de la base de datos!');</script>";
	}*/
	
	$validacion['num_ano_fechainicioacademicosubperiodo']=validafechaano($anoperiodo,$_POST['fechainicioacademicosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del sub periodo académico, no corresponde con el año seleccionado")</script>', true);
	$validacion['num_ano_fechafinalacademicosubperiodo']=validafechaano($anoperiodo,$_POST['fechafinalacademicosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del sub periodo académico no corresponde con el año seleccionado")</script>', true);
	$validacion['num_ano_fechainiciofinancierosubperiodo']=validafechaano($anoperiodo,$_POST['fechainiciofinancierosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del sub periodo financiero, no corresponde con el año seleccionado")</script>', true);	
	$validacion['num_ano_fechafinalfinancierosubperiodo']=validafechaano($anoperiodo,$_POST['fechafinalfinancierosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del sub periodo financiero, no corresponde con el año seleccionado")</script>', true);
	$validacion['req_nombresubperiodo']=validar($_POST['nombresubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado el nombre del subperiodo")</script>', true);			
	$validacion['req_idtiposubperiodo']=validar($_POST['idtiposubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado tipo de subperiodo")</script>', true);			
	$validacion['req_fechainicioacademicosubperiodo']=validar($_POST['fechainicioacademicosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de inicio del subperiodo académico")</script>', true);			
	$validacion['req_fechafinalacademicosubperiodo']=validar($_POST['fechafinalacademicosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de final del subperiodo académico")</script>', true);			
	$validacion['req_fechainiciofinancierosubperiodo']=validar($_POST['fechainiciofinancierosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de inicio del subperiodo financiero")</script>', true);				
	$validacion['req_fechafinalfinancierosubperiodo']=validar($_POST['fechafinalfinancierosubperiodo'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de final del subperiodo financiero")</script>', true);				
	$validacion['dat_fechainicio_fechavem_academico']=validadosfechas($_POST['fechainicioacademicosubperiodo'],$_POST['fechafinalacademicosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del subperiodo académico no puede ser menor a la fecha de inicio")</script>', true);
	$validacion['dat_fechainicio_fechavem_financiero']=validadosfechas($_POST['fechainiciofinancierosubperiodo'],$_POST['fechafinalfinancierosubperiodo'],'mayor','<script language="JavaScript">alert("La fecha de final del subperiodo financiero no puede ser menor a la fecha de inicio")</script>', true);

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
	$toma_idcarreraperiodo = $sala->query($query_toma_idcarrreraperiodo);
	$row_toma_idcarreraperiodo=$toma_idcarreraperiodo->fetchRow();
	$idcarreraperiodo=$row_toma_idcarreraperiodo['idcarreraperiodo'];


	$query_actualiza="update subperiodo set nombresubperiodo='".$_POST['nombresubperiodo']."'
                ,fechasubperiodo='$fechasubperiodo'
                ,fechainicioacademicosubperiodo='".$_POST['fechainicioacademicosubperiodo']."'
                ,fechafinalacademicosubperiodo='".$_POST['fechafinalacademicosubperiodo']."'
                ,fechainiciofinancierosubperiodo='".$_POST['fechainiciofinancierosubperiodo']."'
                ,fechafinalfinancierosubperiodo='".$_POST['fechafinalfinancierosubperiodo']."'
                ,idtiposubperiodo='".$_POST['idtiposubperiodo']."'
                ,codigoestadosubperiodo='".$_POST['codigoestadosubperiodo']."'
                ,idusuario='".$_POST['idusuario']."'
                ,ip='$ip'
                where idsubperiodo='".$_POST['idsubperiodo']."'";
                $sel_actualiza = $sala->query($query_actualiza);



	/*$subperiodo->nombresubperiodo=$_POST['nombresubperiodo'];
	$subperiodo->fechasubperiodo=$fechasubperiodo;
	$subperiodo->fechainicioacademicosubperiodo=$_POST['fechainicioacademicosubperiodo'];
	$subperiodo->fechafinalacademicosubperiodo=$_POST['fechafinalacademicosubperiodo'];
	$subperiodo->fechainiciofinancierosubperiodo=$_POST['fechainiciofinancierosubperiodo'];
	$subperiodo->fechafinalfinancierosubperiodo=$_POST['fechafinalfinancierosubperiodo'];
	$subperiodo->idtiposubperiodo=$_POST['idtiposubperiodo'];
	$subperiodo->codigoestadosubperiodo=$_POST['codigoestadosubperiodo'];
	$subperiodo->idusuario=$usuario->idusuario;
	$subperiodo->ip=$ip;
	
	//print_r($subperiodo);
	//DB_DataObject::debugLevel(5);
	$actualizar=$subperiodo->update($original);
	//DB_DataObject::debugLevel(0);*/

	if($sel_actualiza)
		{
 			echo "<script language='javascript'>alert('Subperiodo modificado correctamente');</script>";
			echo "<script language='javascript'>window.location.href='menu.php';</script>"; 
 		}
	}
}
?>
<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.href='menu.php';</script>";
  }
?>
