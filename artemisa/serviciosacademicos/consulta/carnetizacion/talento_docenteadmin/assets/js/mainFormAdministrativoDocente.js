$(function(){
    var n=0;
   // var root = document.location.hostname+'/serviciosacademicos/consulta/carnetizacion/talento_docenteadmin/';
    $('#tipodocumento').on('change',function(){
       if ($('#tipodocumento').val()!=''){
           $('#numerodocumento').prop( "disabled", false );
       }else{
           $('#numerodocumento').prop( "disabled", true );
       }
    });
    $('#numerodocumento').on('input',function(){
        var numdocumento =  $('#numerodocumento').val().length;
        var tipoDocumento = $('#tipodocumento').val();
        if (numdocumento > 7){
            var url = 'ajax/cargaDatosFormulario.php?numeroDocumento='+$('#numerodocumento').val()+'&tipoDocumento='+tipoDocumento;
            $("#complementaFormulario").load(url);
        }
    });
    $('#btnRegresar').on('click',function(){
        window.history.back();
    });
});