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
                @import "../../../observatorio/data/media/css/demo_page.css";
                @import "../../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../../observatorio/data/media/css/ColVis.css";
                @import "../../../observatorio/data/media/css/TableTools.css";
                @import "../../../observatorio/data/media/css/ColReorder.css";
                @import "../../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>
        <script type="text/javascript" language="javascript" src="../../../observatorio/data/media/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="jquery/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" language="javascript" src="../../../observatorio/data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/FixedColumns.js"></script>
    <script type="text/javascript" charset="utf-8" src="../../../observatorio/data/media/js/ColReorder.js"></script>
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
                                         "iLeftColumns": 3,
                                         "iLeftWidth": 550
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
	/****************************************************************/
	$(document).ready( function () {
                         oTable1 = $('#example1').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bPaginate": true,
			    "sScrollX": "100%",
			    "sScrollXInner": "100,1%",
			    "bScrollCollapse": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
			
                        new FixedColumns( oTable1, {
                            "iLeftColumns": 2,
                            "iLeftWidth": 250
						} );
                                                
                        var oTableTools1 = new TableTools( oTable1, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
					]
		         });
                         $('#demo1').before( oTableTools1.dom.container );
		} );
	/**************************************************************/
</script>	
<?PHP
//    require_once('../../../Connections/sala2.php');
    $rutaado = "../../../funciones/adodb/";
    require_once("../../../funciones/clases/motorv2/motor.php");
    require_once("../../../Connections/salaado-pear.php");
    require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("../../../funciones/clases/formulario/clase_formulario.php");
    require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
    require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
    require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
    require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
    require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
    require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    //require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
?>
<html>
    <body>
        <?php
        $codigocarrera=$_REQUEST['codigocarrera'];
        $codigoperiodo=$_REQUEST['periodo'];
        $semestreestudiante=$_REQUEST['semestre'];
        $numerocorte=$_REQUEST['corte'];
        $modalidad=$_REQUEST['modalidad'];
        
        
if($modalidad!=$_SESSION['codigomodalidadacademicanotasmateriacorte']&&trim($modalidad)!='')
$_SESSION['codigomodalidadacademicanotasmateriacorte']=$modalidad;

//echo "<br>_SESSION[codigomaterianotasmateriacorte]=".$_SESSION['codigomaterianotasmateriacorte'];
if($codigocarrera!=$_SESSION['codigocarreranotasmateriacorte']&&(trim($codigocarrera)!=''))
$_SESSION['codigocarreranotasmateriacorte']=$codigocarrera;

if($codigoperiodo!=$_SESSION['codigoperiododnotasmateriacorte']&&(trim($codigoperiodo)!=''))
$_SESSION['codigoperiododnotasmateriacorte']=$codigoperiodo;

if($semestreestudiante!=$_SESSION['semestreestudiantenotasmateriacorte']&&(trim($semestreestudiante)!=''))
$_SESSION['semestreestudiantenotasmateriacorte']=$semestreestudiante;

if($numerocorte!=$_SESSION['numerocortenotasmateriacorte']&&(trim($numerocorte)!=''))
$_SESSION['numerocortenotasmateriacorte']=$numerocorte;

$objetobase=new BaseDeDatosGeneral($sala);
unset($filacarreras);
$cantidadestmparray=encuentra_array_materias($_SESSION['codigocarreranotasmateriacorte'],$_SESSION['codigoperiododnotasmateriacorte'],$_SESSION['semestreestudiantenotasmateriacorte'],$_SESSION['numerocortenotasmateriacorte'],$objetobase,0);

    $f1=$cantidadestmparray[0][0];
    $i=0;
    $j=0;
    $z=0;
    //print_r($f1);
    ?>
