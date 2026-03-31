<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
    <div id="contenidoSecundario">
            <h2>Valores del Indicador Numérico</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                   <!-- <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar Valores</span>                
                    </button>
                     <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ingresar Valores</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar Valores</span>                
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Inactivar Valores</span>                
                    </button> -->
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width: 100%;">
                    <thead>
                        <tr>                 
                            <th>Tipo de Indicador</th>
                            <th>Periodo Indicador</th>
                            <th>Valor Indicador</th>
                            <th>Usuario Modificación</th>
                            <th>Fecha Modificación</th>                           
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
        </div>

<script type="text/javascript">
        var oTable;
        var aSelected = [];           
                      
        $(document).ready(function() {  
            var sql;
            sql="SELECT g.idsiq_funcionTipo1,g.tipo,g.idPeriodo,g.valor,g.fecha_creacion,g.fecha_modificacion FROM siq_funcionTipo1 g ";
            sql+='inner join `sala`.`siq_funcionIndicadores` f on g.`siq_funcionIndicadores` = f.`idsiq_funcionIndicadores`';
            
            //console.log(sql);
            
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_funcionTipo1&sql="+sql+"&wh=f.idindicador&vwh=<?php echo $_REQUEST["id"]; ?>&tableNickname=g&join=true",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [ 
                    
						{ "bSearchable": true, "bVisible": true, "aTargets": [ 1 ] },
						{ "bSearchable": false, "sClass": "column_center", "bVisible": true, "aTargets": [ 3 ] },
						//{ "fnRender": function ( oObj ) { return oObj.aData[0]+" "+oObj.aData[1];
                                                  //  }, "bSearchable": true, "sClass": "column_center", "bVisible": true, "aTargets": [ 0 ] },
                                                { "sClass": "column_center", "aTargets": [ 4,2 ] }
					]
            });
                        
            $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled'); 
                     $("#ToolTables_example_2").removeClass('DTTT_disabled'); 
                }
             } );
            
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteResponsable("siq_funcionTipo1");}                
            } );
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateForm(); }               
            } );
            
             $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {
                    
                     //if(aSelected.length==1){
                       // var id = aSelected[0];
                           //   llamaphp();
                //}
                    insertForm(); 
                
            }               
            } );
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#contenidoSecundario',oTable);
        });  
        
        
          function llamaphp(){
             var id = aSelected[0];
            id=id.substring(4,id.length);
           
		  window.location.href= "../../sign_numericos/adminFunciones/funciontipo1.php?rw_app_id=1&code=test&device_id=test6255441854";
	}
        
        
</script>
