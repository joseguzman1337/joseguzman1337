<?php
@session_start();
require_once('../../../Connections/sala2.php');
$sala2 = $sala;
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
//$db->debug = true;
include ("calendario/calendario.php");
require_once("../../../funciones/funcionboton.php");
require_once("funciones/asignacionSalon.php");
require_once("funciones/validacionAdmision.php");
require_once("../../../funciones/clases/phpmailer/class.phpmailer.php");
require_once("../interesados/funciones/datos_mail.php");
require_once("../../../funciones/clases/debug/dBug.php");


$ruta="../../../";
require_once($ruta."Connections/conexionldap.php");
require_once($ruta."funciones/clases/autenticacion/claseldap.php");


//unset($_SESSION['numerodocumentosesion']);
//print_r($_REQUEST);
if ($_SESSION['numerodocumentosesion'] <> "")
{
	if($_GET['documento'] <> "" && $_SESSION['numerodocumentosesion'] <> $_GET['documento']){
	$_SESSION['numerodocumentosesion'] = $_GET['documento'];
	$codigoinscripcion = $_SESSION['numerodocumentosesion'];
	}
	else
	$codigoinscripcion = $_SESSION['numerodocumentosesion'];
}
else
{
	$_SESSION['numerodocumentosesion'] = $_GET['documento'];
	$codigoinscripcion = $_SESSION['numerodocumentosesion'];
}
mysql_select_db($database_sala, $sala2);
if ($_GET['modalidad'] <> "")
{
	$_SESSION['modalidadacademicasesion'] = $_GET['modalidad'];
}
if ($_GET['inscripcionactiva'] <> "")
{
	$_SESSION['inscripcionsession'] = $_GET['inscripcionactiva'];
}
$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica, tr.nombretrato
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci, trato tr
WHERE numerodocumento = '$codigoinscripcion'
and i.idinscripcion = '".$_SESSION['inscripcionsession']."'
AND eg.idestudiantegeneral = i.idestudiantegeneral
AND eg.idciudadnacimiento = ci.idciudad
AND i.idinscripcion = e.idinscripcion
AND e.codigocarrera = c.codigocarrera
AND eg.idtrato=tr.idtrato
AND m.codigomodalidadacademica = i.codigomodalidadacademica
and i.codigoestado like '1%'
AND e.idnumeroopcion = '1'";
$data = $db->Execute($query_data);
$totalRows_data = $data->RecordCount();
$row_data = $data->FetchRow();
if(!$row_data)
{
	$query_data = "SELECT *,t.nombretrato
    FROM estudiantegeneral, trato t
	WHERE numerodocumento = '$codigoinscripcion'
	AND estudiantegeneral.idtrato=t.idtrato";
	$data = $db->Execute($query_data);
	$totalRows_data = $data->RecordCount();
	$row_data = $data->FetchRow();
}
$query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo
FROM inscripcionformulario ip, inscripcionmodulo im
WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo
AND ip.codigomodalidadacademica = '".$_SESSION['modalidadacademicasesion']."'
AND ip.codigoestado LIKE '1%'
order by posicioninscripcionformulario";
//echo $query_formularios;
$formularios = $db->Execute($query_formularios);
$totalRows_formularios = $formularios->RecordCount();
$row_formularios = $formularios->FetchRow();
unset($modulos);
unset($nombremodulo);
unset($iddescripcion);
$limitemodulo = $totalRows_formularios;
$cuentamodulos = 1;
// Toca mirar cual es el porcentaje de los módulos que requieran ser diligenciados
// valida_formulario();
do
{
	$modulos[$cuentamodulos] = $row_formularios['linkinscripcionmodulo'];
	$nombremodulo[$cuentamodulos] = $row_formularios['nombreinscripcionmodulo'];
	$iddescripcion[$cuentamodulos] = $row_formularios['idinscripcionmodulo'];
	$cuentamodulos++;
}
while($row_formularios = $formularios->FetchRow());
$query_selgenero = "select codigogenero, nombregenero
from genero";
$selgenero = $db->Execute($query_selgenero);
$totalRows_selgenero = $selgenero->RecordCount();
$row_selgenero = $selgenero->FetchRow();
$query_trato = "select *
from trato";
$trato = $db->Execute($query_trato);
$totalRows_trato = $trato->RecordCount();
$row_trato = $trato->FetchRow();
$query_documentos = "SELECT *
FROM documento";
$documentos = $db->Execute($query_documentos);
$totalRows_documentos = $documentos->RecordCount();
$row_documentos = $documentos->FetchRow();
$query_estadocivil = "SELECT *
FROM estadocivil";
$estadocivil = $db->Execute($query_estadocivil);
$totalRows_estadocivil = $estadocivil->RecordCount();
$row_estadocivil = $estadocivil->FetchRow();
$query_modalidad = "SELECT *
FROM modalidadacademica order by 1";
$modalidad = $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
$row_modalidad = $modalidad->FetchRow();
$query_ciudad = "select *
from ciudad c,departamento d
where c.iddepartamento = d.iddepartamento
order by 3";
$ciudad = $db->Execute($query_ciudad);
$totalRows_ciudad = $ciudad->RecordCount();
$row_ciudad = $ciudad->FetchRow();
$query_estudiante = "SELECT * FROM estudiantegeneral e,inscripcion i
WHERE numerodocumento = '$codigoinscripcion'
AND e.idestudiantegeneral = i.idestudiantegeneral
AND i.codigomodalidadacademica = '".$_SESSION['modalidadacademicasesion']."'
AND i.codigosituacioncarreraestudiante like '70%'";
$estudiante = $db->Execute($query_estudiante);
$totalRows_estudiante = $estudiante->RecordCount();
$row_estudiante = $estudiante->FetchRow();
$query_parentesco = "select *
from tipoestudiantefamilia
where idtipoestudiantefamilia <> 0
order by 2";
$parentesco = $db->Execute($query_parentesco);
$totalRows_parentesco = $parentesco->RecordCount();
$row_parentesco = $parentesco->FetchRow();
?>
<script language="javascript">
function enviar()
{
	document.inscripcion.submit();
}
</script>
<html>
<head>
<title>.:Datos Básicos:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<?php
if ($_SESSION['inscripcionsession'] <> "")
{
?>
<a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $_SESSION['numerodocumentosesion']."&codigocarrera=".$_SESSION['codigocarrerasesion'];?>" id="aparencialinknaranja">Inicio</a><br><br>
<p>FORMULARIO DEL ASPIRANTE</p>
<?php
}
else
{
?>
<p>ACTUALIZACIÓN DE DATOS</p>
        <p><label id="labelresaltado">Se&ntilde;or(a) estudiante, por favor verifique sus datos personales y actualice la información que no corresponda</label></p>
<script type="text/javascript">
        alert('Sr(a) estudiante, por favor verifique sus datos personales y actualice la información que no corresponda');
</script>
<?PHP
}
if (isset($_REQUEST['inicial']))
{
	$moduloinicial = $_REQUEST['inicial'];
	//	echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">';
}
else
{
	$_REQUEST['inicial'] = 1;
	$moduloinicial = $_REQUEST['inicial'];
}
require("funcionformulario.php");
// El cero indica que el campo no ha sido diligenciado
$query = "select nombresestudiantegeneral, apellidosestudiantegeneral, tipodocumento, numerodocumento,
expedidodocumento, codigogenero, idestadocivil, idciudadnacimiento, fechanacimientoestudiantegeneral,
direccionresidenciaestudiantegeneral, telefonoresidenciaestudiantegeneral, ciudadresidenciaestudiantegeneral,
emailestudiantegeneral,casoemergenciallamarestudiantegeneral,telefono1casoemergenciallamarestudiantegeneral,idtipoestudiantefamilia
from estudiantegeneral
where idestudiantegeneral = ".$row_data['idestudiantegeneral']."";
$ratatotal = valida_formulario($query, $db);
?>
<form name="inscripcion" method="post" action="">
<table width="80%" border="0" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
 <tr>
 <td>
