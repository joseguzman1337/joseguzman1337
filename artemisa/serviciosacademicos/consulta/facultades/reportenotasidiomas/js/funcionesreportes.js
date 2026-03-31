function consultar(){
    var periodo = $('#periodo').val();
    var carrera = $('#carrera').val();
    $.ajax({//Ajax
    type: 'POST',
    url: 'datos_ajax.php',
    async: false,
    dataType: 'json',
    data:({actionID:'Consultar',carrera:carrera, periodo:periodo}),
    beforeSend: function() {
        $('#consultar_bt').attr('disabled', 'disabled');
        $('#tablaReporteGeneral').html('<img src="img/loading.gif" /></img>');
    },
    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    success: function(data){
        $('#consultar_bt').removeAttr('disabled');
        $('#tablaReporteGeneral').html(data.imp);                       
        
        }
    });
} 