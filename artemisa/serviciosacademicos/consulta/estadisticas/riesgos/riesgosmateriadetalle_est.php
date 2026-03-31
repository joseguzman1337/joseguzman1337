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
                @import "data/media/css/jquery.modal.css";
                
    </style>
    <script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/jquery.modal.js"></script>
    <script type="text/javascript" language="javascript">
	/****************************************************************/
	$(document).ready( function () {
			
			oTable = $('#example').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                        var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
		} );
	/**************************************************************/
</script>	
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../funciones/sala/nota/nota.php');
require_once('../../../funciones/sala/estudiante/estudiante.php');
require_once('../../../Connections/sala2.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/sala/nota/nota.php');
require ('../../../funciones/notas/redondeo.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');


//print_r($_POST);
// De acuerdo a la sesión y a lo que venga por get muestra el detalle
echo "<pre>";
//print_r($_SESSION);
echo "</pre>";

if(isset($_REQUEST['debug']))
    $db->debug = true;
// Selecciona los datos de la materia

$codigoperiodo = $_REQUEST['periodo'];
$codigomateria = $_REQUEST['codigomateria'];
$modalidad = $_REQUEST['modalidad'];
$codigocarrera = $_REQUEST['codigocarrera'];
$idgrupo =$_REQUEST['idgrupo'];
$riesgo = $_REQUEST['riesgo'];

 
$query_materia = "select m.codigomateria, m.nombremateria, g.idgrupo, g.nombregrupo, concat(d.apellidodocente,' ', d.nombredocente) as nombre
from materia m, grupo g, docente d
where m.codigomateria = g.codigomateria
and g.idgrupo = '".$idgrupo."'
and g.numerodocumento = d.numerodocumento";
$materia = $db->Execute($query_materia);
$totalRows_materia = $materia->RecordCount();
if($totalRows_materia == "") {
    $query_materia = "select m.codigomateria, m.nombremateria, g.idgrupo, g.nombregrupo, concat(d.apellidodocente,' ', d.nombredocente) as nombre
    from materia m, grupo g, docente d
    where m.codigomateria = g.codigomateria
    and g.codigomateria = '".$codigocarrera."'
    and g.codigoperiodo = '".$codigoperiodo."'
    and g.numerodocumento = d.numerodocumento";
    $materia = $db->Execute($query_materia);
    $totalRows_materia = $materia->RecordCount();
}

function encuentra_array_estudiantes($codigomateria, $codigocarrera, $modalidad, $codigoperiodo, $riesgo, $idgrupo="") {
    global $db;
      
    //$db->debug = true;
    if($idgrupo != "")
        $idgrupodestino = "and g.idgrupo = $idgrupo";
    if($codigocarrera!="todos")
        $carreradestino="AND c.codigocarrera='".$codigocarrera."'";
    else
        $carreradestino="";

    if($codigomateria!="todos")
        $materiadestino= "AND m.codigomateria='".$codigomateria."'";
    else
        $materiadestino= "";

    $query_estudiantes = "select c.codigocarrera, c.nombrecarrera, m.codigomateria, m.nombremateria,
    g.idgrupo, g.codigoperiodo, p.codigoestudiante, m.codigomateria, e.codigoperiodo
	from  grupo g, materia m, carrera c, detalleprematricula dp, prematricula p, estudiantegeneral eg, estudiante e
	where g.codigomateria = m.codigomateria
	and g.codigoperiodo = $codigoperiodo
            $carreradestino
            $materiadestino
            $idgrupodestino
	and m.codigocarrera = c.codigocarrera
	and c.codigomodalidadacademica = $modalidad
	and dp.idgrupo = g.idgrupo
	and dp.codigoestadodetalleprematricula like '3%'
	and p.codigoperiodo = g.codigoperiodo
	and dp.idprematricula = p.idprematricula
	and e.codigoestudiante = p.codigoestudiante
	and eg.idestudiantegeneral = e.idestudiantegeneral
	order by eg.apellidosestudiantegeneral";
   // echo $query_estudiantes;
    $estudiantes = $db->Execute($query_estudiantes);
    $totalRows_estudiantes = $estudiantes->RecordCount();

    //$db->debug = true;

    while($row_estudiantes = $estudiantes->FetchRow()) {
        unset($detallenota);

        $detallenota = new detallenota($row_estudiantes['codigoestudiante'], $codigoperiodo);
        
        $detallenota->setAcumuladoCertificado("1");
        /*if(22545 == $row_estudiantes['codigoestudiante'])
        	echo "<pre>"; print_r($detallenota); echo "</pre>";*/
        //if ($detallenota->tieneNotasXMateria($row_estudiantes['codigomateria']))
        {
            if($riesgo != "Nes") {
                if($detallenota->esAltoRiesgoXMateria($codigomateria, $idgrupo)) {
                    if($riesgo != "Alto") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "1 ".$riesgo;*/
                        continue;
                    }
                }
                elseif($detallenota->esMedianoRiesgoXMateria($codigomateria)) {
                    if($riesgo != "Medio") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "2 ".$riesgo;*/
                        continue;
                    }
                }
                elseif($detallenota->esBajoRiesgoXMateria($codigomateria)) {
                    if($riesgo != "Bajo") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "3 ".$riesgo;*/
                        continue;
                    }
                }
                else {
                    if($riesgo != "Sin") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "4 ".$riesgo;*/
                        continue;
                    }
                }
            }
        }
        /*else
    	{
	    	if($riesgo != "Sin_Riesgo")
		        	continue;
	    }*/
        $array_interno[] = $row_estudiantes['codigoestudiante'];
        /*if(22545 == $row_estudiantes['codigoestudiante'])
	    {
	    	echo $riesgo;
	    	//exit();
	    }*/
    }
    return $array_interno;
}


