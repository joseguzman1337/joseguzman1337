<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
include('../../../men/templates/MenuReportes.php');
if($_REQUEST['Div']==0){	
?>
<div id="DivReporte" align="center" ><!-- style="overflow:scroll;width:100%; height:600; overflow-x:scroll;"-->
<style type="text/css" title="currentStyle">
                @import "data/media/css/demo_page.css";
                @import "data/media/css/demo_table_jui.css";
                /*@import "data/media/css/themes/le-frog/jquery-ui-1.9.2.custom.css";*/
                @import "data/media/css/ColVis.css";
                @import "data/media/css/TableTools.css";
                
    </style>
    <script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
<script>
$(document).ready( function () {
			
	oTable = $('#xxxx').dataTable({
					"sDom": '<"H"Cfrltip>',
					"bJQueryUI": true,
					"bPaginate": true,
					"sPaginationType": "full_numbers",
					"oColVis": {
						  "buttonText": "Ver/Ocultar Columns",
						   "aiExclude": [ 0 ]
					}
				});
				
		} );	

function exportar(url){
	location.href=url+"&export=y";
}
</script>
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
	document.location.href="<?php echo $_GET['link_origen'];?>";

}
function regresarGET()
{
	document.location.href="<?php echo $_GET['link_origen'];?>";
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

function encuentra_array_materias($codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$columna,$idgrupo,$objetobase,$imprimir=0){
 
 
if($codigocarrerad!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if(trim($idgrupo)!=""){
$materiadestino="and g.idgrupo='".$idgrupo."'
				 and  m.codigomateria=g.codigomateria";
}
else{
	if($codigomateria!="todos")
		$materiadestino="AND m.codigomateria='".$codigomateria."'";
	else
		$materiadestino="";
}
if($columna){
$numerocorte="and co.numerocorte='".$columna."' ";
$condicionnotaaprobada="and ROUND(d.nota,1) < m.notaminimaaprobatoria";
}
else{
$condicionnotaaprobada="";
$numerocorte="";
}

if($columna==5){
$condicionnotaaprobada="and ROUND(h.notadefinitiva,1) < m.notaminimaaprobatoria";
$numerocorte="";
}


/* QUERY ANTIGUO CON PROBLEMAS PARA DEP FISICA, DEP QUIMICA


$query="select e.codigoestudiante,
e.codigocarrera, 
ce.nombrecarrera Carrera_Origen,
g.nombregrupo Grupo,
e.semestre Semestre_Actual,eg.numerodocumento,
eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
c.nombrecarrera,co.numerocorte,m.nombremateria,d1.nota corte1,
d2.nota corte2,
 d3.nota corte3,
 d4.nota corte4,
 h.notadefinitiva definitiva

 from 
 estudiante e,grupo g, materia m, corte co, carrera c, carrera ce, estudiantegeneral eg,detallenota d

	left join detallenota d1 on 
	d1.codigoestudiante=d.codigoestudiante and
	d1.idgrupo=d.idgrupo and
	d1.idcorte in (select idcorte from corte c1 where numerocorte=1 and c1.codigocarrera=
	c.codigocarrera)
	and d1.codigomateria=d.codigomateria

	left join detallenota d2 on 
	d2.codigoestudiante=d.codigoestudiante and
	d2.idgrupo=d.idgrupo and
	d2.idcorte in (select idcorte from corte c2 where numerocorte=2 and c2.codigocarrera=
	c.codigocarrera ) and
	d2.codigomateria=d.codigomateria

	left join detallenota d3 on 
	d3.codigoestudiante=d.codigoestudiante and
	d3.idgrupo=d.idgrupo and
	d3.idcorte in (select idcorte from corte c3 where numerocorte=3 and c3.codigocarrera=
	c.codigocarrera ) and
	d3.codigomateria=d.codigomateria


	left join detallenota d4 on 
	d4.codigoestudiante=d.codigoestudiante and
	d4.idgrupo=d.idgrupo and
	d4.idcorte in (select idcorte from corte c4 where numerocorte=4 and c4.codigocarrera=
	c.codigocarrera ) and
	d4.codigomateria=d.codigomateria
	
	left join notahistorico h on 
	h.codigoestudiante=d.codigoestudiante and
	h.idgrupo=d.idgrupo and
	h.codigomateria=d.codigomateria 

where 
d.idgrupo=g.idgrupo and
g.codigomateria=m.codigomateria and
d.codigoestudiante=e.codigoestudiante and 
m.codigocarrera=c.codigocarrera and 
co.idcorte=d.idcorte and
ce.codigocarrera=e.codigocarrera and
g.codigoperiodo=".$codigoperiodo." 
".$carreradestino."
".$materiadestino."
".$numerocorte."
and eg.idestudiantegeneral=e.idestudiantegeneral
".$condicionnotaaprobada."
 group by m.codigomateria,e.codigoestudiante
order by eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
";*/


$query="select e.codigoestudiante,
e.codigocarrera, 
ce.nombrecarrera Carrera_Origen,
g.nombregrupo Grupo,
e.semestre Semestre_Actual,eg.numerodocumento,
eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
c.nombrecarrera,co.numerocorte,m.nombremateria,d1.nota corte1,
d2.nota corte2,
 d3.nota corte3,
 d4.nota corte4,
 h.notadefinitiva definitiva

 from 
 estudiante e,grupo g, materia m, corte co, carrera c, carrera ce, estudiantegeneral eg,detallenota d

	left join detallenota d1 on 
	d1.codigoestudiante=d.codigoestudiante and
	d1.idgrupo=d.idgrupo and
	d1.idcorte in (select idcorte from corte c1 where numerocorte=1 )
	and d1.codigomateria=d.codigomateria

	left join detallenota d2 on 
	d2.codigoestudiante=d.codigoestudiante and
	d2.idgrupo=d.idgrupo and
	d2.idcorte in (select idcorte from corte c2 where numerocorte=2 ) and
	d2.codigomateria=d.codigomateria

	left join detallenota d3 on 
	d3.codigoestudiante=d.codigoestudiante and
	d3.idgrupo=d.idgrupo and
	d3.idcorte in (select idcorte from corte c3 where numerocorte=3 ) and
	d3.codigomateria=d.codigomateria


	left join detallenota d4 on 
	d4.codigoestudiante=d.codigoestudiante and
	d4.idgrupo=d.idgrupo and
	d4.idcorte in (select idcorte from corte c4 where numerocorte=4  ) and
	d4.codigomateria=d.codigomateria
	
	left join notahistorico h on 
	h.codigoestudiante=d.codigoestudiante and
	h.idgrupo=d.idgrupo and
	h.codigomateria=d.codigomateria 

where 
d.idgrupo=g.idgrupo and
g.codigomateria=m.codigomateria and
d.codigoestudiante=e.codigoestudiante and 
m.codigocarrera=c.codigocarrera and 
co.idcorte=d.idcorte and
ce.codigocarrera=e.codigocarrera and
g.codigoperiodo=".$codigoperiodo." 
".$carreradestino."
".$materiadestino."
".$numerocorte."
and eg.idestudiantegeneral=e.idestudiantegeneral
".$condicionnotaaprobada."
 group by m.codigomateria,e.codigoestudiante
order by eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
";
		 

	//if($imprimir)
	//echo $query; exit();

	
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


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriadetallenotascorte']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriadetallenotascorte']=$_REQUEST['codigomateria'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreradetallenotascorte']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreradetallenotascorte']=$_REQUEST['codigocarrera'];

if($_REQUEST['columna']!=$_SESSION['columnadetallenotascorte']&&(trim($_REQUEST['columna'])!=''))
$_SESSION['columnadetallenotascorte']=$_REQUEST['columna'];


if($_REQUEST['idgrupo']!=$_SESSION['idgrupodetallenotascorte'])
$_SESSION['idgrupodetallenotascorte']=$_REQUEST['idgrupo'];


$cantidadestmparray=encuentra_array_materias($_SESSION['codigomateriadetallenotascorte'],$_SESSION['codigocarreradetallenotascorte'],$_SESSION['codigomodalidadacademicanotascorte'],$_SESSION['codigoperiododnotascorte'],$_SESSION['columnadetallenotascorte'],$_SESSION['idgrupodetallenotascorte'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($cantidadestmparray,"HISTORIAL LINEA ENFASIS ","listadodetallenotascortes.php?link_origen=".$_GET['link_origen'],'si','si',$_GET['link_origen'],$_GET['link_origen'],true,"si","../../../");
if($_REQUEST['export'] == 'y'){
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=perdida.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
	}
//echo '<pre>';print_r($motor);
?>
<div id="demo2">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="xxxx">
    <thead>
        <tr>
            <th>N&deg;</th>
            <th>Codigo Estudiante</th>
            <th>Numero Documento</th>
            <th>Apellidos Estudiante</th>
            <th>Nombres Estudiante</th>
            <th>Codigo Carrera</th>
            <th>Carrera Origen</th>
            <th>Grupo</th>
            <th>Semestre Actual</th>
            <th>Nombre Carrera</th>
            <th>Numero Corte</th>
            <th>Nombre Materia</th>
            <th>Corte 1</th>
            <th>Corte 2</th>
            <th>Corte 3</th>
            <th>Corte 4</th>
            <th>Definitiva</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>&nbsp;</th> 
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th> 
        </tr>
    </tfoot>
    <tbody>
    <?PHP
    	for($i=0;$i<count($motor->matriz);$i++){
			/*************************************************/
			?>
            <tr>
                <th><?PHP echo $i+1?></th><!--N&deg;-->
                <th><?PHP echo $motor->matriz[$i]['codigoestudiante'];?></th><!--Codigo Estudiante -->
                <th><?PHP echo $motor->matriz[$i]['numerodocumento'];?></th><!--Numero Documento -->
                <th><?PHP echo $motor->matriz[$i]['apellidosestudiantegeneral'];?></th><!--Apellidos Estudiante -->
                <th><?PHP echo $motor->matriz[$i]['nombresestudiantegeneral'];?></th><!--Nombres Estudiante -->
                <th><?PHP echo $motor->matriz[$i]['codigocarrera'];?></th><!--Codigo Carrera -->
                <th><?PHP echo $motor->matriz[$i]['Carrera_Origen'];?></th><!--Carrera Origen -->
                <th><?PHP echo $motor->matriz[$i]['Grupo'];?></th><!--Grupo -->
                <th><?PHP echo $motor->matriz[$i]['Semestre_Actual'];?></th><!--Semestre Actual -->
                <th><?PHP echo $motor->matriz[$i]['nombrecarrera'];?></th><!--Nombre Carrera -->
                <th><?PHP echo $motor->matriz[$i]['numerocorte'];?></th><!--Numero Corte -->
                <th><?PHP echo $motor->matriz[$i]['nombremateria'];?></th><!--Nombre Materia -->
                <th><?PHP echo $motor->matriz[$i]['corte1'];?></th><!--Corte 1 -->
                <th><?PHP echo $motor->matriz[$i]['corte2'];?></th><!--Corte 2 -->
                <th><?PHP echo $motor->matriz[$i]['corte3'];?></th><!--Corte 3 -->
                <th><?PHP echo $motor->matriz[$i]['corte4'];?></th><!--Corte 4 -->
                <th><?PHP echo $motor->matriz[$i]['definitiva'];?></th><!--Definitiva -->
            </tr>
            <?PHP
			/*************************************************/
			}#for
	?>    
    </tbody>         
</table>
<button onclick="exportar(document.URL);">exportar</button>
</div>	
<?PHP
#die;

//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
/* $motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);*/


#$tabla->botonRecargar=false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);


#$motor->mostrar();

if($_REQUEST['Div']=0){
?>

</div> 
<?PHP 
}
?>
