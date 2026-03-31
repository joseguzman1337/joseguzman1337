<?php
include('../templates/templateObservatorio.php');
 include("funciones.php"); 
 $db=writeHeader('Listar <br> Tipo Riesgo',true,'',1.,'Tipode riesgo');
 $fun = new Observatorio();
 $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Tipode riesgo'); 
 
$sql="SELECT * 
        FROM obs_tipocausas
        WHERE codigoestado=100 ";
    //echo $sql;
   $entity='tipocausas';
   $data_in= $db->Execute($sql);
   
  
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
</script>
 <form action="" method="post" id="form_test">
     <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
     <input type="hidden" name="entity" id="entity" value="tipocausas">
      
        <div id="container">
          <div id="demo">
           <table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
                <thead style=" background: #eff0f0">
                    <td>Acciones</td>
                    <td>Nombre</td>
                </thead>
                <tbody>
                <?php
                    foreach($data_in as $dt){
                    ?> 
                    <tr> 
                     <td>
                       <?php if ($roles['editar']==1){?><button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_<?php echo $entity ?>.php?id=row_<?php echo $dt['idobs_'.$entity.''] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /><?php } ?></button>
                       <?php if ($roles['eliminar']==1){?><button type="button" id="eliminar" name="eliminar" title="Eliminar" onclick="deleteRegistro('<?php echo $entity ?>','<?php echo $dt['idobs_'.$entity.''] ?>','listar_tipocausas.php')"><img src="../img/eliminar.png" width="20px" height="20px"  /><?php } ?></button>
                    </td><td>
                         <?php echo $dt['nombretipocausas']; ?>
                     </td>
                     </tr> 
                      <?php
                    }
                    ?> 
             </tbody>
           </table>
          </div>
            <br>
            <?php if ($roles['editar']==1){?>
           <a href="form_tipocausas.php" class="submit" tabindex="4">Nuevo</a>
            <?php } ?>
           &nbsp;&nbsp;
            <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
            </div>
    </form> 
<?php    
writeFooter();
        ?> 
