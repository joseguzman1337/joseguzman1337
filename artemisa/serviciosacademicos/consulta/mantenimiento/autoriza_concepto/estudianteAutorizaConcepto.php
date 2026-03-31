<?php
//print_r($_POST);
?>
<script language="javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>

<script language="javascript">
function enviar()
{
	document.form1.submit();
}
</script>
<script language="JavaScript" src="calendario/javascripts.js"></script>

<?php 
ini_set("include_path", ".:/usr/share/pear_");
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once '../funciones/pear/DB/DataObject.php';
require_once '../funciones/combo.php';
require_once '../funciones/combo_bd.php';
require_once('calendario/calendario.php');
require_once('../funciones/funcionip.php');
require_once('../funciones/arreglarfecha.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/funcionip.php');
$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
@session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
$autorizaconcepto = DB_DataObject::factory('autorizaconcepto');

$autorizaconcepto_consulta = clone($autorizaconcepto);
$fechaautorizaconcepto=date("Y-m-d H:i:s");
$fechahoy=date("Y-m-d");
$ip=tomarip();
$usuario_sesion=$_SESSION['MM_Username'];
$usuario= DB_DataObject::factory('usuario');
$usuario->get('usuario',$usuario_sesion);
//echo "<h1>",$usuario->idusuario,"</h1>";
//print_r($usuario);

$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$tipousuario = $sala->query($query_tipousuario);
$row_tipousuario = $tipousuario->fetchRow();
$totalRows_tipousuario=$tipousuario->numRows();



if(isset($_GET['codigocreado']))
{
	$codigoestudiante = $_GET['codigocreado'];
}
else
{
	$codigoestudiante = $_GET['codigoestudiante'];
}


$query_dataestudiante = "SELECT distinct c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral, d.nombredocumento, d.tipodocumento,e.codigoestudiante,
						eg.numerodocumento, eg.fechanacimientoestudiantegeneral,eg.expedidodocumento,eg.idestudiantegeneral,gr.nombregenero,e.codigoperiodo,
						 eg.celularestudiantegeneral,eg.emailestudiantegeneral, eg.codigogenero,s.nombresituacioncarreraestudiante,
						 eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral,eg.ciudadresidenciaestudiantegeneral,
						eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral,eg.ciudadcorrespondenciaestudiantegeneral,e.codigocarrera
						FROM estudiante e, carrera c,documento d,estudiantegeneral eg,estudiantedocumento ed,situacioncarreraestudiante s,genero gr
						WHERE e.codigocarrera = c.codigocarrera
						and gr.codigogenero = eg.codigogenero
						AND eg.tipodocumento = d.tipodocumento
						and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
						AND ed.idestudiantegeneral = eg.idestudiantegeneral
						AND e.idestudiantegeneral = eg.idestudiantegeneral 
						AND e.idestudiantegeneral = ed.idestudiantegeneral
						AND ed.numerodocumento = '$codigoestudiante'
						order by e.codigosituacioncarreraestudiante desc";
//echo $query_dataestudiante;
$dataestudiante = $sala->query($query_dataestudiante);
$row_dataestudiante = $dataestudiante->fetchRow();
$totalRows_dataestudiante = $dataestudiante->numRows();

if(isset($_GET['codigocreado']))
{
	$query_autorizaconcepto_consulta="SELECT ac.idautorizaconcepto,c.nombreconcepto,c.codigoconcepto,ac.fechavencimientoautorizaconcepto,ac.codigoestudiante FROM autorizaconcepto ac, concepto c
	WHERE 
	ac.codigoestudiante='".$row_dataestudiante['codigoestudiante']."' AND
	c.codigoconcepto=ac.codigoconcepto AND 
	'$fechahoy' <= ac.fechavencimientoautorizaconcepto";
}
elseif(isset($_GET['codigoestudiante']))
{
	$query_autorizaconcepto_consulta="SELECT ac.idautorizaconcepto,c.nombreconcepto,c.codigoconcepto,ac.fechavencimientoautorizaconcepto,ac.codigoestudiante FROM autorizaconcepto ac, concepto c
	WHERE 
	ac.codigoestudiante='".$_GET['codigoestudiante']."' AND
	c.codigoconcepto=ac.codigoconcepto AND 
	'$fechahoy' <= ac.fechavencimientoautorizaconcepto";
}
//echo $query_autorizaconcepto_consulta;
//DB_DataObject::debugLevel(5);
$autorizaconcepto_consulta->query($query_autorizaconcepto_consulta);
//DB_DataObject::debugLevel(0);

