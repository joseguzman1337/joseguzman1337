<?php
include("../consulta/cerrar.php");
require_once("templates/template.php");
$db=getBD();

$fechahoy=date("Y-m-d H:i:s");
$cargarCursos=false;
$carreras="";
$alerta=false;
if(isset($_POST['Cursos'])){
		unset($_SESSION['array_salon']);
		$GLOBALS['nombreprograma'];
		unset($_SESSION["nombreprograma"]);
		$_SESSION['nombreprograma'] = "ingresopreinscripcion.php";
		unset($_SESSION['fppal']);
		$_SESSION['auth'] = 1;
		$_SESSION['modalidadacademicasesion'] = 400;
		$cargarCursos=true;
	if ($_POST['captcha'] != $_SESSION['cap_code']) {		
			$alerta="Verifique que los datos ingresados sean igual a la imagen en pantalla";
		} else {
			$query = "SELECT numerodocumento,idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento='".$_POST['numerodocumento']."' AND 
			nombresestudiantegeneral like '%".$_POST['nombre']."%' AND apellidosestudiantegeneral like '%".$_POST['apellido']."%'";
			$estudiante=$db->GetRow($query);
			if(count($estudiante)>0&&$estudiante!=false){
			    $numeroDocumento = $estudiante["numerodocumento"];
				$carreras = "<tr><td id='tdtitulogris'>Seleccione el curso*</td>";
				 $query="SELECT distinct eg.*,
                               ec.codigocarrera,
                               ec.codigoestudiante,
                               c.codigoindicadorcobroinscripcioncarrera,
                               c.codigoindicadorprocesoadmisioncarrera,
                               m.nombremodalidadacademica,
                               m.codigomodalidadacademica,
                               c.nombrecarrera,
                               ci.nombreciudad,
                               s.nombresituacioncarreraestudiante,
                               i.numeroinscripcion,
                               i.codigosituacioncarreraestudiante,
                               o.*
                        FROM estudiantegeneral eg
                                 JOIN inscripcion i ON (eg.idestudiantegeneral = i.idestudiantegeneral )
                                 JOIN estudiantecarrerainscripcion e ON (i.idinscripcion = e.idinscripcion AND e.codigoestado = '100')
                                 JOIN estudiante ec ON (ec.codigocarrera = e.codigocarrera AND ec.idestudiantegeneral = eg.idestudiantegeneral)
                                 JOIN carrera c ON (e.codigocarrera = c.codigocarrera)
                                 JOIN modalidadacademica m ON (m.codigomodalidadacademica = i.codigomodalidadacademica)
                                 JOIN ciudad ci ON (eg.idciudadnacimiento = ci.idciudad)
                                 JOIN situacioncarreraestudiante s ON (s.codigosituacioncarreraestudiante = i.codigosituacioncarreraestudiante)
                                 JOIN ordenpago o ON (o.codigoestudiante = ec.codigoestudiante AND o.codigoestadoordenpago in(10,11,60,61) )
                        WHERE eg.numerodocumento ='" . $numeroDocumento . "'
                        
                        group by ec.codigocarrera , o.numeroordenpago
                        order by codigocarrera desc;";
							//echo $query;
				$cursos=$db->GetAll($query);
				if(count($cursos)>0){
					$carreras .= "<td><select id='codigocarrera' name='codigoestudiante'>";
					foreach($cursos as $curso){
						$carreras .= "<option value='".$curso["codigoestudiante"]."-".$curso["codigocarrera"]."'>".$curso["nombrecarrera"]."</option>";
					}
					$carreras .= "</select></td></tr>";
				} else {
					$alerta = "No se encontraron cursos de educación continuada asociados con el estudiante.";
				}
			} else {
				$alerta = "Por favor verifique que los datos ingresados sean correctos.";
			}
	}
}
if(isset($_REQUEST['Enviar'])){
		if($_POST['apellido']!=""&&$_POST['numerodocumento']!=""&&$_POST['nombre']!=""&&$_POST['codigoestudiante']!=""&&$_POST['codigoestudiante']!=null&&$alerta==false){
			$datos=explode("-",$_POST['codigoestudiante']);
			$_SESSION['codigocarrerasesion'] = $datos[1];
			if ($_SESSION['MM_Username'] == "estudiante") {
				$_SESSION['codigocarrerasesion'] = "";
			}

			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../consulta/prematricula/inscripcionestudiante/pagoderechosmatricula.php?documentoingreso=".$_POST['numerodocumento']."&codigoestudiante=".$datos[0]."&ec=1'>";			
			die;			
		} else {			
				?>
				<script type="text/javascript">
					<?php if($alerta==false) { ?>
					alert("Todos los campos deben diligenciarse para ingresar.");
					history.go(-1);
					<?php } else {  ?>
					alert("<?php echo utf8_decode($alerta); ?>");
					<?php } ?>
					</script>
				<?php 
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Force best rendering mode for IE -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<title>Ingreso Cursos Educación Continuada</title>
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800);
body {
	margin:0;
	background-color: #EDF0D5;
	font-family: 'Open Sans',sans-serif;
}
#pagina{
	width:765px;
	box-shadow: 0 0 10px 5px rgba(0, 0, 0, 0.2);
	 left: 0;
    margin: auto;
    max-height: 460px;
    position: absolute;
    right: 0;
    top: 0;
	bottom:0
}

