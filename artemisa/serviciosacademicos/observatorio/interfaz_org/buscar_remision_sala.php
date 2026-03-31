<?php
include('../templates/templateObservatorio.php');
//include_once ('funciones_datos.php');
 //  $db=writeHeaderBD();
   $db=writeHeader('Observatorio',true,'');

   ?>
<script>
     $(document).ready( function () {
				var oTable = $('#customers').dataTable( {
                                        "sDom": '<"H"Cfrltip>',
                                        "bJQueryUI": false,
                                        "bProcessing": true,
   					"sScrollX": "100%",
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
                                         "iLeftColumns": 4,
                                         "iLeftWidth": 500
				} );
                                
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
                                
             $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {gotonuevo('form_registro_riesgo.php');  }
            } );
   });


</script>
<?php
$periodo=$_REQUEST['periodo'];
$modalidad=$_REQUEST['modalidad'];
$facultad=$_REQUEST['facultad'];
$ndocente=$_REQUEST['ndocente'];
$nestudiante=$_REQUEST['nestudiante'];
$semestre=$_REQUEST['semestre'];
$carrera=$_REQUEST['carrera'];
$grupos=$_REQUEST['grupos'];
$tipo=$_REQUEST['tipo'];

$wp=''; $wm=''; $wf=''; $wd=''; $we=''; $ws=''; $wn=''; $wca=''; $wcf=''; $wcp=''; $woc='';
if (!empty($periodo)) $wp=" and r.codigoperiodo='".$periodo."' ";
if (!empty($modalidad) or $modalidad!=0) $wm=" and c.codigomodalidadacademica='".$modalidad."' ";
if (!empty($facultad) or $facultad!=0) $wf=" and c.codigofacultad='".$facultad."' ";
if (!empty($ndocente)) $wd=" and d.numerodocumento='".$ndocente."' ";
if (!empty($nestudiante)) $we=" and e.numerodocumento='".$nestudiante."' ";
if (!empty($semestre)) $ws=" and  es.semestre in (".$semestre.")";
if (!empty($causas)) $wca=" and ro.idobs_causas in (".$causas.") ";
if (!empty($grupos)) $wc=" and g.idobs_grupos in (".$grupos.") ";


    $query_carrera = "SELECT r.id_estudiantes_grupos_riesgo, e.idestudiantegeneral, nombresestudiantegeneral, 
apellidosestudiantegeneral, numerodocumento, r.idobs_grupos, g.nombregrupos,
es.semestre, es.codigocarrera, c.nombrecarrera, m.nombremodalidadacademica, fa.nombrefacultad
FROM obs_estudiantes_grupos_riesgo as r
INNER JOIN obs_grupos as g on (r.idobs_grupos=g.idobs_grupos)
INNER JOIN estudiantegeneral as e ON (r.idestudiantegeneral=e.idestudiantegeneral)
INNER JOIN estudiante as es on (e.idestudiantegeneral=es.idestudiantegeneral)
INNER JOIN carrera as c on (es.codigocarrera=c.codigocarrera)
INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad)
INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
WHERE  r.codigoestado=100
     ".$wp." ".$wm." ".$wf."
     ".$wd." ".$we." ".$ws."
     ".$wn." ".$wca." ".$wcf."
     ".$wcp." ".$woc." ".$wc."
     ".$wrf." ".$wrp." ".$wrt."
 group by r.id_estudiantes_grupos_riesgo";

//echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
 
   //echo $reg_carrera->GetMenu2('codigocarrera',$data2[0]['codigocarrera'],false,false,1,' '.$onc.' name="codigocarrera"  id="codigocarrera"  style="width:150px;"')
 if ($tipo=='P'){
   ?>
<!--    <div class="DTTT_container" style=" width: 250px;">
        <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
        <span>Nuevo</span>
        </button>
    </div>-->
<?php
 }
?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
        <td>Acciones</td>
        <td>N Identificacion</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Semestre</td>
        <td>Carrera</td>
        <td>Facultad</td>
        <td>Modalidad Academica</td>
        <td>Sala de Aprendizaje</td> 
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td> 
                           <button type="button" id="crear" name="crear" title="Crear Tutoria" onclick="updateForm3('form_tutorias_sala.php?id_grupos=<?php echo $dt['id_estudiantes_grupos_riesgo'] ?>&tipotutoria=2' )"><img src="../img/agregar.png" width="20px" height="20px"  /></button>
                    </td>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
                            <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
                            <td><?php echo $dt['semestre'] ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['nombrefacultad'] ?></td>
                            <td><?php echo $dt['nombremodalidadacademica'] ?></td>
                            <td><?php echo $dt['nombregrupos'] ?></td> 
                        </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table></div>