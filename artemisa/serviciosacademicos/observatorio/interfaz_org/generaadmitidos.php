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
                                
//                                new FixedColumns( oTable, {
//                                         "iLeftColumns": 4,
//                                         "iLeftWidth": 500
//				} );
                                
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
                                
   });


</script>
<?php
$codigoperiodo=$_REQUEST['periodo'];
$modalidad=$_REQUEST['modalidad'];
$facultad=$_REQUEST['facultad'];
$nestudiante=$_REQUEST['nestudiante'];
$carrera=$_REQUEST['carrera'];
$tipo=$_REQUEST['tipo'];
$tipo2=$_REQUEST['tipo2'];
$vtipo=$_REQUEST['vtipo'];
$Utipo=$_REQUEST['Utipo'];

$wc=''; $wp=''; $wm=''; $wi='';
   
   
   
   if(!empty($carrera)){
       $wc=" AND e.codigocarrera='".$carrera."' ";
   }
   
   if(!empty($codigoperiodo)){
       $wp="and ee.codigoperiodo = '".$codigoperiodo."' ";
   }
   
   if(!empty($modalidad)){
       $wm=" AND c.codigomodalidadacademicasic='".$modalidad."' ";
   }
   
   if(!empty($nestudiante)){
       $wi=" and  eg.numerodocumento='".$nestudiante."' ";
   }
   
if (empty($_REQUEST['tipo'])){
        $query_carrera = "SELECT ee.codigoestudiante, ee.codigoperiodo, ee.codigoprocesovidaestudiante, e.codigocarrera,
     ee.estudianteestadisticafechafinal,eg.nombresestudiantegeneral, 
     eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, 
     fa.nombrefacultad
     FROM estudianteestadistica ee
     INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
     INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
     INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
     INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
     where ee.codigoprocesovidaestudiante= 200
     ".$wc." ".$wp." ".$wm." ".$wi."
     and ee.codigoprocesovidaestudiante= 200 and ee.codigoestado like '1%' ";
}else if ($tipo2=='R') {
     $query_carrera = "SELECT ee.codigoestudiante, ee.codigoperiodo, e.codigocarrera,
     eg.nombresestudiantegeneral,  eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, 
     fa.nombrefacultad, ee.puntaje, ee.seguimiento
     FROM obs_admitidos_cab_entrevista ee
     INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
     INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
     INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
     INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
     where ee.codigoestado like '1%'
     ".$wc." ".$wp." ".$wm." ".$wi." ";
}else{
    $query_carrera = "SELECT ee.codigoestudiante, ee.codigoperiodo, e.codigocarrera,
     eg.nombresestudiantegeneral,  eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, 
     fa.nombrefacultad, ee.puntaje, ee.seguimiento
     FROM obs_admitidos_cab_entrevista ee
     INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
     INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
     INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
     INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
     where ee.codigoestado like '1%'
     ".$wc." ".$wp." ".$wm." ".$wi." ";
}
//echo $query_carrera;
$data_in= $db->Execute($query_carrera);
 
?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
        <td>Acciones</td>
        <td>N Identificacion</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Carrera</td>
        <td>Facultad</td>
        <td>Modalidad Academica</td>
        <td>Puntaje</td>
        <td>Seguimiento PAE</td>
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td> 
                        <?php
                             $cat=0;
                             $sqlpi="SELECT * FROM obs_admitidos_cab_entrevista WHERE codigoestudiante='".$dt['codigoestudiante']."'    ";
                            // echo $sqlpi; 
                             $data_pi= $db->Execute($sqlpi);
                             $E_data = $data_pi->GetArray();
                             $E_data=$E_data[0];
                             $idpi=$E_data['idobs_admitidos_cab_entrevista'];
                             $cat=count($E_data);
                             if ($cat==0){

                            ?>
                             <button type="button" id="crear" name="crear" title="Realizar Entrevista" onclick="updateForm3('form_entrevista2.php?codigoestudiante=<?php echo $dt['codigoestudiante'] ?>&Utipo=<?php echo $_REQUEST['Utipo'] ?>')"><img src="../img/agregar.png" width="20px" height="20px"  /></button>
                            <?php
                            }else{
                                if(empty($tipo2)){
                                  $tip=0;
                                     if($vtipo=='Adm') $tip="&tipo=Adm";
                                      ?>
                                     <button type="button" id="editar" name="editar" title="Editar Entrevista" onclick="updateForm3('form_entrevista2.php?id=row_<?php echo $idpi ?><?php echo $tip; ?>&codigoestudiante=<?php echo $dt['codigoestudiante'] ?>&Utipo=<?php echo $_REQUEST['Utipo'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                                    <?php   
                                }else{
                                   ?>
                                   <button type="button" id="editar" name="editar" title="Crear Registro" onclick="updateForm3('form_registro_riesgo.php?tipo=Prueba&codigoestudiante=<?php echo $dt['codigoestudiante'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                                  <?php 
                                }
                            }
                         
                         ?>
                     </td>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
                            <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['nombrefacultad'] ?></td>
                            <td><?php echo $dt['nombremodalidadacademica'] ?></td>
                            <td><?php echo $dt['puntaje'] ?></td>
                            <td><?php if ($dt['seguimiento']==1) echo 'Si' ?></td>
                        </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table></div>