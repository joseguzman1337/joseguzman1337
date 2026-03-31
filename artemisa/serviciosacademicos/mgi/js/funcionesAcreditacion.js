
function Open(id, vf, rh, fecha_ini, fecha_fin, soloVer, idsiq_estructuradocumento) { 
    var ver = 1;

    $.ajax({
        type: 'GET',
        url: '../../SQI_Documento/Documento_Ver.html.php',
        data: ({
            actionID: 'Archivos', 
            id: id, 
            ver: ver, 
            vf: vf, 
            rh: rh, 
            fecha_ini: fecha_ini, 
            fecha_fin: fecha_fin, 
            soloVer: soloVer,
            idsiq_estructuradocumento: idsiq_estructuradocumento
        }),
        success: function (data) {
            $('#Contenedor_archivos').css('display', 'inline');
            $('#Contenedor_archivos').html(data);
        }
    });
}

function Ventana_OPen(id, i) {
    $("#" + id + '_' + i).dialog();
}

function Close() {
    $('#Contenedor_archivos').css('display', 'none');
}

function Download(url) {
    //window.location.href='Descargar_Documento.php?Documento_id='+id;/usr/local/apache2/htdocs/html/serviciosacademicos/mgi/SQI_Documento
    popUp_3(url, '1500', '800');
}

function Eliminar(id_detalle, id, op) {

    if (op == 0) {
        var Confirm = confirm('Desea Eliminar el Documento ....?');
    } else {
        var Confirm = confirm('Desea Eliminar el URL ....?');
    }

    if (Confirm) {
        $.ajax({
            type: 'GET',
            url: '../../SQI_Documento/Documento_Ver.html.php',
            dataType: 'json',
            data: ({actionID: 'Eliminar_Documento', id_detalle: id_detalle, id: id}),
            error: function (objeto, quepaso, otroobj) {
                alert('Error de Conexi�n , Favor Vuelva a Intentar');
            },
            success: function (data) {
                if (data.val == 'FALSE') {
                    alert(data.descrip);
                    return false;
                } else {
                    alert(data.descrip);
                    Open(id);
                }
            }
        });
    }
}