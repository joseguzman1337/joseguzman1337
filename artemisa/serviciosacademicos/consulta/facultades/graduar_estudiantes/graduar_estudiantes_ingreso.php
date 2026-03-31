<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<script language="JavaScript" src="calendario/javascripts.js"></script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>



<?php 
@session_start();
//error_reporting(2047);
//print_r($_SESSION);
$usuario=$_SESSION['MM_Username'];
require('calendario/calendario.php');
require('funciones/validacion.php');
require('funciones/funcionip.php');
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
require_once('../../../Connections/sap.php');
$fecharegistrograduado=date("Y-m-d H:i:s");
$direccionipregistrograduado=tomarip();

mysql_select_db($database_sala, $sala);
$query_idusuario="select idusuario from usuario where usuario='$usuario'";
$idusuario=mysql_query($query_idusuario, $sala) or die(mysql_error());
$row_idusuario=mysql_fetch_assoc($idusuario);
mysql_select_db($database_sala, $sala);
$query_iddirectivo="select iddirectivo, concat(nombresdirectivo,apellidosdirectivo) as nombre from directivo where idusuario='".$row_idusuario['idusuario']."'";
$iddirectivo=mysql_query($query_iddirectivo,$sala) or die(mysql_error());
$row_iddirectivo=mysql_fetch_assoc($iddirectivo);
$totalrows_iddirectivo=mysql_num_rows($iddirectivo);
mysql_select_db($database_sala, $sala);
$query_autorizadosino="SELECT * FROM autorizagraduado WHERE iddirectivo='".$row_iddirectivo['iddirectivo']."' AND
'$fecharegistrograduado' >= fechainicioautorizagraduado AND
'$fecharegistrograduado' <= fechafinalautorizagraduado";
$autorizadosino=mysql_query($query_autorizadosino, $sala) or die (mysql_error());
$totalrows_autorizadosino=mysql_num_rows($autorizadosino);
$row_autorizadosino=mysql_fetch_assoc($autorizadosino);
//echo $query_autorizadosino;
//print_r($row_autorizadosino);
//print_r($_POST);
?>

<?php
mysql_select_db($database_sala, $sala);
$query_selcodigotiporegistrograduado = "SELECT * FROM tiporegistrograduado";
$selcodigotiporegistrograduado = mysql_query($query_selcodigotiporegistrograduado, $sala) or die(mysql_error());
$row_selcodigotiporegistrograduado = mysql_fetch_assoc($selcodigotiporegistrograduado);
$totalRows_selcodigotiporegistrograduado = mysql_num_rows($selcodigotiporegistrograduado);

mysql_select_db($database_sala, $sala);
$query_selcodigotipogrado = "SELECT * FROM tipogrado";
$selcodigotipogrado = mysql_query($query_selcodigotipogrado, $sala) or die(mysql_error());
$row_selcodigotipogrado = mysql_fetch_assoc($selcodigotipogrado);
$totalRows_selcodigotipogrado = mysql_num_rows($selcodigotipogrado);


$codigoestudiante=$_GET['estudiante'];

mysql_select_db($database_sala, $sala);
$query_datosestudiante="SELECT e.codigoestudiante,e.codigocarrera,eg.codigogenero,concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre FROM estudiante e, estudiantegeneral eg
WHERE e.idestudiantegeneral=eg.idestudiantegeneral
AND e.codigoestudiante='".$_GET['estudiante']."'
AND e.codigocarrera<>'13'
";
$datosestudiante=mysql_query($query_datosestudiante,$sala) or die(mysql_error());
//echo $query_datosestudiante ;
$row_datosestudiante=mysql_fetch_assoc($datosestudiante);
//print_r($row_datosestudiante);

if($row_datosestudiante['codigocarrera']=="" or $row_datosestudiante['codigogenero']="")
{
	$codigocarrera=$_GET['codigocarrera'];
	$codigogenero=$_GET['codigogenero'];
}
else
{
	$codigocarrera=$row_datosestudiante['codigocarrera'];
	$codigogenero=$row_datosestudiante['codigogenero'];
}


$query_nombrecarrera="select nombrecarrera from carrera c where codigocarrera=$codigocarrera";
//echo $query_nombrecarrera;
$nombrecarrera=mysql_query($query_nombrecarrera,$sala) or die(mysql_error());
$row_nombrecarrera=mysql_fetch_assoc($nombrecarrera);

//echo $codigocarrera;
//echo $codigogenero;

