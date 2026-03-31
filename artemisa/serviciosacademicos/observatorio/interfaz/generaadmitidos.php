<?php
include('../templates/templateObservatorio.php');
//include_once ('funciones_datos.php');
   $db=writeHeaderBD();
   //$db=writeHeader('Observatorio',true,'');

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
// echo "<pre>"; print_r($_REQUEST);
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
     eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, ace.puntaje, ace.seguimiento, ea.nombreestadoadmision, 
     fa.nombrefacultad
     FROM estudianteestadistica ee
     INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
     INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
     INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
     INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100) 
	 LEFT JOIN obs_admitidos_cab_entrevista ace on ace.codigoperiodo=ee.codigoperiodo and ace.codigoestudiante=ee.codigoestudiante  
	 and ace.codigoestado=100
     LEFT JOIN obs_estadoadmision ea on (ace.idobs_estadoadmision=ea.idobs_estadoadmision) 
     where ee.codigoprocesovidaestudiante= 200 
     ".$wc." ".$wp." ".$wm." ".$wi."
     and ee.codigoprocesovidaestudiante= 200 and ee.codigoestado like '1%'
	GROUP BY ee.codigoestudiante";
}else if ($tipo2=='R') {

     $query_carrera = "SELECT ee.codigoestudiante, ee.codigoperiodo, e.codigocarrera,
     eg.nombresestudiantegeneral,  eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, 
     fa.nombrefacultad, ee.puntaje, ee.seguimiento, ea.nombreestadoadmision
     FROM obs_admitidos_cab_entrevista ee
     INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
     INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
     INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
     INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
     INNER JOIN obs_estadoadmision ea on (ee.idobs_estadoadmision=ea.idobs_estadoadmision)
     where ee.codigoestado like '1%' 
     ".$wc." ".$wp." ".$wm." ".$wi." GROUP BY ee.codigoestudiante order by ee.fechamodificacion desc";
}else{
   /* $query_carrera = "SELECT ee.codigoestudiante, ee.codigoperiodo, e.codigocarrera,
     eg.nombresestudiantegeneral,  eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, m.nombremodalidadacademica, 
     fa.nombrefacultad, ee.puntaje, ee.seguimiento, ea.nombreestadoadmision
     FROM obs_admitidos_cab_entrevista ee
     INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
     INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral 
     INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
     INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
     INNER JOIN obs_estadoadmision ea on (ee.idobs_estadoadmision=ea.idobs_estadoadmision)
     where ee.codigoestado like '1%' 
     ".$wc." ".$wp." ".$wm." ".$wi." order by ee.fechamodificacion desc";*/
     $query_carrera = " SELECT
                            ee.codigoestudiante,
                        	ee.codigoperiodo,
                        	e.codigocarrera,
                        	eg.nombresestudiantegeneral,
                        	eg.apellidosestudiantegeneral,
                        	eg.numerodocumento,
                        	c.nombrecarrera,
                        	m.nombremodalidadacademica, ace.puntaje, ace.seguimiento, ea.nombreestadoadmision,
                        	fa.nombrefacultad
                        
                        FROM
                        	estudiantegeneral AS eg
                        INNER JOIN estudiante AS e ON e.idestudiantegeneral = eg.idestudiantegeneral
                        INNER JOIN estudianteestadistica AS ee ON e.codigoestudiante = ee.codigoestudiante
                        INNER JOIN carrera AS c ON e.codigocarrera = c.codigocarrera
                        INNER JOIN facultad AS fa ON c.codigofacultad = fa.codigofacultad
                        INNER JOIN modalidadacademica AS m ON c.codigomodalidadacademica = m.codigomodalidadacademica
                        INNER JOIN periodo p ON e.codigoperiodo = p.codigoperiodo
                        INNER JOIN obs_admitidos_cab_entrevista ace ON e.codigoestudiante = ace.codigoestudiante and ace.codigoestado=100 
						LEFT JOIN obs_estadoadmision ea on (ace.idobs_estadoadmision=ea.idobs_estadoadmision) 
                        where p.codigoestadoperiodo in ('1','4') 
                            ".$wc." "."and p.codigoperiodo = '".$codigoperiodo."' "." ".$wm." ".$wi." GROUP BY eg.idestudiantegeneral order by ace.fechamodificacion desc ";
}
//echo $query_carrera;
$data_in= $db->Execute($query_carrera);
 
?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style="font-size: 10px;" width="100%">
    <thead style=" background: #eff0f0">
        <td>Acciones</td>
        <td>N Identificaci&oacute;n</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Carrera</td>
        <td>Facultad</td>
        <td>Modalidad Acad&eacute;mica</td>
        <td>Puntaje</td>
        <td>Seguimiento PAE</td>
        <td>Recomendación de admisión</td>
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){
			//echo "<br/>holaaaaaaaa";
            ?>
                 <tr>
                     <td> 
                        <?php
                             $cat=0;
                             $sqlpi="SELECT * FROM obs_admitidos_cab_entrevista WHERE codigoestudiante='".$dt['codigoestudiante']."' ";
                             //echo $sqlpi; 
                             $data_pi= $db->Execute($sqlpi);
                             $E_data = $data_pi->GetArray();
                             $E_data=$E_data[0];
                             $idpi=$E_data['idobs_admitidos_cab_entrevista'];
                             $cat=count($E_data);
							 //var_dump($E_data['seguimiento']);
							 //print_r($dt);
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
                            <td><?php if($dt['seguimiento']==1){ echo 'Si';}else{echo "No";} ?></td>
                            <td><?php echo $dt['nombreestadoadmision'] ?></td>
                        </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table></div>