#header {
    background: none repeat scroll 0 0 #2e3f50;
    display: block;
    margin: auto;
    opacity: 0.9;
    padding: 23px 35px;
	color:#fff;
	border-bottom: 7px solid #f06e6c;
}
#header a{
	display:block;
}
#footerForm{
	clear:both;
	height:10px;
	margin:0;
	padding:0;
	background: none repeat scroll 0 0 #2e3f50;
	border-top: 4px solid #f06e6c;
}
h1{
	font-weight:bold;
	margin:15px 0 5px;
	font-size:22px;
	display: inline-block;
    float: right;
}
h4{
	font-weight:bold;
	margin:0px 0 10px;
	font-size:18px;
}

form{
	width:100%;
	padding: 20px 0 15px;
	margin:0;
	background-color: #fff;
}

form #labelresaltado{
	font-size:14px;
	text-align:center;
	display:block;
	margin: 10px 0 30px;
	color: #ff9e08;
    font-weight: bold;
}

form table{
border-collapse:collapse;
border:0px;
border-color:#fff;

}
form table td, form table td#tdtitulogris{
	padding: 10px;
	border:0;

}

form table td#tdtitulogris{
	   text-align: right;
	    background-color: #fff;
		font-size: 14px;
    line-height: 1.1em;
	font-weight:normal;
	width:45%;
}

form table td input,form table td select{
	border: 1px solid #cecece;
    box-sizing: border-box;
    font-size: 12px;
	outline: medium none;
      padding: 5px;
    width: 280px;
}

form table td select{
    width: auto;
	max-width:90%;
}

form table input[type="submit"]{
	background-color: #435262;
    border-color: #555;
    border-radius: 0;
    color: #fff;
    font-size: 15px;
    padding:8px 12px
    text-align: center;
	width:auto;
}

form table input[type="submit"]:hover{
	cursor:pointer;
}

form table input[type="submit"]:focus{
	margin-top:1px;
	margin-left:2px;
}

form table td img{
margin-left:10px;position:relative;top:0;
}
p.title{
	font-weight:normal;
	font-size:18px;
	margin:0 auto 20px;
	text-align:center;
	width:585px;
	padding:0 60px 15px;
	border-bottom: 1px solid #ccc;
	line-height: 1.1em;
}
.center{
text-align:center;
}
td span{
	position:relative;
	top:-6px;
}
</style>
</head>
<body>
<div id="pagina">

<div id="header">
<a href="http://www.uelbosque.edu.co/programas_academicos/educacion_continuada"><img class="logo-educon" alt="" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logo_educon.png"></a>
</div>

<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
<p class="title">Si usted ya hizo el proceso de inscripción y desea hacer su pago online, por favor diligencie los siguientes datos.</p>
	<table border="1" cellpadding="1" cellspacing="0" width="100%">
	<tbody><tr>
				<td id="tdtitulogris">Nombres<label id="labelasterisco">*</label></td>
				<td><input type="text" value="<?php if($cargarCursos){ echo $_POST['nombre']; } ?>" id="nombre" name="nombre">
				</td>
			</tr>
			
			<tr>
				<td id="tdtitulogris">Apellidos<label id="labelasterisco">*</label></td>
				<td><input type="text" value="<?php if($cargarCursos){ echo $_POST['apellido']; } ?>" id="apellido" name="apellido">
				</td>
			</tr>
			
			<tr>
				<td id="tdtitulogris">Numero de Documento<label id="labelasterisco">*</label></td>
				<td><input type="text" value="<?php if($cargarCursos){ echo $_POST['numerodocumento']; } ?>" id="numerodocumento" name="numerodocumento">
				</td>
			</tr>
			 <?php if($cargarCursos&&$carreras!=""&&$alerta===false){ echo $carreras; } else { ?>	 
				<tr>
							  
								<td id="tdtitulogris"><span>Ingrese el contenido de la imagen<label id="labelasterisco">*</label></span> <img src="../mgi/autoevaluacion/interfaz/phpcaptcha/captcha.php"></td>
								
								<td>            
									<input type="text" size="6" maxlength="6" id="captcha" name="captcha" autocomplete="off"></td>          
							</tr>
							
				<tr>
			<?php } ?>
					
				<td colspan="2" class="center">
					<?php if($cargarCursos&&$alerta===false){ ?>
					<input type="submit" value="Ingresar" id="Enviar" name="Enviar">
					<?php } else { ?>
					<input type="submit" value="Cargar cursos" id="Cursos" name="Cursos"><br/><br/>
					<hr/>
					Nota: se recomienda usar navegador Mozilla Firefox 38+ o Internet Explorer 10+
					<?php } ?>
				</td>
			</tr>
	
 </tbody></table>

 </table>
</form>
 <div id="footerForm">
 </div>

 <?php 
	if(isset($_REQUEST['Cursos'])){
		if($_POST['apellido']!=""&&$_POST['numerodocumento']!=""&&$_POST['nombre']!=""&&$alerta==false){
		} else {			
				?>
				<script type="text/javascript">
					<?php if($alerta==false) { ?>
					alert("Todos los campos deben diligenciarse para ingresar.");
					history.go(-1);
					<?php } else {  ?>
					alert("<?php echo $alerta; ?>");
					<?php } ?>
					</script>
				<?php 
		}
	}	

?>
</div>
</body>
</html>

