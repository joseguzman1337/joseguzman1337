    
    <div id="contenidoSecundario">
            <h2>Responsables de la Función</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar responsable</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width: 100%;">
                    <thead>
                        <tr>                 
                            <th>Nombre de la Función</th>
                            <th>Usuario Responsable</th>
                            <th>Apellido Usuario Responsable</th>
                            <th>Tipo de Responsabilidad</th>
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
            //el id no cuenta, entonces desde nombre empieza en 0
            sql="SELECT g.idsiq_responsableFuncion,f.nombre as funcion,c.nombres,c.apellidos,t.nombre,g.usuario_modificacion,g.fecha_modificacion FROM siq_responsableFuncion g ";
            sql+='inner join siq_funcion f on f.idsiq_funcion = g.idsiq_funcion ';
            sql+='inner join usuario c on c.idusuario = g.idUsuarioResponsable ';
            sql+='inner join siq_tipoResponsabilidad t on t.idsiq_tipoResponsabilidad = g.idTipoResponsabilidad ';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_responsableFuncion&sql="+sql+"&wh=g.idsiq_funcion&vwh=<?php echo $_REQUEST["id"]; ?>&tableNickname=g&join=true",
                "aaSorting": [[ 5, "desc" ]],
                "aoColumnDefs": [ 
                    
						{ "bSearchable": true, "bVisible": false, "aTargets": [ 2 ] },
						{ "bSearchable": false, "bVisible": true, "aTargets": [ 4 ] },
						{ "fnRender": function ( oObj ) { return oObj.aData[1]+" "+oObj.aData[2];
                                                    }, "bSearchable": true, "bVisible": true, "aTargets": [ 1 ] },
                                                { "sClass": "column_fecha", "aTargets": [ 5,4,1,3 ] }
					]
            });
                        
            $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                }
             } );
            
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteResponsable("responsableFuncion");}                
            } );
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#contenidoSecundario',oTable);
        });   
</script>