$query_muestra_conceptos="SELECT distinct c.codigoconcepto, c.nombreconcepto FROM concepto c, autorizacionreferenciaconcepto arc, referenciaconcepto rc
WHERE
c.codigoreferenciaconcepto=rc.codigoreferenciaconcepto AND
rc.codigoautorizacionreferenciaconcepto=100 and c.codigoconcepto NOT IN (SELECT c.codigoconcepto FROM autorizaconcepto ac, concepto c
WHERE 
ac.codigoestudiante='".$row_dataestudiante['codigoestudiante']."' AND
c.codigoconcepto=ac.codigoconcepto AND 
'$fechahoy' <= ac.fechavencimientoautorizaconcepto)";
//DB_DataObject::debugLevel(5);
$muestraconcepto=$sala->query($query_muestra_conceptos);
//DB_DataObject::debugLevel(0);
$row_muestraconcepto=$muestraconcepto->fetchRow();
//echo $query_muestra_conceptos;
?>
<html>
<head>
<title>Crear Estudiante</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="">
    <p align="center" class="Estilo3">AUTORIZAR CONCEPTOS </p>

<?php if(isset($_GET['codigocreado'])){ ?>
    <table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
    <tr>
	<td>
	<table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Apellidos</div></td>
        <td class="Estilo1">
          <div align="center"><?php echo $row_dataestudiante['apellidosestudiantegeneral'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Nombres</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['nombresestudiantegeneral'];?></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Tipo de Documento</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['nombredocumento'];?></div></td>
        <td colspan="1" bgcolor="#C5D5D6" class="Estilo2"><div align="center">N&uacute;mero</div></td>
		<td colspan="1" class="Estilo1"><div align="center"><?php echo $row_dataestudiante['numerodocumento'];?></div></td>
      </tr>     
	  <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Expedido en</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['expedidodocumento'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha de Nacimiento</div></td>
        <td class="Estilo1"><div align="center">
        <?php if(isset($_POST['fnacimiento'])) echo $_POST['fnacimiento']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_dataestudiante['fechanacimientoestudiantegeneral']); ?>
        </div></td>
      </tr>
	   <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">G&eacute;nero</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['nombregenero'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Id</div></td>
		<td class="Estilo1" ><div align="center"><?php echo $row_dataestudiante['idestudiantegeneral']; ?></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Celular</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['celularestudiantegeneral'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">E-mail</div></td>
		<td class="Estilo1" ><div align="center">
		  <?php echo $row_dataestudiante['emailestudiantegeneral'];?>
		</div></td>
      </tr>
      <tr>        
      <td  bgcolor="#C5D5D6" class="Estilo2"><div align="center">Dir. Estudiante</div></td>
      <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['direccionresidenciaestudiantegeneral'];?></div></td>
      <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Tel&eacute;fono</div></td>
      <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'];?></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center" class="Estilo10"><strong>Dir. Correspondencia</strong></div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral'];?></div></td>
        <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Tel&eacute;fono</div></td>
        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];?></div></td>
      </tr>	  

</table>
<?php } ?>
  </td>
 </tr>
</table>
    <br>
	<table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
      <tr>
        <td><table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
            <tr>
              <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Id Concepto </div></td>
              <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Conceptos Activos </div></td>
              <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha vencimiento </div></td>
            </tr>
            
              <?php while ($autorizaconcepto_consulta->fetch()){ ?>
			<tr bgcolor="#FFFFFF">
			  <td class="Estilo1"><div align="center"><?php echo $autorizaconcepto_consulta->codigoconcepto; ?>    </div></td>
			  <td class="Estilo1"><div align="center"><a href="autoriza_concepto_detalle.php?idautorizaconcepto=<?php echo $autorizaconcepto_consulta->idautorizaconcepto;?>&codigoestudiante=<?php echo $autorizaconcepto_consulta->codigoestudiante; ?>&nombreconcepto=<?php echo $autorizaconcepto_consulta->nombreconcepto; ?>" onClick="abrir('autoriza_concepto_detalle.php?idautorizaconcepto=<?php echo $autorizaconcepto_consulta->idautorizaconcepto;?>&codigoestudiante=<?php echo $autorizaconcepto_consulta->codigoestudiante; ?>&nombreconcepto=<?php echo $autorizaconcepto_consulta->nombreconcepto; ?>','miventana','width=700,height=150,top=200,left=150,scrollbars=yes');return false"><?php echo $autorizaconcepto_consulta->nombreconcepto;?></a>&nbsp;</div></td>
			  <td class="Estilo1"><div align="center"><?php echo $autorizaconcepto_consulta->fechavencimientoautorizaconcepto; ?>&nbsp;</div></td>
            </tr>
	  			<?php	} ?>

        </table></td>
      </tr>
    </table>
  <br>
