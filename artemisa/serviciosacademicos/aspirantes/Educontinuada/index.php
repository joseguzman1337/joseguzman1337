<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once("../../funciones/clases/phpmailer/class.phpmailer.php");
$varguardar=0;

if(!isset ($_REQUEST['codigocarrera']) or $_REQUEST['codigocarrera']==''){
  $_REQUEST['codigocarrera']=1;
}

$SQL = "SELECT tipodocumento, nombredocumento FROM documento WHERE codigoestado = 100";
if($Tipo_documento=&$db->Execute($SQL)===false){  
	echo 'Error en consulta a base de datos ';
	die;     
}

if(!isset($_REQUEST['origen']) || $_REQUEST['origen'] == ''){
	$origen = 9;
}
?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
	<SCRIPT language="JavaScript" type="text/javascript">

	function contar(form,form1) {
	  n = document.forms[form][form1].value.length;
	  t = 500;
	  if (n > t) {
	    document.forms[form][form1].value = document.forms[form][form1].value.substring(0, t);
	  }
	  else {
	    document.forms[form]['result'].value = t-n;
	  }
	}
	</script>
	<style>
		input[type=text], select, textarea {padding:5px; border:2px solid #ccc; 
-webkit-border-radius: 5px;
border-radius: 5px;
}
input[type=text]:focus {border-color:#333; }

input[type=submit] {padding:15px 25px; background:#EA4240; border:0 none;
cursor:pointer;
-webkit-border-radius: 5px;
border-radius: 5px; color: #FFF; font-size: 14px;}

body{margin: 0 !important;}

.header{
	background-color: #000;
	color: #fff;
}

.header_up{
	background-color: #45a4a3;
    border: 0 none;
    height: 5px;
    margin: 0;
    padding: 0;
}

.header_down{
	background-color: #F06E6C;
    border: 0 none;
    height: 5px;
    margin: 0;
    padding: 0;
}

.logo-educon {
    padding: 30px 300px 10px;
}

table{
	background-color: #fff !important;
}

.formulario tr td{
	background-color: #fff !important;
}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
    <body bgcolor="#EDEFF0">
<form name="form1" id="form1"  method="POST">
    <div class="header">
		<hr class="header_up"></hr>
		<a href="http://www.uelbosque.edu.co/programas_academicos/educacion_continuada"><img class="logo-educon" alt="" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logo_educon.png"></a>
		<hr class="header_down"></hr>		
	</div>
<table width="1000px"  border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFF" >

         <TR >
           <TD align="Left"><h1><?php  if(isset ($_REQUEST['codigocarrera'])){
            $query_nomcarrera = "select nombrecarrera from carrera where codigocarrera = '".$_REQUEST['codigocarrera']."'";
                $nomcarrera= $db->Execute($query_nomcarrera);
                $totalRows_nomcarrera = $nomcarrera->RecordCount();
                $row_nomcarrera = $nomcarrera->FetchRow();
		$nombrecarrera=$row_nomcarrera['nombrecarrera'];
                echo "REGISTRO - ".$row_nomcarrera['nombrecarrera'];
                 }
             ?>
            </h1></TD>
         </TR>
	<tr><td bgcolor="#45A4A3"></td></tr>
	</table>
	<table width="1000px" class="formulario" border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#FFF" >
	<tr>
	   <td style="color:#40482D;font-size:15px;"><b>Tipo de documento</b><label id="labelasterisco">*</label>
	   </td>
	</tr>
	<tr>
        <td bgcolor="#FFF">
			<select name="tipo_documento"><?php if(!$Tipo_documento->EOF){
                while(!$Tipo_documento->EOF){
                	echo '<option value="'.$Tipo_documento->fields['tipodocumento'].'">'.$Tipo_documento->fields['nombredocumento'].'</option>';
                	$Tipo_documento->MoveNext();
                }
            } ?></select>
        </td>
    </tr>
	<tr>
	   <td style="color:#40482D;font-size:15px;"><b>Numero documento</b><label id="labelasterisco">*</label>
	   </td>
	</tr>
	<tr>
        <td bgcolor="#FFF"><input type="text" name="documento" size="70" value="<?php if ($_POST['documento']!=""){
            echo $_POST['documento']; } ?>">
        </td>
    </tr>
	<tr>
	   <td style="color:#40482D;font-size:15px;"><b>Nombre(s)</b><label id="labelasterisco">*</label>
	   </td>
	</tr>
	<tr>
           <td bgcolor="#FFF"><input type="text" name="nombres" size="70" value="<?php if ($_POST['nombres']!=""){
                        echo $_POST['nombres']; } ?>">
           </td>
        </tr>
	<tr>
	   <td style="color:#40482D;font-size:15px;"><b>Apellidos</b><label id="labelasterisco">*</label>
	   </td>
	</tr>
	<tr>
           <td bgcolor="#FFF"><input type="text" name="apellidos" size="70" value="<?php if ($_POST['apellidos']!=""){
                        echo $_POST['apellidos']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Télefono</b><label id="labelasterisco">*</label>
           </td>
        </tr>
        <tr>
           <td bgcolor="#FFF"><input type="text" name="telefono" size="70" value="<?php if ($_POST['telefono']!=""){
                        echo $_POST['telefono']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Celular</b><label id="labelasterisco">*</label>
           </td>
        </tr>
        <tr>
           <td bgcolor="#FFF"><input type="text" name="celular" size="70" value="<?php if ($_POST['celular']!=""){
                        echo $_POST['celular']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Correo Electrónico</b><label id="labelasterisco">*</label>
           </td>
        </tr>
        <tr>
           <td bgcolor="#FFF"><input type="text" name="email" size="70" value="<?php if ($_POST['email']!=""){
                        echo $_POST['email']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Profesión</b><label id="labelasterisco">*</label>
           </td>
        </tr>
        <tr>
           <td bgcolor="#FFF"><input type="text" name="profesion" size="70" value="<?php if ($_POST['profesion']!=""){
                        echo $_POST['profesion']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Especialidad</b>
           </td>
        </tr>
        <tr>
           <td bgcolor="#FFF"><input type="text" name="especialidad" size="70" value="<?php if ($_POST['especialidad']!=""){
                        echo $_POST['especialidad']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Empresa</b>
           </td>
        </tr>
        <tr>
           <td bgcolor="#FFF"><input type="text" name="empresa" size="70" value="<?php if ($_POST['empresa']!=""){
                        echo $_POST['empresa']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Cargo</b>
           </td>
        </tr>
        <tr>
           <td bgcolor="#FFF"><input type="text" name="cargo" size="70" value="<?php if ($_POST['cargo']!=""){
                        echo $_POST['cargo']; } ?>">
           </td>
        </tr>
	<tr>
           <td style="color:#40482D;font-size:15px;"><b>Comentarios</b>
           </td>
        </tr>
	<tr>
           <td bgcolor="#FFF">
               <TEXTAREA name="comentario" cols="50" rows="2"  onkeydown="contar('form1','text')" onkeyup="contar('form1','comentario')" ><?php if ($_POST['comentario']!=""){
                   echo $_POST['comentario']; } ?></TEXTAREA>
                <input type="hidden" name="origen" value="<?php echo $origen; ?>"><br />
               Quedan &nbsp;<INPUT name="result" value="500" size="4" readonly="true"> &nbsp; Caracteres
           </td>
        </tr>
	<tr>
           <td align="center">
		<input type="hidden" name="nombrecarrera" value="<?php echo $nombrecarrera; ?>">
		<input type="submit" name="enviar" value="Enviar">
	   </td>
	</tr>
    </table>
	</form>
