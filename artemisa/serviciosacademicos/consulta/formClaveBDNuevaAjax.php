<?php
session_start();
//print_r($_SESSION);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<script language="javascript">
var browser = navigator.appName;
function hRefCentral(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.contenidocentral.location.href(url);
	}
	else{
		parent.contenidocentral.location=url;
	}
	return true;
}
</script>
<link rel="stylesheet" type="text/css" href="../estilos/salaNuevo.css">
<?php
/*
if(!isset($_REQUEST['idusuario'])){
echo '<script language="javascript">hRefCentral("facultades/central.php")</script>';
//alert('Sesión perdida');
exit();
}*/
require_once('../Connections/sala2.php');
mysql_select_db($database_sala,$sala);
?>
<script type="text/javascript" src="js/separateFiles/dhtmlSuite-common.js"></script>
<script type="text/javascript" src="js/config.js"></script>
<script type="text/javascript" src="../funciones/clases/autenticacion/inc.js"></script>
<script type="text/javascript">
DHTMLSuite.include('formValidator');
DHTMLSuite.include('form');
function cerrarsesion(){
	http.open('post','facultades/cerrar.php',true);
	http.onreadystatechange=function cerrarRespuesta(){
		if(http.readyState==4&&http.status==200){
			alert('Sesión cerrada correctamente');
			hRefIzq('facultades/facultadeslv2.php');
			hRefCentral('facultades/central.php');
			
		}
	};
	http.send(null);
return false;
}

</script>
<!--<script type="text/javascript" src="js/md5.js"></script>-->
<?php

$fechahoy=date("Y-m-d H:i:s");

$queryDeterminaSiExisteClaveAntiguaBloqueadaCaducada="SELECT * from claveusuario ca WHERE ca.idusuario='".$_REQUEST['idusuario']."' ORDER BY idclaveusuario DESC";
$opDeterminaSiExisteClaveBloqueadaCaducada=mysql_query($queryDeterminaSiExisteClaveAntiguaBloqueadaCaducada,$sala) or die(mysql_error());
$numRowsDeterminaSiExisteClaveBloqueadaCaducada=mysql_num_rows($opDeterminaSiExisteClaveBloqueadaCaducada);
if($numRowsDeterminaSiExisteClaveBloqueadaCaducada > 0){
	$rowDeterminaSiExisteClaveBloqueadaCaducada=mysql_fetch_assoc($opDeterminaSiExisteClaveBloqueadaCaducada);
	//print_r($rowDeterminaSiExisteClaveBloqueadaCaducada);
	if($rowDeterminaSiExisteClaveBloqueadaCaducada['codigoestado']==200 and ($rowDeterminaSiExisteClaveBloqueadaCaducada['codigoindicadorclaveusuario']==200 or $rowDeterminaSiExisteClaveBloqueadaCaducada['codigoindicadorclaveusuario']==300)){
		$preguntarClaveAnterior=true;
	}
}

$queryPoliticaClave="SELECT pc.* FROM politicaclave pc
WHERE '$fechahoy' between pc.fechadesdepoliticaclave and pc.fechahastapoliticaclave
";

$politicaClave=mysql_query($queryPoliticaClave,$sala) or die(mysql_error().$queryPoliticaClave);
$rowPoliticaClave=mysql_fetch_assoc($politicaClave);
$numRowsPoliticaClave=mysql_num_rows($politicaClave);

$cantDias=$rowPoliticaClave['diascaducidadpoliticaclave'];
$numerointentospoliticaclave=$rowPoliticaClave['numerointentospoliticaclave'];

if(empty($cantDias)){
	$cantDias=30;
}

if (empty($numerointentospoliticaclave)) {
	$numerointentospoliticaclave=5;
}

if($cantDias > 0){
	$fechasinformato=strtotime("+$cantDias day",strtotime($fechahoy));
	$fechanueva=date("Y-m-d H:i:s",$fechasinformato);
}

