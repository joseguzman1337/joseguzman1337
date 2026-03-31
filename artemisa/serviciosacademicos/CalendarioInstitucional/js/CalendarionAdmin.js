$(document).ready(function () {
    oTable = $('#CalendarioInstitucional').dataTable({
            "sDom": '<"H"Cfrltip>',
            "bJQueryUI": true,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "oColVis": {
                  "buttonText": "Ver/Ocultar Columns",
                
            }
        });
        var oTableTools = new TableTools( oTable, {
        "buttons": [
            "copy",
            "csv",
            "xls",
            "pdf",
            { "type": "print", "buttonText": "Print me!" }
            ]
        });  
    
    $('#ToolTables_example_0').click(
        function(){
            DisplayCreate();
        }
    );
    $('#ToolTables_example_1').click(
        function(){
            DisplayEdit();
        }
    );   
    $('#ToolTables_example_2').click(
        function(){
            var confirmar = 'Desea Cambiar el estado del evento...?';
            
            if(confirm(confirmar)){
                var id = $('#id_cargado').val();
                $.ajax({ //Ajax
                    type: 'POST',
                    url: '../Controller/CalendarioInstitucional_html.php',
                    async: false,
                    dataType: 'json',
                    data:({action_ID: 'CambioEstado',id:id}),
                    error: function (objeto, quepaso, otroobj) {
                        alert('Error de Conexi?n , Favor Vuelva a Intentar');
                    },
                    success: function (data) {
                            if(data.val===false){
                                alert(data.msj);
                                return false;
                            }else{
                                alert(data.msj);
                                location.href='../Controller/CalendarioInstitucional_html.php';
                            }
                        } //DATA
                }); //AJAX   
            }
        }//function
    );
    $('#ToolTables_example_3').click(
        function(){
            var confirmar = 'Desea Eliminar el evento...?';
            
            if(confirm(confirmar)){
                var id = $('#id_cargado').val();
                $.ajax({ //Ajax
                    type: 'POST',
                    url: '../Controller/CalendarioInstitucional_html.php',
                    async: false,
                    dataType: 'json',
                    data:({action_ID: 'DeleteEvento',id:id}),
                    error: function (objeto, quepaso, otroobj) {
                        alert('Error de Conexi?n , Favor Vuelva a Intentar');
                    },
                    success: function (data) {
                            if(data.val===false){
                                alert(data.msj);
                                return false;
                            }else{
                                alert(data.msj);
                                location.href='../Controller/CalendarioInstitucional_html.php';
                            }
                        } //DATA
                }); //AJAX   
            }
        }//function
    );
    $('#ToolTables_example_4').click(
        function(){
            $.ajax({ //Ajax
                type: 'POST',
                url: '../Controller/CalendarioInstitucional_html.php',
                async: false,
                dataType: 'html',
                data:({action_ID: 'Visualizar'}),
                error: function (objeto, quepaso, otroobj) {
                    alert('Error de Conexi?n , Favor Vuelva a Intentar');
                },
                success: function (data) {
                        $('#PrincipalView').html(data);
                    } //DATA
            }); //AJAX
        }//function
    );
});   
function CargarValor(valor){
    $('#id_cargado').val(valor);
}