<div align="center" class="Estilo3">
  <table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
    <tr>
      <td><table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
          <tr>
            <td colspan="4" bgcolor="#C5D5D6" class="Estilo2"><div align="center">APLICAR CONCEPTO NUEVO </div></td>
            </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha vencimiento concepto<span class="Estilo4">*</span> </div></td>
            <td class="Estilo1"><div align="center"><span class="phpmaker"><span class="style2">
              <span class="Estilo2">
              <?php if(isset($_POST['fechavencimientoautorizaconcepto'])){escribe_formulario_fecha_vacio("fechavencimientoautorizaconcepto","form1","",@$_POST['fechavencimientoautorizaconcepto']);}else{escribe_formulario_fecha_vacio("fechavencimientoautorizaconcepto","form1","","");} ?>
              </span>
            </span></span>
            </div></td>
            <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
            <td bgcolor="#FFFFFF" class="Estilo2"><span class="phpmaker"><span class="style2"><span class="Estilo1">
              <select name="concepto" id="concepto">
                <option value="">Seleccionar</option>
                <?php
                  do {
?>
                <option value="<?php echo $row_muestraconcepto['codigoconcepto'];?>"<?php if(isset($_POST['concepto'])){if($_POST['concepto'] == $row_muestraconcepto['codigoconcepto']){echo "selected";}}?>><?php echo $row_muestraconcepto['nombreconcepto'];?></option>
                <?php
                  } while ($row_muestraconcepto=$muestraconcepto->fetchRow());
?>
              </select>
</span></span></span></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Observaci&oacute;n<span class="Estilo4">*</span></div></td>
            <td colspan="3" bgcolor="#FFFFFF" class="Estilo2"><input name="observacionautorizaconcepto" type="text" id="observacionautorizaconcepto" size="60" value="<?php if(isset($_POST['observacionautorizaconcepto'])){echo $_POST['observacionautorizaconcepto'];}?>"></td>
            </tr>
          <tr>
            <td colspan="4" bgcolor="#C5D5D6" class="Estilo2"><div align="center">
              <input name="Nuevo" type="submit" id="Nuevo" value="Nuevo">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input name="Regresar" type="submit" id="Regresar" value="Regresar">
			</div></td>
          </tr>

      </table></td>
    </tr>
  </table>

</div>
</form>

<?php
if(isset($_GET['codigocreado']))
{
	echo '<script language="Javascript">
	function recargar() 
	{
		window.location.reload("estudiante.php?codigocreado='.$_GET['codigocreado'].'");
	}
	</script>';
}
elseif(isset($_GET['codigoestudiante']))
{
	echo '<script language="Javascript">
	function recargar() 
	{
		window.location.reload("estudiante.php?codigoestudiante='.$_GET['codigoestudiante'].'");
	}
	</script>';
}
?>

<?php
if(isset($_POST['Nuevo']))
{
	$validaciongeneral=true;
	if($_SESSION['MM_Username']=="")
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede ingresar datos")</script>';
	}
	$validacion['req_fechavencimientoconcepto']=validar($_POST['fechavencimientoautorizaconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de vencimiento del concepto")</script>', true);
	$validacion['req_concepto']=validar($_POST['concepto'],"requerido",'<script language="JavaScript">alert("No seleccionado el concepto")</script>', true);
	$validacion['req_observacionautorizaconcepto']=validar($_POST['observacionautorizaconcepto'],"requerido",'<script language="JavaScript">alert("No digitado la observación")</script>', true);

	foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
	
	if($validaciongeneral==true){
	$autorizaconcepto->fechaautorizaconcepto=$fechaautorizaconcepto;
	$autorizaconcepto->fechavencimientoautorizaconcepto=$_POST['fechavencimientoautorizaconcepto'];
	$autorizaconcepto->idusuario='1';//$usuario->idusuario;
	$autorizaconcepto->ip=$ip;
	if(isset($_GET['codigoestudiante']))
	{
		$autorizaconcepto->codigoestudiante=$_GET['codigoestudiante'];
	}
	else
	{
		$autorizaconcepto->codigoestudiante=$row_dataestudiante['codigoestudiante'];
	}
	$autorizaconcepto->codigoconcepto=$_POST['concepto'];
	$autorizaconcepto->observacionautorizaconcepto=$_POST['observacionautorizaconcepto'];
	//print_r($autorizaconcepto);
	//DB_DataObject::debugLevel(5);
	$insertar=$autorizaconcepto->insert();
	//DB_DataObject::debugLevel(0);
	if($insertar)
		{
			echo '<script language="JavaScript">alert("Autoriza Concepto Ingresado Correctamente")</script>';
			if(isset($_GET['codigoestudiante']))
			{
				echo "<script language='javascript'>window.location.reload('estudiante.php?codigoestudiante=".$_GET['codigoestudiante']."');</script>";
			}
			else
			{
				echo "<script language='javascript'>window.location.reload('estudiante.php?codigocreado=".$_GET['codigocreado']."');</script>";
			}
		}
	
	}
}
?>

<?php if(isset($_POST['Regresar']))
 {
 	if(isset($_GET['codigocreado']))
	{
		echo "<script language='javascript'>window.location.reload('busqueda_estudiante.php');</script>";
	}
	elseif(isset($_GET['codigoestudiante']))
	{
		echo "<script language='javascript'>window.location.reload('../../prematricula/matriculaautomaticaordenmatricula.php');</script>";
	}
}
?>
