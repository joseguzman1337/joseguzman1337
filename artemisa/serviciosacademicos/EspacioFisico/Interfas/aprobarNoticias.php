<?php

    include("template.php");
    writeHeader("Publicación de Noticias y Eventos",false);
	
    include("./menuNoticias.php");
	
	$aprobado=0;
	if(isset($_GET["aprobado"])){
		$aprobado=1;
	} 
    writeMenuAprobarNoticia($aprobado+1);
       ?>

<div id="container">
            <h2>Publicación de Noticias y Eventos</h2>
            <div class="demo_jui">
			<?php if(!$aprobado) { ?>
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Aprobar noticia</span>                
                    </button>
                </div>
			<?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>      
                            <th>Código</th>    
                            <th>Titulo</th> 
                            <th>Noticia</th>     
                            <th>Fecha Inicio</th>       
                            <th>Fecha Fin</th>                               
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
            
            <?php $fechahoy=date("Y-m-d H:i:s"); ?>
                        
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "../../mgi/server_processing.php?IndexColumn=NoticiaEventoId&table=NoticiaEvento&action=traerNoticiasPantallas&wh=g.NoticiaEventoId&tableNickname=g&cwh=g.CodigoEstado=100 AND g.AprobadoPublicacion=<?php echo $aprobado; ?>",
                "aaSorting": [[ 4, "DESC" ]],
                "aoColumnDefs": [  
                                                //{ "bSearchable": true, "bVisible": false, "aTargets": [ 3,5 ] },
                                                //{ "bSearchable": false, "bVisible": true, "aTargets": [ 6,7 ] },
												{ "sClass": "column_fecha", "aTargets": [ 0,3,4 ] }
                            ],
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth);
                        }
            });
                        
            $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_0").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_0").removeClass('DTTT_disabled');
                }
             } );
            
            $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {					
					if(confirm('¿Esta seguro de aprobar esta noticia para su publicación?')){                
						if(aSelected.length==1){
							var id = aSelected[0];
							id=id.substring(4,id.length);                
							$.ajax({
								dataType: 'json',
								type: 'POST',
								url: 'processNoticias.php',
								data: 'NoticiaEventoId='+id+'&entity=NoticiaEvento&action=aprobar',
								success:function(data){ 
									if (data.success == true){
										 location.reload();
									} else {
										alert(data.message);
									}
								},
								error: function(data,error){}
							}); 
						}else{
							return false;
						}               
					}
				}
            } );
                          
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        });      
        </script>
    
<?php    writeFooter();
        ?>       


