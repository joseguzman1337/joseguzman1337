<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

error_reporting(E_ALL);
ini_set('display_errors', '0');

include('../../../men/templates/MenuReportes.php');

?>

    <style type="text/css" title="currentStyle">
                @import "data/media/css/demo_page.css";
                @import "data/media/css/demo_table_jui.css";
                @import "data/media/css/ColVis.css";
                @import "data/media/css/TableTools.css";
                @import "data/media/css/ColReorder.css";
                @import "data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>
        <script type="text/javascript" language="javascript" src="data/media/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="jquery/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/FixedColumns.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColReorder.js"></script>
    <script type="text/javascript" language="javascript">
        
        $(document).ready( function () {
				var oTable = $('#example').dataTable( {
					"sDom": '<"H"Cfrltip>',
  					"sScrollX": "100%",
					"sScrollXInner": "100,1%",
					"bScrollCollapse": true,
                                        "bPaginate": true,
                                        "sPaginationType": "full_numbers",
					"oColReorder": {
						"iFixedColumns": 1
					},
                                        "oColVis": {
                                                "buttonText": "Ver/Ocultar Columns",
                                                 "aiExclude": [ 0 ]
                                          }
				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 5,
                                         "iLeftWidth": 650
				} );
                                
                                 var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
			} );
</script>

<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css" />

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

function encuentra_array_materias($tmateria,$codigomateria,$codigocarrera,$codigomodalidadacademica,$periodoinicial,$periodofinal,$columna,$objetobase,$imprimir=0){
 
 
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


$query="select e.codigoestudiante,eg.numerodocumento,eg.apellidosestudiantegeneral,
eg.nombresestudiantegeneral,
    e.codigocarrera, ce.nombrecarrera Carrera_Origen,
e.semestre Semestre_Actual,c.nombrecarrera,co.numerocorte,g.codigoperiodo,m.nombremateria,
d1.nota corte1,
d2.nota corte2,
 d3.nota corte3,
 d4.nota corte4,
 h.notadefinitiva definitiva

 from 
 estudiante e,grupo g, materia m, corte co, carrera c, carrera ce, estudiantegeneral eg,detallenota d

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

where 
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
and eg.idestudiantegeneral=e.idestudiantegeneral
".$condicionnotaaprobada."
 group by m.codigomateria,e.codigoestudiante,g.codigoperiodo
order by g.codigoperiodo,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
";
		 
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


$codigomodalidadacademica=$_REQUEST['modalidad'];
$codigomateria=$_REQUEST['codigomateria'];
$tmaterias=$_REQUEST['tmaterias'];
$codigocarrera=$_REQUEST['codigocarrera'];
$codigoperiodo=$_REQUEST['periodoi'];
$codigoperiodofinal=$_REQUEST['periodof'];
$tmaterias=$_REQUEST['tmaterias'];
$columna=$_REQUEST['columna'];

        

if(isset($_POST['codigocarrera'])&&($_POST['codigocarrera']!=''))
$codigofacultad="05";



unset($filacarreras);




$cantidadestmparray=encuentra_array_materias($codigomateria,$codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$codigoperiodofinal,$columna,$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
if($columna==5)
$detalleencabezado="ESTUDIANTES QUE PERDIERON";
else
$detalleencabezado="";

$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['codigocarreradetalledefinitivaperiodo'],"","",0);
$datosmateria=$objetobase->recuperar_datos_tabla("materia","codigomateria",$_SESSION['codigomateriadetalledefinitivaperiodo'],"","",0);

//echo "<table><tr><td><h3>DETALLE HISTORICO DE NOTAS ".$detalleencabezado." ".$datosmateria["nombremateria"]." ".$datoscarrera["nombrecarrera"]." POR PERIODOS ".$_SESSION['periodoinicialdetalledefinitivaperiodo']." AL ".$_SESSION['periodofinaldetalledefinitivaperiodo']."</h3></td></tr></table>";

//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
//$motor = new matriz($cantidadestmparray,"HISTORIAL LINEA ENFASIS ","listadodetallenotasdefinitivaperiodos.php",'si','si','listadonotascorte.php','listadogeneral.php',true,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
/* $motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);
 */
$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
//$motor->mostrar();

$f2=$cantidadestmparray[0];
//print_r($f2);
$i1=0;
$j1=0;
$z1=0;
$z2=0;
$val=""; $to=0;
//print_r($cantidadestmparray);
?>
<div id="container">
          <h2>DETALLE HISTORICO DE NOTAS  <?php echo $detalleencabezado.' '.$datosmateria["nombremateria"].' '.$datoscarrera["nombrecarrera"] ?> POR PERIODOS <?php echo $_SESSION['codigoperiododdefinitivaperiodo'] ?> AL <?php echo $_SESSION['codigoperiodofinaldefinitivaperiodo'] ?></h2>
        </div>
      <div id="demo">
      <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <?php
                    foreach ($f2 as $index1 => $value1) {
                        ?>
                        <th><?php echo $index1 ?></th>
                        <?
                        $j1++;
                    }
                ?>
            </tr>      
        </thead>
        <tbody>
                <?php
                foreach ($cantidadestmparray as $index1 => $value1) {
                    ?>
                    <tr>
                      <td><?php echo $z1+1 ?></td>
                   <?php
                    foreach ($f2 as $index2 => $value2) {
                        $val2=$cantidadestmparray[$z1];
                        ?>
                        <td> <?php echo  $val2[$index2] ?>  </td>
                        <?php
                    }
                     $z1++;
                     ?>
                     </tr>
                    <?php
                }
                ?>
        </tbody>
      </table>
      </div>
   