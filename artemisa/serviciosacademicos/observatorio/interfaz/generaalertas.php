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
$vtipo=$_REQUEST['vtipo'];
$tipofinanciero=$_REQUEST['idtipoestudianterecursofinanciero'];

$wc=''; $wp=''; $wm=''; $wi='';
   
   
   
   if(!empty($carrera)){
       $wc=" AND e.codigocarrera='".$carrera."' ";
   }
   
   if(!empty($codigoperiodo)){
       $wp="and e.codigoperiodo = '".$codigoperiodo."' ";
   }
   
   if(!empty($modalidad)){
       $wm=" AND c.codigomodalidadacademicasic='".$modalidad."' ";
   }
   
   if(!empty($nestudiante)){
       $wi=" and  eg.numerodocumento='".$nestudiante."' ";
   }
   
   if(!empty($tipofinanciero)){
       $wt=" and  t.idtipoestudianterecursofinanciero='".$tipofinanciero."' ";
   }else{
       $wt=" and t.idtipoestudianterecursofinanciero in (3,4,5,7,9,10,11)";
   }

     $query_carrera = "SELECT *
     FROM estudianterecursofinanciero as ee
     INNER JOIN tipoestudianterecursofinanciero as t on (ee.idtipoestudianterecursofinanciero=t.idtipoestudianterecursofinanciero and t.codigoestado=100) 
    INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=ee.idestudiantegeneral 
    INNER JOIN estudiante e ON e.idestudiantegeneral=ee.idestudiantegeneral 
    INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
    INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad) 
     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
     where ee.codigoestado like '1%'
     ".$wc." ".$wp." ".$wm." ".$wi."  ".$wt." ";

//echo $query_carrera;
$data_in= $db->Execute($query_carrera);
 
?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
        <td>No</td>
        <td>N Identificaci&oacute;n</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Carrera</td>
        <td>Facultad</td>
        <td>Modalidad Acad&eacute;mica</td>
        <td>Tipo de Financiaci&oacute;n</td>
        <td>Descripcion de Financiaci&oacute;sn</td>
    </thead>
    <tbody>
    <?php
        $i=1;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td><?php echo $i ?> </td>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
                            <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['nombrefacultad'] ?></td>
                            <td><?php echo $dt['nombremodalidadacademica'] ?></td>
                            <td><?php echo $dt['nombretipoestudianterecursofinanciero'] ?></td>
                            <td><?php echo $dt['descripcionestudianterecursofinanciero'] ?></td>
                        </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table></div>