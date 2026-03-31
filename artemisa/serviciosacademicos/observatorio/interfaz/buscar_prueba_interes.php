<?php
include('../templates/templateObservatorio.php');
include("funciones.php");
include("../class/toolsFormClass.php");
$fun = new Observatorio();
$tipo=$_REQUEST['tipo'];

if(!empty($_REQUEST['fecha_i']) and !empty($_REQUEST['fecha_f'])){
 $db =writeHeader("Prueba de<br> Intereses",true,"Admisiones");
}else{
 $db =writeHeader("Prueba de<br> Intereses",true,"Admisiones",1);   
}

$_REQUEST['id']=53;
if(!empty($_REQUEST['fecha_i']) and !empty($_REQUEST['fecha_f'])){
    
    $fec_ini=$_REQUEST['fecha_i'];
    $fec_ini=date("Y-m-d",  strtotime($fec_ini));
    
    $fec_fin=$_REQUEST['fecha_f'];
    $nuevafecha = strtotime ( '+1 day' , strtotime ( $fec_fin ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
   /*
    * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
    * Ajuste consulta para que muestre Interés Vocacional de la prueba realizada.
    * @since Febrero 26, 2018.
    */ 
    $query_carrera = "SELECT r.cedula, p.nombre, p.apellido, p.correo, idsiq_Arespuestainstrumento,r.fechacreacion, p.telefono, p.texto
            FROM siq_Arespuestainstrumento AS r
			INNER JOIN siq_Apublicoobjetivocsv AS p on (r.cedula=p.cedula)
			where r.fechacreacion BETWEEN '".$fec_ini."' AND '".$nuevafecha."' and r.idsiq_Ainstrumentoconfiguracion=53
            GROUP BY r.cedula
            ORDER BY r.fechacreacion";
      
   $data_in= $db->Execute($query_carrera);
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

            //<

                });


            </script>
    
        <table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
            <thead style=" background: #eff0f0">
                <td>Identificaci&oacute;n</td>
                <td>Fecha Prueba</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Correo</td>
                <td>Tel&eacute;fono</td>
                <td>Inter&eacute;s Vocacional</td> 
            </thead>
           <tbody>
            <?php
               $id=53;
                foreach($data_in as $dt){  
                    if(!empty($dt['nombre'])){
                    ?>
                         <tr>
                            <td><?php echo $dt['cedula'] ?></td>
                            <td><?php echo $dt['fechacreacion'] ?></td>
                            <td><?php echo $dt['nombre'] ?></td>
                            <td><?php echo $dt['apellido'] ?></td>
                            <td><?php echo $dt['correo'] ?></td>
                            <td><?php echo $dt['telefono'] ?></td>
                            <td><?php echo $dt['texto'] ?></td>
                        </tr>
                    <?php
                   }
                 $i++;
                }
            
            ?>
            </tbody>
        </table>
   <?php
}
        
?>
<script>
    $(function() {
            $( "#fecha_ini" ).datepicker({ 
                maxDate: '+0d',
                changeMonth: true,
                changeYear: true
            });
            
            $( "#fecha_fin" ).datepicker({
                maxDate: '+0d',
                changeMonth: true,
                changeYear: true
            });
    });
    
     function Buscar(){
        var fi=$("#fecha_ini").val();
        var ff=$("#fecha_fin").val();
       
        if (fi==''){
            alert("Debe escoger una fecha inicial");
                 $('#fecha_ini').css('border-color','#F00');
                 $('#fecha_ini').effect("pulsate", {times:3}, 500);
                 $("#fecha_ini").focus();
        }else if (ff==''){
            alert("Debe escoger una fecha final");
                 $('#fecha_ini').css('border-color','#F00');
                 $('#fecha_ini').effect("pulsate", {times:3}, 500);
                 $("#fecha_ini").focus();
        }else{    
            $('#demo').html('<blink>Cargando...</blink>');
            $.ajax({//Ajax
                      type: 'POST',
                      url: 'buscar_prueba_interes.php',
                      async: false,
                      //dataType: 'json',
                      data:({fecha_i:fi, fecha_f:ff }),
                     error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                     success:function(data){
                     $('#demo').html(data);
               }
            }); //AJAX   
        }
    }
</script>

<br>
<?php
if(empty($_REQUEST['fecha_i']) and empty($_REQUEST['fecha_f'])){
?>
    <table border="0" class="CSSTableGenerator" aling="center" style=" width: 600px; margin-left: 300px">
        <tr>
            <td>Fecha Inicial</td>
            <td><input type="text" id="fecha_ini" name="fecha_ini" /></td>
            <td>Fecha Final</td>
            <td><input type="text" id="fecha_fin" name="fecha_fin" /></td>
            <td><button type="button" id="buscar" name="buscar" onclick="Buscar()" class="submit">Buscar</button></td>
        </tr>
    </table>
    <?php } ?>
<br>
 <div id="demo" style="width: 1030px;">
                
 </div>

