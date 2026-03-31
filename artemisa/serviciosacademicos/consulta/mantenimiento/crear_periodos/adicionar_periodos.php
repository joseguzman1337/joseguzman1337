<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<script language="JavaScript" src="calendario/javascripts.js"></script>
<?php
  session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
ini_set("include_path", ".:/usr/share/pear_");
@session_start();
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
if($_SESSION['MM_Username']=="")
{
	echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede ingresar datos")</script>';
}
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
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once (realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_novalida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/funcionip.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}

//combo("nombrevarpost/ger","nombredataobjeto","etiqueta_para_el_combo","dato_que_ingresa_combo");
?>
<?php 
$fechahoy=date("Y-m-d H:i:s");
if($_POST['todas']=='si')
{
	$query_sel_carrera="select * from carrera order by nombrecarrera asc";
	$sel_carrera=$sala->query($query_sel_carrera);
}

elseif(isset($_POST['codigomodalidadacademica']))
{
	$query_sel_carrera="select * from carrera c where codigomodalidadacademica = '".$_POST['codigomodalidadacademica']."' 
	and c.fechainiciocarrera <= '".$fechahoy."' and c.fechavencimientocarrera >= '".$fechahoy."'
	order by nombrecarrera asc";
	$sel_carrera=$sala->query($query_sel_carrera);
}
 ?>
<?php
$consulta_periodo = DB_DataObject::factory('periodo');
$nuevo_periodo = DB_DataObject::factory('periodo');
$fechahoy=date("Y-m-d");
$usuario_sesion=$_SESSION['MM_Username'];
$usuario = DB_DataObject::factory('usuario');
$usuario->get('usuario',$usuario_sesion);
$carrera = DB_DataObject::factory('carrera');
$carreraperiodo1 = DB_DataObject::factory('carreraperiodo');
$subperiodo1 = DB_DataObject::factory('subperiodo');
$fechasubperiodo=date("Y-m-d H:i:s");
$ip=tomarip();


//echo $anohoy;
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

