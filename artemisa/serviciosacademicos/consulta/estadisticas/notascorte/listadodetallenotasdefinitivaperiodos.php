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
	document.location.href="<?php echo 'listadonotasdefinitivaperiodos.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'listadonotasdefinitivaperiodos.php';?>";
}

</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

function encuentra_array_materias($codigomateria,$codigocarrera,$codigomodalidadacademica,$periodoinicial,$periodofinal,$columna,$objetobase,$imprimir=0){
 
 
if($codigocarrerad!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino="AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino="";

/* if($columna){
$numerocorte="and co.numerocorte='".$columna."' ";
$condicionnotaaprobada="and ROUND(d.nota,1) < m.notaminimaaprobatoria";
}
else{
$condicionnotaaprobada="";
$numerocorte="";
}
 */
if($columna==5){
$condicionnotaaprobada="and ROUND(h.notadefinitiva,1) < m.notaminimaaprobatoria";
$numerocorte="";
}
else{
$condicionnotaaprobada="";
$numerocorte="";
}
/*
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Se modifica la consulta para que muestre los datos del docente "cedula, nombres y apellidos" de acuerdo solicitud
 * por Registro y Control
 * Caso Número 86716
 * @since  Febrary 1, 2017
*/  
    
$query="select e.codigoestudiante,e.codigocarrera, ce.nombrecarrera Carrera_Origen,
    e.semestre Semestre_Actual,eg.numerodocumento,eg.apellidosestudiantegeneral,
    eg.nombresestudiantegeneral,c.nombrecarrera,co.numerocorte,g.codigoperiodo,m.nombremateria,
    d1.nota corte1,
    d2.nota corte2,
    d3.nota corte3,
    d4.nota corte4,
    h.notadefinitiva definitiva,
    g.numerodocumento AS Documento_Docente,
    docente.nombredocente AS Nombre_Docente,
    docente.apellidodocente AS Apellidos_Docente
 FROM 
 docente, estudiante e,grupo g, materia m, corte co, carrera c, carrera ce, estudiantegeneral eg,detallenota d

	left join detallenota d1 on 
	d1.codigoestudiante=d.codigoestudiante and
	d1.idgrupo=d.idgrupo and
	d1.idcorte in (select idcorte from corte c1 where numerocorte=1 and (c1.codigocarrera=
	c.codigocarrera or c1.usuario=c.codigocarrera))
	and d1.codigomateria=d.codigomateria

	left join detallenota d2 on 
	d2.codigoestudiante=d.codigoestudiante and
	d2.idgrupo=d.idgrupo and
	d2.idcorte in (select idcorte from corte c2 where numerocorte=2 and (c2.codigocarrera=
	c.codigocarrera or c2.usuario=c.codigocarrera)) and
	d2.codigomateria=d.codigomateria

	left join detallenota d3 on 
	d3.codigoestudiante=d.codigoestudiante and
	d3.idgrupo=d.idgrupo and
	d3.idcorte in (select idcorte from corte c3 where numerocorte=3 and (c3.codigocarrera=
	c.codigocarrera or c3.usuario=c.codigocarrera)) and
	d3.codigomateria=d.codigomateria


	left join detallenota d4 on 
	d4.codigoestudiante=d.codigoestudiante and
	d4.idgrupo=d.idgrupo and
	d4.idcorte in (select idcorte from corte c4 where numerocorte=4 and (c4.codigocarrera=
	c.codigocarrera or c4.usuario=c.codigocarrera)) and
	d4.codigomateria=d.codigomateria
	
	left join notahistorico h on 
	h.codigoestudiante=d.codigoestudiante and
	h.idgrupo=d.idgrupo and
	h.codigomateria=d.codigomateria 

WHERE 
    d.idgrupo=g.idgrupo and
    g.codigomateria=m.codigomateria and
    d.codigoestudiante=e.codigoestudiante and 
    m.codigocarrera=c.codigocarrera and 
    co.idcorte=d.idcorte and
    ce.codigocarrera=e.codigocarrera and
    (g.codigoperiodo between ".$periodoinicial." and ".$periodofinal.")
    ".$carreradestino."
    ".$materiadestino."
    ".$numerocorte."
    and docente.numerodocumento = g.numerodocumento
    and eg.idestudiantegeneral=e.idestudiantegeneral
    ".$condicionnotaaprobada."
    group by m.codigomateria,e.codigoestudiante,g.codigoperiodo
    order by g.codigoperiodo,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
    ";
	//End caso 86716
 	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


if(isset($_POST['codigocarrera'])&&($_POST['codigocarrera']!=''))
$codigofacultad="05";



unset($filacarreras);


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriadetalledefinitivaperiodo']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriadetalledefinitivaperiodo']=$_REQUEST['codigomateria'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreradetalledefinitivaperiodo']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreradetalledefinitivaperiodo']=$_REQUEST['codigocarrera'];

if($_REQUEST['columna']!=$_SESSION['columnadetalledefinitivaperiodo']&&(trim($_REQUEST['columna'])!=''))
$_SESSION['columnadetalledefinitivaperiodo']=$_REQUEST['columna'];

if($_REQUEST['periodoinicial']!=$_SESSION['periodoinicialdetalledefinitivaperiodo']&&(trim($_REQUEST['periodoinicial'])!=''))
$_SESSION['periodoinicialdetalledefinitivaperiodo']=$_REQUEST['periodoinicial'];

if($_REQUEST['periodofinal']!=$_SESSION['periodofinaldetalledefinitivaperiodo']&&(trim($_REQUEST['periodofinal'])!=''))
$_SESSION['periodofinaldetalledefinitivaperiodo']=$_REQUEST['periodofinal'];


$cantidadestmparray=encuentra_array_materias($_SESSION['codigomateriadetalledefinitivaperiodo'],$_SESSION['codigocarreradetalledefinitivaperiodo'],$_SESSION['codigomodalidadacademicanotascorte'],$_SESSION['periodoinicialdetalledefinitivaperiodo'],$_SESSION['periodofinaldetalledefinitivaperiodo'],$_SESSION['columnadetalledefinitivaperiodo'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
if($_SESSION['columnadetalledefinitivaperiodo']==5)
$detalleencabezado="ESTUDIANTES QUE PERDIERON";
else
$detalleencabezado="";

$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['codigocarreradetalledefinitivaperiodo'],"","",0);
$datosmateria=$objetobase->recuperar_datos_tabla("materia","codigomateria",$_SESSION['codigomateriadetalledefinitivaperiodo'],"","",0);

echo "<table><tr><td><h3>DETALLE HISTORICO DE NOTAS ".$detalleencabezado." ".$datosmateria["nombremateria"]." ".$datoscarrera["nombrecarrera"]." POR PERIODOS ".$_SESSION['periodoinicialdetalledefinitivaperiodo']." AL ".$_SESSION['periodofinaldetalledefinitivaperiodo']."</h3></td></tr></table>";

//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($cantidadestmparray,"HISTORIAL LINEA ENFASIS ","listadodetallenotasdefinitivaperiodos.php",'si','si','listadonotascorte.php','listadogeneral.php',true,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
/* $motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);
 */
$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
