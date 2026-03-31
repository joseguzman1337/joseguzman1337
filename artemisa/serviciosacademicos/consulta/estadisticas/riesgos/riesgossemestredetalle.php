<?php  
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

#echo 'Aca estoy =)';die;
include('../../../men/templates/MenuReportes.php');

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

//print_r($_GET);
// De acuerdo a la sesión y a lo que venga por get muestra el detalle
        /* echo "<pre>";
          print_r($_SESSION);
          echo "</pre>";
         */
//$_SESSION['codigoperiodosesion'] = 20082;
//$_SESSION['codigofacultad'] = 118;
        $codigoperiodo 			= $_POST['Periodo'];
        $semestre 				= $_POST['semestre'];
		
		$C_Semestre				= explode('::',$semestre);
		
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
		
        $riesgo 				= $_POST['riesgo'];   
        $codigocarrera 			= $_POST['codigocarrera'];
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
		if ($_POST['riesgo'] == 0) {
				$cuentaregistros = SinRiesgo($semestre,$codigoperiodo,$codigocarrera);
			}	 
        if ($_POST['riesgo'] == 1) {
				$cuentaregistros = RiesgoAlto($semestre,$codigoperiodo,$codigocarrera)
?>
<!--                    <th>Pierde Más del 50%</th>
                    <th>Promedio Ponderado Acumulado Menor a 3.3</th>
                    <th>Pierde Asignatura Otra Vez</th>
                    <th>Está en Prueba Académica</th>--> 
            <!-- 	<td>Pierde Por Fallas</td> -->
                   <!-- <th>Materias Perdidas</th>-->
               <?php
            }
            if ($_POST['riesgo'] == 2) {
				$cuentaregistros = RiesgoMedio($semestre,$codigoperiodo,$codigocarrera);
                ?>
                <!--<th colspan="4">Pierde Menos del 50% y Más del 25%</th>
                <th>Materias Perdidas</th>-->
<?php
            }
            if ($_POST['riesgo'] == 3) {
				$cuentaregistros =  RiesgoBajo($semestre,$codigoperiodo,$codigocarrera);
?>
               <!-- <th colspan="4">Pierde Menos del 25% y Más del 0%</th>
                <th>Materias Perdidas</th>-->
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
        <?PHP
                if (!isset($_REQUEST['formato'])) {
?>
				<br><br>		
            	<table>	
                    <tr>
                       <!-- <td <?php if ($_POST['riesgo'] != "Sin Riesgo")
							echo 'colspan="8"'; else
                        echo 'colspan="4"'; ?>>
                            <form action="riesgossemestredetalle.php" method="get" name="f1">
                                <input type="button" onClick="document.location.href='menuriesgossemestre.php';" value="Regresar">
                                <input type="submit" value="Exportar a Excel">
                                <input type="hidden" value="" name="formato">
                                <input type="hidden" value="<?php echo $semestre; ?>" name="semestre">
                                <input type="hidden" value="<?php echo $riesgo; ?>" name="riesgo">
                            </form>
                        </td>-->
            <?php 
						
                    if ($_POST['riesgo'] != "Sin Riesgo") {
            ?>
                            <td>(F): Perdio por fallas</td>
            <?php 
                    }
            ?>
                    </tr>
                  </table>  
            <?php
                }
            ?>
           
    </body>
</html>
<?PHP 
	function SinRiesgo($semestre,$codigoperiodo,$codigocarrera){
		global $db;
			?>
             <div id="demo">
             <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        
                        <th>N&deg;</th>
                        <th>Documento</th>
                        <th>Nombre Estudiante</th>
                        <th>E-Mail U. Bosque</th>
                        <th>E-Mail 1</th>
                        <th>E-Mail 2</th>
                        <th>Periodo Ingreso</th>
                        <th>Semestre</th>
                        <th>Carrera</th>

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
                	</tr>        
                </tfoot>    
                <?PHP 
				if($codigocarrera=='0'){
					if($semestre=='0'){
					/****************************************************/	
					
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

				 if($estudiantes =&$db->Execute($query_estudiantes)===false){
				   		echo 'Error en el SQL <br>'.$query_estudiantes;
						die;
				   }
				 
				// echo '<pre>';print_r($estudiantes);  
				   
                //$totalRows_estudiantes = $estudiantes->RecordCount();
                //$hayregistros = false;
                $cuentaregistros = 0;
				
				 while(!$estudiantes->EOF){//$row_estudiantes = $estudiantes->FetchRow()
                    unset($detallenota);
                    $codigoestudiante = $estudiantes->fields['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
							
							 if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
							
							
                            $cuentaregistros++;
							
							  $SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$estudiantes->fields['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">

                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo $estudiantes->fields['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $estudiantes->fields['nombre']; ?></td>
                                <td><?php echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?php echo $Datos->fields['email']?></td>
                                <td><?php echo $Datos->fields['email2']?></td>
                                <td><?php echo $estudiantes->fields['codigoperiodo']; ?></td>
                                <td><?php echo $estudiantes->fields['semestreprematricula']; ?></td>
                                <td><?php echo $estudiantes->fields['nombrecarrera']; ?></td>

                            </tr>
<?php
                        }
						$estudiantes->MoveNext();
				 
					}/*Fin*/
					
					/****************************************************/
						}else{
					
					
					$C_Semestre			= explode('::',$semestre); 
					
					 $cuentaregistros = 0;
						
					for($t=1;$t<count($C_Semestre);$t++){
					
					$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'

and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";	

				 if($estudiantes =&$db->Execute($query_estudiantes)===false){
				   		echo 'Error en el SQL <br>'.$query_estudiantes;
						die;
				   }
				 
				// echo '<pre>';print_r($estudiantes);  
				   
                //$totalRows_estudiantes = $estudiantes->RecordCount();
                //$hayregistros = false;
               
				
				 while(!$estudiantes->EOF){//$row_estudiantes = $estudiantes->FetchRow()
                    unset($detallenota);
                    $codigoestudiante = $estudiantes->fields['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
							
							 if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
							
							
                            $cuentaregistros++;
							
							  $SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$estudiantes->fields['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $estudiantes->fields['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $estudiantes->fields['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $estudiantes->fields['codigoperiodo']; ?></td>
                                <td><?php echo $estudiantes->fields['semestreprematricula']; ?></td>
                                <td><?php echo $estudiantes->fields['nombrecarrera']; ?></td>
                            </tr>
<?php
                        }
						$estudiantes->MoveNext();
				 
					}/*Fin*/	
				}//for
		}//if
						}else{
				
				
				$C_CodigoCarrera	= explode('::',$codigocarrera);
				
				//echo '<pre>';print_r($C_CodigoCarrera);
				
				if($semestre=='0'){
					/*************************************************/
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

				

					//echo '<br><br>Consulta-><br>'.$query_estudiantes;
	
					
               if($estudiantes =&$db->Execute($query_estudiantes)===false){
				   		echo 'Error en el SQL <br>'.$query_estudiantes;
						die;
				   }
				 
				// echo '<pre>';print_r($estudiantes);  
				   
                //$totalRows_estudiantes = $estudiantes->RecordCount();
                //$hayregistros = false;
               
				
				 while(!$estudiantes->EOF){//$row_estudiantes = $estudiantes->FetchRow()
                    unset($detallenota);
                    $codigoestudiante = $estudiantes->fields['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
							
							 if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
							
							
                            $cuentaregistros++;
							
							  $SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$estudiantes->fields['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $estudiantes->fields['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $estudiantes->fields['nombre']; ?></td>
                                <td><?php echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?php echo $Datos->fields['email']?></td>
                                <td><?php echo $Datos->fields['email2']?></td>
                                <td><?php echo $estudiantes->fields['codigoperiodo']; ?></td>
                                <td><?php echo $estudiantes->fields['semestreprematricula']; ?></td>
                                <td><?php echo $estudiantes->fields['nombrecarrera']; ?></td>
                            </tr>
<?php
                        }
						$estudiantes->MoveNext();	
					}/*Fin*/
				  }//for	
					/*************************************************/
					}else{
						/*******************************************************/
						
						$C_Semestre			= explode('::',$semestre); 
				
				$cuentaregistros = 0;
				 
				 
				for($l=1;$l<count($C_CodigoCarrera);$l++){//for
					
					for($t=1;$t<count($C_Semestre);$t++){
					
				
				    $query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'
and e.codigocarrera = '$C_CodigoCarrera[$l]'
and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";

				

					//echo '<br><br>Consulta-><br>'.$query_estudiantes;
	
					
               if($estudiantes =&$db->Execute($query_estudiantes)===false){
				   		echo 'Error en el SQL <br>'.$query_estudiantes;
						die;
				   }
				 
				// echo '<pre>';print_r($estudiantes);  
				   
                //$totalRows_estudiantes = $estudiantes->RecordCount();
                //$hayregistros = false;
               
				
				 while(!$estudiantes->EOF){//$row_estudiantes = $estudiantes->FetchRow()
                    unset($detallenota);
                    $codigoestudiante = $estudiantes->fields['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
							
							 if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && !$detallenota->esBajoRiesgo()) {
							
							
                            $cuentaregistros++;
							
							  $SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$estudiantes->fields['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $estudiantes->fields['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $estudiantes->fields['nombre']; ?></td>
                                <td><?php echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?php echo $Datos->fields['email']?></td>
                                <td><?php echo $Datos->fields['email2']?></td>
                                <td><?php echo $estudiantes->fields['codigoperiodo']; ?></td>
                                <td><?php echo $estudiantes->fields['semestreprematricula']; ?></td>
                                <td><?php echo $estudiantes->fields['nombrecarrera']; ?></td>
                            </tr>
<?php
                        }
						$estudiantes->MoveNext();	
					}/*Fin*/
				  }//for	
				}//for	
						
			/*******************************************************/
			}//If
	}
				?>
             </table> 
             </div>         
            <?php
		return $cuentaregistros; }
	function RiesgoAlto($semestre,$codigoperiodo,$codigocarrera){
			global $db;
			?>
             <div id="demo">
             <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>N&deg;</th>
                        <th>Documento</th>
                        <th>Nombre Estudiante</th>
                        <th>E-Mail U. Bosque</th>
                        <th>E-Mail 1</th>
                        <th>E-Mail 2</th>
                        <th>Periodo Ingreso</th>
                        <th>Semestre</th>
                        <th>Carrera</th>
                        <th>Pierde Más del 50%</th>
                        <th>Promedio Ponderado Acumulado Menor a 3.3</th>
                        <th>Pierde Asignatura Otra Vez</th>
                        <th>Est&aacute; en Prueba Acad&eacute;mica</th>
                        <th>Materias Perdidas</th>
                        <?php if(!empty($_REQUEST['tipo'])){?>
                        <th>Acci&oacute;n</th>
                        <?php } ?>
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
                $cuentaregistros = 0;
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {

					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						 if ($detallenota->esAltoRiesgo()) {
                            $cuentaregistros++;
							
							$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario, u.idusuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                                <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasdel50; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajeppaMenor33; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); ?>&nbsp;</td>
                                <td>&nbsp;<?php echo $detallenota->mensajeestaEnPrueba; ?></td>
                        <!-- 	<td>&nbsp;<?php //echo $detallenota->mensajeperdioPorFallas; ?></td>  -->
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>
            <?php echo obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)"); ?>
                                </td>
                                <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasdel50; 
                                    $arr['detallenota2']=$detallenota->mensajeppaMenor33; 
                                    $arr['nombremateria']=obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); 
                                    $arr['detallenota3']=$detallenota->mensajeestaEnPrueba;
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']=obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)");
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                            </tr>
<?php
                        }
					 
					 }#Fin
						
						/*************************************************/
						}else{
							/******************************************************/
					$C_Semestre			= explode('::',$semestre); 
					
					$cuentaregistros = 0;
						
					for($t=1;$t<count($C_Semestre);$t++){
						
						$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'

and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";	

				 $estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						 if ($detallenota->esAltoRiesgo()) {
                            
							$cuentaregistros++;
							
							$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario, u.idusuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                                <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasdel50; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajeppaMenor33; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); ?>&nbsp;</td>
                                <td>&nbsp;<?php echo $detallenota->mensajeestaEnPrueba; ?></td>
                        <!-- 	<td>&nbsp;<?php //echo $detallenota->mensajeperdioPorFallas; ?></td>  -->
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>
            <?php echo obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)"); ?>
                                </td>
                               <?php if(!empty($_REQUEST['tipo'])){
                                   $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasdel50; 
                                    $arr['detallenota2']=$detallenota->mensajeppaMenor33; 
                                    $arr['nombremateria']=obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); 
                                    $arr['detallenota3']=$detallenota->mensajeestaEnPrueba;
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']=obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)");
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php 
                                    }

                                } ?>
                            </tr>
<?php
                        }
					 
					 }#Fin
				}//For
			/******************************************************/
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
               
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                    $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						 if ($detallenota->esAltoRiesgo()) {
                           
						    $cuentaregistros++;
							
							$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario, u.idusuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                                <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasdel50; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajeppaMenor33; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); ?>&nbsp;</td>
                                <td>&nbsp;<?php echo $detallenota->mensajeestaEnPrueba; ?></td>
                        <!-- 	<td>&nbsp;<?php //echo $detallenota->mensajeperdioPorFallas; ?></td>  -->
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>
            <?php echo obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)"); ?>
                                </td>
                                <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasdel50; 
                                    $arr['detallenota2']=$detallenota->mensajeppaMenor33; 
                                    $arr['nombremateria']=obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); 
                                    $arr['detallenota3']=$detallenota->mensajeestaEnPrueba;
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']=obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)");
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                            </tr>
<?php
                        }
					 
					 }#Fin
				}//for
					
					/*******************************************************/
					}else{
					/************************************************************************/	
					
				$C_CodigoCarrera	= explode('::',$codigocarrera);
				
				//echo '<pre>';print_r($C_CodigoCarrera);
				
				$C_Semestre			= explode('::',$semestre);  
					
				$cuentaregistros = 0;
					
				for($l=1;$l<count($C_CodigoCarrera);$l++){//for	
				
					for($t=1;$t<count($C_Semestre);$t++){	
						
				$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'
and e.codigocarrera = '$C_CodigoCarrera[$l]'
and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";
					
                $estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
                
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						 if ($detallenota->esAltoRiesgo()) {
                            $cuentaregistros++;
							
							$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario, u.idusuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                                <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasdel50; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajeppaMenor33; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); ?>&nbsp;</td>
                                <td>&nbsp;<?php echo $detallenota->mensajeestaEnPrueba; ?></td>
                        <!-- 	<td>&nbsp;<?php //echo $detallenota->mensajeperdioPorFallas; ?></td>  -->
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>
            <?php echo obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)"); ?>
                                </td>
                                <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasdel50; 
                                    $arr['detallenota2']=$detallenota->mensajeppaMenor33; 
                                    $arr['nombremateria']=obternerNombreMateria($detallenota->mensajepierdeAsignaturaOtraVez); 
                                    $arr['detallenota3']=$detallenota->mensajeestaEnPrueba;
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']=obternerNombreMateria($detallenota->materiasperdidasfallas, " (F)");
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                 $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
//                                 if($DatosR=&$db->Execute($sql_tip)===false){
//                                        echo 'Error en el SQL...<br><br>'.$sql_tip;
//                                        die;
//                                }
                                $DatosR=$db->Execute($sql_tip);
                                $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                            </tr>
<?php
                        }
					 
					 }#Fin
				}//for
			  }//for
		/************************************************************************/	
			}//If
		}
	 ?>		
     </table>		 
     </div>
     <?PHP
		return $cuentaregistros;}
		
	function RiesgoMedio($semestre,$codigoperiodo,$codigocarrera){
			global $db;
			?>
             <div id="demo">
             <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>N&deg;</th>
                        <th>Documento</th>
                        <th>Nombre Estudiante</th>
                        <th>E-Mail U. Bosque</th>
                        <th>E-Mail 1</th>
                        <th>E-Mail 2</th>
                        <th>Periodo Ingreso</th>
                        <th>Semestre</th>
                        <th>Carrera</th>
                        <th>Pierde Menos del 50% y Más del 25%</th>
               		<th>Materias Perdidas</th>
                        <?php if(!empty($_REQUEST['tipo'])){?>
                        <th>Acci&oacute;n</th>
                        <?php } ?>
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
                	</tr>        
                </tfoot>    
                <?PHP 
				
				if($codigocarrera=='0'){
					
					if($semestre=='0'){
						/**************************************************/
						
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
                $cuentaregistros = 0;
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistros++;
							
						$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                            <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                            <td>&nbsp;<?php echo $detallenota->mensajepierdeMasde25yMenosde50; ?></td>
                            <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                            <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasde25yMenosde50;
                                    $arr['detallenota2']=''; 
                                    $arr['nombremateria']=''; 
                                    $arr['detallenota3']='';
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']='';
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                        </tr>
            <?php
                        }
				 }#Fin
						
						/***************************************************/
						}else{
							/*********************************************************/
							
							$C_Semestre			= explode('::',$semestre);  
							
							$cuentaregistros = 0;
							
							for($t=1;$t<count($C_Semestre);$t++){
								
								$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'

and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";	

				$estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
                
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistros++;
							
						$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                            <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                            <td>&nbsp;<?php echo $detallenota->mensajepierdeMasde25yMenosde50; ?></td>
                            <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                             <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasde25yMenosde50;
                                    $arr['detallenota2']=''; 
                                    $arr['nombremateria']=''; 
                                    $arr['detallenota3']='';
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']='';
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                        </tr>
            <?php
                        }
				 }#Fin
			}//For
		/*********************************************************/
		}//If
	
		 }else{
			 
			 
			 if($semestre=='0'){
				 /**************************************************************/
				 
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
               
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistros++;
							
						$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                            <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                            <td>&nbsp;<?php echo $detallenota->mensajepierdeMasde25yMenosde50; ?></td>
                            <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                             <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasde25yMenosde50;
                                    $arr['detallenota2']=''; 
                                    $arr['nombremateria']=''; 
                                    $arr['detallenota3']='';
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']='';
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                        </tr>
            <?php
                        }
				 }#Fin
		    }//For
				 
		 /**************************************************************/
		 }else{
			 /**************************************************************************/
			 
			 $C_Semestre			= explode('::',$semestre);  
							
			$cuentaregistros = 0;
			
			$C_CodigoCarrera	= explode('::',$codigocarrera);
			
			for($l=1;$l<count($C_CodigoCarrera);$l++){//for	
			
				for($t=1;$t<count($C_Semestre);$t++){
						
				$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'
and e.codigocarrera = '$C_CodigoCarrera[$l]'
and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";
					
                $estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
               
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						if (!$detallenota->esAltoRiesgo() && $detallenota->esMedianoRiesgo()) {
                            $cuentaregistros++;
							
						$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                            <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                            <td>&nbsp;<?php echo $detallenota->mensajepierdeMasde25yMenosde50; ?></td>
                            <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                             <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasde25yMenosde50;
                                    $arr['detallenota2']=''; 
                                    $arr['nombremateria']=''; 
                                    $arr['detallenota3']='';
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']='';
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                 $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                        </tr>
            <?php
                        }
				 }#Fin
		    }//For
		}//for
	 /************************************************************************/
	 }//if
		}
		 ?>		
     </table>	
     </div>	 
     <?PHP		 
		return $cuentaregistros; }	
	function RiesgoBajo($semestre,$codigoperiodo,$codigocarrera){
			global $db;
			?>
             <div id="demo">
             <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>N&deg;</th>
                        <th>Documento</th>
                        <th>Nombre Estudiante</th>
                        <th>E-Mail U. Bosque</th>
                        <th>E-Mail 1</th>
                        <th>E-Mail 2</th>
                        <th>Periodo Ingreso</th>
                        <th>Semestre</th>
                        <th>Carrera</th>
                        <th>Pierde Menos del 25% y Más del 0%</th>
                	<th>Materias Perdidas</th>
                        <?php if(!empty($_REQUEST['tipo'])){?>
                        <th>Acci&oacute;n</th>
                        <?php } ?>
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
                	</tr>        
                </tfoot>    
                <?PHP 
				
				if($codigocarrera=='0'){
					
					if($semestre=='0'){
						/******************************************************************/
						
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
                $cuentaregistros = 0;
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						
						if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
                            $cuentaregistros++;
							
							$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                                <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasde0yMenosde25; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                                 <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasde0yMenosde25;
                                    $arr['detallenota2']='';
                                    $arr['nombremateria']=''; 
                                    $arr['detallenota3']='';
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']='';
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                            </tr>
            <?php
                        }
				 }#Fin
						
			/******************************************************************/
			}else{
				/***************************************************************/
				
				$C_Semestre			= explode('::',$semestre); 
					
				$cuentaregistros = 0;
					
				for($t=1;$t<count($C_Semestre);$t++){
					
					$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'
and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";	

				$estudiantes = $db->Execute($query_estudiantes);
                $totalRows_estudiantes = $estudiantes->RecordCount();
                $hayregistros = false;
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						
						if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
                            $cuentaregistros++;
							
							$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                                <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasde0yMenosde25; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                                <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasde0yMenosde25;
                                    $arr['detallenota2']='';
                                    $arr['nombremateria']=''; 
                                    $arr['detallenota3']='';
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']='';
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                            </tr>
            <?php
                        }
				 }#Fin
					
			}//for
		
		/*****************************************************************/
	}
		
		}else{
				
			if($semestre=='0'){
				/**********************************************************/
				
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
                
				
				 while ($row_estudiantes = $estudiantes->FetchRow()) {
					 
					  unset($detallenota);
                    $codigoestudiante = $row_estudiantes['codigoestudiante'];
                    $detallenota = new detallenota($codigoestudiante, $codigoperiodo);
                            $detallenota->setAcumuladoCertificado("1");
							
						/*************************************************/	
						
						if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
                            $cuentaregistros++;
							
							$SQL='SELECT

									e.idestudiantegeneral,
									u.usuario,
									e.emailestudiantegeneral as email,
									e.email2estudiantegeneral as email2

									
									
									FROM
									
									usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
									
									
									WHERE
									
									e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
									
							if($Datos=&$db->Execute($SQL)===false){
									echo 'Error en el SQL...<br><br>'.$SQL;
									die;
								}		
            ?>
                            <tr class="odd_gradeX">
                                <td><?php echo $cuentaregistros; ?></td>
                                <td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
                                <td><?php echo $row_estudiantes['nombre']; ?></td>
                                <td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
                                <td><?PHP echo $Datos->fields['email']?></td>
                                <td><?PHP echo $Datos->fields['email2']?></td>
                                <td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
                                <td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
                                <td>&nbsp;<?php echo $detallenota->mensajepierdeMasde0yMenosde25; ?></td>
                                <td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                                <?php if(!empty($_REQUEST['tipo'])){
                                    $arr['idusuario']=$Datos->fields['idusuario'];
                                    $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                    $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                    $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                    $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                    $arr['detallenota1']=$detallenota->mensajepierdeMasde0yMenosde25;
                                    $arr['detallenota2']='';
                                    $arr['nombremateria']=''; 
                                    $arr['detallenota3']='';
                                    $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                    $arr['fallas']='';
                                    $arr['riesgo']=$_REQUEST['riesgo'];
                                    $tmp=serialize($arr);
                                    $tmp=urlencode($tmp);
                                  $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                            INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                            INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                            where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                $DatosR=$db->Execute($sql_tip);
                               $totalRows_S= $DatosR->RecordCount();
                                
                                if($totalRows_S==0){
                             ?>
                              <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                             <?php }else{
                                    ?><td>Ya esta en el PAE</td><?php
                                    }

                                } ?>
                            </tr>
            <?php
                        }
				 }#Fin
			}//for
				
		/**********************************************************/
		}else{
			/*********************************************************************/
			
			$C_CodigoCarrera	= explode('::',$codigocarrera);
				
		//	echo '<pre>';print_r($C_CodigoCarrera);die;
			
			$C_Semestre			= explode('::',$semestre); 
		//	echo '<pre>';print_r($C_Semestre);die;		
			$cuentaregistros = 0;
					
			for($l=1;$l<count($C_CodigoCarrera);$l++){//for	
				
				for($t=1;$t<count($C_Semestre);$t++){			
			
			$query_estudiantes = "select distinct e.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) as nombre, eg.numerodocumento, e.codigoperiodo,e.codigocarrera,
c.codigocarrera,
c.nombrecarrera, p.semestreprematricula, eg.idestudiantegeneral
from prematricula p, estudiante e, estudiantegeneral eg, detalleprematricula dp, carrera c
where e.codigoestudiante = p.codigoestudiante
and eg.idestudiantegeneral = e.idestudiantegeneral
and p.codigoestadoprematricula like '4%'
and p.codigoperiodo = '$codigoperiodo'
and p.semestreprematricula = '$C_Semestre[$t]'
and e.codigocarrera = '$C_CodigoCarrera[$l]'
and dp.idprematricula = p.idprematricula
and dp.codigoestadodetalleprematricula like '3%'
AND
c.codigocarrera=e.codigocarrera

order by 5 ,2";	
				
			$estudiantes = $db->Execute($query_estudiantes);
			$totalRows_estudiantes = $estudiantes->RecordCount();
			$hayregistros = false;
			
			 while ($row_estudiantes = $estudiantes->FetchRow()) {
				 
				  unset($detallenota);
				$codigoestudiante = $row_estudiantes['codigoestudiante'];
				$detallenota = new detallenota($codigoestudiante, $codigoperiodo);
						$detallenota->setAcumuladoCertificado("1");
						
					/*************************************************/	
					
					if (!$detallenota->esAltoRiesgo() && !$detallenota->esMedianoRiesgo() && $detallenota->esBajoRiesgo()) {
						$cuentaregistros++;
						
						$SQL='SELECT

								e.idestudiantegeneral,
								u.usuario,
								e.emailestudiantegeneral as email,
								e.email2estudiantegeneral as email2

								
								
								FROM
								
								usuario u INNER JOIN  estudiantegeneral e ON u.numerodocumento=e.numerodocumento AND u.tipodocumento=e.tipodocumento
								
								
								WHERE
								
								e.idestudiantegeneral="'.$row_estudiantes['idestudiantegeneral'].'"';
								
						if($Datos=&$db->Execute($SQL)===false){
								echo 'Error en el SQL...<br><br>'.$SQL;
								die;
							}		
		?>
						<tr class="odd_gradeX">
							<td><?php echo $cuentaregistros; ?></td>
							<td><?php echo  $row_estudiantes['numerodocumento'];//$row_estudiantes['numerodocumento']; ?></td>
							<td><?php echo $row_estudiantes['nombre']; ?></td>
							<td><?PHP echo $Datos->fields['usuario']?>@unbosque.edu.co</td>
							<td><?PHP echo $Datos->fields['email']?></td>
							<td><?PHP echo $Datos->fields['email2']?></td>
							<td><?php echo $row_estudiantes['codigoperiodo']; ?></td>
                                                        <td><?php echo $row_estudiantes['semestreprematricula']; ?></td>
							<td><?php echo $row_estudiantes['nombrecarrera']; ?></td>
							<td>&nbsp;<?php echo $detallenota->mensajepierdeMasde0yMenosde25; ?></td>
							<td><?php echo obternerNombreMateria($detallenota->materiasperdidas); ?>&nbsp;</td>
                                                        <?php if(!empty($_REQUEST['tipo'])){
                                                            $arr['idusuario ']=$Datos->fields['idusuario'];
                                                            $arr['numerodocumento']=$row_estudiantes['numerodocumento'];
                                                            $arr['codigoperiodo']=$row_estudiantes['codigoperiodo'];
                                                            $arr['semestreprematricula']=$row_estudiantes['codigoperiodo']; 
                                                            $arr['nombrecarrera']=$row_estudiantes['nombrecarrera'];
                                                            $arr['detallenota1']=$detallenota->mensajepierdeMasde0yMenosde25;
                                                            $arr['detallenota2']='';
                                                            $arr['nombremateria']=''; 
                                                            $arr['detallenota3']='';
                                                            $arr['detallenota4']=obternerNombreMateria($detallenota->materiasperdidas);
                                                            $arr['fallas']='';
                                                            $arr['riesgo']=$_REQUEST['riesgo'];
                                                            $tmp=serialize($arr);
                                                            $tmp=urlencode($tmp);
                                                            $sql_tip="SELECT * FROM obs_registro_riesgo AS r
                                                                        INNER JOIN estudiantegeneral as g on (r.codigoestudiante=g.idestudiantegeneral)
                                                                        INNER JOIN estudiante as e on (g.idestudiantegeneral=e.idestudiantegeneral)
                                                                        where g.numerodocumento='".$row_estudiantes['numerodocumento']."' ";
                                                            $DatosR=$db->Execute($sql_tip);
                                                            $totalRows_S= $DatosR->RecordCount();
                                                            //echo $totalRows_S.'<br>'; 
                                                            if($totalRows_S==0){
                                                         ?>
                                                          <td><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('../../../observatorio/interfaz/form_registro_riesgo.php?tipo=Notas&datos=<?php echo $tmp ?>')"><img src="../../../observatorio/img/editar.png" width="20px" height="20px"  /></button></td>
                                                         <?php }else{
                                                                ?><td>Ya esta en el PAE</td><?php
                                                                }
                                                            
                                                            } ?>
						</tr>
		<?php
					}
			 }#Fin
		}//for
	}//for
			/*********************************************************************/
			}//if	
		}
		 ?>		
     </table>
	 </div>
     <?PHP		 
		return $cuentaregistros;}		
?>