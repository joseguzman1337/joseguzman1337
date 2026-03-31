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
$nivel=$_REQUEST['nivel'];
$causas=$_REQUEST['causas'];
$carrera=$_REQUEST['carrera'];
$tipo=$_REQUEST['tipo'];

$wp=''; $wm=''; $wf=''; $wd=''; $we=''; $ws=''; $wn=''; $wca=''; $wcf=''; $wcp=''; $woc='';
if (!empty($periodo)) $wp=" and r.codigoperiodo='".$periodo."' ";
if (!empty($modalidad) or $modalidad!=0) $wm=" and c.codigomodalidadacademica='".$modalidad."' ";
if (!empty($facultad) or $facultad!=0) $wf=" and c.codigofacultad='".$facultad."' ";
if (!empty($ndocente)) $wd=" and d.numerodocumento='".$ndocente."' ";
if (!empty($nestudiante)) $we=" and e.numerodocumento='".$nestudiante."' ";
if (!empty($semestre)) $ws=" and  es.semestre in (".$semestre.")";
if (!empty($nivel)) $wn=" and tr.idobs_tiporiesgo in (".$nivel.")";
if (!empty($causas)) $wca=" and ro.idobs_causas in (".$causas.") ";
if (!empty($carrera)) $wc=" and c.codigocarrera in (".$carrera.") ";
if ($tipo=='R'){
         $query_carrera = "SELECT r.idobs_registro_riesgo, e.numerodocumento, nombresestudiantegeneral, apellidosestudiantegeneral,  
       nombredocente, apellidodocente, d.numerodocumento as numerodocumentodocente,
es.semestre, es.codigocarrera, c.nombrecarrera, m.nombremodalidadacademica, fa.nombrefacultad,
f.nombrecausas as causas, t.nombretipocausas,  tr.nombretiporiesgo, observacionesregistro_riesgo, intervencionregistro_riesgo, re.idobs_tiporemision
FROM obs_primera_instancia as pi
INNER JOIN obs_registro_riesgo as r on (r.idobs_registro_riesgo=pi.idobs_registro_riesgo)
INNER JOIN obs_registro_riesgo_causas as ro on (r.idobs_registro_riesgo=ro.idobs_registro_riesgo)
INNER JOIN obs_tiporiesgo AS tr on (r.idobs_tiporiesgo=tr.idobs_tiporiesgo)
INNER JOIN obs_remision as re on (re.idobs_registro_riesgo=r.idobs_registro_riesgo)
INNER JOIN estudiantegeneral as e on (r.codigoestudiante=e.idestudiantegeneral) 
INNER JOIN estudiante as es on (e.idestudiantegeneral=es.idestudiantegeneral)
INNER JOIN carrera as c on (es.codigocarrera=c.codigocarrera)
INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad)
INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
INNER JOIN usuario as u on (u.idusuario=r.usuariocreacion)
LEFT JOIN docente as d on (d.numerodocumento=u.numerodocumento) 
LEFT JOIN obs_causas as f on (f.idobs_causas=ro.idobs_causas and f.codigoestado=100) 
LEFT JOIN obs_tipocausas as t on (f.idobs_tipocausas=t.idobs_tipocausas)
WHERE r.codigoestado=100  and re.idobs_tiporemision=2 
     ".$wp." ".$wm." ".$wf."
     ".$wd." ".$we." ".$ws."
     ".$wn." ".$wca." ".$wcf."
     ".$wcp." ".$woc." ".$wc."
     ".$wrf." ".$wrp." ".$wrt."
group by e.numerodocumento order by r.fechacreacion desc";
}else{
    $query_carrera = "SELECT r.idobs_registro_riesgo, e.numerodocumento, nombresestudiantegeneral, apellidosestudiantegeneral,  
       nombredocente, apellidodocente, d.numerodocumento as numerodocumentodocente,
es.semestre, es.codigocarrera, c.nombrecarrera, m.nombremodalidadacademica, fa.nombrefacultad,
f.nombrecausas as causas, t.nombretipocausas,  tr.nombretiporiesgo, observacionesregistro_riesgo, intervencionregistro_riesgo, rp.idobs_remision_financiera
 FROM obs_remision_financiera as rp 
INNER JOIN obs_primera_instancia as pi ON (rp.idobs_registro_riesgo=pi.idobs_registro_riesgo and pi.codigoestado=100) 
INNER JOIN obs_registro_riesgo as r on (r.idobs_registro_riesgo=pi.idobs_registro_riesgo)
INNER JOIN obs_registro_riesgo_causas as ro on (r.idobs_registro_riesgo=ro.idobs_registro_riesgo)
INNER JOIN obs_tiporiesgo AS tr on (r.idobs_tiporiesgo=tr.idobs_tiporiesgo)
INNER JOIN estudiantegeneral as e on (r.codigoestudiante=e.idestudiantegeneral) 
INNER JOIN estudiante as es on (e.idestudiantegeneral=es.idestudiantegeneral)
INNER JOIN carrera as c on (es.codigocarrera=c.codigocarrera)
INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad)
INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
INNER JOIN usuario as u on (u.idusuario=r.usuariocreacion)
LEFT JOIN docente as d on (d.numerodocumento=u.numerodocumento) 
LEFT JOIN obs_causas as f on (f.idobs_causas=ro.idobs_causas and f.codigoestado=100) 
LEFT JOIN obs_tipocausas as t on (f.idobs_tipocausas=t.idobs_tipocausas)
WHERE r.codigoestado=100 
     ".$wp." ".$wm." ".$wf."
     ".$wd." ".$we." ".$ws."
     ".$wn." ".$wca." ".$wcf."
     ".$wcp." ".$woc." ".$wc."
     ".$wrf." ".$wrp." ".$wrt."
group by e.numerodocumento order by r.fechacreacion desc";
}
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
        <td>Nivel de Riesgo</td>
        <td>Nombre Docente</td> 
        <td>Apellido Docente</td> 
        <?php
             if ($tipo=='P'){
        ?>
            <td>Fecha De Creacion</td>
        <?php
           }
        ?>
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td> 
                         <?php
                         if ($tipo=='R'){
                            ?>
                              <button type="button" id="crear" name="crear" title="Crear Registro Financiero" onclick="updateForm3('form_remision_financiera.php?id_res=<?php echo $dt['idobs_registro_riesgo'] ?>')"><img src="../img/agregar.png" width="20px" height="20px"  /></button>
                          
                         <?php
                         }else{
                             ?>
                            <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_remision_financiera.php?id=row_<?php echo $dt['idobs_remision_financiera'] ?>&id_res=<?php echo $dt['idobs_registro_riesgo'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                            <!--<button type="button" id="eliminar" name="eliminar" title="Eliminar" onclick="deleteRegistro('remision_financiera','<?php echo $dt['idobs_remision_financiera'] ?>','listar_riesgo_financiero.php?tipo=R')"><img src="../img/eliminar.png" width="20px" height="20px"  /></button>-->
                         <?php
                          }
                         ?>
                     </td>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
                            <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
                            <td><?php echo $dt['semestre'] ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['nombrefacultad'] ?></td>
                            <td><?php echo $dt['nombremodalidadacademica'] ?></td>
                            <td><?php echo $dt['nombretiporiesgo'] ?></td>
                            <td><?php echo $dt['nombredocente'] ?></td> 
                            <td><?php echo $dt['apellidodocente'] ?></td>
                            <?php
                            if ($tipo=='P'){
                       ?>
                                <td><?php echo $dt['fechacreacion'] ?></td>
                       <?php
                          }
                       ?>
                        </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table></div>