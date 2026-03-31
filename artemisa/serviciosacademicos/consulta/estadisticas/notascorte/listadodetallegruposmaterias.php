<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if($_REQUEST['Div']==0){
?>

<div id="DivReporte" align="center" style="overflow:scroll;width:100%; height:600; overflow-x:scroll;" >
<?PHP
}
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
	document.location.href="<?php echo 'listadonotascorte.php';?>";
}
function regresarGET()
{
	document.location.href="<?php echo 'listadonotascorte.php';?>";
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
require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

function encuentra_array_materias($codigomateria,$codigocarrera,$codigocarrerad,$codigoperiodo,$objetobase,$imprimir=0){
 
 
if($codigocarrerad!="")
$carreradestino="AND e.codigocarrera='".$codigocarrerad."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino="AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino="";


$select="select distinct  e.codigoestudiante from ordenpago o, detalleordenpago d, concepto co,estudiante e
 where o.numeroordenpago=d.numeroordenpago  and
  e.codigoestudiante=o.codigoestudiante AND
  d.codigoconcepto=co.codigoconcepto AND
  co.cuentaoperacionprincipal=151 
  AND o.codigoperiodo='".$codigoperiodo."' AND o.codigoestadoordenpago LIKE '4%'";  
 
 $condicion=" m.codigocarrera='".$codigocarrera."'
		and eg.idestudiantegeneral=e.idestudiantegeneral
		AND g.codigomateria=m.codigomateria 
		AND g.codigoperiodo='".$codigoperiodo."'
		AND g.codigoestadogrupo like '1%'
		and d.numerodocumento=g.numerodocumento
		and dn.idgrupo=g.idgrupo
		and dn.codigoestudiante=e.codigoestudiante
		and co.idcorte=dn.idcorte 
		and cm.codigocarrera=m.codigocarrera
		$materiadestino
		GROUP by m.codigomateria,g.idgrupo
		order by cm.nombrecarrera,m.nombremateria";
		
$conteo="
		,count(distinct e.codigoestudiante) Total_Alumnos,
		 count(distinct d1.codigoestudiante) Perdieron_Corte1,
		CONCAT((ROUND((count(distinct d1.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte1',
		count(distinct d2.codigoestudiante) Perdieron_Corte2,
		CONCAT((ROUND((count(distinct d2.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte2',
		
		count(distinct d3.codigoestudiante) Perdieron_Corte3,
		CONCAT((ROUND((count(distinct d3.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte3',
		
		count(distinct d4.codigoestudiante) Perdieron_Corte4,
		CONCAT((ROUND((count(distinct d4.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte4',		
		count(distinct h.codigoestudiante) Perdieron_Definitiva,
		CONCAT((ROUND((count(distinct h.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_definitiva'
		";
		
$leftjoin="	left join detallenota d1 on 
	d1.codigoestudiante=dn.codigoestudiante and
	d1.idgrupo=dn.idgrupo and
	d1.idcorte in (select idcorte from corte c1 where numerocorte=1 and c1.idcorte=co.idcorte) and
	ROUND(d1.nota,1) < (select notaminimaaprobatoria from materia m1 where m1.codigomateria=d1.codigomateria)

	left join detallenota d2 on 
	d2.codigoestudiante=dn.codigoestudiante and
	d2.idgrupo=dn.idgrupo and
	d2.idcorte in (select idcorte from corte c2 where numerocorte=2 and c2.idcorte=co.idcorte) and
	ROUND(d2.nota,1) < (select notaminimaaprobatoria from materia m2 where m2.codigomateria=d2.codigomateria)

	left join detallenota d3 on 
	d3.codigoestudiante=dn.codigoestudiante and
	d3.idgrupo=dn.idgrupo and
	d3.idcorte = (select idcorte from corte c3 where numerocorte=3 and c3.idcorte=co.idcorte) and
	ROUND(d3.nota,1) < (select notaminimaaprobatoria from materia m3 where m3.codigomateria=d3.codigomateria)
	
	left join detallenota d4 on 
	d4.codigoestudiante=dn.codigoestudiante and
	d4.idgrupo=dn.idgrupo and
	d4.idcorte = (select idcorte from corte c3 where numerocorte=4 and c3.idcorte=co.idcorte) and
	ROUND(d4.nota,1) < (select notaminimaaprobatoria from materia m4 where m4.codigomateria=d4.codigomateria)

	left join notahistorico h on 
	h.codigoestudiante=dn.codigoestudiante and
	h.idgrupo=dn.idgrupo and
	ROUND(h.notadefinitiva,1) < (select notaminimaaprobatoria from materia m5 where m5.codigomateria=h.codigomateria)";
	
$tablas="estudiante e, estudiantegeneral eg, materia m,grupo g,
		docente d, carrera cm,corte co,detallenota dn";
$query="select cm.codigocarrera,cm.nombrecarrera Carrera_Materia,m.codigomateria,m.nombremateria Materia,
		g.idgrupo, g.nombregrupo Grupo,d.numerodocumento Documento_Docente,
		d.apellidodocente Apellido_Docente,d.nombredocente Nombre_Docente ".$conteo." from 
		".$tablas." ".$leftjoin." where ".$condicion."";
				 
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


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriafacultadesmateriadetalle']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriafacultadesmateriadetalle']=$_REQUEST['codigomateria'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrerafacultadesmateriadetalle']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarrerafacultadesmateriadetalle']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigocarrerad']!=$_SESSION['codigocarreradfacultadesmateriadetalle']&&(trim($_REQUEST['codigocarrerad'])!=''))
$_SESSION['codigocarreradfacultadesmateriadetalle']=$_REQUEST['codigocarrerad'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododfacultadesmateriadetalle']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododfacultadesmateriadetalle']=$_REQUEST['codigoperiodo'];



/*if($_POST['codigocarrera']=="todos"){
$filacarreras=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera","codigofacultad='".$codigofacultad."'");
	$i=0;
	foreach($filacarreras as $codigocarrera => $nombrecarrera){

		if($i!=0){
		$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
		$cantidadestmparray=encuentra_array_materias($_GET['codigomateria'],$_GET['codigocarrera'],$_GET['codigocarrerad'],$_GET['codigoperiodo'],$objetobase,$imprimir=0);
		
			echo "<BR>MATERIAS<pre>";
			print_r($materiastmparray);
			echo "</pre>";

			if(is_array($materiastmparray))
				$arraymaterias=InsertaVectorFinal($arraymaterias,$materiastmparray);
			else
				$arraymaterias=$materiastmparray;

			
		}
		else{
			$arraymaterias=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,1);
			echo "<BR>MATERIAS<pre>";
			print_r($arraymaterias);
			echo "</pre>";
		}
		
		$i++;
	}

}
else{
	//$filacarreras[$_POST['codigocarrera']]="";
	$arraymaterias=encuentra_array_materias($_POST['codigocarrera'],$_POST['periodo'],$objetobase);
}*/

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigocarrerafacultadesmateriadetalle'],"","",0);
echo "<table width='100%'><tr><td align='center'><h3>LISTADO NOTAS PERDIDAS POR CORTE Y MATERIA  ".$datoscarrera["nombrecarrera"]." PERIODO ".$_SESSION['codigoperiododfacultadesmateriadetalle']."</h3></td></tr></table>";

$cantidadestmparray=encuentra_array_materias($_SESSION['codigomateriafacultadesmateriadetalle'],$_SESSION['codigocarrerafacultadesmateriadetalle'],$_SESSION['codigocarreradfacultadesmateriadetalle'],$_SESSION['codigoperiododfacultadesmateriadetalle'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($cantidadestmparray,"HISTORIAL LINEA ENFASIS ","listadodetallefacultadesmaterias.php",'si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('Total_Alumnos','listadodetallegruposmaterias.php','listadodetallenotascortes.php','','idgrupo',"&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte1','listadodetallegruposmaterias.php','listadodetallenotascortes.php','','idgrupo',"&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=1",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte2','listadodetallegruposmaterias.php','listadodetallenotascortes.php','','idgrupo',"&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=2",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte3','listadodetallegruposmaterias.php','listadodetallenotascortes.php','','idgrupo',"&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=3",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte4','listadodetallegruposmaterias.php','listadodetallenotascortes.php','','idgrupo',"&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=4",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Definitiva','listadodetallegruposmaterias.php','listadodetallenotascortes.php','','idgrupo',"&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=5",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');

$motor->agregar_llaves_totales('Total_Alumnos',"listadodetallegruposmaterias.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomateriafacultadesmateriadetalle']."&codigocarrera=".$_SESSION['codigocarreradfacultadesmateriadetalle']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=0","","","Totales");
$motor->agregar_llaves_totales('Perdieron_Corte1',"listadodetallegruposmaterias.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomateriafacultadesmateriadetalle']."&codigocarrera=".$_SESSION['codigocarreradfacultadesmateriadetalle']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=1","","","Totales");
$motor->agregar_llaves_totales('Perdieron_Corte2',"listadodetallegruposmaterias.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomateriafacultadesmateriadetalle']."&codigocarrera=".$_SESSION['codigocarreradfacultadesmateriadetalle']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=2","","","Totales");
$motor->agregar_llaves_totales('Perdieron_Corte3',"listadodetallegruposmaterias.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomateriafacultadesmateriadetalle']."&codigocarrera=".$_SESSION['codigocarreradfacultadesmateriadetalle']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=3","","","Totales");
$motor->agregar_llaves_totales('Perdieron_Corte4',"listadodetallegruposmaterias.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomateriafacultadesmateriadetalle']."&codigocarrera=".$_SESSION['codigocarreradfacultadesmateriadetalle']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=4","","","Totales");
$motor->agregar_llaves_totales('Perdieron_Definitiva',"listadodetallegruposmaterias.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomateriafacultadesmateriadetalle']."&codigocarrera=".$_SESSION['codigocarreradfacultadesmateriadetalle']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateriadetalle']."&columna=5","","","Totales");

$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
if($_REQUEST['Div']=0){
?>
</div>
<?PHP 
}
?>
