$(function(){
    $('.btnActualiza').on('click',function(){
        var idBtn =  $(this).attr("id");
            idBtn = idBtn.split('_');
            idBtn = idBtn[1];
        var idUsuario = $('#idusuario_'+idBtn).text();
        $('#idAdministrativosDocentes').val(idUsuario);
        $('#frmActualizar').submit();
    });
});