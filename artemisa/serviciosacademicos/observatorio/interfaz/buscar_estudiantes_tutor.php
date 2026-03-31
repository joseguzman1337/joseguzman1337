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
$nestudiante=$_REQUEST['nestudiante'];
$semestre=$_REQUEST['semestre'];
$carrera=$_REQUEST['carrera'];
$tipo=$_REQUEST['tipo'];

$semestre = str_replace("\\", "", $semestre );
$carrera = str_replace("\\", "", $carrera );

$wp=''; $wm=''; $wf=''; $wd=''; $we=''; $ws=''; $wn=''; $wca=''; $wcf=''; $wcp=''; $woc='';
if (!empty($periodo)) $wp=" and r.codigoperiodo='".$periodo."' ";
if (!empty($modalidad) or $modalidad!=0) $wm=" and c.codigomodalidadacademica='".$modalidad."' ";
if (!empty($facultad) or $facultad!=0) $wf=" and c.codigofacultad='".$facultad."' ";
if (!empty($nestudiante)) $we=" and e.numerodocumento='".$nestudiante."' ";
if (!empty($semestre)) $ws=" and  es.semestre in (".$semestre.")";
if (!empty($carrera)) $wc=" and c.codigocarrera in (".$carrera.") ";

   $query_carrera = "SELECT r.idobs_estudiante_tutor, e.numerodocumento, nombresestudiantegeneral, apellidosestudiantegeneral,  
       es.semestre, es.codigocarrera, c.nombrecarrera,  
       fa.nombrefacultad, m.nombremateria
FROM `obs_estudiante_tutor` as r 
INNER JOIN estudiantegeneral as e on (r.codigoestudiante=e.idestudiantegeneral) 
INNER JOIN estudiante as es on (e.idestudiantegeneral=es.idestudiantegeneral)
INNER JOIN carrera as c on (es.codigocarrera=c.codigocarrera)
INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad)
LEFT OUTER JOIN materia m on (m.codigomateria = r.codigomateria)
WHERE r.codigoestado=100
".$wp." ".$wm." ".$wf."
".$wd." ".$we." ".$ws."
".$wn." ".$wca." ".$wcf."
".$wcp." ".$woc." ".$wc."

order by r.fechacreacion desc";
//echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
//echo "<pre>";print_r($data_in->fields["idobs_estudiante_tutor"]); 
   //echo $reg_carrera->GetMenu2('codigocarrera',$data2[0]['codigocarrera'],false,false,1,' '.$onc.' name="codigocarrera"  id="codigocarrera"  style="width:150px;"')
 if ($tipo=='R'){
   ?>
    <div class="DTTT_container" style=" width: 250px;">
        <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
        <span>Nuevo</span>
        </button>
    </div>
<?php
 }
?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
        <td>Acciones</td>
        <td>N Identificaci&oacute;n</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Semestre</td>
        <td>Carrera</td>
        <td>Materia</td>
        <td>Facultad</td>
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td> 
                          <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_estudiante_tutor.php?id=row_<?php echo $dt['idobs_estudiante_tutor'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                          <button type="button" id="eliminar" name="eliminar" title="Eliminar" onclick="deleteRegistro('estudiante_tutor','<?php echo $dt['idobs_estudiante_tutor'] ?>','listar_estudiante_tutor.php')"><img src="../img/eliminar.png" width="20px" height="20px"  /></button>
                     </td>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
                            <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
                            <td><?php echo $dt['semestre'] ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['nombremateria'] ?></td>
                            <td><?php echo $dt['nombrefacultad'] ?></td>
                        </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table></div>