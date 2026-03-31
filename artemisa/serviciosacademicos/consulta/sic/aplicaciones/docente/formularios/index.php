<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
<!--
 * Caso 96114.
 * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
 * Se modifican las rutas de las librerias css y js porque esta bloqueado el uso directo de internet.
 * @since Enero 18, 2018.
-->
		<meta charset="utf-8">
		<title>:: Hoja de vida - Docentes ::</title>
		<script type="text/javascript" src="../../../../../../assets/js/jquery.js"></script>
		<script type="text/javascript" src="../../../../../../assets/js/jquery-ui.js"></script>   
        <script type="text/javascript" src="../../../../../../assets/js/jquery.validate.min.js"></script>   
        
        <link rel="stylesheet" type="text/css" media="screen" href="../../../../../../assets/css/css_menu.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../../../../../../assets/css/css_form.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../../../../../../assets/css/css_table.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../../../../../../assets/css/jquery-ui-git.css"/>   
<!--End Caso 96114-->        
		<script>
			$().ready(function() {
				$("#forma").validate({
					submitHandler: function(form) {
							$.ajax({
								type: 'POST',
								url: 'informacionGeneralDocenteSave.php',
								async: false,
								data: $('#forma').serialize(),                
								success:function(data){
									$('#resultado').html(data);
								},
								error: function(data,error,errorThrown){alert(error + errorThrown);}
							});
					}
				});
			});
		</script>
	</head>
	<body>
<?php
		include_once("includes/connection.php");
		$db =& connection::getInstance();
		include_once("includes/objetosHTML.php");
		$obj = New objetosHTML;
		include_once("includes/menu.php");
?>
		<form class="cmxform" id="forma" name="forma" method="post" action="">
<?php
			$docConsulta=(isset($_SESSION["sissic_numerodocumentodocente"]))?$_SESSION["sissic_numerodocumentodocente"]:$_SESSION["codigodocente"];
			$res=$db->exec("select iddocente from docente where numerodocumento='".$docConsulta."'");
			$row=mysql_fetch_array($res);
			$_SESSION["sissic_iddocente"]=$row["iddocente"];
			if(!isset($_SESSION["codigoperiodosesion"])) {
				$res=$db->exec("select codigoperiodo from periodo where codigoestadoperiodo=1");
				$row=mysql_fetch_array($res);
				$_SESSION["codigoperiodosesion"]=$row["codigoperiodo"];
			}

			if(!isset($_REQUEST["opc"]))
				include_once("informacion_general_docente/bienvenida.php");

			if($_REQUEST["opc"]=="ip")
				include_once("informacion_general_docente/informacionPersonal.php");
			if($_REQUEST["opc"]=="dp")
				include_once("informacion_general_docente/desarrolloProfesoral.php");
			if($_REQUEST["opc"]=="hlu")
				include_once("informacion_general_docente/historiaLaboralUnbosque.php");
			if($_REQUEST["opc"]=="pu")
				include_once("informacion_general_docente/participacionUniversitaria.php");

			if($_REQUEST["opc"]=="alud")
				include_once("informacion_general_docente/actividadLaboralUniversidad_docencia.php");
			if($_REQUEST["opc"]=="aluli")
				include_once("informacion_general_docente/actividadLaboralUniversidad_lineasInvestigacion.php");
			if($_REQUEST["opc"]=="alupsoagaa")
				include_once("informacion_general_docente/actividadLaboralUniversidad_proySocialOrienAcademGestAcademAdmin.php");

			if($_REQUEST["opc"]=="fafddi")
				include_once("informacion_general_docente/formacionAcademica_formacionDisciplinarDocenciaInvestigacion.php");
			if($_REQUEST["opc"]=="fafgi")
				include_once("informacion_general_docente/formacionAcademica_formacionGeneral_idioma.php");
			if($_REQUEST["opc"]=="fafgmt")
				include_once("informacion_general_docente/formacionAcademica_formacionGeneral_manejoTics.php");

			if($_REQUEST["opc"]=="el")
				include_once("informacion_general_docente/experienciaLaboral.php");
			if($_REQUEST["opc"]=="pa")
				include_once("informacion_general_docente/produccionAcademica.php");
			if($_REQUEST["opc"]=="e")
				include_once("informacion_general_docente/estimulos.php");
			if($_REQUEST["opc"]=="r")
				include_once("informacion_general_docente/reconocimientos.php");
			if($_REQUEST["opc"]=="ga")
				include_once("informacion_general_docente/gruposAcademicos.php");

			if($_REQUEST["opc"]=="prev")
				include_once("previsualizacion/previsualizacion.php");
?>
		</form>
	</body>
</html>
