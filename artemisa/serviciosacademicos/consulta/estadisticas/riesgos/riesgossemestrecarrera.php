<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

#echo 'Aca estoy =)';die;
include('../../../men/templates/MenuReportes.php');
ini_set('max_execution_time', '216000');
?>

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
        
function updateForm3(url){            
      window.location.href= url;
}
</script>	

<?PHP
$nombrearchivo = 'riesgos' . "_" . $_POST['riesgo'] . "_" . $_GET['semestre'];
require_once('../../../Connections/sala2.php');
if (isset($_REQUEST['formato'])) {
    $formato = $_REQUEST['formato'];
    switch ($formato) {
        case 'xls' :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo . ".xls";
            break;
        case 'doc' :
            $strType = 'application/msword';
            $strName = $nombrearchivo . ".doc";
            break;
        case 'txt' :
            $strType = 'text/plain';
            $strName = $nombrearchivo . ".txt";
            break;
        case 'csv' :
            $strType = 'text/plain';
            $strName = $nombrearchivo . ".csv";
            break;
        case 'xml' :
            $strType = 'text/plain';
            $strName = $nombrearchivo . ".xml";
            break;
        default :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo . ".xls";
            break;
    }
    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");
}

$rutaado = "../../../funciones/adodb/";
require_once('../../../funciones/sala/estudiante/estudiante.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/sala/nota/nota.php');
require ('../../../funciones/notas/redondeo.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');


?>
<html>
    <head>
        <title>Menu Riesgos X Semestre</title>
<?php
if (isset($_REQUEST['debug']))
    $db->debug = true;

if (!isset($_REQUEST['formato'])) {
?>
        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <?php
    }
        ?>
    </head>
    <body>
        <?php

        function obternerNombreMateria($codigomaterias, $mensaje = "") {
            global $db;
            if ($codigomaterias != "") {
                $codigomaterias = ereg_replace(",$", "", $codigomaterias);
                $query_materia = "select nombremateria, codigomateria
		from materia
		where codigomateria in($codigomaterias)";
                $materia = $db->Execute($query_materia);
                $totalRows_materia = $materia->RecordCount();
                $nombrematerias = "";
                while ($row_materia = $materia->FetchRow()) {
                    $nombrematerias .= "<b>" . $row_materia['codigomateria'] . "</b>-" . $row_materia['nombremateria'] . "$mensaje<br>";
                }
            }
            return $nombrematerias;
        }#Fin Function


        $codigoperiodo= $_POST['Periodo'];
        $semestre= $_POST['semestre'];

	$C_Semestre= explode('::',$semestre);
		
		//echo 'Num->'.count($C_Semestre);
		//echo '<pre>';print_r($C_Semestre);
		
		if(count($C_Semestre)==2){
				$LabelSemestre = $C_Semestre[1];
			}else{
					for($k=1;$k<count($C_Semestre);$k++){
						/**************************/
						$LabelSemestre	= $LabelSemestre.''.$C_Semestre[$k].',';
						/*****************************/
						}
				}   
		
        $riesgo	= $_POST['riesgo'];   
        $codigocarrera= $_POST['codigocarrera'];
		//$codigocarreraOtra		= $_POST['codigocarreraOtra'];
		
		
					if($_POST['riesgo']==1){$NombreRiesgo=' en Riesgo Alto';}
					if($_POST['riesgo']==2){$NombreRiesgo= 'en Riesgo Medio';}
					if($_POST['riesgo']==3){$NombreRiesgo='en Riesgo Bajo';}
					if($_POST['riesgo']==0){$NombreRiesgo='Sin Riesgo';}
        ?>
        <p>Listado de Estudiantes <?php echo $NombreRiesgo; ?> y semestre(s) <?php echo $LabelSemestre; ?></p>
        
        <!--<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Periodo Ingreso</th>-->
             <?php
			 
        if ($_POST['riesgo'] == 1) {
				RiesgoAlto($semestre,$codigoperiodo,$codigocarrera)
?>

               <?php
            }
            ?>
            </tr>
        </thead>
        <tbody>
           
                <?php
	
                if ($cuentaregistros == 0) {
					
					if($_POST['riesgo']==1){$NombreRiesgo='Alto';}
					if($_POST['riesgo']==2){$NombreRiesgo='Medio';}
					if($_POST['riesgo']==3){$NombreRiesgo='Bajo';}
					if($_POST['riesgo']==0){$NombreRiesgo='Sin Riesgo';}
?>
                    <tr class="odd_gradeX">
                        <td colspan="100">No existen estudiantes con riesgo <?php echo $NombreRiesgo; ?></td>
                    </tr>
<?php
                }
				?>
			 </tbody>
        </table>	        
           
    </body>
