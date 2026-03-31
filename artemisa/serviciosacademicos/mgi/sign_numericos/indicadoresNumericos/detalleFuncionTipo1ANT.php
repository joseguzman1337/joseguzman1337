    <div id="contenidoSecundario">
            <h2>Valores del Indicador Numérico</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                   <!-- <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Borrar Valor</span>                
                    </button> -->
                     <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ingresar Valor</span>                
                    </button>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar Valor</span>                
                    </button>
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
            sql="SELECT g.idsiq_funcionTipo1,i.nombre,p.nombre,g.valor,g.usuario_modificacion,g.fecha_modificacion FROM siq_funcionTipo1 g ";
            sql+='inner join siq_funcionIndicadores f on g.funcionIndicadores = f.idsiq_funcionIndicadores ';
            sql+='left join siq_periodo p on g.idPeriodo = p.idsiq_periodo ';
            sql+='left join siq_infoIndicador i on g.tipo = i.idsiq_infoIndicador ';
            sql+='where  f.idindicador = <?php echo $_REQUEST["id"]; ?>';
            //alert (sql);
            //console.log(sql);
            
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
               "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_funcionTipo1&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true",
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
                {deleteValor("funcionTipo1");}                
            } );
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateFormTipo1(); }               
            } );
            
             $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {
                    
                     //if(aSelected.length==1){
                       // var id = aSelected[0];
                           //   llamaphp();
                //}
                
                    //insertForm(); 
                    
                     if(aSelected.length==1){
                        var id = aSelected[0];
                              insertarphp();
                            // docdetallecargar();
                              
                             // var idDocumento = 20;
                             //   docdetallever(idDocumento);
                               //window.location.href= "../../sign_numericos/indicadoresNumericos/documentos.php?indicador_id="+id;
                               // window.location.href= "../../sign_numericos/indicadoresNumericos/documentos.php";
                      } else{
                            return false;
                      }   
                
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
        
         function insertarphp(){
             var id = aSelected[0];
            id=id.substring(4,id.length);
           
		  window.location.href= "../../sign_numericos/indicadoresNumericos/insertar.php?id="+ <?php echo $_REQUEST["id"]; ?>;
	}
        
        
        
</script>