<?php
cabecera_formulario($nombremodulo, $cuentamodulos, $modulos, $row_data, $ratatotal);
// debo validar si ya pago y entro logeado and isset($_SESSION['MM_username'] and $row_estudiante <> "")
if ($codigoinscripcion <> "" )
{// if 1
        // Codigo para poner datos de actualización obligatoria en la actualización de datos
        if(ereg("estudiante",$_SESSION['MM_Username']) && $_SESSION['inscripcionsession'] == "")
        {
            //$row_data['telefonoresidenciaestudiantegeneral'] = '';
            //$row_data['emailestudiantegeneral'] = '';
            //$row_data['emailestudiantegeneral'] = '';
        }

?>
	  <br>
	  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <tr>
         <td colspan="7" id="tdtitulogris">INFORMACI&Oacute;N PERSONAL<a onClick="window.open('pregunta.php?id=<?php echo 1;?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>
        </tr>
        <tr>
          <td id="tdtitulogris"><select name="trato" id="requerido">
             <option value="0" <?php if (!(strcmp("0", $row_data['idtrato']))) {echo "SELECTED";} ?>>Trato</option>
<?php
do
{
?>              <option value="<?php echo $row_trato['idtrato']?>"<?php if (!(strcmp($row_trato['idtrato'], $row_data['idtrato']))) {echo "SELECTED";} ?>><?php echo $row_trato['inicialestrato']?></option>
 <?php
}
while($row_trato = $trato->FetchRow());
?>
           </select>
		  </td>
		   <td  id="tdtitulogris">Nombre<label id="labelresaltado">*</label></td>
           <td><input name="nombres" type="text" id="requerido" size="25" maxlength="50" value="<?php if(isset($_POST['nombres'])) echo $_POST['nombres']; else echo $row_data['nombresestudiantegeneral']; ?>"> </td>
           <td id="tdtitulogris">Apellidos<label id="labelresaltado">*</label></td>
           <td colspan="3"><input name="apellidos" type="text" id="requerido" size="30" maxlength="50"  value="<?php if(isset($row_data['apellidosestudiantegeneral'])) echo $row_data['apellidosestudiantegeneral']; else echo $_POST['apellidos']; ?>"></td>
          </tr>
          <tr>
           <td colspan="2" id="tdtitulogris">Tipo Documento<label id="labelresaltado">*</label></td>
           <td><select name="tipodocumento" id="requerido">
<?php
do
{
?>
                  <option value="<?php echo $row_documentos['tipodocumento']?>"<?php if (!(strcmp($row_documentos['tipodocumento'], $row_data['tipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_documentos['nombredocumento']?></option>
<?php
}
while($row_documentos = $documentos->FetchRow());
?>
          </select></td>
          <td id="tdtitulogris">No. Documento<label id="labelresaltado">*</label></td>
          <td>
		    <input name="numerodocumento" type="text" id="requerido" size="11" maxlength="12" value="<?php if(isset($row_data['numerodocumento'])) echo $row_data['numerodocumento']; else echo $_POST['numerodocumento']; ?>">
		  </td>
          <td id="tdtitulogris">Expedida en<label id="labelresaltado">*</label></td>
          <td><input name="expedidodocumento" type="text" id="requerido" size="12" maxlength="15" value="<?php if($row_data['expedidodocumento'] <> "") echo $row_data['expedidodocumento']; else echo $_POST['expedidodocumento']; ?>"></td>
        </tr>
        <tr>
          <td colspan="2" id="tdtitulogris">Libreta Militar</td>
          <td>
            <input name="libreta" type="text" id="libreta" size="25" maxlength="50" value="<?php if(isset($_POST['libreta'])) echo $_POST['libreta']; else echo $row_data['numerolibretamilitar']; ?>">
            </td>
          <td id="tdtitulogris">Distrito</td>
          <td>
              <input name="distrito" type="text" id="distrito" size="5" maxlength="2" value="<?php if(isset($_POST['distrito'])) echo $_POST['distrito']; else echo $row_data['numerodistritolibretamilitar']; ?>">
            </td>
          <td id="tdtitulogris">Expedida en </td>
          <td><input name="expedidalibreta" type="text" id="expedidalibreta" size="12" maxlength="15" value="<?php if(isset($_POST['expedidalibreta'])) echo $_POST['expedidalibreta']; else echo $row_data['expedidalibretamilitar']; ?>"></td>
        </tr>
        <tr>
		   <td colspan="2" id="tdtitulogris">G&eacute;nero<label id="labelresaltado">*</label></td>
           <td>
            <select name="genero" id="requerido">
              <option value="0" <?php if (!(strcmp(0, $row_data['codigogenero']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
              <option value="<?php echo $row_selgenero['codigogenero']?>"<?php if (!(strcmp($row_selgenero['codigogenero'], $row_data['codigogenero']))) {echo "SELECTED";} ?>><?php echo $row_selgenero['nombregenero']?></option>
<?php
}
while($row_selgenero = $selgenero->FetchRow());
?>
            </select>
          </td>
          <td id="tdtitulogris">Estado Civil<label id="labelresaltado">*</label></td>
          <td colspan="1">
          <strong></strong>
		    <select name="civil" id="requerido">
                <option value="0" <?php if (!(strcmp(0, $row_data['idestadocivil']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
                <option value="<?php echo $row_estadocivil['idestadocivil']?>"<?php if (!(strcmp($row_estadocivil['idestadocivil'], $row_data['idestadocivil']))) {echo "SELECTED";} ?>><?php echo $row_estadocivil['nombreestadocivil']?></option>
<?php
}
while($row_estadocivil = $estadocivil->FetchRow());
?>
            </select>
		  </td>
		  <td id="tdtitulogris">Estrato<label id="labelresaltado">*</label></td>
          <td colspan="1">
<?php
$query_estrato = "select *
from estrato
order by 1";
$estrato = $db->Execute($query_estrato);
$totalRows_estrato = $estrato->RecordCount();

$query_estratohistorico = "select *
from estratohistorico
where idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
and codigoestado like '1%'
order by 1";
$estratohistorico = $db->Execute($query_estratohistorico);
$totalRows_estratohistorico = $estratohistorico->RecordCount();
$row_estratohistorico = $estratohistorico->FetchRow();
?>
	<select name="idestrato">
	<option value="seleccionar">Seleccionar...</option>
<?php
while($row_estrato = $estrato->FetchRow())
{
	//echo $_POST['idestrato'];
?>
		  	<option value="<?php echo $row_estrato['idestrato']; ?>" <?php if(isset($_POST['idestrato'])) { if($_POST['idestrato'] == $row_estrato['idestrato']) echo "selected"; } else if($row_estrato['idestrato'] == $row_estratohistorico['idestrato']) echo "selected"; ?>><?php echo $row_estrato['nombreestrato'];?></option>
<?php
}
?>
		  </select>
          </td>
        </tr>
        <tr>
          <td colspan="1" id="tdtitulogris">Lugar Nacimiento<label id="labelresaltado">*</label></td>
          <td>
  	      <select name="ciudadnacimiento" id="requerido">
           <option value="0" <?php if (!(strcmp("0", $row_data['idciudadnacimiento']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
            <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $row_data['idciudadnacimiento']))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombreciudad'];?></option>
<?php
}
while($row_ciudad = $ciudad->FetchRow());
$ciudad->Move(0);
?>
          </select>
		  <!-- <input type="button" name="nuevo" value="..." onClick="crear()"> -->
 <?php
          //crearmenubotones($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, $sala2);?>
		 </td>
         <td id="tdtitulogris">Fecha Nacimiento<label id="labelresaltado">*</label></td>
         <td colspan="3">
 <?
 /*escribe_formulario_fecha_vacio("fecha1","inscripcion",$row_data['fechanacimientoestudiantegeneral']);*/
?>
           <input name="fecha1" type="text" id="requerido" size="10" value="<?php
		   $fechanacimientoestudiantegeneral=explode(" ",$row_data['fechanacimientoestudiantegeneral']);
		   if(isset($row_data['fechanacimientoestudiantegeneral'])) echo $fechanacimientoestudiantegeneral[0]; else echo $_POST['fecha1']?>" maxlength="10">
	       aaaa-mm-dd
	  </td>
       </tr>
	 <tr>
	  <td colspan="2" id="tdtitulogris">Direcci&oacute;n Residencia<label id="labelresaltado">*</label></td>
          <td colspan="5">
		  <INPUT name="direccion1" size="90" id="requerido" readonly onclick="window.open('direccion.php?inscripcion=1','direccion','width=1000,height=300,left=10,top=150,scrollbars=yes')"  value="<?php if(isset($_POST['direccion1'])) echo $_POST['direccion1']; else echo $row_data['direccionresidenciaestudiantegeneral'] ; ?>">
          <input name="direccion1oculta" type="hidden" value="<?php if(isset($_POST['direccion1oculta'])) echo $_POST['direccion1oculta']; else echo $row_data['direccioncortaresidenciaestudiantegeneral']; ?>">
          </td>
          </tr>
        <tr>
		  <td colspan="2" id="tdtitulogris">Tel&eacute;fono Residencia<label id="labelresaltado">*</label></td>
          <td>
            <input name="telefono1" type="text" id="requerido" size="15" maxlength="50" value="<?php if(isset($row_data['telefonoresidenciaestudiantegeneral'])) echo $row_data['telefonoresidenciaestudiantegeneral']; else echo $_POST['telefono1']; ?>">
          </td>
          <td id="tdtitulogris">Ciudad<label id="labelresaltado">*</label></td>
          <td colspan="3">
<!-- <input name="ciudad1" type="text" id="ciudad1" size="12" maxlength="50" value="<?php if(isset($row_data['ciudadresidenciaestudiantegeneral'])) echo $row_data['ciudadresidenciaestudiantegeneral']; else echo $_POST['ciudad1']; ?>"> -->
          <select name="ciudad1" id="requerido">
            <option value="0" <?php if (!(strcmp("0", $row_data['ciudadresidenciaestudiantegeneral']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
                 <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $row_data['ciudadresidenciaestudiantegeneral']))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombreciudad'];?></option>
<?php
}
while($row_ciudad = $ciudad->FetchRow());
$ciudad->Move(0);
?>
          </select>
            </td>
          </tr>
    <tr>
	  <td colspan="2" id="tdtitulogris">Direcci&oacute;n Correspondencia</td>
      <td colspan="5">
          <INPUT name="direccion2" size="90" readonly onclick="window.open('direccion.php?correo=1','direccion','width=1000,height=300,left=10,top=150,scrollbars=yes')"  value="<?php if(isset($_POST['direccion2'])) echo $_POST['direccion2']; else echo $row_data['direccioncorrespondenciaestudiantegeneral']; ?>">
     	  <input name="direccion2oculta" type="hidden" size="25" value="<?php if(isset($_POST['direccion2oculta'])) echo $_POST['direccion2oculta']; else echo $row_data['direccioncortacorrespondenciaestudiantegeneral']; ?>"></td>
       </tr>
        <tr>
          <td colspan="2" id="tdtitulogris">Tel&eacute;fono Correspondencia</td>
          <td>
           <input name="telefono2" type="text" id="telefono2" size="15" maxlength="50" value="<?php if(isset($_POST['telefono2'])) echo $_POST['telefono2']; else echo $row_data['telefono2estudiantegeneral']; ?>">
          </td>
          <td id="tdtitulogris">Ciudad</td>
         <td colspan="3">
            <!-- <input name="ciudad2" type="text" id="ciudad2" size="12" maxlength="50" value="<?php if(isset($row_data['ciudadcorrespondenciaestudiantegeneral'])) echo $row_data['ciudadcorrespondenciaestudiantegeneral']; else echo $_POST['ciudad2']; ?>"> -->
			<select name="ciudad2">
            <option value="0" <?php if (!(strcmp("0", $row_data['ciudadcorrespondenciaestudiantegeneral']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
            do
            {
?>
            <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $row_data['ciudadcorrespondenciaestudiantegeneral']))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombreciudad'];?></option>
            <?php
            }
            while($row_ciudad = $ciudad->FetchRow());
				?>
          </select>
          </td>
         </tr>
         <tr>
          <td colspan="2" id="tdtitulogris">E-mail 1 <label id="labelresaltado">*</label></td>
          <td><font size="2" face="Tahoma"><input name="email" type="text" id="requerido" size="35" maxlength="50" value="<?php if(isset($_POST['email'])) echo $_POST['email']; else echo $row_data['emailestudiantegeneral']; ?>"></font></td>
          <td id="tdtitulogris">E-mail 2</td>
          <td><span class="style1"><input name="email2" type="text" id="email2" size="20" maxlength="50" value="<?php if(isset($_POST['email2'])) echo $_POST['email2']; else echo $row_data['email2estudiantegeneral']; ?>"></td>
          <td id="tdtitulogris">Celular</td>
          <td><input name="celular" type="text" id="celular" size="12" maxlength="50" value="<?php if(isset($_POST['celular'])) echo $_POST['celular']; else echo $row_data['celularestudiantegeneral']; ?>"></td>
        </tr>
		 <tr>
          <td colspan="2" rowspan="2" id="tdtitulogris">En caso de Emergencia<br> Llamar a
            <label id="labelresaltado">*</label></td>
          <td rowspan="2" ><input name="emergencia" type="text" id="requerido" size="45" maxlength="70" value="<?php if(isset($_POST['emergencia'])) echo $_POST['emergencia']; else echo $row_data['casoemergenciallamarestudiantegeneral']; ?>"></td>
          <td rowspan="2"  id="tdtitulogris">Parentesco <label id="labelresaltado">*</label> </td>
      	  <td rowspan="2"><select name="parentesco" id="requerido">
           <option value="0" <?php if (!(strcmp("0", $row_data['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do
{
?>
                  <option value="<?php echo $row_parentesco['idtipoestudiantefamilia']?>"<?php if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $row_data['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>><?php echo $row_parentesco['nombretipoestudiantefamilia']?></option>
<?php
}
while($row_parentesco = $parentesco->FetchRow());
?>
         </select></td>
          <td id="tdtitulogris">Tel&eacute;fono1
            <label id="labelresaltado"> *</label></td>
          <td><input name="telemergencia1" type="text" id="requerido" size="12" maxlength="50" value="<?php if(isset($_POST['telemergencia1'])) echo $_POST['telemergencia1']; else echo $row_data['telefono1casoemergenciallamarestudiantegeneral']; ?>"></td>
        </tr>
		 <tr>
		   <td id="tdtitulogris">Tel&eacute;fono2</td>
	       <td><input name="telemergencia2" type="text" size="12" maxlength="50" value="<?php if(isset($_POST['telemergencia2'])) echo $_POST['telemergencia2']; else echo $row_data['telefono2casoemergenciallamarestudiantegeneral']; ?>"></td>
		 </tr>
      </table>
</td>
</tr>
</table>
<script language="javascript">
function grabar()
{
	document.inscripcion.submit();
}
</script>
<br>
<?php
barra("BARRA DE DILIGENCIAMIENTO DE ".$nombremodulo[1],$ratatotal*100);
// Modificar Caraga Académica
//$valores['programausadopor'] = $_GET['programausadopor'];
/*$_SESSION['MM_Username'] = "admintecnologia";
crearmenubotones($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, $sala);*/
?>
 <input type="button" value="Enviar" onClick="grabar()">
<?php
if ($_SESSION['inscripcionsession'] <> "")
{
?>
 <input type="button" value="Regresar" onClick="window.location.reload('../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $row_data['numerodocumento']."&codigocarrera=".$_SESSION['codigocarrerasesion'];?>')">
 <input type="button" value="Vista Previa" onClick="vista()">
<?php
}
?>
 <!-- <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->
  <input type="hidden" name="grabado" value="grabado">
<?php
//Si ya se han digitado datos, se dispara asignacion de salon y correo electronico
/**********************************************************************************************/
/*							FUNCIONES DE ASIGNACION AUTOMATICA DE SALONES 					   */
/**********************************************************************************************/
if(is_array($row_data)){
	if(!empty($row_data['emailestudiantegeneral'])){
		$codigocarrera=$_SESSION['codigocarrerasesion'];
		//echo "<pre>";
		//print_r($_GET);
		//echo "</pre>";
		//if($codigocarrera==10){
		if(validarIdAdmision($codigocarrera,$idsubperiodo,&$db)){
		//echo "<h1>Entro</h1>";
			$salon = new asignacionAutomaticaSalones(&$db,$codigocarrera,$codigoinscripcion,false);
			//print_r($salon);
			$seAsignoSalon=$salon->retornaSiSeAsignoSalon();
			//si se asigno salon, se dispara correo
			if($seAsignoSalon==true){
				//correo, proceso 5 se asignará como proceso de asignacion salones
				$array_salon_asignado=$salon->retornaArrayAsignacionSalon();
				$correo=new ObtenerDatosMail(&$db,$array_salon_asignado['codigocarrera'],5,false);
				$correo->ConstruirCorreoAsignacionSalones($array_salon_asignado,$row_data['emailestudiantegeneral'],$row_data['nombresestudiantegeneral'].' '.$row_data['apellidosestudiantegeneral'],$row_data['nombretrato']);
				//$row_data['emailestudiantegeneral']
				//$d_correo = new dBug($correo);
			}
			if($seAsignoSalon==true){
				if($_GET['depurar']=='si'){
					$deb = new dBug($salon);
					$deb1 = new dBug($correo);
					$deb2 = new dBug($row_data);
				}
			}
		}
	}
}
/**********************************************************************************************/
$banderagrabar = 0;
if (isset($_POST['grabado']))
{
	$ano = substr($_POST['fecha1'],0,4);
	$mes = substr($_POST['fecha1'],5,2);
	$dia = substr($_POST['fecha1'],8,2);
	$email = "^[A-z0-9\._-]+"
	."@"
	."[A-z0-9][A-z0-9-]*"
	."(\.[A-z0-9_-]+)*"
	."\.([A-z]{2,6})$";
	 $_POST['nombres']   =  strtr(strtoupper($_POST['nombres']), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
     $_POST['apellidos'] =  strtr(strtoupper($_POST['apellidos']), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
	if ($_POST['trato'] == 0)
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el trato")</script>';
		$banderagrabar = 1;
	}
	else
	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( *[A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['nombres']) or $_POST['nombres'] == ""))
	{
		echo '<script language="JavaScript">alert("El Nombre es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( *[A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*)) *$",$_POST['apellidos']) or $_POST['apellidos'] == ""))
	{
		echo '<script language="JavaScript">alert("El Apellido es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['tipodocumento'] == 0)
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el tipo de documento")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['idestrato'] == 'seleccionar')
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el estrato")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento'])||trim($_POST['numerodocumento'])=='0')
	{
		echo '<script language="JavaScript">alert("Número de documento Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['expedidodocumento'] == "")
	{
		echo '<script language="JavaScript">alert("Expedido documento es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['libreta']) and $_POST['libreta'] <> "")
	{
		echo '<script language="JavaScript">alert("Libreta militar Incorrecta")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['distrito']) and $_POST['libreta'] <> "")
	{
		echo '<script language="JavaScript">alert("El distrito de la Libreta militar es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['expedidalibreta']) and $_POST['libreta'] <> ""))
	{
		echo '<script language="JavaScript">alert("La expedición de la libreta militar es incorrecta")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['genero'] == 0)
	{
		echo '<script language="JavaScript">alert("Seleccione el genero")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['civil'] == 0)
	{
		echo '<script language="JavaScript">alert("Seleccione el estado civil")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['ciudadnacimiento'] == 0)
	{
		echo '<script language="JavaScript">alert("Lugar de nacimiento es Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if (!(@checkdate($mes, $dia,$ano)) or ($ano > date("Y")) or ($ano < 1900))
	{
		echo '
		<script language="JavaScript">
		alert("La fecha digitada debe ser valida y en formato aaaa-mm-dd")
		</script>
		';
		$banderagrabar = 1;
	}
	else
	if ($_POST['genero'] == 0)
	{
		echo '<script language="JavaScript">alert("Debe seleccionar el genero")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi($email,$_POST['email']) or $_POST['email'] == "")
	{
		echo '<script language="JavaScript">alert("E-mail Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['direccion1'] == "")
	{
		echo '<script language="JavaScript">alert("Debe Digitar una Dirección")</script>';
  	    $banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['telefono1']))
	{
		echo '<script language="JavaScript">alert("Teléfono de residencia Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['telefono2'])  and $_POST['telefono2'] <> "")
	{
		echo '<script language="JavaScript">alert("Telefono de correspondencia Incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ($_POST['ciudad1'] == 0)
	{
		echo '<script language="JavaScript">alert("Ciudad de residencia es Incorrecta")</script>';
		$banderagrabar = 1;
	}
	else
    if (!eregi("^[0-9]{1,15}$", $_POST['telemergencia1']))
	{
		echo '<script language="JavaScript">alert("Teléfono1 en caso de Emergencia es incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if (!eregi("^[0-9]{1,15}$", $_POST['telemergencia2'])  and $_POST['telemergencia2'] <> "")
	{
		echo '<script language="JavaScript">alert("Teléfono2 en caso de Emergencia es incorrecto")</script>';
		$banderagrabar = 1;
	}
	else
	if ( $_POST['parentesco'] == 0 )
	{
		echo '<script language="JavaScript">alert("Debe digitar el parentesco")</script>';
		$banderagrabar = 1;
	}
	else
	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['emergencia']) or $_POST['emergencia'] == ""))
	{
		echo '<script language="JavaScript">alert("Debe digitar nombre de una persona en caso de emergencia")</script>';
		$banderagrabar = 1;
	}
	else
	if(trim($codigoinscripcion)=='0'||trim($codigoinscripcion)==''||!isset($codigoinscripcion)){
		$banderagrabar=1;
	}
	else
	if ($banderagrabar == 0)
	{
		if ($_POST['telemergencia2'] == "")
		{
			$_POST['telemergencia2'] = $_POST['telemergencia1'];
		}
  		     $base="update estudiantegeneral
			 set idtrato = '".$_POST['trato']."',
             idestadocivil = '".$_POST['civil']."',
 			 tipodocumento = '".$_POST['tipodocumento']."',
   			 numerodocumento = '".$_POST['numerodocumento']."',
             expedidodocumento = '".$_POST['expedidodocumento']."',
			 numerolibretamilitar = '".$_POST['libreta']."',
			 numerodistritolibretamilitar = '".$_POST['distrito']."',
			 expedidalibretamilitar = '".$_POST['expedidalibreta']."',
             nombrecortoestudiantegeneral = '".$_POST['numerodocumento']."',
			 nombresestudiantegeneral = '".$_POST['nombres']."',
             apellidosestudiantegeneral = '".$_POST['apellidos']."',
			 fechanacimientoestudiantegeneral = '".$_POST['fecha1']."',
			 idciudadnacimiento = '".$_POST['ciudadnacimiento']."',
			 codigogenero = '".$_POST['genero']."',
			 direccionresidenciaestudiantegeneral = '".$_POST['direccion1']."',
			 direccioncortaresidenciaestudiantegeneral = '".$_POST['direccion1oculta']."',
			 ciudadresidenciaestudiantegeneral = '".$_POST['ciudad1']."',
			 telefonoresidenciaestudiantegeneral = '".$_POST['telefono1']."',
			 telefono2estudiantegeneral = '".$_POST['telefono2']."',
			 celularestudiantegeneral = '".$_POST['celular']."',
			 direccioncorrespondenciaestudiantegeneral = '".$_POST['direccion2']."',
			 direccioncortacorrespondenciaestudiantegeneral = '".$_POST['direccion2oculta']."',
			 ciudadcorrespondenciaestudiantegeneral = '".$_POST['ciudad2']."',
			 telefonocorrespondenciaestudiantegeneral = '".$_POST['telefono2']."',
			 emailestudiantegeneral = '".$_POST['email']."',
			 email2estudiantegeneral = '".$_POST['email2']."',
			 casoemergenciallamarestudiantegeneral = '".$_POST['emergencia']."',
			 telefono1casoemergenciallamarestudiantegeneral = '".$_POST['telemergencia1']."',
			 telefono2casoemergenciallamarestudiantegeneral = '".$_POST['telemergencia2']."',
			 idtipoestudiantefamilia = '".$_POST['parentesco']."'
			 where idestudiantegeneral = '".$row_data['idestudiantegeneral']."'";
		     $sol = $db->Execute($base);

			// Mira si el estrato seleccionado es diferente al actual
			if($_POST['idestrato'] != $row_estratohistorico['idestrato'])
			{
				$query_updestratohistorico = "UPDATE estratohistorico
				SET codigoestado='200'
				WHERE idestudiantegeneral = '".$row_data['idestudiantegeneral']."'";
				//echo $query_insdocumento;
				$updestratohistorico = $db->Execute($query_updestratohistorico);

				$query_insestratohistorico = "INSERT INTO estratohistorico(idestratohistorico, idestrato, idestudiantegeneral, fechaingresoestratohistorico, codigoestado)
			    VALUES(0, '".$_POST['idestrato']."', '".$row_data['idestudiantegeneral']."', now(), '100');";
				//echo $query_insdocumento;
				$insestratohistorico = $db->Execute($query_insestratohistorico);
			}
		//echo $base;
		$_SESSION['sesionmodulos'][1] = $nombremodulos[1];
		//echo $codigoinscripcion;
		if($_POST['numerodocumento'] <> $codigoinscripcion)
		{
			$_SESSION['numerodocumentosesion'] = $_POST['numerodocumento'];
			$query_insdocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento)
			VALUES(0,'".$row_data['idestudiantegeneral']."', '".$_POST['tipodocumento']."', '".$_POST['numerodocumento']."', '".$_POST['expedidodocumento']."', '".date("Y-m-d")."', '2999-12-31')";
			//echo $query_insdocumento;
			if(!($insdocumento = $db->Execute($query_insdocumento)))
			{
				$query_upddocumento = "UPDATE estudiantedocumento
				SET fechavencimientoestudiantedocumento='2999-12-31'
				WHERE idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
				and numerodocumento = '".$_POST['numerodocumento']."'";
				$upddocumento = $db->Execute($query_upddocumento);
			}
			$fechahabil = date("Y-m-d");
			//echo "FH : $fechahabil<br>";
			//echo "$diamax<br>";
			$unDiaMenos = strtotime("-1 day", strtotime($fechahabil));
			$fechahabil = date("Y-m-d",$unDiaMenos);
			$query_upddocumento = "UPDATE estudiantedocumento
    		SET fechavencimientoestudiantedocumento='$fechahabil'
    		WHERE idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
			and numerodocumento = '$codigoinscripcion'";
			//echo $query_upddocumento,"<br><br>";
			//exit();
			$upddocumento = $db->Execute($query_upddocumento);
			$query_updusuario = "UPDATE usuario
			SET numerodocumento = '".$_POST['numerodocumento']."'
			WHERE numerodocumento = '$codigoinscripcion'";
			$updusuario = $db->Execute($query_updusuario);
		}
        $query_datausuario = "select * from usuario where numerodocumento=".$_POST['numerodocumento'];
        $datausuario = $db->Execute($query_datausuario);
        $row_datausuario = $datausuario->FetchRow();

        $objetoldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
        $objetoldap->ConexionAdmin();
        $infomodificado["gacctMail"]=$_POST['email'];
        //$infomodificado= array("gacctMail" => array($_POST['email']));

        if(!$objetoldap->ModificacionUsuario($infomodificado,$row_datausuario["usuario"])){
            //$infomodificado["objectClass"][0]="googleUser";
            $objetoldap->AdicionUsuario($infomodificado,$row_datausuario["usuario"]);
        }

		if ($_SESSION['inscripcionsession'] <> "")
		{
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosbasicos.php?modalidad=".$_GET['modalidad']."'>";
		}
		else
		{
			$base="update estudiantegeneral
		    set fechaactualizaciondatosestudiantegeneral = '".date("Y-m-d G:i:s",time())."'
		    where idestudiantegeneral = '".$row_data['idestudiantegeneral']."'";
			$sol = $db->Execute($base);
			//echo $base;
			$query_direccion = "SELECT direccioncortaresidenciaestudiantegeneral
			FROM estudiantegeneral
			WHERE idestudiantegeneral = '".$row_data['idestudiantegeneral']."'";
			//echo $query_direccion;
			$direccion = $db->Execute($query_direccion);
			$totalRows_direccion = $direccion->RecordCount();
			$row_direccion = $direccion->FetchRow();
			if ($row_direccion['direccioncortaresidenciaestudiantegeneral'] <> "")
			{
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../facultades/creacionestudiante/estudiante.php'>";
			}
			else
			{
				echo '<script language="JavaScript">alert("Es necesaria la Actualización de su dirección")</script>';
			}
		}
	}
}
?>
<br>
<?php
if ($_SESSION['inscripcionsession'] <> "")
{
	$moduloinicial = 1;
	if($moduloinicial > 1)
	{
		$atras = $moduloinicial - 1;
?>
 		 <!-- <a href="<?php echo $modulos[$atras] ?>?inicial=<?php echo $atras ?>"><img src="../../../../imagenes/izquierda.gif" width="20" height="20" alt="Atras"></a> -->
<?php        }
if($moduloinicial < $limitemodulo)
{
	$adelante = $moduloinicial + 1;
?>
			<!-- <a href="<?php echo $modulos[$adelante] ?>?inicial=<?php echo $adelante ?>"><img src="../../../../imagenes/derecha.gif" width="20" height="20" alt="Adelante"></a> -->
            <?php
}
} // if ($_SESSION['inscripcionsession'] <> "")
} // if 1
?>
            <script language="javascript">
            function recargar(direccioncompleta, direccioncompletalarga)
            {
            	document.inscripcion.direccion1.value=direccioncompletalarga;
            	document.inscripcion.direccion1oculta.value=direccioncompleta;
            }
            function recargar1(direccioncompleta, direccioncompletalarga)
            {
            	document.inscripcion.direccion2.value=direccioncompletalarga;
            	document.inscripcion.direccion2oculta.value=direccioncompleta;
            }
            function crear()
            {
            	window.open('crearpais.php','pais','width=800,height=300,left=150,top=50,scrollbars=yes');
            }
            function cuentaelementosllenos()
            {
            	var cuenta=0;
            	for(var i = 0; i < document.inscripcion.elements.length; i++)
            	{
            		if (document.inscripcion.elements[i].value == "")
            		{
            			if (document.inscripcion.elements[i].id == "requerido")
            			{
            				cuenta++;
            			}
            		}
            	}
            	alert("cuenta: "+cuenta);
            	alert(document.inscripcion.elements.length);
            }
</script>
</form>
<script language="javascript">
//cuentaelementosllenos();
//alert("adsa"+document.inscripcion.length));
function vista()
{
	window.location.reload("vistaformularioinscripcion.php");
}
</script>
</body>
</html>