<div id="container">
          <!-- <h2>Listado Promedio Corte <?php echo $numerocorte ?> Periodo <?php echo $codigoperiodo ?> Semestre <?php echo $semestreestudiante ?></h2>-->
        </div>
        <div id="demo">
      <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <?php
                    foreach ($f1 as $index => $value) {
                        ?>
                        <th><?php echo $index ?></th>
                        <?
                        $j++;
                    }
                ?>
            </tr>
        </thead>
       <tbody>
                <?php
                foreach ($cantidadestmparray[0] as $index => $value) {
                    ?>
                    <tr>
                      <td><?php echo $z ?></td>
                   <?php
                    foreach ($f1 as $index => $value) {
                        $val=$cantidadestmparray[0][$z];
                        ?>
                        <td><?php echo $val[$index] ?></td>
                        <?php
                    }
                     $z++;
                     ?>
                     </tr>
                    <?php
                }
                ?>
        </tbody>
     </table>
        </div>
        <br>
        <br>
        <?php
            $f2=$cantidadestmparray[1][0];
            $i1=0;
            $j1=0;
            $z1=0;
        ?>
        <div id="container">
          <h2>Resumen Periodo X Corte</h2>
        </div>
          <div id="demo1">
      <table cellpadding="0" cellspacing="0" border="1" class="display" id="example1">
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
                foreach ($cantidadestmparray[1] as $index1 => $value1) {
                    ?>
                    <tr>
                      <td><?php echo $z1 ?></td>
                   <?php
                    foreach ($f2 as $index1 => $value1) {
                        $val1=$cantidadestmparray[1][$z1];
                        ?>
                        <td><?php echo $val1[$index1] ?></td>
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
        
    </body>
</html>
<?php
function encuentra_array_materias($codigocarrera,$codigoperiodo,$semestreestudiante,$numerocorte,$objetobase,$imprimir=0){
//echo $codigocarrera.'xxxx'; 
 
if($codigocarrera!="todos")
$carreradestino="AND e.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($semestreestudiante!="todos")
$semestredestino="and p.semestreprematricula='".$semestreestudiante."'";
else
$semestredestino="";

if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

$query="select * from
materia m , prematricula p, detalleprematricula d, 
estudiante e, detallenota dn, grupo g, estudiantegeneral eg, corte co, carrera c
where 
m.codigomateria=d.codigomateria and
c.codigocarrera=e.codigocarrera and
d.idprematricula=p.idprematricula and
e.codigoestudiante=p.codigoestudiante 
and g.idgrupo=dn.idgrupo
and dn.codigoestudiante=e.codigoestudiante
and g.codigomateria=m.codigomateria
and g.codigoperiodo=p.codigoperiodo
and eg.idestudiantegeneral=e.idestudiantegeneral
and co.idcorte=dn.idcorte
AND p.codigoestadoprematricula LIKE '4%'
AND d.codigoestadodetalleprematricula  LIKE '3%'
and p.codigoperiodo=".$codigoperiodo."
".$carreradestino."
".$semestredestino."
and co.numerocorte=".$numerocorte."
order by p.semestreprematricula,m.nombremateria,
		 eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		$array_armado[$row_operacion['numerodocumento']]["nombre"]=$row_operacion['apellidosestudiantegeneral']."  ".$row_operacion['nombresestudiantegeneral'];
		$array_armado[$row_operacion['numerodocumento']]["numerodocumento"]=$row_operacion['numerodocumento'];
		$array_armado[$row_operacion['numerodocumento']]["nombrecarrera"]=$row_operacion['nombrecarrera'];
		$array_armado[$row_operacion['numerodocumento']]["semestreprematricula"]=$row_operacion['semestreprematricula'];
		$array_armado[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]=$row_operacion['nota'];
		$materias[cambiarespacio($row_operacion['nombremateria'])]=1;
		$notasmateria[cambiarespacio($row_operacion['nombremateria'])][]=$row_operacion['nota'];
		$array_creditos[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]=$row_operacion['numerocreditos'];
		
		if($array_armado[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]<$row_operacion["notaminimaaprobatoria"])
		$notasperdidasmateria[cambiarespacio($row_operacion['nombremateria'])][]=$row_operacion['nota'];
		$row_operacion;
		
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
	/*echo "<pre>";
	print_r($array_armado);
	echo "</pre>";*/
	$i=0;
	if(is_array($array_armado))
	foreach($array_armado as $numerodocumento => $row_armado){

		$row_otro["NOMBRE"]=$row_armado["nombre"];
		$row_otro["DOCUMENTO"]=$row_armado["numerodocumento"];
		$row_otro["CARRERA"]=$row_armado["nombrecarrera"];
		$row_otro["SEMESTRE"]=$row_armado["semestreprematricula"];
		unset($creditos);
		unset($notas);

		foreach($materias as $materia => $numeral){

			//echo "if((!isset(".$row_armado[$materia]."))||(trim(".$row_armado[$materia].")==''))<br>";
			if((!isset($row_armado[$materia]))||(trim($row_armado[$materia])=='')){
				$row_otro[$materia]="&nbsp;";
				$creditos[]="0";
				$notas[]="0";

				}
			else{	
				$row_otro[$materia]=$row_armado[$materia];
				$creditos[]=$array_creditos[$numerodocumento][$materia];
				$notas[]=$row_otro[$materia];
				}
		}		
		$row_otro["PROMEDIO_PONDERADO"]=round(promedioponderado($notas,$creditos),2);	

/*  		echo "$i<pre>";
		print_r($notas);
		echo "</pre>";
 */ 
		//$row_otro
		
		$arrayinterno1[$i]=$row_otro;
		$i++;
	}
	if(is_array($notasmateria))
	foreach ($notasmateria as $materia => $arraynotas){
	$arrayinterno2[0]["TIPO DE CALCULO\\ASIGNATURA"]="<B>NOTA MINIMA</B>";
	$arrayinterno2[0][$materia]=min($arraynotas);
	$arrayinterno2[1]["TIPO DE CALCULO\\ASIGNATURA"]="<B>NOTA MAXIMA</B>";
	$arrayinterno2[1][$materia]=max($arraynotas);
	$arrayinterno2[2]["TIPO DE CALCULO\\ASIGNATURA"]="<B>DESVIACIÓN ESTANDAR</B>";
	$arrayinterno2[2][$materia]=round(desviacionestandar($arraynotas),2);
	$arrayinterno2[3]["TIPO DE CALCULO\\ASIGNATURA"]="<B>PROMEDIO</B>";
	$arrayinterno2[3][$materia]=round(promedio($arraynotas),2);
	$arrayinterno2[4]["TIPO DE CALCULO\\ASIGNATURA"]="<B>Nº ESTUDIANTES PERDIERON</B>";
	$arrayinterno2[4][$materia]=count($notasperdidasmateria[$materia]);
	$arrayinterno2[5]["TIPO DE CALCULO\\ASIGNATURA"]="<B>Nº ESTUDIANTES ASIGNATURA</B>";
	$arrayinterno2[5][$materia]=count($arraynotas);
	}
		$array_interno[0]=$arrayinterno1;
		$array_interno[1]=$arrayinterno2;

	/*echo "<pre>";
	print_r($array_interno);
	echo "</pre>";*/

	
return $array_interno;
}
?>