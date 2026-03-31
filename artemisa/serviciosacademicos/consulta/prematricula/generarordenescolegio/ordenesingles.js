function verOrdenes(codigo,periodopre,periodoAc,periodo) {
    Pace.restart();
    Pace.track(function() {
        $.ajax({
            type: 'POST',
            url: '../showOrderPayments.php',
            data:{
                codest: codigo,
                periodopre: periodopre,
                periodoAct: periodoAc,
                periodo: periodo
            },
            beforeSend: function (data) {
            },
            success: function (data) {
                console.log(data);
                $('#divOrdenes').html(data);
            }//success,
        }); //ajax
    });
}

/*function validar() {
    var fecha = $('#fechapago').val();
    var v = new RegExp(/^[1-9]+[0-9]+$/);
    var regExp=/^((?:19|20)\d\d)\-((?:0?[1-9])|(?:1[0-2]))\-((?:0?[1-9])|(?:[12]\d)|(?:3[01]))$/;
    if(fecha == '' || fecha.match(regExp) == null) {
        swal("Debe digitar o seleccionar una fecha");
        fecha.preventDefault();
    }else{
        crearorden();
    }
    /*if(f1.cambiar.checked == true) {
        if(f1.valor.value.match(v) == null) {
            swal("Debe digitar un valor");
            return false;
        }
        if(f1.observacion.value == '') {
            swal("Debe digitar una observación");
            return false;
        }
    }*/
//}//function*/

function crearorden(){
    var fecha = $('#fechapago').val();
    var v = new RegExp(/^[1-9]+[0-9]+$/);
    var regExp=/^((?:19|20)\d\d)\-((?:0?[1-9])|(?:1[0-2]))\-((?:0?[1-9])|(?:[12]\d)|(?:3[01]))$/;
    if(fecha == '' || fecha.match(regExp) == null) {
        swal("Debe digitar o seleccionar una fecha");
    }else {
        var codigoperiodo = $('#codigoperiodo').val();
        var codigoestudiante = $('#codigoestudiante').val();
        var codigomateria = $('#codigomateria').val();
        var grupo = $("input:radio:checked").val();
        var valor = $('#valor').val();
        var valordetallecohorte = $('#valordetallecohorte').val();
        var cobroMaterialesIdiomas = $('#cobroMaterialesIdiomas:checked').val();
        var cobroDescuento = $('#cobroDescuento:checked').val();
        var observacion = "";

        Pace.restart();
        Pace.track(function() {

            $.ajax({
                type: 'POST',
                url: 'funcionesordeningles.php',
                dataType: "json",
                data: {
                    fechapago: fecha,
                    codigoperiodo: codigoperiodo,
                    codigoestudiante: codigoestudiante,
                    codigomateria: codigomateria,
                    grupo: grupo,
                    valor: valor,
                    valordetallecohorte: valordetallecohorte,
                    observacion: observacion,
                    cobroMaterialesIdiomas: cobroMaterialesIdiomas,
                    cobroDescuento: cobroDescuento,
                    accion: "crearordeningles"
                },
                success: function (data) {
                    if(data.val == true) {
                        swal(data.msg);
                    }else{
                        swal(data.msg);
                    }
                },
                error: function (data, error) {
                    swal(data + error);
                }
            });//ajax
        });
    }
}

function mostrarGrupos(materia){
    var codigomateria = materia.value;
    var periodo = $('#codigoperiodo').val();

    Pace.restart();
    Pace.track(function() {

        $.ajax({
            type: 'POST',
            url: 'funcionesordeningles.php',
            dataType: "json",
            data: {
                periodo: periodo, codigomateria: codigomateria, accion: 'gruposyhorarios'
            },
            success: function (data) {
                console.log(data);
                if (data.val == false) {
                    swal("La materia seleccionada no tiene grupos, por favor selecciones otra o comuníquese con la facultad");
                } else {
                    $('#divgruposyhorarios').html(data.html);
                }
            },
            error: function (data, error) {
                alert(data + error);
            }
        });//ajax
    });
}

function genera(grupo) {
    var grupo = grupo.value;
    var periodo = $('#codigoperiodo').val();

    Pace.restart();
    Pace.track(function() {
        $.ajax({
            type: 'POST',
            url: 'funcionesordeningles.php',
            dataType: "html",
            data: {
                periodo: periodo, grupo: grupo, accion: 'generarorden'
            },
            success: function (data) {
                $('#divgenerarorden').html(data);
            },
            error: function (data, error) {
                swal(data + error);
            }
        });//ajax
    });
}