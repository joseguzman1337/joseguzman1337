<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
include('../templates/templateObservatorio.php');

   $db=writeHeaderBD();
   
   $val='';
   if (!empty($_REQUEST['id'])) $val=$_REQUEST['id'];
   $semestre=$_REQUEST['semestre'];
   $identi=$_REQUEST['nestudiante'];
   $modalidad=$_REQUEST['modalidad'];
   $codigocarrea=$_REQUEST['carrera'];
   $idobs_grupos=$_REQUEST['sala'];
   $periodo=$_REQUEST['periodo'];
   $tipo=$_REQUEST['tipo'];
   $wv=''; $wn=''; $wa=''; $wi=''; $wcr='';
   
  
   if(!empty($val)){
       $wv=" and  eg.idestudiantegeneral='".$val."'";
   }
   
   if(!empty($modalidad)){
       $wm=" and  eg.codigomodalidadacademica='".$modalidad."'";
   }
   
   if(!empty($codigocarrea)){
       if ($codigocarrea=='undefined'){
           $wcr=""; 
       }else{
        $wcr=" and  e.codigocarrera='".$codigocarrea."'";
       }
   }
   
   if(!empty($semestre)){
       $wa=" and  eg.semestre like '%".$semestre."%'";
   }
   
   if(!empty($identi)){
       $wi=" and  eg.numerodocumento='".$identi."'";
   }
   if(empty($tipo)){
   $query_estudiante = "
                    SELECT cr.codigoestudiante, eg.idestudiantegeneral, nombresestudiantegeneral, apellidosestudiantegeneral, numerodocumento, 
                    c.nombrecarrera, m.nombremodalidadacademica, fa.nombrefacultad
                    FROM obs_estudiante_competencia as cr
                    INNER JOIN `estudiantegeneral` as eg on (eg.idestudiantegeneral=cr.codigoestudiante)
                    INNER JOIN estudiante as e on (eg.idestudiantegeneral=e.idestudiantegeneral)
                    INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
                    INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
                    INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
                    where 1
                    ".$wv."
                    ".$wn."
                    ".$wa."
                    ".$wi." 
                    ".$wcr."
                     GROUP BY codigoestudiante ";
 
   }else if ($tipo==2){
       $wp="";
       if(!empty($periodo)){
           $wp=" and codigoperiodo='".$periodo."' ";
       }
       $query_estudiante="SELECT * 
                            FROM obs_competencias_nacional
                            where codigoestado=100 ".$wp."
                            group by codigoperiodo";
   }
   //echo $query_estudiante;
   $data_in= $db->Execute($query_estudiante);
   $F_data1 = $data_in->GetArray();
   $F_total1=count($F_data1);
   
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
if(empty($tipo)){
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
    </thead>
    <tbody>
        <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td> 
                             <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_estudiante_saberpro.php?idestudiante=<?php echo $dt['codigoestudiante'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                      </td>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
                            <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['nombrefacultad'] ?></td>
                            <td><?php echo $dt['nombremodalidadacademica'] ?></td>
                      </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table>
</div>
<?php
}else if ($tipo==2){
    ?>
        <div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
        <td>Acciones</td>
        <td>Periodo</td>
    </thead>
    <tbody>
        <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td> 
                             <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_nacional_saberpro.php?periodo=<?php echo $dt['codigoperiodo'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                      </td>
                            <td><?php echo $dt['codigoperiodo'] ?></td>
                      </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table>
    <?php
 
}
?>