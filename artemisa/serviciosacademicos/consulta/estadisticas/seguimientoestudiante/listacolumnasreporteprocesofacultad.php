<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<html>
<body>
<title>Servicios Academicos</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body marginheight="0" marginwidth="0">
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750' align='left'>";
		$fila["<b>INS_RAD</b>: INSCRITOS RADICADOS. Son los inscritos que una vez pagada su derecho de inscripción, radican en la facultad su documentación"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["<b>INS_REG</b>: INSCRITOS REGISTRADOS. Son los inscritos procesados de pagos realizados y registrados por  Credito y Cartera"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["<b>TOTAL_INS</b>: TOTAL INSCRITOS. Total inscripciones radicadas en facultad o registradas por Credito y  Cartera"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>FAL_RAD_INS</b>: FALTANTES EN INSCRITOS RADICADOS. Inscritos faltantes por radicar en la facultad (Responsable Facultad)"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["<b>FAL_REG_INS</b>: FALTANTES EN INSCRITOS REGISTRADOS. Inscritos faltantes por registrar en Credito y Cartera (Responsable Credito y Cartera)"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["<b>INSCRITOS</b>: INSCRITOS. Son las coincidencias de inscripciones de los radicados en las Facultades y el registro realizado por Credito y Cartera."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		

/***MATRICULADOS NUEVOS***/
		unset($fila);
		$fila["<b>MAT_NU_RAD</b>: MATRICULADOS NUEVOS RADICADOS. Son los matriculados nuevos que una vez pagada su derecho de matrícula, radican en al facultad su documentación."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>MAT_NU_REG</b>: MATRICULADOS NUEVOS REGISTRADOS. Son los matriculados nuevos procesados de pagos realizados y matrícula por  Credito y Cartera."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>TOTAL_MAT_NU</b>: TOTAL MATRICULADOS NUEVOS .Total matriculas nuevas radicadas en Facultad o registradas por Credito y  Cartera."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>FAL_MAT_NU_REG</b>: FALTANTES EN MATRICULADOS NUEVOS REGISTRADOS .Matriculados nuevos faltantes por registrar en Credito y Cartera (Responsable Credito y Cartera)."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>FAL_MAT_NU_RAD</b>: FALTANTES EN MATRICULADOS NUEVOS RADICADOS. matriculados nuevos faltantes por radicar en la facultad (Responsable Facultad)"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>MAT NUEVO</b>: MATRICULADOS. NUEVOS. Son las coincidencias de matriculados nuevos de los radicados en las Facultades y el registro realizado por Credito y Cartera."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

/***MATRICULADOS ANTIGUOS***/
		unset($fila);
		$fila["<b>MAT_ANT_RAD</b>: MATRICULADOS ANTIGUOS RADICADOS. Son los matriculados antiguos que una vez pagada su derecho de matrícula, radican en al facultad su documentación."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>MAT_ANT_REG</b>: MATRICULADOS ANTIGUOS REGISTRADOS. Son los matriculados antiguos procesados de pagos realizados y matrícula por  Credito y Cartera."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>TOTAL_MAT_ANT</b>: TOTAL MATRICULADOS ANTIGUOS .Total matriculas antiguos radicadas en Facultad o registradas por Credito y  Cartera."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>FAL_MAT_ANT_REG</b>: FALTANTES EN MATRICULADOS ANTIGUOS REGISTRADOS .Matriculados antiguos faltantes por registrar en Credito y Cartera (Responsable Credito y Cartera)."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>FAL_MAT_ANT_RAD</b>: FALTANTES EN MATRICULADOS ANTIGUOS RADICADOS. matriculados antiguos faltantes por radicar en la facultad (Responsable Facultad)"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>MAT_ANTIGUO</b>: MATRICULADOS ANTIGUOS. Son las coincidencias de matriculados antiguos de los radicados en las Facultades y el registro realizado por Credito y Cartera"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);


/***MATRICULADOS***/
		unset($fila);
		$fila["<b>MAT_RAD</b>: MATRICULADOS RADICADOS. Son los matriculados que una vez pagada su derecho de matrícula, radican en al facultad su documentación"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["<b>MAT_REG</b>: MATRICULADOS REGISTRADOS. Son los matriculados procesados de pagos realizados y matrícula por  Credito y Cartera"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		
		unset($fila);
		$fila["<b>TOTAL_MAT</b>: TOTAL MATRICULADOS. Total matriculas radicadas en Facultad o registradas por Credito y  Cartera"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);

		unset($fila);
		$fila["<b>FAL_RAD_MAT</b>: FALTANTES EN MATRICULADOS RADICADOS. matriculados faltantes por radicar en la facultad (Responsable Facultad)"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["<b>FAL_REG_MAT</b>: FALTANTES EN MATRICULADOS REGISTRADOS. matriculados faltantes por registrar en Credito y Cartera (Responsable Credito y Cartera)"]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["<b>MATRICULADOS</b>: MATRICULADOS. Son las coincidencias de matriculados de los radicados en las Facultades y el registro realizado por Credito y Cartera."]="";
		$formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);



echo "</table>";
?>

</body>
</head>
</html>