echo '<script language="Javascript">
function recargar() 
{
	window.location.reload("graduar_estudiantes_ingreso.php?autorizar&codigocarrera='.$codigocarrera.'&estudiante='.$codigoestudiante.'&codigogenero='.$codigogenero.'")
}
</script>';



//echo $usuario;

if(isset($_GET['estudiante']))
{
	require('validacion_documentos.php');
	$pendientedocumentos=validacion_documentos($codigocarrera,$codigogenero,$codigoestudiante,$sala);
	require('validacion_materias.php');
	$pendientematerias=generarcargaestudiante($codigoestudiante,$sala);
	require('validacion_pazysalvo.php');
	$pendiente_pazysalvo=validacion_pazysalvo($codigoestudiante,$sala);
	require('funciones/saldo_favor_contra.php');
	$pendiente_sap=saldoencontra($codigoestudiante,$database_sala,$sala,$rfc,$login,$rfchandle);
	require('validacion_estadoegreso.php');
	$mensaje="Estudiante no cumple todos los requisitos de grado ";


	if($pendiente_sap== false) //no debe en sap
	{
		$validasap=true;
		//echo "No debe sap";
	}
	else //debe en sap
	{
		$validasap=false;
		$mensaje="$mensaje Debe en SAP ";
		//echo "Documentos Incompletos";
	}

	//echo $pendientedocumentos;
	if($pendientedocumentos == false) //no debe documentos
	{
		$validadocumentos=true;
		//echo "No debe documentos";
	}
	else //debe documentos
	{
		$validadocumentos=false;
		$mensaje="$mensaje No tiene los documentos completos ";
		//echo "Documentos Incompletos";
	}
	//echo $validadocumentos;
	if($pendientematerias==true)
	{
		$validamaterias=false;
		$mensaje="$mensaje Debe materias ";
		//echo "debematerias";
	}
	else
	{
		$validamaterias=true;
		//echo "No debe materias";
	}
	//echo $validamaterias;
	if($pendiente_pazysalvo==false)
	{
		$validapazysalvo=true;
		//echo "Esta a paz y salvo";
	}
	else
	{
		$validapazysalvo=false;
		$mensaje="$mensaje No se encuentra a paz y salvo ";
		//echo "No se encuentra a paz y salvo";
	}
	if($totalRows_estadoegreso==1)
	{
		$validaestadoegreso=true;
		//echo "Se encuentra en estado egreso";
	}
	else
	{
		$mensaje="$mensaje No se encuentra en estado Egreso ";
		$validaestadoegreso=false;
	}
}
?>
<form name="form1" method="post" action="">
<?php
echo "*"; 
if($validamaterias == true and $validadocumentos==true and $validapazysalvo==true and $validaestadoegreso==true)
{ 
	
	$query_registrograduado="select * from registrograduado where codigoestudiante='$codigoestudiante' and codigoestado='100'";
	$registrograduado=mysql_query($query_registrograduado,$sala);
	$totalrows_registrograduado=mysql_num_rows($registrograduado);
	$row_registrograduado=mysql_fetch_assoc($registrograduado);
	//print_r($row_registrograduado);echo $totalrows_registrograduado;

	if($totalrows_registrograduado==0){
		$query_numeroregistro="select max(idregistrograduado) as numeroregistro from registrograduado";
		$numeroregistro=mysql_query($query_numeroregistro,$sala) or die(mysql_error());
		$row_numeroregistro=mysql_fetch_assoc($numeroregistro);
		$noregistro=$row_numeroregistro['numeroregistro'] + 1;
	}
	$query_verifica_diploma="select * from documentograduado d where d.idregistrograduado='".$row_registrograduado['idregistrograduado']."' and d.codigotipodocumentograduado='1' and codigoestado='100'";
	$verifica_diploma=mysql_query($query_verifica_diploma,$sala);
	$numrows_verifica_diploma=mysql_num_rows($verifica_diploma);
	$query_verifica_acta="select * from documentograduado d where d.idregistrograduado='".$row_registrograduado['idregistrograduado']."' and d.codigotipodocumentograduado='2' and codigoestado='100'";
	$verifica_acta=mysql_query($query_verifica_acta,$sala);
	$numrows_verifica_acta=mysql_num_rows($verifica_acta);

	if($totalrows_registrograduado==1)
	{
		$idregistrograduado=$row_registrograduado['idregistrograduado'];

		$query_muestra_firmadiploma="SELECT iddocumentograduado,idregistrograduado,dg.codigotipodocumentograduado,d.iddirectivo,concat(d.nombresdirectivo,' 					',d.apellidosdirectivo) AS nombre FROM documentograduado dg, directivo d WHERE
		d.iddirectivo=dg.iddirectivo AND
		idregistrograduado = '".$row_registrograduado['idregistrograduado']."' AND
		codigotipodocumentograduado='1' AND codigoestado='100'";
		$muestra_firmadiploma=mysql_query($query_muestra_firmadiploma,$sala);
		$totalrows_muestra_firmadiploma=mysql_num_rows($muestra_firmadiploma);

		$query_muestra_firmaacta="SELECT iddocumentograduado,idregistrograduado,dg.codigotipodocumentograduado,d.iddirectivo,concat(d.nombresdirectivo,' 					',d.apellidosdirectivo) AS nombre FROM documentograduado dg, directivo d WHERE
		d.iddirectivo=dg.iddirectivo AND
		idregistrograduado = '".$row_registrograduado['idregistrograduado']."' AND
		codigotipodocumentograduado='2' AND codigoestado='100'";
		$muestra_firmaacta=mysql_query($query_muestra_firmaacta,$sala);
		$totalrows_muestra_firmaacta=mysql_num_rows($muestra_firmaacta);

		$query_muestra_autorizaciongrado="SELECT d.iddirectivo,d.idusuario, concat(nombresdirectivo,' ',apellidosdirectivo) AS nombre FROM directivo d, autorizagraduado ag WHERE ag.iddirectivo=d.iddirectivo AND '$fecharegistrograduado' >= ag.fechainicioautorizagraduado AND '$fecharegistrograduado' <= ag.fechafinalautorizagraduado and d.idusuario='$idusuario'";
		$muestra_autorizaciongrado=mysql_query($query_muestra_autorizaciongrado,$sala);
		$numrows_muestra_autorizaciongrado=mysql_num_rows($muestra_autorizaciongrado);
		$row_muestra_autorizaciongrado=mysql_fetch_assoc($muestra_autorizaciongrado);

		$query_muestra_incentivosacademicos="SELECT ri.idregistroincentivoacademico,i.nombreincentivoacademico FROM registroincentivoacademico ri, incentivoacademico i
		WHERE ri.idincentivoacademico=i.idincentivoacademico
		AND ri.idregistrograduado='".$row_registrograduado['idregistrograduado']."'
		AND ri.codigoestado='100'
		";
		$muestra_incentivosacademicos=mysql_query($query_muestra_incentivosacademicos,$sala) or die (mysql_error());
		$row_muestra_incentivosacademicos=mysql_fetch_assoc($muestra_incentivosacademicos);
		$numrows_muestra_incentivosacademicos=mysql_num_rows($muestra_incentivosacademicos);
		
 		$query_muestra_firma_incentivosacademicos="SELECT iddocumentograduado,idregistrograduado,dg.codigotipodocumentograduado,d.iddirectivo,concat(d.nombresdirectivo,' ',d.apellidosdirectivo) AS nombre FROM documentograduado dg, directivo d WHERE
		d.iddirectivo=dg.iddirectivo AND
		idregistrograduado = '".$row_registrograduado['idregistrograduado']."' AND
		codigotipodocumentograduado='3' AND codigoestado='100'";
		//echo $query_muestra_firma_incentivosacademicos;
		
		$muestra_firma_incentivosacademicos=mysql_query($query_muestra_firma_incentivosacademicos,$sala);
		$totalrows_muestra_firma_incentivosacademicos=mysql_num_rows($muestra_firma_incentivosacademicos);
	}


?>
<div align="center" class="Estilo3">
    <p>DATOS PARA REGISTRO DE GRADUACION ESTUDIANTE </p>
</div>
  <p>

 </p>
     <table border="2" align="center" cellpadding="2" bordercolor="#003333">
     <tr>
       <td><table border="0" align="center" cellpadding="0" bordercolor="#003333">
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">N&uacute;mero de Registro Graduado</div></td>
             <td bgcolor="#FEF7ED"><div align="center">
               <?php if($totalrows_registrograduado==1){echo $row_registrograduado['idregistrograduado'];};?>
             </div></td>
           </tr>
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">Estudiante</div></td>
             <td bgcolor="#FEF7ED"><div align="center"><?php echo $row_datosestudiante['nombre'];?>&nbsp;</div></td>
           </tr>
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">Carrera estudiante </div></td>
             <td bgcolor="#FEF7ED">
             <div align="center"><?php echo $row_nombrecarrera['nombrecarrera'];?>&nbsp;</div></td>
           </tr>
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">N&uacute;mero de Acuerdo<span class="Estilo4">*</span> </div></td>
             <td bgcolor="#FEF7ED"><input name="numeroacuerdoregistrograduado" type="text" id="numeroacuerdoregistrograduado" value="<?php if(isset($_POST['numeroacuerdoregistrograduado'])){echo $_POST['numeroacuerdoregistrograduado'];}elseif($totalrows_registrograduado==1){echo $row_registrograduado['numeroacuerdoregistrograduado'];}?>" /></td>
           </tr>
          

           <tr class="Estilo1">
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Fecha de  Acuerdo<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><?php if(isset($_POST['fechaacuerdoregistrograduado'])){escribe_formulario_fecha_vacio("fechaacuerdoregistrograduado","form1","",@$_POST['fechaacuerdoregistrograduado']);}else{escribe_formulario_fecha_vacio("fechaacuerdoregistrograduado","form1","",@$row_registrograduado['fechaacuerdoregistrograduado']);} ?>&nbsp;</td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Responsable Acuerdo<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><input name="responsableacuerdoregistrograduado" type="text" id="responsableacuerdoregistrograduado" value="<?php if(isset($_POST['responsableacuerdoregistrograduado'])){echo $_POST['responsableacuerdoregistrograduado'];}elseif($totalrows_registrograduado==1){echo $row_registrograduado['responsableacuerdoregistrograduado'];}?>"></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">N&uacute;mero de Acta<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><input name="numeroactaregistrograduado" type="text" id="numeroactaregistrograduado" value="<?php if(isset($_POST['numeroactaregistrograduado'])){echo $_POST['numeroactaregistrograduado'];}elseif($totalrows_registrograduado==1){echo $row_registrograduado['numeroactaregistrograduado'];}?>">
             <input type="submit" name="Submit2" value="Firma" onclick="abrir('documentograduado_acta.php?carrera=<?php echo $codigocarrera;?>&documento=2&idregistrograduado=<?php if($totalrows_registrograduado==0){echo $noregistro;} elseif($totalrows_registrograduado==1){echo $row_registrograduado['idregistrograduado'];};?>','miventana','width=300,height=300,top=200,left=150,scrollbars=yes');return false"/>
             <span class="Estilo4">*</span></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha de Acta<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><?php if(isset($_POST['fechaactaregistrograduado'])){escribe_formulario_fecha_vacio("fechaactaregistrograduado","form1","",@$_POST['fechaactaregistrograduado']);}else{escribe_formulario_fecha_vacio("fechaactaregistrograduado","form1","",@$row_registrograduado['fechaactaregistrograduado']);} ?>               &nbsp;</td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">N&uacute;mero de Diploma<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><input name="numerodiplomaregistrograduado" type="text" id="numerodiplomaregistrograduado" value="<?php if(isset($_POST['numerodiplomaregistrograduado'])){echo $_POST['numerodiplomaregistrograduado'];}elseif($totalrows_registrograduado==1){echo $row_registrograduado['numerodiplomaregistrograduado'];}?>">
             <input type="submit" name="Submit" value="Firma" onclick="abrir('documentograduado_diploma.php?carrera=<?php echo $codigocarrera;?>&documento=1&idregistrograduado=<?php if($totalrows_registrograduado==0){echo $noregistro;} elseif($totalrows_registrograduado==1){echo $row_registrograduado['idregistrograduado'];};?>','miventana','width=300,height=300,top=200,left=150,scrollbars=yes');return false"/>
             <span class="Estilo4">*</span></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha de Elaboraci&oacute;n Diploma<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><?php if(isset($_POST['fechadiplomaregistrograduado'])){escribe_formulario_fecha_vacio("fechadiplomaregistrograduado","form1","",@$_POST['fechadiplomaregistrograduado']);}else{escribe_formulario_fecha_vacio("fechadiplomaregistrograduado","form1","",@$row_registrograduado['fechadiplomaregistrograduado']);} ?>&nbsp;</td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha de Grado<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><?php if(isset($_POST['fechagradoregistrograduado'])){escribe_formulario_fecha_vacio("fechagradoregistrograduado","form1","",@$_POST['fechagradoregistrograduado']);}else{escribe_formulario_fecha_vacio("fechagradoregistrograduado","form1","",@$row_registrograduado['fechagradoregistrograduado']);} ?>&nbsp;</td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Sitio de Graduaci&oacute;n </div></td>
             <td bgcolor="#FEF7ED"><input name="lugarregistrograduado" type="text" id="lugarregistrograduado" value="<?php if(isset($_POST['lugarregistrograduado'])){echo $_POST['lugarregistrograduado'];}elseif($totalrows_registrograduado==1){echo $row_registrograduado['lugarregistrograduado'];}?>"></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Presidi&oacute; Registro</div></td>
             <td bgcolor="#FEF7ED"><input name="presidioregistrograduado" type="text" id="presidioregistrograduado" value="<?php if(isset($_POST['presidioregistrograduado'])){echo $_POST['presidioregistrograduado'];}elseif($totalrows_registrograduado==1){echo $row_registrograduado['presidioregistrograduado'];}?>"></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Observaci&oacute;n</div></td>
             <td bgcolor="#FEF7ED"><textarea name="observacionregistrograduado" id="observacionregistrograduado"><?php if(isset($_POST['observacionregistrograduado'])){echo $_POST['observacionregistrograduado'];}else{echo $row_registrograduado['observacionregistrograduado'];}?></textarea></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Modalidad de Graduaci&oacute;n<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><select name="codigotiporegistrograduado" id="codigotiporegistrograduado">
			 <?php ?>
			 <option value="">Seleccionar</option>
               <?php
               do {
?>
               <option value="<?php echo $row_selcodigotiporegistrograduado['codigotiporegistrograduado']?>" <?php if(isset($_POST['codigotiporegistrograduado'])){if($_POST['codigotiporegistrograduado']==$row_selcodigotiporegistrograduado['codigotiporegistrograduado']){echo "selected";};}elseif($row_registrograduado['codigotiporegistrograduado']==$row_selcodigotiporegistrograduado['codigotiporegistrograduado']){echo "selected";}?>><?php echo $row_selcodigotiporegistrograduado['nombretiporegistrograduado']?></option>
               <?php
               } while ($row_selcodigotiporegistrograduado = mysql_fetch_assoc($selcodigotiporegistrograduado));
               $rows = mysql_num_rows($selcodigotiporegistrograduado);
               if($rows > 0) {
               	mysql_data_seek($selcodigotiporegistrograduado, 0);
               	$row_selcodigotiporegistrograduado = mysql_fetch_assoc($selcodigotiporegistrograduado);
               }
?>
             </select></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Tipo de Graduaci&oacute;n<span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><select name="idtipogrado" id="idtipogrado">
			 			 <option value="">Seleccionar</option>
               <?php
               do {
?>
               <option value="<?php echo $row_selcodigotipogrado['idtipogrado']?>" <?php if(isset($_POST['idtipogrado'])){if($_POST['idtipogrado']==$row_selcodigotipogrado['idtipogrado']){echo "selected";};}elseif($row_registrograduado['idtipogrado']==$row_selcodigotipogrado['idtipogrado']){echo "selected";}?>><?php echo $row_selcodigotipogrado['nombretipogrado']?></option>
               <?php
               } while ($row_selcodigotipogrado = mysql_fetch_assoc($selcodigotipogrado));
               $rows = mysql_num_rows($selcodigotipogrado);
               if($rows > 0) {
               	mysql_data_seek($selcodigotipogrado, 0);
               	$row_selcodigotipogrado = mysql_fetch_assoc($selcodigotipogrado);
               }
?>
             </select></td>
           </tr>
           <tr class="Estilo1">
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">N&uacute;mero de Promoci&oacute;n <span class="Estilo4">*</span></div></td>
             <td bgcolor="#FEF7ED"><input name="numeropromocion" type="text" id="numeropromocion" value="<?php if(isset($_POST['numeropromocion'])){echo $_POST['numeropromocion'];}elseif($totalrows_registrograduado==1){echo $row_registrograduado['numeropromocion'];}?>"></td>
           </tr>
           <tr class="Estilo1">
             <td colspan="2" bgcolor="#C5D5D6" class="Estilo2"><?php if($totalrows_registrograduado > 0 and $totalrows_muestra_firmaacta > 0 and $totalrows_muestra_firmadiploma > 0){
				 //echo $totalrows_muestra_firmaacta; echo $totalrows_muestra_firmadiploma; ?>
               <div align="center">
                 <input name="Incentivos" type="submit" id="Incentivos" value="Registrar Incentivos Acad&eacute;micos" onClick="abrir('documentograduado_incentivos.php?idusuario=<?php echo $row_idusuario['idusuario']?>&idregistrograduado=<?php if($totalrows_registrograduado==0){echo $noregistro;} elseif($totalrows_registrograduado==1){echo $row_registrograduado['idregistrograduado'];};?>','miventana','width=615,height=500,top=200,left=150,scrollbars=yes');return false">
                 <?php } ?>
             </div></td>
           </tr>
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">Incentivos Acad&eacute;micos</div></td>
             <td bgcolor="#FEF7ED">
             <div align="center"><?php do {echo @$row_muestra_incentivosacademicos['nombreincentivoacademico'],"<br>";} while(@$row_muestra_incentivosacademicos=mysql_fetch_assoc(@$muestra_incentivosacademicos))?></div></td>
           </tr>
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">Funcionario(s) Firmas Incentivos Acad&eacute;micos </div></td>
             <td bgcolor="#FFFFFF">
             <div align="center">
               <?php while(@$row_muestra_firma_incentivosacademicos=mysql_fetch_assoc($muestra_firma_incentivosacademicos)){echo @$row_muestra_firma_incentivosacademicos['nombre'],"<br>";}?>
             </div></td>
           </tr>
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">Funcionario(s) Firmas Acta </div></td>
             <td bgcolor="#FEF7ED"><div align="center">
               <?php while(@$row_muestra_firmaacta=mysql_fetch_assoc($muestra_firmaacta)){echo @$row_muestra_firmaacta['nombre'],"<br>";}?>             
          </div></td>
           </tr>
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center">Funcionario(s) Firmas Diploma </div></td>
             <td bgcolor="#FFFFFF"><div align="center">
               <?php while(@$row_muestra_firmadiploma=mysql_fetch_assoc($muestra_firmadiploma)){echo @$row_muestra_firmadiploma['nombre'],"<br>";}?>
             </div></td>
           </tr>
           <tr>
             <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Estado de autorizaci&oacute;n de grado </div></td>
             <td bgcolor="#FEF7ED" class="Estilo1">
                          <div align="center"><?php if($row_registrograduado['codigoautorizacionregistrograduado']=='100'){echo "Autorizado";}else{echo "No autorizado";}?></div>
             </td>
           </tr>
           <tr bgcolor="#C5D5D6" class="Estilo1">
             <td colspan="2" class="Estilo2">
               <div align="center">
                 
				 <?php if($totalrows_autorizadosino != 0 and $totalrows_registrograduado > 0 and $totalrows_muestra_firmaacta > 0 and $totalrows_muestra_firmadiploma > 0 and $row_registrograduado['codigoautorizacionregistrograduado']!='100'){
				 //echo $totalrows_muestra_firmaacta; echo $totalrows_muestra_firmadiploma; ?>
                 <input name="Autorizar" type="submit" id="Autorizar" value="Autorizar Grado" onClick="abrir('autorizacion_grado.php?idregistrograduado=<?php echo $row_registrograduado['idregistrograduado'];?>&iddirectivo=<?php echo $row_iddirectivo['iddirectivo'];?>&nombre=<?php echo $row_iddirectivo['nombre'];?>&diploma=<?php echo $totalrows_muestra_firmadiploma;?>&acta=<?php echo $totalrows_muestra_firmaacta;?>','miventana','width=300,height=150,top=200,left=150,scrollbars=yes');return false"/>				 
                 <?php } ?>
             </div></td>
           </tr>
           

           
       </table>
         <div align="center">
           <input name="Atras" type="submit" id="Atras" value="Atras" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <input name="Grabar" type="submit" id="Grabar" value="Grabar">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <?php if($totalrows_registrograduado >0 and $row_registrograduado['codigoautorizacionregistrograduado']!='100' and $totalrows_autorizadosino==1){ ?>
		   <input name="Anular" type="submit" id="Anular" value="Anular" /> <?php } ?>

         </div></td>
     </tr>
   </table>
 <p>&nbsp; </p>
 
<?php } 
else
{
	echo '<script language="javascript">
alert("'.$mensaje.'");
</script>';
	echo'<script language="javascript">history.go(-1);</script>';
}
?>