/*$columnas = array(
        'codigoestudiante' => 'Código', 'numerodocumento' => 'Documento',
        'nombresestudiantegeneral' => 'Nombres', 'apellidosestudiantegeneral' => 'Apellidos',
        'codigocarrera' => 'Carrera', 'semestre' => 'Semestre', 'codigoperiodo' => 'Periodo de Ingreso'
);

$links = array(
        'codigoestudiante' => 'estudianteriesgos.php?codigoestudiante='
);*/
?>

<h3>Detalle Estudiantes <?php echo $_REQUEST['riesgo'];?></h3>
<table border="1" cellspacing="0" cellpadding="0" width="50%">
    <tr id="trtitulogris">
        <td>Nombre de la materia</td>
        <td>Id Grupo</td>
        <td>Nombre del grupo Grupo</td>
        <td>Docente</td>
    </tr>
    
<?php
while($row_materia = $materia->FetchRow()) {
?>
    <tr>
        <td><?php echo $row_materia['nombremateria']; ?></td>
        <td><?php echo $row_materia['idgrupo']; ?></td>
        <td><?php echo $row_materia['nombregrupo']; ?></td>
        <td><?php echo $row_materia['nombre']; ?></td>
    </tr>
<?php
}
?>
</table>
<br>
<br>
<?php
$arrayEstudiantes = encuentra_array_estudiantes($codigomateria, $codigocarrera, $modalidad, $codigoperiodo, $riesgo, $idgrupo);

if(count($arrayEstudiantes) > 0) {
    ?>
<div id="demo">
         <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Codigo</th>
                <th>Documento</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Carrera</th>
                <th>Semestre</th>
                <th>Periodo Ingreso</th>
                <th>Riesgos Encontrados</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $i=0;
    foreach($arrayEstudiantes as $key => $codigoestudiante) {
        $estudiantes[] = new estudiante($codigoestudiante, $codigoperiodo);
        $detallenota = new detallenota($estudiantes[$i]->codigoestudiante, $estudiantes[$i]->codigoperiodo);
        $detallenota->setAcumuladoCertificado("1");
        $riesgos[] = $detallenota->riesgoEstudiante(false);
        
       // print_r($riesgos);
       // print_r($estudiantes);
        ?>
            <tr>
                    <td><?php echo $i+1 ?></td>
                    <td><?php echo $estudiantes[$i]->codigoestudiante ?></td>
                    <td><?php echo $estudiantes[$i]->numerodocumento ?></td>
                    <td><?php echo $estudiantes[$i]->nombresestudiantegeneral ?></td>
                    <td><?php echo $estudiantes[$i]->apellidosestudiantegeneral ?></td>
                    <td><?php echo $estudiantes[$i]->codigocarrera ?></td>
                    <td><?php echo $estudiantes[$i]->semestre ?></td>
                    <td><?php echo $estudiantes[$i]->codigoperiodo ?></td>
                    <td>
                        <?php 
                        $riesgosarreglo = explode("\\n",$riesgos[$i]); 
                        if(count($riesgosarreglo) <= 1){
                            echo "<p>Este estudiante no tiene riesgo</p>";
                        }else{
                            foreach($riesgosarreglo as $key => $riesgo){
                                if($key >0)  echo "$riesgo <br>";

                            }
                        }
                    ?>
                    </td>
                </tr>
        <?php
        $i++;
    }
    ?>
                     
        </tbody>
         </table>    
</div>
    <?php
}