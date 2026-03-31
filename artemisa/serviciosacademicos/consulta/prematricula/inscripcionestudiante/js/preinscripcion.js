function getTipoDocumento(value){
    if (value != 0 && value != 01 && value != 02 && value != 04) {
        $('#table_extranjero').css('display', 'block');
    } else {
        $('#table_extranjero').css('display', 'none');
    }
}
