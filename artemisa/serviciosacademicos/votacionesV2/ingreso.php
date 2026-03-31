<?php
session_start();
$rutaado=("../funciones/adodb/");

require_once("../Connections/salaado-pear.php");
require_once("../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../funciones/sala_genericas/FuncionesCadena.php");
require_once("../funciones/sala_genericas/FuncionesFecha.php");
require_once("../funciones/sala_genericas/FuncionesIngresoNombreTabla.php");
require_once("../funciones/clases/formulario/clase_formulario.php");
require_once("../funciones/sala_genericas/formulariobaseestudiante.php");
unset($_SESSION['tmptipovotante']);
unset($_SESSION['datosvotante']);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Votación <?php echo date("Y"); ?></title>
<link rel="stylesheet" type="text/css" href="../../serviciosacademicos/estilos/sala.css">
<script type="text/javascript" src="../../serviciosacademicos/funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../serviciosacademicos/funciones/calendario_nuevo/calendar-win2k-1.css);
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #EDF0D5;
	font-family: "Source Sans Pro",sans-serif;

}

#pagina{
	width:765px;
	margin: 0 auto;
	background-color: #fff;
	/*border: 1px solid #394528;*/
	box-shadow: 0 0 10px 5px rgba(0, 0, 0, 0.2);
	margin-top:30px;
}

#header {
    background: none repeat scroll 0 0 #394528;
    display: block;
    margin: auto;
    opacity: 0.9;
    padding: 15px 35px 30px;
	color:#fff;
	border-bottom: 7px solid #88ab0c;
}
h1{
	font-weight:bold;
	margin:15px 0 5px;
	font-size:22px;
}
h4{
	font-weight:bold;
	margin:0px 0 10px;
	font-size:18px;
}

form{
	width:100%;
	padding: 20px 0 40px;
}

form #labelresaltado{
	font-size:14px;
	text-align:center;
	display:block;
	margin: 10px 0 30px;
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
		font-size: 12px;
    line-height: 1.1em;
	font-weight:normal;
}

form table td input,form table td select{
	border: 1px solid #cecece;
    box-sizing: border-box;
    font-size: 1em;
	outline: medium none;
      padding: 5px;
    width: 70%;
}

form table input[type="submit"]{
	background-color: #82b440;
	color: #fff;
	border-radius: 4px;
	padding: 5px 20px;
    text-align: center;
	box-shadow: 0 2px 0 #6f9a37;
	border-color:#82b440;
	font-size: 14px;
}

form table input[type="submit"]:hover{
	cursor:pointer;
}

form table input[type="submit"]:focus{
	margin-top:1px;
	margin-left:1px;
}

form table td img{
margin-left:10px;position:relative;top:0;
}

</style>
<script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../serviciosacademicos/funciones/clases/formulario/globo.js"></script>
<script type="text/javascript">
if (document.location.protocol == "https:"){
	var direccion=document.location.href;
	var ssl=(direccion.replace(/https/, "http"));
	document.location.href=ssl;
}
</script>
</head>
<body>
<div id="pagina">

<div id="header">
<img width="310" src="logoU.png" alt="Universidad El Bosque">
<h1>Universidad El Bosque en mejoramiento continuo</h1>
<h4>Tu eres clave. Participa!</h4>
</div>

<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
<?php $formulario->dibujar_fila_titulo('VOTACIONES '.date('Y'),'labelresaltado',"2","align='center'"); ?>
	<table border="1" cellpadding="1" cellspacing="0" width="87%">
<?php 
	
//	$formulario->filatmp["1"]="Egresado";
//	$formulario->filatmp["3"]="Directivo";
//	$formulario->filatmp["2"]="Docente";
	$formulario->filatmp["6"]="Docentes y Administrativos";
//	$formulario->filatmp["4"]="Docentes sin candidato de consejo facultad";
//	$formulario->filatmp["5"]="Docentes Colegio";

//	$formulario->filatmp[""]="Seleccionar";

	$menu="menu_fila"; $parametrosmenu="'idtipovotante','".$_POST['idtipovotante']."',''";
	$formulario->dibujar_campo($menu,$parametrosmenu,"Tipo de votante","tdtitulogris","idtipovotante",'requerido');


	$campo="boton_tipo"; $parametros="'text','nombre','".$_POST['nombre']."',''";
  	$formulario->dibujar_campo($campo,$parametros,"Nombres","tdtitulogris",'nombre','requerido');
	
	$campo="boton_tipo"; $parametros="'text','apellido','".$_POST['apellido']."',''";
  	$formulario->dibujar_campo($campo,$parametros,"Apellidos","tdtitulogris",'apellido','requerido');

	$campo="boton_tipo"; $parametros="'text','numerodocumento','".$_POST['numerodocumento']."',''";
  	$formulario->dibujar_campo($campo,$parametros,"Numero de Documento","tdtitulogris",'numerodocumento','numero');

