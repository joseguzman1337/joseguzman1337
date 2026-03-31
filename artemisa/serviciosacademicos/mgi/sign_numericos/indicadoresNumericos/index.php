<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
      include($rutaTemplate."templateNumericos.php");
      include("../../API_Monitoreo.php"); 
      $Monitoreo = new API_Monitoreo(); 
 //     $lista = $Monitoreo->getQueryIndicadoresACargo();
//echo 'lista'.$lista;
    $db = writeHeader("Gestión de Indicadores",true,$proyectoNumericos);
    
    include("./menu.php");
    writeMenu(1);    ?>

<div id="container">
            <h2>Administración de Indicadores Numéricos</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Ver detalle</span>                
                    </button>
                   <!--<button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Editar</span>
                    </button>-->
                   <!-- <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Asignar Responsable</span>                
                    </button>-->
                    <!--<button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Gestionar Vencimiento</span>                
                    </button>-->
                    <!--<button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Inactivar</span>                
                    </button>-->
                    <!--<button id="ToolTables_example_5" class="DTTT_button DTTT_button_text">
                        <span>Prueba</span>                
                    </button>-->
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>         
                            <th>Indicador</th> 
                            <th>ID Discriminación</th>  
                            <th>Discriminación</th>  
                            <th>Carrera</th>      
                            <th>Estado</th>
                            <th>Fecha Última Modificación</th>    
                             <th>¿Documento?</th>  
                              <th>Función</th>  
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
            
            //sql="SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera,f.nombrefacultad as facultad,e.nombre as estado,g.fecha_modificacion FROM siq_indicador g ";
            //sql+='inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico ';
            //sql+='inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion ';
            //sql+='left join carrera c on c.codigocarrera = g.idCarrera ';
            //sql+='left join facultad f on f.codigofacultad = g.idFacultad ';
            //sql+='inner join siq_estadoIndicador e on e.idsiq_estadoIndicador = g.idEstado ';
            
            sql="SELECT g.idsiq_indicador,id.nombre,g.discriminacion as disc,d.nombre as discriminacion,c.nombrecarrera as carrera,e.nombre as estado,g.fecha_modificacion, i.existe , f.nombre   FROM sala.siq_funcionIndicadores n ";
            sql+='RIGHT join siq_indicador g  on n.idIndicador = g.idsiq_indicador  ';
            sql+='inner join siq_indicadorGenerico id on id.idsiq_indicadorGenerico = g.idIndicadorGenerico ';
            sql+='inner join siq_discriminacionIndicador d on d.idsiq_discriminacionIndicador = g.discriminacion ';
            sql+='left join carrera c on c.codigocarrera = g.idCarrera ';
            sql+='left join sala.siq_funcion f on n.idsiq_funcion = f.idsiq_funcion ';
            sql+='left join sala.siq_existe i on g.inexistente = i.idsiq_existe ';
            sql+='inner join siq_estadoIndicador e on e.idsiq_estadoIndicador = g.idEstado and id.idTipo = 3 ';
            //sql+='inner join "(<?PHP #echo $lista; ?>)" on l.idsiq_indicador = g.idsiq_indicador ';
            //sql+='where  id.idTipo = 3';
            
            
                console.log(sql);
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                 "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_indicador&sql="+sql+"&wh=g.usuario_modificacion&tableNickname=g&join=true",
                "aaSorting": [[ 0, "desc" ]],
                "aoColumnDefs": [  
                                                { "bSearchable": true, "bVisible": false, "aTargets": [ 1,3 ] },
						{ "sClass": "column_fecha", "aTargets": [ 5 ] },
                                                { "fnRender": function ( oObj ) {
                                                    if(oObj.aData[1]==1){
                                                       return oObj.aData[0] + ' (' + oObj.aData[2] + ')';     
                                                    } else if(oObj.aData[1]==3) {
                                                        return oObj.aData[0] + ' (' + oObj.aData[3] + ")";
                                                    } 
                                                  },
                                                "aTargets": [ 0 ]}
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
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                    $("#ToolTables_example_0").addClass('DTTT_disabled');
                    $("#ToolTables_example_4").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                    $("#ToolTables_example_0").removeClass('DTTT_disabled');
                    $("#ToolTables_example_4").removeClass('DTTT_disabled');
                }
             } );
            
            $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {
                    
                     if(aSelected.length==1){
                        var id = aSelected[0];
                              llamaphp();
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
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateForm(); }               
            } );
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {assignResponsable();}                
            } );
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteForm("indicador");}                
            } );          
            
            $('#ToolTables_example_4').click( function () {  
                if(!$('#ToolTables_example_4').hasClass('DTTT_disabled'))
                {
                      if(aSelected.length==1){
                        var id = aSelected[0];
                            window.location.href= "monitoreoIndicador.php?id="+id;
                      } else{
                            return false;
                      }                  
                }                
            });
            
            //$('#ToolTables_example_5').click( function () {  
            //    if(!$('#ToolTables_example_5').hasClass('DTTT_disabled'))
            //   {
            //          if(aSelected.length==1){
            //                var id = aSelected[0];
            //                id=id.substring(4,id.length);                
            //                $.ajax({
            //                    dataType: 'json',
            //                    type: 'POST',
            //                    url: 'process.php',
            //                    data: 'idsiq_indicador='+id+'&entity=indicador&action=revisar',
            //                    success:function(data){ 
            //                        if (data.success == true){
            //                            location.reload();
            //                        }
            //                    },
            //                    error: function(data,error){}
            //                }); 
            //            }else{
            //                    return false;
            //        }                     
            //    }                
            //});
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#container',oTable);
        }); 
        
        function llamaphp(){
             var id = aSelected[0];
            id=id.substring(4,id.length);
           
		  window.location.href= "../../sign_numericos/indicadoresNumericos/documentos.php?id="+id;
	}
        
        //function retorno(variablejs){
        //    alert ("Entre");
        //    document.write("index = " + variablejs);
	//	docdetallever(variablejs);
	//}
        
        
        
        </script>
    
<?php    writeFooter();
        ?>       
   