</form>
 


<?php
//echo $numrows_verifica_diploma,$numrows_verifica_acta;
if(isset($_POST['Grabar'])){
	if(isset($_SESSION["diploma"]) or isset($_SESSION['acta']) or isset($_SESSION['incentivos']))
	{
		$diploma=$_SESSION["diploma"];
		$acta=$_SESSION["acta"];
		//$incentivos=$_SESSION["incentivos"];
		//print_r($diploma);
		//print_r($acta);
	}



	$validacion['req_numeroacuerdoregistrograduado']=validar($_POST['numeroacuerdoregistrograduado'],"requerido",'<script language="JavaScript">alert("No ha digitado el número de acuerdo")</script>', true);
	$validacion['req_fechaacuerdoregistrograduado']=validar($_POST['fechaacuerdoregistrograduado'],"requerido",'<script language="JavaScript">alert("No ha digitado la fecha de acuerdo")</script>', true);
	$validacion['fech_fechaacuerdoregistrograduado']=validar($_POST['fechaacuerdoregistrograduado'],"fecha",'<script language="JavaScript">alert("No ha digitado correctamente la fecha acuerdo")</script>', true);
	$validacion['req_responsableacuerdoregistrograduado']=validar($_POST['responsableacuerdoregistrograduado'],"requerido",'<script language="JavaScript">alert("No digitado responsable")</script>', true);
	$validacion['req_numeroactaregistrograduado']=validar($_POST['numeroactaregistrograduado'],"requerido",'<script language="JavaScript">alert("No ha digitado el número del acta de grado")</script>', true);
	$validacion['req_fechaactaregistrograduado']=validar($_POST['fechaactaregistrograduado'],"requerido",'<script language="JavaScript">alert("No ha digitado la fecha del acta de grado")</script>', true);
	$validacion['fech_fechaactaregistrograduado']=validar($_POST['fechaactaregistrograduado'],"fecha",'<script language="JavaScript">alert("No ha digitado correctamente la fecha del acta de grado")</script>', true);
	$validacion['req_numerodiplomaregistrograduado']=validar($_POST['numerodiplomaregistrograduado'],"requerido",'<script language="JavaScript">alert("No ha digitado el número del diploma de grado")</script>', true);
	$validacion['req_fechadiplomaregistrograduado']=validar($_POST['fechadiplomaregistrograduado'],"requerido",'<script language="JavaScript">alert("No ha digitado la fecha del diploma de grado")</script>', true);
	$validacion['fech_fechadiplomaregistrograduado']=validar($_POST['fechadiplomaregistrograduado'],"fecha",'<script language="JavaScript">alert("No ha digitado correctamente la fecha del diploma de grado")</script>', true);
	$validacion['req_fechagradoregistrograduado']=validar($_POST['fechagradoregistrograduado'],"requerido",'<script language="JavaScript">alert("No ha digitado la fecha de grado")</script>', true);
	$validacion['fech_fechagradoregistrograduado']=validar($_POST['fechagradoregistrograduado'],"fecha",'<script language="JavaScript">alert("No ha digitado correctamente la fecha de grado")</script>', true);
	$validacion['req_codigotiporegistrograduado']=validar($_POST['codigotiporegistrograduado'],"requerido",'<script language="JavaScript">alert("No seleccionado la modalidad de graduación")</script>', true);
	$validacion['req_idtipogrado']=validar($_POST['idtipogrado'],"requerido",'<script language="JavaScript">alert("No seleccionado el tipo de graduación")</script>', true);
	$validacion['req_numeropromocion']=validar($_POST['numeropromocion'],"requerido",'<script language="JavaScript">alert("No seleccionado el número de promoción")</script>', true);
	$validaciongeneral=true;
	foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
	
	
	if($numrows_verifica_diploma > 0)
	{
		unset($_SESSION["diploma"]);
		//$_SESSION["diploma"]='bd';
	}
	if($numrows_verifica_acta > 0)
	{
		unset($_SESSION["acta"]);
		//$_SESSION["acta"]='bd';
	}
	
	
	
	if($numrows_verifica_diploma > 0 or $numrows_verifica_acta > 0)
	{
		$validaporbd=true;
	}
	else
	{
		$validaporbd=false;
	}
	if($validaporbd==true){
		if($validaciongeneral==true){
			require('insertar_datos.php');
			require('insertar_datos_firmas.php');
			
			//require('insertar_datos_incentivos.php');
			unset($_SESSION["diploma"]);
			unset($_SESSION["acta"]);
			//unset($_SESSION["incentivos"]);
			unset($diploma);
			unset($acta);
			//unset($incentivos);
			unset($_POST['Grabar']);

		}
	}
	else{
		if($validaciongeneral==true and isset($diploma) and isset($acta))
		{
			require('insertar_datos.php');
			require('insertar_datos_firmas.php');
			//require('insertar_datos_incentivos.php');
			unset($_SESSION["diploma"]);
			unset($_SESSION["acta"]);
			//unset($_SESSION["incentivos"]);
			unset($diploma);
			unset($acta);
			//unset($incentivos);
			unset($_POST['Grabar']);
		}

		else{
			if(!isset($acta)){
				unset($_SESSION["acta"]);
				unset($acta);
				echo '<script language="JavaScript">alert("No ha ingresado firmas para el acta de grado")</script>';
			}
			if(!isset($diploma)){
				unset($_SESSION["diploma"]);
				unset($diploma);
				echo '<script language="JavaScript">alert("No ha ingresado firmas para el diploma de grado")</script>';
			}
		}

	}
}
if(isset($_POST['Atras']))
{
	if(isset($_GET['autorizar']))
	{
	echo '<script language="javascript">window.location.reload("autorizar_masivo.php");</script>';
	}
	//echo "Atras";
	
	elseif(isset($_GET['tablaautorizados']))
	{
	echo '<script language="javascript">window.location.reload("../menuopcion.php");</script>';
	}
	
	elseif(isset($_GET['listado']))
	{
	echo '<script language="javascript">window.location.reload("../menuopcion.php");</script>';
	}
	
	else{
	echo '<script language="javascript">window.location.reload("../../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=creditoycartera");</script>';
	}
}