</html>

            <?PHP
		
	function RiesgoAlto($semestre,$codigoperiodo,$codigocarrera){
			global $db;
			?>
             <div id="demo">
             <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>Programa</th>
                        <th>Matriculados</th>                        
                        <th>No. Estudiantes Riesgo Alto</th>
                        <th>% de Estudiantes Riesgo Alto</th>
                        <th>No. Estudiantes Riesgo Medio</th>
                        <th>% de Estudiantes Riesgo Medio</th>
                        <th>No. Estudiantes Riesgo Bajo</th>
                        <th>% de Estudiantes Riesgo Bajo</th>
                        <th>No. Estudiantes Riesgo Sin Riesgo</th>
                        <th>% de Estudiantes Riesgo Sin Riesgo</th>
                        
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>                        
                	</tr>        
                </tfoot>    
                <?PHP
				
				if($codigocarrera=='0'){
					
					if($semestre=='0'){
						/*************************************************/
						
						$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'

and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";	

				$estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
               $cuentaregistrosBajo=0;
$cuentaregistros=0;
$cuentaregistrosMedio=0;
$cuentaregistrosSinR=0;
$porcentaje1=0;
$porcentaje2=0;
$porcentaje3=0;
$porcentaje4=0;
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
			if ($detallenota->esAltoRiesgo()) {

                       $cuentaregistros++;
                   }
                   if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistrosMedio++;
                   }
                   if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
                   
                            $cuentaregistrosBajo++;
                   }
                   if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
                           $cuentaregistrosSinR++;
                   }
		 }#Fin
		 ?>
		 <tr class="odd_gradeX">
		 
		 <?php
                $porcentaje1=(100*$cuentaregistros)/$totalRows_estudiantes;
                $porcentaje2=(100*$cuentaregistrosMedio)/$totalRows_estudiantes;
                $porcentaje3=(100*$cuentaregistrosBajo)/$totalRows_estudiantes;
                $porcentaje4=(100*$cuentaregistrosSinR)/$totalRows_estudiantes;
               ?>
                                <td><?php echo $cuentaregistros." totalregistros= ".$totalRows_estudiantes; ?></td>                                
                                <td><?php echo $nombredecarrera; ?></td>
                                <td><?php echo $cuentaregistros; ?></td>                                
                                <td><?php echo $cuentaregistrosMedio; ?></td>
                                <td><?php echo $cuentaregistrosBajo; ?></td>
                                <td><?php echo $cuentaregistrosSinR; ?></td>
                            </tr>
		 <?php
						
						/*************************************************/
						}//if
						
						}else{ 
				
				if($semestre=='0'){
					/*******************************************************/
					
				$C_CodigoCarrera	= explode('::',$codigocarrera);
				
				//echo '<pre>';print_r($C_CodigoCarrera);
				 $cuentaregistros = 0;
				for($l=1;$l<count($C_CodigoCarrera);$l++){//for		
						
				$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and e.codigocarrera = '$C_CodigoCarrera[$l]'
and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";
					
                $estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
               
$cuentaregistrosBajo=0;
$cuentaregistros=0;
$cuentaregistrosMedio=0;
$cuentaregistrosSinR=0;

$porcentaje1=0;
$porcentaje2=0;
$porcentaje3=0;
$porcentaje4=0;
                while ($row_estudiantes = $estudiantes->FetchRow()) {

                   unset($detallenota);
                   $nombredecarrera=$row_estudiantes['nombrecarrera'];
                   $codigoestudiante = $row_estudiantes['codigoestudiante'];
                   $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                   $detallenota->setAcumuladoCertificado("1");

                   /*************************************************/	
		   if ($detallenota->esAltoRiesgo()) {

                       $cuentaregistros++;
                   }
                   if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistrosMedio++;
                   }
                   if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
                   
                            $cuentaregistrosBajo++;
                   }
                   if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
                           $cuentaregistrosSinR++;
                   }
                   
               }#Fin
               ?>
               <tr class="odd_gradeX">
               
               <?php
                $porcentaje1=(100*$cuentaregistros)/$totalRows_estudiantes;
                $porcentaje2=(100*$cuentaregistrosMedio)/$totalRows_estudiantes;
                $porcentaje3=(100*$cuentaregistrosBajo)/$totalRows_estudiantes;
                $porcentaje4=(100*$cuentaregistrosSinR)/$totalRows_estudiantes;
               ?>
                                                                
                                <td><?php echo $nombredecarrera; ?></td>                                
                                <td><?php echo $totalRows_estudiantes; ?></td>
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo round($porcentaje1,2)."%"; ?></td>
                                <td><?php echo $cuentaregistrosMedio; ?></td>
                                <td><?php echo round($porcentaje2,2)."%"; ?></td>
                                <td><?php echo $cuentaregistrosBajo; ?></td>
                                <td><?php echo round($porcentaje3,2)."%"; ?></td>
                                <td><?php echo $cuentaregistrosSinR; ?></td>
                                <td><?php echo round($porcentaje4,2)."%"; ?></td>
                            </tr>
<?php       }//for

/*******************************************************/
       }//If
    }
	 ?>		
     </table>		 
     </div>
     <?PHP
		}
	
	?>