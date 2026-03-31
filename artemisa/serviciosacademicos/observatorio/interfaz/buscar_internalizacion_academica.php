<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('../templates/templateObservatorio.php');
include("funciones.php");

 $db =writeHeader("Repitecia <br> Academica",true,"PAE");
    //require_once('../../funciones/sala/nota/nota.php');
    //require_once('../../funciones/sala/estudiante/estudiante.php');
    $fun = new Observatorio();
    $tipo=$_REQUEST['tipo'];
    $codigoperiodo=$_REQUEST['periodo'];
    $codigocarrera=$_REQUEST['carrera'];
    $modalidad=$_REQUEST['modalidad'];
    $estudiante=$_REQUEST['nestudiante'];
    
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
                                        "oColVis": {
                                                "buttonText": "Ver/Ocultar Columns",
                                                 "aiExclude": [ 0 ]
                                          }

				} );
				//new FixedColumns( oTable );
                                
      
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
if (!empty($periodo)) $wp=" and em.codigoperiodo='".$periodo."' ";
if (!empty($modalidad) or $modalidad!=0) $wm=" and c.codigomodalidadacademica='".$modalidad."' ";
if (!empty($facultad) or $facultad!=0) $wf=" and c.codigofacultad='".$facultad."' ";
if (!empty($nestudiante)) $we=" and eg.numerodocumento='".$nestudiante."' ";
if (!empty($carrera)) $wc=" and c.codigocarrera in (".$carrera.") ";

        $query_carrera="SELECT * 
                        FROM estudiantesituacionmovilidad as em
                        INNER JOIN situacionmovilidad as m on (em.idsituacionmovilidad=m.idsituacionmovilidad)
                        INNER JOIN estudiante e ON e.codigoestudiante = em.codigoestudiante 
                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral 
                        INNER JOIN carrera as c on (e.codigocarrera=c.codigocarrera)
                        INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad)
                        INNER JOIN modalidadacademica as mo on (c.codigomodalidadacademica=mo.codigomodalidadacademica and mo.codigoestado=100)                   
                        where em.codigoestado=100
                    ".$wp." ".$wm." ".$wf."
                    ".$wd." ".$we." ".$ws."
                    ".$wn." ".$wca." ".$wc."
                        ";
   //echo $query_carrera;
   $data_in= $db->Execute($query_carrera);

        
 ?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
    <td>N Identificaci&oacute;n</td>
        <td>Nombre</td>
        <td>Carrera</td>
        <td>Semestre</td>
        <td>Desde</td> 
        <td>Hasta</td> 
        <td>Esatdo</td>
    </thead>
    <tbody>
    <?php foreach($data_in as $dt){ 
?>
                        <tr>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'].' '.$dt['apellidosestudiantegeneral']; ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['semestre'] ?></td>
                            <td><?php echo $dt['periodoinicial']?></td>
                            <td><?php echo $dt['periodofinal']?></td>
                            <td><?php echo $dt['nombre'] ?></td>
                        </tr>
                    <?php
                    $i++;
             //}
  
        }
    ?>
    </tbody>
</table>
    <br>
     &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
</div>