$queryPregunta="SELECT * FROM referenciaclaveusuario
		WHERE
		'$fechahoy' BETWEEN fechainicioreferenciaclaveusuario AND fechafinalreferenciaclaveusuario
		AND idusuario='".$_REQUEST['idusuario']."'
		";


$pregunta=mysql_query($queryPregunta,$sala) or die(mysql_error().$queryPregunta);
$numRowsPregunta=mysql_num_rows($pregunta);
$rowPregunta=mysql_fetch_assoc($pregunta);


$queryDatosUsuario="SELECT * from usuario u WHERE u.idusuario='".$_REQUEST['idusuario']."'";
$datosUsuario=mysql_query($queryDatosUsuario) or die(mysql_error().$queryDatosUsuario);
$rowDatosUsuario=mysql_fetch_assoc($datosUsuario);


$queryLogIntentos="SELECT * from logintentosaccesousuario WHERE idusuario='".$_REQUEST['idusuario']."'";
$logIntentos=mysql_query($queryLogIntentos) or die(mysql_error());
$numRowsLogIntentos=mysql_num_rows($logIntentos);
$rowLogIntentos=mysql_fetch_assoc($logIntentos);
$contadorIntentos=$rowLogIntentos['contadorlogintentosaccesousuario'];


//echo $contadorIntentos," >= ",$numerointentospoliticaclave;
?>
</head>
<body >
<strong>
Diligenciamiento de clave usuarios administrativos:<br><br>
</strong>
Su clave:<br>
<ul>
<li>Debe contener mínimo 8 y máximo 20 carácteres</li>
<li>No puede ser su nombre, apellido, documento de identidad, o correo</li>
<!--<li>En caso de olvidar la contraseña, se debe acudir a la respuesta a la pregunta secreta, por lo cual, se sugiere que sea una respuesta clara y puntual. Los espacios y signos de puntuación no son adecuados</li>-->
<li>No puede haber sido usada con anteriodad</li>
</ul>
<br>
<br>
<strong>Señor usuario:<br><br>Porfavor diligencie una clave nueva.</strong>
<br>
<br>
<form name="formSegClave" method="POST" action="">
<table  border="0" cellpadding="0" cellspacing="1" bgcolor="#fafbf4">
<?php if($preguntarClaveAnterior==true) {?>
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Digite su clave anterior:</td>
	<td><input type="password" size="20" minlength="8" maxlength="20" id="claveant" name="claveant"  value="<?php echo $_POST['claveant'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['clave'])) { echo "*"; }?>
	</td>
</tr>
<?php }?>

<tr>
	<td class="tdOscurecido" id="tdtitulogris">Digite su clave nueva:</td>
	<td><input type="password" size="20" minlength="8" maxlength="20" id="clave" name="clave"  value="<?php echo $_POST['clave'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['clave'])) { echo "*"; }?>
	</td>
</tr>
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Confirme su clave nueva:</td>
	<td><input type="password" size="20" minlength="8" maxlength="20" id="claveconf" name="claveconf"  value="<?php echo $_POST['claveconf'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['claveconf'])) { echo "*"; }?>
	</td>
</tr>
<?php if($numRowsPregunta==0){?>
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Diligencie su pregunta secreta:</td>
	<td><input type="text" size="40" id="pregunta" name="pregunta" value="<?php echo $_POST['pregunta'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['pregunta'])) { echo "*"; }?>
	</td>
</tr>
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Diligencie la respuesta a su pregunta secreta:</td>
	<td><input type="password" size="40" id="respuesta" name="respuesta" value="<?php echo $_POST['respuesta'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['respuesta'])) { echo "*"; }?>
	</td>
</tr>
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Diligencie la confirmación de la respuesta a su pregunta secreta:</td>
	<td><input type="password" size="40" id="respuestaconf" name="respuestaconf" value="<?php echo $_POST['respuestaconf'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['respuestaconf'])) { echo "*"; }?>
	</td>
</tr>
<?php } ?>
<tr>
	<td colspan="2"><input type="submit" value="Enviar" id="Enviar"></td>