<p align="center"><span class="Estilo2"><span class="Estilo3">CREAR PERIODOS - ADICIONAR PERIODOS</span></span></p>
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">A&ntilde;o<span class="Estilo4">*</span> </div></td>
        <td nowrap bgcolor="#FEF7ED"><?php combo("anoperiodo","ano","codigoano","codigoano",'','');?>
        </td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha inicio periodo<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php if(isset($_POST['fechainicioperiodo'])){escribe_formulario_fecha_vacio("fechainicioperiodo","form1","",@$_POST['fechainicioperiodo']);}else{escribe_formulario_fecha_vacio("fechainicioperiodo","form1","","");} ?>
        </span> </span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha vencimiento periodo<span class="Estilo4">*</span></div></td>
        <td nowrap bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo1">
          <?php if(isset($_POST['fechavencimientoperiodo'])){escribe_formulario_fecha_vacio("fechavencimientoperiodo","form1","",@$_POST['fechavencimientoperiodo']);}else{escribe_formulario_fecha_vacio("fechavencimientoperiodo","form1","","");} ?>
        </span> </span></span></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad acad&eacute;mica </div></td>
        <td nowrap bgcolor="#FEF7ED"><div align="center">
            <?php combo_novalida_post("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica",'onChange="enviar()"',"","nombremodalidadacademica","si","Modalidad acad&eacute;mica")?>
        </div></td>
      </tr>
      <tr>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione carreras<span class="Estilo4">*</span> </div></td>
        <td nowrap bgcolor="#FEF7ED">&nbsp;</td>
      </tr>
      <?php while(@$row_sel_carrera=$sel_carrera->fetchRow()){ ?>
	  <tr>
        <td nowrap class="Estilo1"><div align="center"><?php echo $row_sel_carrera['nombrecarrera'] ?></div></td>
        <td nowrap><div align="center">
            <input type="checkbox" title "carreras" name="carreras<?php echo $row_sel_carrera['codigocarrera']?>" value="<?php echo $row_sel_carrera['codigocarrera']?>">
        </div></td>
      </tr>
	  <?php } ?>
      <tr bgcolor="#CCDADD">
        <td colspan="2" nowrap class="Estilo2"><div align="center">
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
if(isset($_POST['Enviar'])){

	$validaciongeneral=true;

	$validacion['req_anoperiodo']=validar($_POST['anoperiodo'],"requerido",'<script language="JavaScript">alert("No digitado el año para crear los periodos")</script>', true);
	$validacion['num_ano_fechainicioperiodo']=validafechaano($_POST['anoperiodo'],$_POST['fechainicioperiodo'],'mayor','<script language="JavaScript">alert("La fecha de inicio del periodo, no corresponde con el año seleccionado")</script>', true);
	$validacion['num_ano_fechavencimientoperiodo']=validar($_POST['anoperiodo'],$_POST['fechavencimientoperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del periodo, no corresponde con el año seleccionado")</script>', true);
	$validacion['dat_fechainicio_fechavem_periodo']=validadosfechas($_POST['fechainicioperiodo'],$_POST['fechavencimientoperiodo'],'mayor','<script language="JavaScript">alert("La fecha de vencimiento del  periodo no puede ser menor menor a la fecha de inicio")</script>', true);
	$validacion['req_carreras']=0;

	//print_r($_POST);
	foreach ($_POST as $vpost => $valor)
	{
		if(ereg("carreras",$vpost))
		{
			$validacion['req_carreras']=1;
		}
	}

	if ($validacion['req_carreras']==0)
	{
		echo '<script language="JavaScript">alert("Debe seleccionar al menos una carrera")</script>';
	}

	foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}

	$query_toma_idultimoperiodo="select max(codigoperiodo) as codigoperiodo from periodo where codigoperiodo like '".$_POST['anoperiodo']."%'";
	//echo $query_toma_idultimoperiodo;
	$toma_idultimoperiodo=$sala->query($query_toma_idultimoperiodo);
	$row_idultimoperiodo=$toma_idultimoperiodo->fetchRow();
	//echo $row_idultimoperiodo['codigoperiodo'];
	if($row_idultimoperiodo['codigoperiodo']=="")
	{
		$idultimoperiodo=$_POST['anoperiodo']."0";
		//echo $idultimoperiodo;
	}
	else
	{
		$idultimoperiodo=$row_idultimoperiodo['codigoperiodo'];
	}
	$consulta_periodo->get('codigoperiodo',$idultimoperiodo);
	//print_r($consulta_periodo);
	$nuevocodigoperiodo=$idultimoperiodo+1;
	$nuevo_numeroperiodo=$consulta_periodo->numeroperiodo+1;
	$fechainicioperiodo=arreglarfecha($_POST['fechainicioperiodo']);
	$fechavencimientoperiodoanterior=substr($consulta_periodo->fechavencimientoperiodo, 0, 10);
	//echo $fechainicioperiodo,"<br>";
	//echo $fechavencimientoperiodoanterior;



	if($fechainicioperiodo <= $consulta_periodo->fechavencimientoperiodo)
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("La fecha de inicio o vencimiento del periodo, se cruza con fechas de periodos existentes")</script>';
	}

	if($validaciongeneral==true)
	{
		$nuevo_periodo->codigoperiodo=$nuevocodigoperiodo;
		$nuevo_numero_periodo_substr=substr($nuevocodigoperiodo, 4, 5);  
		//echo $nuevo_numero_periodo_substr;
		switch ($nuevo_numero_periodo_substr)
		{

			case "1":
				$nuevo_periodo->nombreperiodo='PRIMER PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;


			case "2":
				$nuevo_periodo->nombreperiodo='SEGUNDO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;

			case "3":
				$nuevo_periodo->nombreperiodo='TERCER PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "4":
				$nuevo_periodo->nombreperiodo='CUARTO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "5":
				$nuevo_periodo->nombreperiodo='QUINTO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "6":
				$nuevo_periodo->nombreperiodo='SEXTO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "7":
				$nuevo_periodo->nombreperiodo='SEPTIMO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "8":
				$nuevo_periodo->nombreperiodo='OCTAVO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "9":
				$nuevo_periodo->nombreperiodo='NOVENO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "10":
				$nuevo_periodo->nombreperiodo='DECIMO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
			case "11":
				$nuevo_periodo->nombreperiodo='UNDECIMO PERIODO ACADEMICO DE '.$_POST['anoperiodo'];
				break;
		}

		$nuevo_periodo->codigoestadoperiodo='2';
		$nuevo_periodo->fechainicioperiodo=$_POST['fechainicioperiodo'];
		$nuevo_periodo->fechavencimientoperiodo=$_POST['fechavencimientoperiodo'];
		$nuevo_periodo->numeroperiodo=$nuevo_numeroperiodo;
		//print_r($nuevo_periodo);
		//DB_DataObject::debugLevel(5);
		$insertar=$nuevo_periodo->insert();
		//DB_DataObject::debugLevel(0);
		if($insertar)
		{
			foreach($_POST as $vpostcarreras => $valorcarreras)
			{
				if (ereg("carreras".$row_sel_carrera['codigocarrera']."",$vpostcarreras))
				{
					$carreraperiodo1->codigocarrera=$valorcarreras;
					$carreraperiodo1->codigoperiodo=$nuevo_periodo->codigoperiodo;
					$carreraperiodo1->codigoestado='100';
					//DB_DataObject::debugLevel(5);
					$carreraperiodo1_insertar=$carreraperiodo1->insert();
					//DB_DataObject::debugLevel(0);
					$idcarreraperiodo1=$carreraperiodo1_insertar;
					//cho "<h1>",$idcarreraperiodo1,"</h1>";
					$subperiodo1->idcarreraperiodo=$idcarreraperiodo1;
					$subperiodo1->nombresubperiodo='SUBPERIODO BASE';
					$subperiodo1->fechasubperiodo=$fechasubperiodo;
					$subperiodo1->fechainicioacademicosubperiodo=$_POST['fechainicioperiodo'];
					$subperiodo1->fechafinalacademicosubperiodo=$_POST['fechavencimientoperiodo'];
					$subperiodo1->fechainiciofinancierosubperiodo=$_POST['fechainicioperiodo'];
					$subperiodo1->fechafinalfinancierosubperiodo=$_POST['fechavencimientoperiodo'];
					$subperiodo1->numerosubperiodo='1';
					$subperiodo1->idtiposubperiodo='9';
					$subperiodo1->codigoestadosubperiodo='100';
					$subperiodo1->idusuario=$usuario->idusuario;
					$subperiodo1->ip=$ip;
					//DB_DataObject::debugLevel(5);
					$subperiodo1_insertar=$subperiodo1->insert();
					//DB_DataObject::debugLevel(0);

				}

			}

		}
		if($insertar and $carreraperiodo1_insertar and $subperiodo1_insertar)
		echo "<script language='javascript'>alert('Periodos adicionado correctamente');</script>";
		echo "<script language='javascript'>window.location.reload('menu.php');</script>";
	}

}
?>
<?php if(isset($_POST['Regresar'])){
	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
}
?>