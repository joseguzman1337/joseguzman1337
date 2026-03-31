<?php 
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo 'menucreditosestudiantes.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'menucreditosestudiantes.php';?>";
}
function enviarmenu()
{
	form1.action="";
	form1.submit();
}
</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/clases/autenticacion/redirect.php' );

if($_POST['codigoperiodo']!=$_SESSION['codigoperiodocreditosestudiantes']&&(trim($_POST['codigoperiodo'])!=''))
$_SESSION['codigoperiodocreditosestudiantes']=$_POST['codigoperiodo'];

if($_POST['codigotipomateria']!=$_SESSION['codigotipomateriacreditosestudiantes']&&(trim($_POST['codigotipomateria'])!=''))
$_SESSION['codigotipomateriacreditosestudiantes']=$_POST['codigotipomateria'];

if($_POST['codigocarrera']!=$_SESSION['codigocarreracreditosestudiantes']&&(trim($_POST['codigocarrera'])!=''))
$_SESSION['codigocarreracreditosestudiantes']=$_POST['codigocarrera'];

$objetobase=new BaseDeDatosGeneral($sala);
$codigos="	(select distinct e.codigoestudiante 
	from ordenpago o, detalleordenpago d, concepto co,estudiante e 
	where o.numeroordenpago=d.numeroordenpago 
	and e.codigoestudiante=o.codigoestudiante 
	AND d.codigoconcepto=co.codigoconcepto 
	AND co.cuentaoperacionprincipal=151 
	AND o.codigoperiodo='".$_SESSION['codigoperiodocreditosestudiantes']."'
	AND o.codigoestadoordenpago LIKE '4%')";

$query="select e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
 SUM(d.numerocreditosdetalleplanestudio) numerocreditosdetalleplanestudio,p.idplanestudio
from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t,
carrera c, estudiante e, estudiantegeneral eg
where
 p.codigoestudiante = e.codigoestudiante
and p.idplanestudio = d.idplanestudio
and p.codigoestadoplanestudioestudiante like '1%'
and d.codigoestadodetalleplanestudio like '1%'
and d.codigomateria = m.codigomateria
and d.codigotipomateria = t.codigotipomateria
and t.codigotipomateria = '".$_SESSION['codigotipomateriacreditosestudiantes']."'
and e.idestudiantegeneral = eg.idestudiantegeneral
and c.codigocarrera=e.codigocarrera
and c.codigocarrera='".$_SESSION['codigocarreracreditosestudiantes']."'
and e.codigoestudiante in $codigos
group by e.codigoestudiante
order by eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";

$operacion=$sala->query($query);
//$row_operacion=$operacion->fetchRow();
while ($row_operacion=$operacion->fetchRow())
{
	$estudianteplanestudio[$row_operacion['codigoestudiante']]['numerocreditos']=$row_operacion['numerocreditosdetalleplanestudio'];
	$estudianteplanestudio[$row_operacion['codigoestudiante']]['idplanestudio']=$row_operacion['idplanestudio'];
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}


//$codigos="10318";
$query="select e.codigoperiodo Periodo_Ingreso,e.codigoestudiante,e.semestre,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
 sum(m.numerocreditos) Creditos_Cursados 
 from  carrera c,  estudiantegeneral eg,estudiante e
LEFT JOIN notahistorico n ON e.codigoestudiante=n.codigoestudiante and n.codigotipomateria = '".$_SESSION['codigotipomateriacreditosestudiantes']."'
LEFT JOIN materia m ON  n.codigomateria = m.codigomateria and m.notaminimaaprobatoria <= n.notadefinitiva 
where
e.idestudiantegeneral = eg.idestudiantegeneral
and c.codigocarrera=e.codigocarrera
and c.codigocarrera='".$_SESSION['codigocarreracreditosestudiantes']."'
and e.codigoestudiante in $codigos 
group by e.codigoestudiante
order by eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";
$operacion=$sala->query($query);
//$row_operacion=$operacion->fetchRow();
while ($row_operacion=$operacion->fetchRow())
{
	$row_operacion['Requisitos_Creditos_Planestudio']=$estudianteplanestudio[$row_operacion['codigoestudiante']]['numerocreditos'];
	//$arrayequivalencias=seleccionarequivalencias($codigomateria, $estudianteplanestudio[$row_operacion['codigoestudiante']]['idplanestudio'], $objetobase)
	if($row_operacion['Creditos_Cursados']<=$estudianteplanestudio[$row_operacion['codigoestudiante']]['numerocreditos'])
		$row_operacion['Creditos_Planestudio_Por_Cursar']=$estudianteplanestudio[$row_operacion['codigoestudiante']]['numerocreditos'] - $row_operacion['Creditos_Cursados'];
	else
		$row_operacion['Creditos_Planestudio_Por_Cursar']="0";	
	$array_interno[]=$row_operacion;
	
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"CREDITOS ESTUDIANTES","listadofacultadesmaterias.php?",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('iddetalleproceso','listadodetalleproceso.php','detalleproceso.php','','iddetalleproceso',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->mostrar();
?>