</tr>
</table>

<input type="hidden" name="clavehash" id="clavehash">
<input type="hidden" name="clavehashconf" id="clavehashconf">
<input type="hidden" name="Enviar" value="Enviar">
</form>
<table>
<tr>
	<td colspan="2"><br>	<br>
	<input type="image" src="facultades/imagesAlt2/cerrar.gif" onclick="return cerrarsesion();"><br><br></td>
</tr>
</table>

<?php
if(isset($_POST['Enviar'])){
	$validacion=true;
	$valCont=true;


	$_SESSION['arrayInvalido']=$arrInvalido;

	if(!empty($_POST['clave']) and !empty($_POST['claveconf'])){
		if($_POST['clavehash']<>$_POST['clavehashconf']){
		$validacion=false; ?>
		<script language="javascript">alert('La clave digitada no coincide con la confirmación')</script>
	<?php }
	}


	if(!empty($_POST['respuesta']) and !empty($_POST['respuestaconf'])){
		if($_POST['respuesta']<>$_POST['respuestaconf']){
		$validacion=false; ?>
		<script language="javascript">alert('La respuesta digitada no coincide con la confirmación')</script>
	<?php }
	}

	if(!empty($_POST['clave']) and !empty($_POST['respuesta'])){
		if($_POST['clave']==$_POST['respuesta']){
		$validacion=false; ?>
		<script language="javascript">alert('La respuesta secreta no debe ser igual a la contraseña')</script>
	<?php }
	}

	//if($_SESSION['key']==md5($_POST['clave'])){
    if($_SESSION['key']==hash('sha256', $_POST['clave'])){
		$validacion=false; ?>
		<script language="javascript">alert('La clave digitada no puede ser la misma del correo electrónico')</script>
	<?php }


	$validacionAnt=true;
	$queryVerificaAntiguas="SELECT claveusuario FROM claveusuario cu WHERE idusuario='".$_REQUEST['idusuario']."'";
	$opVerificaAntiguas=mysql_query($queryVerificaAntiguas) or die(mysql_error().$queryVerificaAntiguas);
	do {
		//if((md5($_POST['clave']))==$RowVerificaAntiguas['claveusuario']){
        if((hash('sha256',$_POST['clave']))==$RowVerificaAntiguas['claveusuario']){
			//echo md5($_POST['clave'])," ",$RowVerificaAntiguas['claveusuario'];
			$validacionAnt=false;
			$validacion=false;
		}
	}
	while ($RowVerificaAntiguas=mysql_fetch_assoc($opVerificaAntiguas));


	if($validacionAnt==false){ ?>
			<script language="javascript">alert('No puede usar una contraseña que se haya asignado antes')</script>
		<?php }

		if($validacion==true and $valCont==true){
			if(empty($fechanueva)){
				$fechanueva='2999-12-31';
			}

			if($preguntarClaveAnterior==true){
                //if(md5($_POST['claveant'])==$rowDeterminaSiExisteClaveBloqueadaCaducada['claveusuario']){
				if(hash('sha256',$_POST['claveant'])==$rowDeterminaSiExisteClaveBloqueadaCaducada['claveusuario']){
					$pasaClaveAnterior=true;
				}
				else{
					$pasaClaveAnterior=false;
					echo '<script>alert("Error en clave antigua. No podrá diligenciar su nueva clave, si no digita correctamente la clave antigua")</script>';
					exit();
				}
			}

			

			$queryInsertaPregunta="insert into referenciaclaveusuario
			values
			('', '".$_REQUEST['idusuario']."', 
			'".date("Y-m-d H:i:s")."', 
			'".date("Y-m-d H:i:s")."', 
			'2999-12-31', 
			'".$_POST['pregunta']."', 
			'".hash('sha256',$_POST['respuesta'])."'
			)";

			$insertaPregunta=mysql_query($queryInsertaPregunta,$sala) or die(mysql_error().$queryInsertaPregunta);
			$querySegundaClave="SELECT cu.* FROM claveusuario cu
				WHERE 
				cu.idusuario='".$_REQUEST['idusuario']."'
				AND cu.codigoestado=200 AND cu.codigoindicadorclaveusuario = 500
				ORDER BY cu.idclaveusuario DESC
				";
			//echo $querySegundaClave,"<br>";
			$segundaClave=mysql_query($querySegundaClave) or die(mysql_error().$querySegundaClave);
			$cantRows=mysql_num_rows($segundaClave);
			$rowSegundaClave=mysql_fetch_assoc($segundaClave);
			//pone indicador de clave caducada a la ultima clave que estuvo vigente

			if($cantRows > 0){
				//si está bloqueada
				$queryVenceClaveVieja="UPDATE claveusuario SET fechavenceclaveusuario='".date("Y-m-d H:i:s")."'
					WHERE idclaveusuario='".$rowSegundaClave['idclaveusuario']."'";
				$opVenceClaveVieja=mysql_query($queryVenceClaveVieja) or die(mysql_error().$queryVenceClaveVieja);

				$queryReiniciaRegLogIntentos="DELETE from logintentosaccesousuario WHERE idusuario='".$_REQUEST['idusuario']."'";
				$reiniciaLog=mysql_query($queryReiniciaRegLogIntentos) or die(mysql_error());
			}
			//inserta clave nueva

			//por ahora
			if($_SESSION['2clavereq']=='SEGCLAVEREQ'){
				$codigotipoclaveusuario=3;
			}
			else{
				$codigotipoclaveusuario=2;
			}

			$queryIngresaClaveNueva="insert into claveusuario values
			('', '".$_REQUEST['idusuario']."',
			'".date("Y-m-d H:i:s")."',
			'".date("Y-m-d H:i:s")."',
			'2999-12-31',
			'".hash('sha256', $_POST['clave'])."',
			'100',
			'100',
			'$codigotipoclaveusuario'
			)";
			$op=mysql_query($queryIngresaClaveNueva,$sala) or die(mysql_error().$queryIngresaClaveNueva);
			$url='facultades/consultafacultadesv2.htm';
			if($op){
				foreach ($_SESSION as $llave => $valor){
					unset($_SESSION[$llave]);
				}
				?>
			<script language="javascript">
			alert('Clave asignada correctamente, porfavor, reingrese al sistema con la clave previamente digitada');
			parent.document.location.href='<?php echo $url?>';
			</script>
			<?php } 

		}
	elseif($validacion==false){ ?>
		<script language="javascript">alert('Formulario no valido, revise que todos los datos solicitados hayan cumplido con los requisitos')</script>
	<?php }
	elseif($valCont==false){ ?>
		<script language="javascript">alert('La clave no puede ser su documento de identidad, su nombre, o apellido')</script>
		
	<?php }
}
?>
</body>
</html>
<script language="javascript">

function calculaHash(){
	var hash = hex_md5(document.getElementById('clave').value);
	var hashConf = hex_md5(document.getElementById('claveconf').value);

	document.getElementById('clavehash').value=hash;
	document.getElementById('clavehashconf').value=hashConf;

	//document.getElementById('clave').value='';
	//document.getElementById('claveconf').value='';

	document.formSegClave.submit();
}

function activaEnviar(){
	document.getElementById('Enviar').disabled=false;
}
function desactivaEnviar(){
	document.getElementById('Enviar').disabled=true;
}

var formValObj = new DHTMLSuite.formValidator({formRef:'formSegClave',keyValidation:true,callbackOnFormValid:'activaEnviar',callbackOnFormInvalid:'desactivaEnviar',indicateWithBars:false});

</script>