if(isset($_POST['Anular']))
{
	if($totalrows_registrograduado==1){

		$query_anular_incentivos="update registroincentivoacademico set codigoestado='200' where idregistrograduado='$idregistrograduado'";
		$anular_incentivos=mysql_query($query_anular_incentivos,$sala) or die(mysql_error());

		$query_anular_firmas="update documentograduado set codigoestado='200' where idregistrograduado='$idregistrograduado'";
		$anular_firmas=mysql_query($query_anular_firmas,$sala) or die(mysql_error());

		$query_anular_registrograduado="update registrograduado set codigoestado='200' where idregistrograduado='$idregistrograduado'
		and codigoestudiante='$codigoestudiante'
		";

		$anular_registrograduado=mysql_query($query_anular_registrograduado,$sala) or die(mysql_error());
		if($anular_registrograduado){
			$query_ingresardatos_log_autorizacion=
			"
	insert into logregistrograduado
	values
	(
	'',
	'".$row_registrograduado['idregistrograduado']."',
	'".$row_registrograduado['codigoestudiante']."',
	'".$row_registrograduado['numeropromocion']."',
	'$fecharegistrograduado',
	'".$row_registrograduado['numeroacuerdoregistrograduado']."',
	'".$row_registrograduado['fechaacuerdoregistrograduado']."',
	'".$row_registrograduado['responsableacuerdoregistrograduado']."',
	'".$row_registrograduado['numeroactaregistrograduado']."',
	'".$row_registrograduado['fechaactaregistrograduado']."',
	'".$row_registrograduado['numerodiplomaregistrograduado']."',
	'".$row_registrograduado['fechadiplomaregistrograduado']."',
	'".$row_registrograduado['fechagradoregistrograduado']."',
	'".$row_registrograduado['lugarregistrograduado']."',
	'".$row_registrograduado['presidioregistrograduado']."',
	'".$row_registrograduado['observacionregistrograduado']."',
	'100',
	'".$row_registrograduado['codigotiporegistrograduado']."',
	'$direccionipregistrograduado',
	'$usuario',
	'".$row_registrograduado['iddirectivo']."',
	'".$row_registrograduado['codigoautorizacionregistrograduado']."',
	'$fecharegistrograduado',
	'215',
	'".$row_registrograduado['idtipogrado']."'
	)
	";
			$ingresardatos_log_autorizacion=mysql_query($query_ingresardatos_log_autorizacion) or die(mysql_error());
			if($ingresardatos_log_autorizacion){
				unset($_POST['Anular']);
				unset($_SESSION["diploma"]);
				unset($_SESSION["acta"]);
				unset($diploma);
				unset($acta);
				echo '<script language="javascript">window.location.reload("graduar_estudiantes_ingreso.php?codigocarrera='.$codigocarrera.'&estudiante='.$codigoestudiante.'&codigogenero='.$codigogenero.'");</script>';
			}else{echo $query_ingresardatos_log_autorizacion,mysql_error();}

		}else{echo $query_anular_registrograduado,mysql_error();}

	}
}
?>
<?php

mysql_free_result($selcodigotiporegistrograduado);

mysql_free_result($selcodigotipogrado);
?>
