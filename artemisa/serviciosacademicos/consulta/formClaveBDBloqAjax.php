<?php
session_start();
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
if(!isset($_GET['idusuario'])){
	//echo '<script language="javascript">hRefCentral("formSegundaClaveAjax.php")</script>';
	echo "<h1>No hay idusuario. No se puede continuar</h1>";
	exit();
}
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
<!-- <script type="text/javascript" src="js/md5.js"></script>-->
<?php

$fechahoy=date("Y-m-d H:i:s");

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

$queryVerificaClaveCaducada="SELECT cu.* FROM claveusuario cu
	WHERE 
	cu.idusuario='".$_GET['idusuario']."'
	ORDER BY cu.idclaveusuario DESC LIMIT 1
	";
$opVerClaveCaduca=mysql_query($queryVerificaClaveCaducada) or die(mysql_error().$queryVerificaClaveCaducada);
$numRowClaveCaduca=mysql_num_rows($opVerClaveCaduca);

$queryUser = "SELECT * FROM tmp_usuario2 
		WHERE idusuario = '".$_GET['idusuario']."' 
		and verificacion IS NULL";
		//echo $queryUser; die;
		$opVerRequiereClave=mysql_query($queryUser) or die(mysql_error().$queryUser);
		$numRowRequiereClave=mysql_num_rows($opVerRequiereClave);

//var_dump($numRowRequiereClave);
		