<?php 
if(isset($_POST['enviar'])){
	if ($_POST['nombres'] == "") {
            echo '<script language="JavaScript">alert("Campo requerido debe digitar su Nombre")</script>';
            $varguardar = 1;
    	}
	elseif ($_POST['apellidos'] == "") {
            echo '<script language="JavaScript">alert("Campo requerido debe digitar sus Apellidos")</script>';
            $varguardar = 1;
    	}
	elseif ($_POST['documento'] == "") {
        echo '<script language="JavaScript">alert("Campo requerido debe digitar su Numero de documento")</script>';
        $varguardar = 1;
    }
	elseif ($_POST['telefono'] == "" || !ereg("^[0-9]{0,20}$",$_POST['telefono'])) {
            echo '<script language="JavaScript">alert("Campo requerido debe digitar un número de Télefono valido")</script>';
            $varguardar = 1;
    	}
	elseif ($_POST['celular'] == "" || !ereg("^[0-9]{0,20}$",$_POST['celular'])) {
            echo '<script language="JavaScript">alert("Campo requerido debe digitar un número de Celular valido")</script>';
            $varguardar = 1;
        }

    	elseif ($_POST['email']=="" || !ereg("^([a-zA-Z0-9\._]+)\@([a-zA-Z0-9\.-]+)\.([a-zA-Z]{2,4})",$_POST['email'])) {
            echo '<script language="JavaScript"> alert("Debe Digitar una Dirección de E-mail o hacerlo de forma Correcta")</script>';
            $varguardar = 1;
    	}
	elseif ($_POST['profesion'] == ""){
	    echo '<script language="JavaScript">alert("Campo requerido debe digitar su Profesión")</script>';
            $varguardar = 1;
	}
	elseif ($varguardar == 0) {
		
		/* Obtener codigo de periodo actual */
		$SQL='select codigoperiodo from periodo where codigoestadoperiodo = 3';
		if($Periodo=&$db->Execute($SQL)===false){    
			echo 'Error en consulta a base de datos '.$SQL;
			die;     
		}
		if($Periodo->_numOfRows == 0){
			$SQL='select codigoperiodo from periodo where codigoestadoperiodo = 1';   
			if($Periodo=&$db->Execute($SQL)===false){
				echo 'Error en consulta a base de datos '.$SQL;
				die; 
			}
		}
		$Periodo = $Periodo->fields['codigoperiodo'];
		
		$SQL = "SELECT idpreinscripcion FROM preinscripcion WHERE numerodocumento = '".$_REQUEST['documento']."' AND codigoperiodo = '".$Periodo."' AND codigoestado = 100 LIMIT 1";
		if($Preinscripcion=&$db->Execute($SQL)===false){    
			echo 'Error en consulta a base de datos '.$SQL;
			die;     
		}
		if($Preinscripcion->_numOfRows == 0){
			$SQL = "INSERT INTO preinscripcion SET fechapreinscripcion = '".date("Y-m-d")."', numerodocumento = '".$_REQUEST['documento']."', tipodocumento = '".$_REQUEST['tipo_documento']."', codigoperiodo = '".$Periodo."', idtrato = 1, apellidosestudiante = '".$_REQUEST['apellidos']."', nombresestudiante = '".$_REQUEST['nombres']."', ciudadestudiante = 359, telefonoestudiante = '".$_REQUEST['telefono']."', celularestudiante = '".$_REQUEST['celular']."', emailestudiante = '".$_REQUEST['email']."', codigocalendarioestudiante = 0, codigoestadopreinscripcionestudiante = 100, idusuario = 1, ip = '".$_SERVER['REMOTE_ADDR']."', codigoestado = 100, codigoindicadorenvioemailacudientepreinscripcion = 100, idempresa = 1, idtipoorigenpreinscripcion = '".$_REQUEST['origen']."'";
			if($Resultado=&$db->Execute($SQL)===false){    
				echo 'Error en consulta a base de datos '.$SQL;
				die;     
			}
			$Preinscripcion = $db->Insert_ID();
		}else{
			$Preinscripcion = $Preinscripcion->fields['idpreinscripcion'];
		}

		$SQL = "INSERT INTO preinscripcioncarrera SET idpreinscripcion = '".$Preinscripcion."', codigocarrera = '".$_REQUEST['codigocarrera']."', codigoestado = 100";
		if($Resultado=&$db->Execute($SQL)===false){    
			echo 'Error en consulta a base de datos '.$SQL;
			die;     
		}
	  $query_guarda = "INSERT INTO capturaeducontinuada (idcapturaeducontinuada
				,nombres
				,telefono
				,celular
				,email
				,codigocarrera
				,profesion
				,especialidad
				,empresa
				,cargo
				,comentarios
				,fecharegistro)
                values (0,'".$_REQUEST['nombres']." ".$_REQUEST['apellidos']."'
			,'".$_REQUEST['telefono']."'
			,'".$_REQUEST['celular']."'
			,'".$_REQUEST['email']."'
			,'".$_REQUEST['codigocarrera']."'
			,'".$_REQUEST['profesion']."'
			,'".$_REQUEST['especialidad']."'
			,'".$_REQUEST['empresa']."'
			,'".$_REQUEST['cargo']."'
			,'".$_REQUEST['comentario']."'
			,now())";
                $guarda = $db->Execute ($query_guarda);
		if($guarda){
			
			$mail = new PHPMailer();
                        $mail->From = "UNIVERSIDAD EL BOSQUE";
                        $mail->FromName = "UNIVERSIDAD EL BOSQUE";
                        $mail->ContentType = "text/html";
                        $mail->Subject = "REGISTRO DE DATOS";
                        $mail->AddAddress("educacion.continuada@unbosque.edu.co","Educacion Continuada");
	
			$mensaje="Señores Educación Continuada.<br><br>"."<b>A continuación se envía los datos de registro de interesado.</b><BR><BR>".
			"Carrera = ".$_REQUEST['nombrecarrera']."<br>".
                        "Nombres = ".$_REQUEST['nombres']."<br>".
                        "Telefono = ".$_REQUEST['telefono']."<br>".
                        "Celular = ".$_REQUEST['celular']."<br>".
                        "Email = ".$_REQUEST['email']."<br>".
                        "Profesion = ".$_REQUEST['profesion']."<br>".
                        "Especialidad = ".$_REQUEST['especialidad']."<br>".
                        "Empresa = ".$_REQUEST['empresa']."<br>".
                        "Cargo = ".$_REQUEST['cargo']."<br>".
                        "Comentarios = ".$_REQUEST['comentario']."<br>";

			$mail->Body = $mensaje;
	            	//print_r($mensaje);
		        $mail->Send();
			
	                if(!$mail->Send())
        	        {
                	    echo "El mensaje no pudo ser enviado";
	                    echo "Mailer Error: " . $mail->ErrorInfo;
	                //exit();
        	        }
                	else
	                {
        	           echo '<script language="JavaScript">alert("Agradecemos su interés en los programas de Educación Continuada de la Universidad El Bosque, enviaremos la información solicitada al correo electrónico registrado.")
                	   window.location.href="http://www.uelbosque.edu.co";
	                   </script>';
        	        }
	   	}
	}




}

?>