$conboton=0; ?>
<tr>
                            
                            <td id="tdtitulogris">Ingrese el contenido de la imagen<label id="labelasterisco">*</label> <img src="../mgi/autoevaluacion/interfaz/phpcaptcha/captcha.php"/>  </td>
                            
                            <td>            
                                <input type="text" name="captcha" id="captcha" maxlength="6" size="6"/></td>          
                        </tr>
						<?php 
	$parametrobotonenviar[$conboton]="'submit','Enviar','Ingresar a votar'";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);

	if(isset($_REQUEST['Enviar'])){
		if($formulario->valida_formulario()){
			if ($_POST['captcha'] == $_SESSION['cap_code']) {
		switch($_POST['idtipovotante'])
		{
			case 1:
				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$numerodocumento=$_POST['numerodocumento'];
				$tablanombre="nombresestudiantegeneral";
				$tablaapellido="apellidosestudiantegeneral";
				$tabla="estudiantegeneral t1";

				$condicion .="";

				IngresoNombreTabla($nombre,$apellido,$numerodocumento,$tablanombre,$tablaapellido,$tabla,$condicion,$objetobase);

				$_SESSION['datosvotante']['tipovotante']='egresado';
				$_SESSION['datosvotante']['numerodocumento']=$_POST['numerodocumento'];	
				$_SESSION['datosvotante']['estadovotante']='porfuera';

				$query_sitestudiante="select c.codigomodalidadacademica,c.codigocarrera
					from estudiantegeneral e, estudiante ee, carrera c 
					WHERE e.numerodocumento=$numerodocumento
					AND e.idestudiantegeneral=ee.idestudiantegeneral
					AND ee.codigocarrera=c.codigocarrera AND c.codigomodalidadacademica IN (200,300) 
					AND ee.codigosituacioncarreraestudiante=400
					limit 1 
				UNION select c.codigomodalidadacademica,c.codigocarrera from egresado e, estudiante ee, carrera c 
							where e.numerodocumento=$numerodocumento
							and e.idestudiantegeneral=ee.idestudiantegeneral
							and ee.codigocarrera=c.codigocarrera
							and ee.codigosituacioncarreraestudiante=400
							limit 1";
		                $sitestudiante=$sala->query($query_sitestudiante);
                		$totalRows_sitestudiante = $sitestudiante->RecordCount();
		                $row_sitestudiante=$sitestudiante->fetchRow();
						if(!$row_sitestudiante['codigocarrera']){
							alerta_javascript("Nombre no corresponde con el documento");
							exit();
						}
				$_SESSION['datosvotante']['codigocarrera']=$row_sitestudiante['codigocarrera'];
				$_SESSION['datosvotante']['modalidadacademica']=$row_sitestudiante['codigomodalidadacademica'];	


				$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, 
				v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
						votacion v
						WHERE
						v.codigoestado=100
						and v.idtipocandidatodetalleplantillavotacion=3
						AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
					";
				$operacion_votacion=$sala->query($query_votacion);
				$row_operacion_votacion=$operacion_votacion->fetchRow();
				$idvotacion=$row_operacion_votacion['idvotacion'];
				if(!$idvotacion){
					alerta_javascript("No hay votacion vigente");
					exit();
				}
				$_SESSION['datosvotante']['idvotacion']=$idvotacion;
					
				$query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
				votacion v, votantesvotacion vv
				WHERE
				v.codigoestado='100'
				AND vv.codigoestado='100'
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				AND v.idvotacion=vv.idvotacion
				and v.idvotacion='".$idvotacion."'
				AND vv.numerodocumentovotantesvotacion='".$_POST['numerodocumento']."'
				";
				$operacion_votacion_vigente=$sala->query($query_votacion_vigente);
				$row_operacion_votacion_vigente=$operacion_votacion_vigente->fetchRow();
				$cantVotos=$row_operacion_votacion_vigente['votos'];
				if($cantVotos>0){
					alerta_javascript("Usted ya ha votado, No puede ingresar ");
				}
				else{
					alerta_javascript("Bienvenido a la votación");	
					echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
				}
			break;
			case 2:

				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$numerodocumento=$_POST['numerodocumento'];
				$tablanombre="nombredocente";
				$tablaapellido="apellidodocente";
				$tabla="docente t1";

				$condicion .=" ";

				IngresoNombreTabla($nombre,$apellido,$numerodocumento,$tablanombre,$tablaapellido,$tabla,$condicion,$objetobase);


				$_SESSION['datosvotante']['tipovotante']='docente';
				$_SESSION['datosvotante']['numerodocumento']=$_POST['numerodocumento'];	
				$_SESSION['datosvotante']['estadovotante']='porfuera';
				$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
				votacion v
				WHERE
				v.codigoestado=100
				and v.idtipocandidatodetalleplantillavotacion=1
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				";
				$operacion_votacion=$sala->query($query_votacion);
				$row_operacion_votacion=$operacion_votacion->fetchRow();
				$idvotacion=$row_operacion_votacion['idvotacion'];
				if(!$idvotacion){
					alerta_javascript("No hay votacion vigente");
					exit();
				}
				$_SESSION['datosvotante']['idvotacion']=$idvotacion;
				$query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
				votacion v, votantesvotacion vv
				WHERE
				v.codigoestado='100'
				AND vv.codigoestado='100'
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				AND v.idvotacion=vv.idvotacion
				and v.idvotacion='".$idvotacion."'
				AND vv.numerodocumentovotantesvotacion='".$_POST['numerodocumento']."'
				";
				$operacion_votacion_vigente=$sala->query($query_votacion_vigente);
				$row_operacion_votacion_vigente=$operacion_votacion_vigente->fetchRow();
				$cantVotos=$row_operacion_votacion_vigente['votos'];
				if($cantVotos>0){
					alerta_javascript("Usted ya ha votado, No puede ingresar ");
				}
				else{
					alerta_javascript("Bienvenido a la votación");	
					echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
				}

			break;
			case 3:

				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$numerodocumento=$_POST['numerodocumento'];
				$tablanombre="nombres";
				$tablaapellido="apellidos";
				$tabla="tmpdirectivo t1";

				$condicion .="";

				IngresoNombreTabla($nombre,$apellido,$numerodocumento,$tablanombre,$tablaapellido,$tabla,$condicion,$objetobase);

				$_SESSION['datosvotante']['tipovotante']='directivo';
				$_SESSION['datosvotante']['numerodocumento']=$_POST['numerodocumento'];	
				$_SESSION['datosvotante']['estadovotante']='porfuera';
				$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
				votacion v
				WHERE
				v.codigoestado=100
				and v.idtipocandidatodetalleplantillavotacion=1
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				";
				$operacion_votacion=$sala->query($query_votacion);
				$row_operacion_votacion=$operacion_votacion->fetchRow();
				$idvotacion=$row_operacion_votacion['idvotacion'];
				if(!$idvotacion){
					alerta_javascript("No hay votacion vigente");
					exit();
				}
				$_SESSION['datosvotante']['idvotacion']=$idvotacion;
				$query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
				votacion v, votantesvotacion vv
				WHERE
				v.codigoestado='100'
				AND vv.codigoestado='100'
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				AND v.idvotacion=vv.idvotacion
				and v.idvotacion='".$idvotacion."'
				AND vv.numerodocumentovotantesvotacion='".$_POST['numerodocumento']."'
				";
				$operacion_votacion_vigente=$sala->query($query_votacion_vigente);
				$row_operacion_votacion_vigente=$operacion_votacion_vigente->fetchRow();
				$cantVotos=$row_operacion_votacion_vigente['votos'];
				if($cantVotos>0){
					alerta_javascript("Usted ya ha votado, No puede ingresar ");
				}
				else{
					alerta_javascript("Puede continuar");	
					echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
				}

			break;
			case 4:

				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$numerodocumento=$_POST['numerodocumento'];
				$tablanombre="nombredocente";
				$tablaapellido="apellidodocente";
				$tabla="docente t1";

				$condicion .="";

				IngresoNombreTabla($nombre,$apellido,$numerodocumento,$tablanombre,$tablaapellido,$tabla,$condicion,$objetobase);

				$_SESSION['datosvotante']['tipovotante']='directivo';
				$_SESSION['datosvotante']['numerodocumento']=$_POST['numerodocumento'];	
				$_SESSION['datosvotante']['estadovotante']='porfuera';
				$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
				votacion v
				WHERE
				v.codigoestado=100
				and v.idtipocandidatodetalleplantillavotacion=1
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				";
				$operacion_votacion=$sala->query($query_votacion);
				$row_operacion_votacion=$operacion_votacion->fetchRow();
				$idvotacion=$row_operacion_votacion['idvotacion'];
				if(!$idvotacion){
					alerta_javascript("No hay votacion vigente");
					exit();
				}
				$_SESSION['datosvotante']['idvotacion']=$idvotacion;
				$query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
				votacion v, votantesvotacion vv
				WHERE
				v.codigoestado='100'
				AND vv.codigoestado='100'
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				AND v.idvotacion=vv.idvotacion
				and v.idvotacion='".$idvotacion."'
				AND vv.numerodocumentovotantesvotacion='".$_POST['numerodocumento']."'
				";
				$operacion_votacion_vigente=$sala->query($query_votacion_vigente);
				$row_operacion_votacion_vigente=$operacion_votacion_vigente->fetchRow();
				$cantVotos=$row_operacion_votacion_vigente['votos'];
				if($cantVotos>0){
					alerta_javascript("Usted ya ha votado, No puede ingresar ");
				}
				else{
					alerta_javascript("Puede continuar");	
					echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
				}

			break;
			case 5:

				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$numerodocumento=$_POST['numerodocumento'];
				$tablanombre="nombres";
				$tablaapellido="apellidos";
				$tabla="tmppersonal2010 t1";

				$condicion .=" and a21 LIKE '%docente%' ";

				IngresoNombreTabla($nombre,$apellido,$numerodocumento,$tablanombre,$tablaapellido,$tabla,$condicion,$objetobase);

				$_SESSION['datosvotante']['tipovotante']='directivo';
				$_SESSION['datosvotante']['numerodocumento']=$_POST['numerodocumento'];	
				$_SESSION['datosvotante']['estadovotante']='porfuera';
				$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
				votacion v
				WHERE
				v.codigoestado=100
				and v.idtipocandidatodetalleplantillavotacion=1
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				";
				$operacion_votacion=$sala->query($query_votacion);
				$row_operacion_votacion=$operacion_votacion->fetchRow();
				$idvotacion=$row_operacion_votacion['idvotacion'];
				if(!$idvotacion){
					alerta_javascript("No hay votacion vigente");
					exit();
				}
				$_SESSION['datosvotante']['idvotacion']=$idvotacion;
				$query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
				votacion v, votantesvotacion vv
				WHERE
				v.codigoestado='100'
				AND vv.codigoestado='100'
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				AND v.idvotacion=vv.idvotacion
				and v.idvotacion='".$idvotacion."'
				AND vv.numerodocumentovotantesvotacion='".$_POST['numerodocumento']."'
				";
				$operacion_votacion_vigente=$sala->query($query_votacion_vigente);
				$row_operacion_votacion_vigente=$operacion_votacion_vigente->fetchRow();
				$cantVotos=$row_operacion_votacion_vigente['votos'];
				if($cantVotos>0){
					alerta_javascript("Usted ya ha votado, No puede ingresar ");
				}
				else{
					alerta_javascript("Bienvenido a la votación");	
					echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
				}

			break;
			case 6:

				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$numerodocumento=$_POST['numerodocumento'];
				$tablanombre="nombres";
				$tablaapellido="apellidos";
				$tabla="tmp_docenteadministrativo t1";

				$condicion .="";

				IngresoNombreTabla($nombre,$apellido,$numerodocumento,$tablanombre,$tablaapellido,$tabla,$condicion,$objetobase);

				$_SESSION['datosvotante']['tipovotante']='directivo';
				$_SESSION['datosvotante']['numerodocumento']=$_POST['numerodocumento'];	
				$_SESSION['datosvotante']['estadovotante']='porfuera';
				$query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion FROM
				votacion v
				WHERE
				v.codigoestado=100
				and v.idtipocandidatodetalleplantillavotacion=1
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				";
				$operacion_votacion=$sala->query($query_votacion);
				$row_operacion_votacion=$operacion_votacion->fetchRow();
				$idvotacion=$row_operacion_votacion['idvotacion'];
				if(!$idvotacion){
					alerta_javascript("No hay votacion vigente");
					exit();
				}
				$_SESSION['datosvotante']['idvotacion']=$idvotacion;
				$query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
				votacion v, votantesvotacion vv
				WHERE
				v.codigoestado='100'
				AND vv.codigoestado='100'
				AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
				AND v.idvotacion=vv.idvotacion
				and v.idvotacion='".$idvotacion."'
				AND vv.numerodocumentovotantesvotacion='".$_POST['numerodocumento']."'
				";
				$operacion_votacion_vigente=$sala->query($query_votacion_vigente);
				$row_operacion_votacion_vigente=$operacion_votacion_vigente->fetchRow();
				$cantVotos=$row_operacion_votacion_vigente['votos'];
				if($cantVotos>0){
					alerta_javascript("Usted ya ha votado, No puede ingresar ");
				}
				else{
					alerta_javascript("Bienvenido a la votación");	
					echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
				}
			break;

		}
		
			}else {					
				?>
				<script type="text/javascript">
					alert("Verifique que los datos ingresados sean igual a la imagen en pantalla");
					history.go(-1);
					</script>
				<?php 
			}
		} 
	}

?>

 </table>
</form>

</div>
	<script languaje='javascript'>
		//alert('Votaciones Cerradas...gracias');
		//window.location.href = "http://www.uelbosque.edu.co"; 
	</script>
</body>
</html>