if($numRowClaveCaduca > 0){
	//Hay clave viva, entonces verificar si la fecha de la clave es valida
	$rowClaveCaduca=mysql_fetch_assoc($opVerClaveCaduca);
	//print_r($rowClaveCaduca);

	if($rowClaveCaduca['codigoestado']==200 and $rowClaveCaduca['codigoindicadorclaveusuario']==400){
		$desbloq=true;
	}
	else{
		$desbloq=false;
	}
}
if($desbloq==true)
{

	$queryPregunta="SELECT * FROM referenciaclaveusuario
	WHERE
	'$fechahoy' BETWEEN fechainicioreferenciaclaveusuario AND fechafinalreferenciaclaveusuario
	AND idusuario='".$_GET['idusuario']."'
	";
	$pregunta=mysql_query($queryPregunta,$sala) or die(mysql_error().$queryPregunta);
	$numRowsPregunta=mysql_num_rows($pregunta);
	$rowPregunta=mysql_fetch_assoc($pregunta);

	$queryDatosUsuario="SELECT * from usuario u WHERE u.idusuario='".$_GET['idusuario']."'";
	$datosUsuario=mysql_query($queryDatosUsuario) or die(mysql_error().$queryDatosUsuario);
	$rowDatosUsuario=mysql_fetch_assoc($datosUsuario);

	$queryLogIntentos="SELECT * from logintentosaccesousuario WHERE idusuario='".$_GET['idusuario']."'";
	$logIntentos=mysql_query($queryLogIntentos) or die(mysql_error());
	$numRowsLogIntentos=mysql_num_rows($logIntentos);
	$rowLogIntentos=mysql_fetch_assoc($logIntentos);
	$contadorIntentos=$rowLogIntentos['contadorlogintentosaccesousuario'];

	$queryRefPregunta="SELECT preguntareferenciaclaveusuario from referenciaclaveusuario
	WHERE 
	idusuario='".$_GET['idusuario']."'
	AND '".date("Y-m-d H:i:s")."' BETWEEN fechainicioreferenciaclaveusuario AND fechafinalreferenciaclaveusuario
	";
	$refPregunta=mysql_query($queryRefPregunta,$sala) or die(mysql_error().$queryPregunta);
	$rowRefPregunta=mysql_fetch_assoc($refPregunta);
	$numRowsRefPregunta=mysql_num_rows($refPregunta);
?>
</head>
<body >
<strong>
Diligenciamiento de clave:<br><br>
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
<strong>Señor usuario:<br>Por su seguridad su clave ha sido bloqueada por alcanzar el número máximo permitido de intentos fallidos.<br>Porfavor diligencie una nueva respondiendo a la clave antigua o a la pregunta secreta.<br>
Si no puede desbloquear su clave de esta manera, favor comuníquese a la extensión 362 o 555.
</strong>
<br>
<br>
<form name="formSegClave" method="POST" action="">
Su pregunta secreta es: <strong><?php echo $rowPregunta['preguntareferenciaclaveusuario']?></strong><br>

<br>
<table>
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Digite clave antigua:</td> 
	<td><input type="password" size="20" minlength="8" maxlength="20" id="claveant" name="claveant"  value="<?php echo $_POST['claveant'];?>"></td>
	<td> o </td>
	<td class="tdOscurecido" id="tdtitulogris">Digite la respuesta a a su pregunta secreta:</td>
	<td><input type="password" size="30" name="respuesta" id="respuesta" value="<?php echo $_POST['respuesta']?>"></td>
</tr>
</table>
<br>
<table  border="0" cellpadding="0" cellspacing="1" bgcolor="#fafbf4">
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Digite clave:</td>
	<td><input type="password" size="20" minlength="8" maxlength="20" id="clave" name="clave"  value="<?php echo $_POST['clave'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['clave'])) { echo "*"; }?>
	</td>
</tr>
<tr>
	<td class="tdOscurecido" id="tdtitulogris">Confirme clave:</td>
	<td><input type="password" size="20" minlength="8" maxlength="20" id="claveconf" name="claveconf"  value="<?php echo $_POST['claveconf'];?>" required>
	<?php if(isset($_POST['Enviar']) and empty($_POST['claveconf'])) { echo "*"; }?>
	</td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Enviar" id="Enviar" onclick=""></td>
</tr>
</table>
<input type="hidden" name="clavehash" id="clavehash">
<input type="hidden" name="clavehashconf" id="clavehashconf">
<input type="hidden" name="clavehashant" id="clavehashant">
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
	//echo "<br/><br/>";print_r($_REQUEST);
	$validacion=true;
	$desbloqOK=false;
	$validacionAnt=true;
	
	//if($rowClaveCaduca['claveusuario']==md5($_POST['claveant']))
    if($rowClaveCaduca['claveusuario']==hash('sha256', $_POST['claveant']))
	{
		$desbloqOK=true;
		//echo "1  ";var_dump($desbloqOK);
	}
	/*elseif(md5($_POST['respuesta'])==$rowPregunta['repuestareferenciaclaveusuario']){
		$desbloqOK=true;
		echo "entre 2";
	}*/
	//var_dump($desbloqOK); die;
	
	if($desbloqOK==false){
		?>
		<script language="javascript">
		alert('La clave antigua o respuesta a la pregunta secreta no coinciden');
		//hRefCentral('facultades/central.php');
		</script>
	<?php 
	}


	if(!empty($_POST['clave']) and !empty($_POST['claveconf'])){
		if($_POST['clave']<>$_POST['claveconf']){
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

	$validacionAnt=true;
	$queryVerificaAntiguas="SELECT claveusuario FROM claveusuario cu WHERE idusuario='".$_GET['idusuario']."'";
	
	//echo $queryVerificaAntiguas,"<br>";
	$opVerificaAntiguas=mysql_query($queryVerificaAntiguas) or die(mysql_error().$queryVerificaAntiguas);
	$RowVerificaAntiguas=mysql_fetch_assoc($opVerificaAntiguas);
	do {
		//echo md5($_POST['clave'])," ",$RowVerificaAntiguas['claveusuario'],"<br>";
		//if((md5($_POST['clave']))==$RowVerificaAntiguas['claveusuario']){
        if((hash('sha256', $_POST['clave']))==$RowVerificaAntiguas['claveusuario']){
			$validacionAnt=false;
			$validacion=false;
		}
	}
	while ($RowVerificaAntiguas=mysql_fetch_assoc($opVerificaAntiguas));
        /*$validacion=true;  
        $validacionAnt=true;
        $desbloqOK=true;*/
	if($validacionAnt==false){ ?>
			<script language="javascript">alert('No puede usar una contraseña que se haya asignado antes')</script>
		<?php }

		if($validacion==true and $validacionAnt==true and $desbloqOK==true){
			$queryInsertaPregunta="insert into referenciaclaveusuario
			values
			('', '".$_GET['idusuario']."', 
			'".date("Y-m-d H:i:s")."', 
			'".date("Y-m-d H:i:s")."', 
			'2999-12-31', 
			'".$_POST['pregunta']."', 
			'".hash('sha256', $_POST['respuesta'])."'
			)";

			$insertaPregunta=mysql_query($queryInsertaPregunta,$sala) or die(mysql_error().$queryInsertaPregunta);

			$querySegundaClave="SELECT MAX(idclaveusuario) as idclaveusuario,codigoestado FROM claveusuario cu
	  		WHERE idusuario='".$_GET['idusuario']."' group by codigoestado
			";
			//echo $querySegundaClave,"<br>";
			$segundaClave=mysql_query($querySegundaClave) or die(mysql_error().$querySegundaClave);
			$cantRows=mysql_num_rows($segundaClave);
			$rowSegundaClave=mysql_fetch_assoc($segundaClave);
			//pone indicador de clave caducada a la ultima clave que estuvo vigente

			if($cantRows > 0){
				/*$queryVenceClaveVieja="UPDATE claveusuario SET codigoindicadorclaveusuario='400',fechavenceclaveusuario='".date("Y-m-d H:i:s")."'
				WHERE idclaveusuario='".$rowSegundaClave['idclaveusuario']."' and idusuario='".$_GET['idusuario']."'
				";
				*/
				$queryReiniciaRegLogIntentos="DELETE from logintentosaccesousuario WHERE idusuario='".$_GET['idusuario']."'";
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
			('', '".$_GET['idusuario']."', 
			'".date("Y-m-d H:i:s")."', 
			'".date("Y-m-d H:i:s")."', 
			'2999-12-31', 
			'".hash('sha256',$_POST['clave'])."', 
			'100',
			'100',
			'$codigotipoclaveusuario'
			)";
			$op=mysql_query($queryIngresaClaveNueva,$sala) or die(mysql_error().$queryIngresaClaveNueva);
			$url='facultades/consultafacultadesv2.htm';
			if($op){
				if($numRowRequiereClave>0){
					$queryCambioClave="UPDATE tmp_usuario2 
						SET verificacion = '1' 
						WHERE idusuario = '".$_GET['idusuario']."' ";

						$cambioClave=mysql_query($queryCambioClave,$sala) or die(mysql_error().$queryCambioClave);
				}
						
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
	var hashAnt = hex_md5(document.getElementById('claveant').value);

	document.getElementById('clavehash').value=hash;
	document.getElementById('clavehashconf').value=hashConf;
	document.getElementById('clavehashant').value=hashAnt;

	document.getElementById('clave').value='';
	document.getElementById('claveconf').value='';
	document.getElementById('claveant').value='';

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
<?php }?>
